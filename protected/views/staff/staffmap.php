<?php

// Geocoding helper'ı dahil et
$geocode_helper_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'geocode_helper.php';
if (file_exists($geocode_helper_path)) {
    require_once($geocode_helper_path);
} else {
    require_once(Yii::getPathOfAlias('application.views.staff') . DIRECTORY_SEPARATOR . 'geocode_helper.php');
}

// Personel listesini al
$currentUser = User::model()->findByPk(Yii::app()->user->id);
$firmid = $currentUser->firmid;

$staff_list = User::model()->findAll(array(
    'condition' => 'firmid = :firmid AND clientid = 0 AND active = 1',
    'params' => array(':firmid' => $firmid),
    'select' => 'id, name, surname, color, firmid, clientid, active', // Surname'i de dahil et
));

// Seçilen tarih
$today = date('Y-m-d');
$selected_date = Yii::app()->request->getParam('date', $today);
$debug_mode = Yii::app()->request->getParam('dbgh', '') === '1';

// Tüm personellerin o tarihteki aktivitelerini al
$all_staff_activities = array();
$default_staff_colors = array(
    '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', 
    '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9',
    '#F8C471', '#82E0AA', '#F1948A', '#85C1E9', '#D7BDE2'
);

$count_start = strtotime($selected_date . ' 00:00:00');
$count_end = strtotime($selected_date . ' 23:59:59');

foreach ($staff_list as $index => $staff) {
    $routes = Yii::app()->db->createCommand()
        ->select('*')
        ->from('superlogs')
        ->where('userid = :userid AND createdtime >= :start_time AND createdtime <= :end_time')
        ->order('createdtime ASC, id ASC')
        ->bindParam(':userid', $staff['id'])
        ->bindParam(':start_time', $count_start)
        ->bindParam(':end_time', $count_end)
        ->queryAll();

    if (!empty($routes)) {
        $staff_locations = array();
        
        foreach ($routes as $route) {
            $data = json_decode($route['data'], true);
            if ($data && is_array($data)) {
                foreach ($data as $client) {
                    if (isset($client['clientname']) && !empty($client['clientname'])) {
                        $staff_locations[] = array(
                            'clientname' => $client['clientname'],
                            'address' => isset($client['address']) ? $client['address'] : '',
                            'start_time' => isset($client['start_time']) ? $client['start_time'] : '',
                            'finish_time' => isset($client['finish_time']) ? $client['finish_time'] : '',
                            'createdtime' => $route['createdtime'],
                            'todo' => isset($client['todo']) ? $client['todo'] : '',
                            'special_notes' => isset($client['special_notes']) ? $client['special_notes'] : '',
                            'workorder_id' => isset($client['id']) ? $client['id'] : null
                        );
                    }
                }
            }
        }
        
        // Aynı müşteri isimlerini grupla
        $grouped_locations = array();
        $location_order = array();
        
        foreach ($staff_locations as $location) {
            $key = strtolower(trim($location['clientname']));
            
            if (!isset($grouped_locations[$key])) {
                $grouped_locations[$key] = array(
                    'clientname' => $location['clientname'],
                    'address' => $location['address'],
                    'start_time' => $location['start_time'],
                    'finish_time' => $location['finish_time'],
                    'createdtime' => $location['createdtime'],
                    'todo' => $location['todo'],
                    'special_notes' => $location['special_notes'],
                    'workorder_id' => $location['workorder_id'],
                    'visit_count' => 1,
                    'real_start_time' => null,
                    'real_end_time' => null,
                    'all_workorder_ids' => array($location['workorder_id'])
                );
                $location_order[] = $key;
            } else {
                $grouped_locations[$key]['visit_count']++;
                $grouped_locations[$key]['all_workorder_ids'][] = $location['workorder_id'];
                
                if ($location['createdtime'] < $grouped_locations[$key]['createdtime']) {
                    $grouped_locations[$key]['createdtime'] = $location['createdtime'];
                }
            }
        }
        
        // Sıralı unique locations oluştur
        $unique_locations = array();
        foreach ($location_order as $key) {
            if (isset($grouped_locations[$key])) {
                $unique_locations[] = $grouped_locations[$key];
            }
        }
        
        // Workorder tablosundan gerçek giriş-çıkış saatlerini al
        foreach ($unique_locations as &$location) {
            if (!empty($location['all_workorder_ids'])) {
                $earliest_start = null;
                $latest_end = null;
                
                foreach ($location['all_workorder_ids'] as $workorder_id) {
                    if ($workorder_id) {
                        $workorder_sql = "SELECT realstarttime, realendtime FROM workorder WHERE id = :workorder_id";
                        $workorder_command = Yii::app()->db->createCommand($workorder_sql);
                        $workorder_command->bindParam(':workorder_id', $workorder_id, PDO::PARAM_INT);
                        $workorder_result = $workorder_command->queryRow();
                        
                        if ($workorder_result) {
                            if ($workorder_result['realstarttime'] && ($earliest_start === null || $workorder_result['realstarttime'] < $earliest_start)) {
                                $earliest_start = $workorder_result['realstarttime'];
                            }
                            if ($workorder_result['realendtime'] && ($latest_end === null || $workorder_result['realendtime'] > $latest_end)) {
                                $latest_end = $workorder_result['realendtime'];
                            }
                        }
                    }
                }
                
                $location['real_start_time'] = $earliest_start;
                $location['real_end_time'] = $latest_end;
            }
        }
        unset($location);
        
        if (!empty($unique_locations)) {
            // Geocoding yap
            $clients_for_geocoding = array();
            foreach ($unique_locations as $location) {
                $clients_for_geocoding[] = array(
                    'clientname' => $location['clientname'],
                    'address' => $location['address']
                );
            }
            
            $geocode_results = GeocodeHelper::geocodeUniqueClients($clients_for_geocoding);
            
            // Sonuçları eşleştir
            $geocode_lookup = array();
            foreach ($geocode_results as $result) {
                $client_key = strtolower(trim($result['clientname']));
                $geocode_lookup[$client_key] = $result;
            }
            
            foreach ($unique_locations as &$location) {
                $location_key = strtolower(trim($location['clientname']));
                
                if (isset($geocode_lookup[$location_key])) {
                    $geocode_result = $geocode_lookup[$location_key];
                    $location['lat'] = $geocode_result['lat'];
                    $location['lon'] = $geocode_result['lon'];
                    $location['geocoded'] = $geocode_result['found'];
                } else {
                    $location['lat'] = null;
                    $location['lon'] = null;
                    $location['geocoded'] = false;
                }
            }
            unset($location);
            
            // Kullanıcının kendi rengi varsa onu kullan, yoksa default renklerden seç
            $user_color = !empty($staff['color']) ? $staff['color'] : $default_staff_colors[$index % count($default_staff_colors)];
            
            // Rengin başında # yoksa ekle
            if (!empty($user_color) && substr($user_color, 0, 1) !== '#') {
                $user_color = '#' . $user_color;
            }
            
            // Debug: Renk kontrolü
            if ($debug_mode) {
                error_log("DEBUG: Staff {$staff['name']} (ID: {$staff['id']}) - User Color: " . ($staff['color'] ?? 'NULL') . " -> Final Color: $user_color");
            }
            
            // Geocoded ve non-geocoded lokasyon sayılarını hesapla
            $geocoded_count = 0;
            $non_geocoded_locations = array();
            
            foreach ($unique_locations as $loc) {
                if ($loc['geocoded'] && $loc['lat'] && $loc['lon']) {
                    $geocoded_count++;
                } else {
                    $non_geocoded_locations[] = array(
                        'clientname' => $loc['clientname'],
                        'address' => $loc['address'],
                        'reason' => empty($loc['address']) ? 'Adres bilgisi eksik' : 'Adres geocode edilemedi'
                    );
                }
            }
            
            $all_staff_activities[$staff['id']] = array(
                'staff' => $staff,
                'locations' => $unique_locations,
                'color' => $user_color,
                'visible' => true,
                'geocoded_count' => $geocoded_count,
                'non_geocoded_locations' => $non_geocoded_locations
            );
        }
    }
}

// CSS ve JS dosyalarını ekle
Yii::app()->clientScript->registerCssFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
Yii::app()->clientScript->registerScriptFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile('https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css');
Yii::app()->clientScript->registerScriptFile('https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCoreScript('jquery');

// Body class'ını menu-collapsed yap
Yii::app()->clientScript->registerScript('menu-collapse', '
$(document).ready(function() {
    $("body").removeClass("menu-expanded").addClass("menu-collapsed");
});
', CClientScript::POS_READY);
?>

<style>
#map { 
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 1;
}





.staff-checkbox-vertical.inactive {
    background: #9ca3af !important;
    color: white !important;
    border-color: #9ca3af !important;
}

.timeline-container {
    margin-bottom: 15px;
    padding: 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    background: rgba(248, 249, 250, 0.8);
    font-size: 13px;
}

.timeline-staff-header {
    font-weight: bold;
    margin-bottom: 10px;
    padding: 5px 10px;
    border-radius: 15px;
    color: white;
    text-align: center;
}

.timeline-bar {
    position: relative;
    height: 30px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin: 8px 0;
}

.custom-marker {
    background: none;
    border: none;
}

.marker-content {
    border-radius: 8px;
    padding: 3px 6px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    border: 2px solid white;
    position: relative;
    min-width: 70px;
}

.marker-content::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 8px solid;
    /* Border rengi JavaScript'te dinamik olarak ayarlanacak */
}

.marker-number {
    font-weight: bold;
    font-size: 14px;
    line-height: 1.2;
    color: white !important;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8) !important;
}

.marker-time {
    font-size: 9px;
    line-height: 1.1;
    white-space: nowrap;
    color: white !important;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.8) !important;
}

.leaflet-routing-container {
    display: none !important;
}
</style>

<!-- Fullscreen Map -->
<div id="map"></div>

<!-- Map Overlay Controls -->

<!-- Staff Selection (Right Side) -->
<?php if (!empty($all_staff_activities)): ?>
<div style="position: fixed; top: 50%; right: 20px; z-index: 1000; transform: translateY(-50%); pointer-events: auto;">
    <div style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 12px 15px; backdrop-filter: blur(20px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); max-height: 60vh; overflow-y: auto; min-width: 200px; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 12px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.boxShadow='0 8px 32px rgba(0, 0, 0, 0.1)'">
        <div style="font-weight: 700; font-size: 13px; color: white; margin-bottom: 12px; text-align: center;">
            👥 <?php echo t('Staff'); ?> (<?php echo count($all_staff_activities); ?>)
        </div>
        <div id="staff-toggles" style="max-height: 300px; overflow-y: auto; overflow-x: hidden; display: flex; flex-direction: column; gap: 4px;">
            <?php foreach ($all_staff_activities as $staff_id => $activity): ?>
            <div class="staff-checkbox-vertical active" 
                 data-staff-id="<?php echo $staff_id; ?>"
                 style="border: 1px solid <?php echo $activity['color']; ?>; background: <?php echo $activity['color']; ?>; color: white; padding: 6px 8px; border-radius: 6px; cursor: pointer; font-size: 10px; font-weight: 600; text-align: left; transition: all 0.3s ease; height: 28px; display: flex; align-items: center; justify-content: space-between; pointer-events: auto; user-select: none; box-shadow: 0 1px 4px rgba(0,0,0,0.2);"
                 title="<?php 
                    $total = count($activity['locations']);
                    $geocoded = $activity['geocoded_count'];
                    $not_geocoded = count($activity['non_geocoded_locations']);
                    echo "Toplam: $total lokasyon\nHaritada: $geocoded lokasyon\nAdres sorunu: $not_geocoded lokasyon";
                    if ($not_geocoded > 0) {
                        echo "\n\nAdres sorunlu lokasyonlar:\n";
                        foreach ($activity['non_geocoded_locations'] as $ng) {
                            echo "• {$ng['clientname']} - {$ng['reason']}\n";
                        }
                    }
                 ?>"
                 onmouseover="this.style.transform='translateX(3px)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.3)'"
                 onmouseout="this.style.transform='translateX(0px)'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.2)'">
                <div style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5); pointer-events: none; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <?php echo $activity['staff']['name']; ?>
                    <?php if (!empty($activity['staff']['surname'])): ?>
                        <?php echo ' ' . $activity['staff']['surname']; ?>
                    <?php endif; ?>
                    <?php 
                        $total = count($activity['locations']);
                        $geocoded = $activity['geocoded_count'];
                        if ($geocoded < $total) {
                            echo " ⚠️";
                        }
                    ?>
                </div>
                <div style="font-size: 9px; opacity: 0.9; pointer-events: none; margin-left: 5px; flex-shrink: 0;">
                    <?php echo $geocoded; ?>/<?php echo $total; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="font-size: 11px; color: rgba(255,255,255,0.8); margin-top: 12px; text-align: center;">
            💡 <?php echo t('Click to toggle'); ?>
        </div>
        
        <!-- Details Toggle Button -->
        <div style="margin-top: 15px; text-align: center;">
            <button id="timeline-toggle" style="background: rgba(52, 144, 220, 0.2); border: 1px solid rgba(52, 144, 220, 0.3); border-radius: 8px; padding: 12px 15px; backdrop-filter: blur(10px); box-shadow: 0 2px 8px rgba(0,0,0,0.1); cursor: pointer; font-weight: 700; color: white; font-size: 12px; width: 100%; transition: all 0.3s ease; margin-bottom: 8px;" onmouseover="this.style.background='rgba(52, 144, 220, 0.3)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'" onmouseout="this.style.background='rgba(52, 144, 220, 0.2)'; this.style.transform='translateY(0px)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                📊 <?php echo t('Details'); ?>
            </button>
            

        </div>
    </div>
</div>
<?php endif; ?>

<!-- Date Selector (Bottom Center) - Her zaman göster -->
<div id="date-selector" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 1000; pointer-events: auto;">
    <div id="date-container" style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 12px 15px; backdrop-filter: blur(20px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 8px 32px rgba(0, 0, 0, 0.1)'">
        <div style="display: flex; align-items: center; gap: 12px;">
            <!-- Compact Calendar Logo -->
            <div style="background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); border-radius: 10px; padding: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-width: 50px; height: 50px; box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);">
                <div style="color: white; font-weight: 900; font-size: 17px; line-height: 1; margin-bottom: 1px;">
                    <?php echo date('d', strtotime($selected_date)); ?>
                </div>
                <div style="color: rgba(255,255,255,0.9); font-weight: 700; font-size: 7px; text-transform: uppercase; letter-spacing: 0.3px;">
                    <?php 
                        $months = array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
                        echo $months[date('n', strtotime($selected_date)) - 1];
                    ?>
                </div>
            </div>
            
            <!-- Date Info and Selector -->
            <div style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
                <!-- First Row: Date and Stats -->
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="font-weight: 700; font-size: 13px; color: white;">
                        <?php echo date('d.m.Y', strtotime($selected_date)); ?>
                    </div>
                    <div style="font-weight: 600; font-size: 11px; color: rgba(255,255,255,0.8);">
                        <?php 
                            if (!empty($all_staff_activities)) {
                                $total_staff = count($all_staff_activities);
                                $total_locations = 0;
                                $total_geocoded = 0;
                                
                                foreach ($all_staff_activities as $activity) {
                                    $total_locations += count($activity['locations']);
                                    $total_geocoded += $activity['geocoded_count'];
                                }
                                
                                echo "$total_staff " . t('staff') . " • $total_geocoded/$total_locations " . t('locations');
                            } else {
                                echo "📅 " . t('No activities for this date');
                            }
                        ?>
                    </div>
                </div>
                
                <!-- Second Row: Date Selector -->
                <div style="display: flex; align-items: center; gap: 7px;">
                    <div style="font-weight: 600; font-size: 11px; color: rgba(255,255,255,0.9);">
                        <?php echo t('Select Date'); ?>:
                    </div>
                    <?php
                    echo CHtml::tag('input', array(
                        'type' => 'date',
                        'name' => 'date',
                        'value' => $selected_date,
                        'style' => 'padding: 5px 7px; border: 1px solid rgba(255,255,255,0.3); border-radius: 5px; font-size: 12px; background: rgba(255,255,255,0.95); color: #333; font-weight: 600; min-width: 125px;',
                        'id' => 'date',
                        'max' => date('Y-m-d')
                    ), '', true);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php if (!empty($all_staff_activities)): ?>
    <!-- Timeline Panel Modal -->
    <div id="timeline-panel" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.5); z-index: 1002; opacity: 0; visibility: hidden; transition: all 0.3s ease; backdrop-filter: blur(5px);">
        <div style="position: absolute; top: 10%; left: 15%; right: 15%; bottom: 8%; max-width: 650px; margin: 0 auto; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(15px); border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; display: flex; flex-direction: column;">
            <!-- Header -->
            <div style="padding: 20px 25px; background: rgba(248, 249, 250, 0.8); border-bottom: 1px solid #dee2e6; flex-shrink: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 style="margin: 0; color: #333; font-size: 18px;">📊 <?php echo t('Staff Details'); ?></h3>
                    <button id="close-timeline" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 50%; width: 35px; height: 35px; cursor: pointer; color: #dc3545; font-size: 16px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(220, 53, 69, 0.2)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(220, 53, 69, 0.1)'; this.style.transform='scale(1)'">✕</button>
                </div>
                
                <!-- Status Summary -->
                <div style="background: rgba(52, 144, 220, 0.1); border: 1px solid rgba(52, 144, 220, 0.3); border-radius: 8px; padding: 12px; font-size: 13px; color: #333;">
                    <?php 
                        $total_staff = count($all_staff_activities);
                        $total_locations = 0;
                        $total_geocoded = 0;
                        $staff_with_issues = 0;
                        
                        foreach ($all_staff_activities as $activity) {
                            $total_locations += count($activity['locations']);
                            $total_geocoded += $activity['geocoded_count'];
                            if (count($activity['non_geocoded_locations']) > 0) {
                                $staff_with_issues++;
                            }
                        }
                        
                        echo "<strong>$total_staff " . t('staff with activities on') . " " . date('d.m.Y', strtotime($selected_date)) . ".</strong><br>";
                        echo t('Total') . " $total_locations " . t('locations') . ", $total_geocoded " . t('shown on map') . ".";
                        
                        if ($staff_with_issues > 0) {
                            echo "<br><span style='color: #dc3545;'>⚠️ $staff_with_issues " . t('staff have address issues') . ".</span>";
                        }
                    ?>
                </div>
            </div>
            
            <!-- Content -->
            <div style="flex: 1; overflow-y: auto; padding: 15px 25px;">
        
        <div id="timelines-container">
        <?php foreach ($all_staff_activities as $staff_id => $activity): ?>
        <div class="timeline-container" id="timeline-<?php echo $staff_id; ?>">
            <div class="timeline-staff-header" style="background: <?php echo $activity['color']; ?>;">
                <?php echo $activity['staff']['name']; ?> - <?php echo count($activity['locations']); ?> <?php echo count($activity['locations']) == 1 ? t('location') : t('locations'); ?>
            </div>
            <div class="timeline-bar" id="timeline-bar-<?php echo $staff_id; ?>">
                <!-- Timeline segments will be added here by JavaScript -->
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Staff Locations List -->
        <div style="margin-top: 20px;">
            <div style="display: flex; align-items: center; cursor: pointer; padding: 10px; background: rgba(52, 144, 220, 0.1); border: 1px solid rgba(52, 144, 220, 0.3); border-radius: 8px; margin-bottom: 15px;" onclick="toggleStaffDetails()">
                <h5 style="margin: 0; flex: 1;"><?php echo t('Staff Location Details'); ?></h5>
                <span id="staff-details-arrow" style="font-size: 18px; transition: transform 0.3s ease;">▼</span>
            </div>
            <div id="staff-details-content" style="display: none;">
            <?php foreach ($all_staff_activities as $staff_id => $activity): ?>
            <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #dee2e6; border-radius: 5px; background: #f8f9fa;">
                <div style="font-weight: bold; color: <?php echo $activity['color']; ?>; margin-bottom: 8px;">
                    <?php echo $activity['staff']['name']; ?> - <?php echo count($activity['locations']); ?> <?php echo count($activity['locations']) == 1 ? t('location') : t('locations'); ?>
                </div>
                <div style="font-size: 12px;">
                    <?php 
                    $locations = $activity['locations'];
                    usort($locations, function($a, $b) {
                        return $a['createdtime'] - $b['createdtime'];
                    });
                    
                    foreach ($locations as $index => $location): 
                        $location_number = $index + 1;
                        $status_icon = '';
                        $status_text = '';
                        
                        if ($location['geocoded'] && $location['lat'] && $location['lon']) {
                            $status_icon = '📍';
                            $status_text = t('Shown on map');
                        } else {
                            $status_icon = '❌';
                            $status_text = empty($location['address']) ? t('Address information missing') : t('Address could not be geocoded');
                        }
                        
                                                 // Ortak lokasyon kontrolü (aynı müşteri adı)
                         $shared_with = array();
                         foreach ($all_staff_activities as $other_staff_id => $other_activity) {
                             if ($other_staff_id != $staff_id) {
                                 foreach ($other_activity['locations'] as $other_location) {
                                     if (strtolower(trim($other_location['clientname'])) == strtolower(trim($location['clientname']))) {
                                         $shared_with[] = array(
                                             'name' => $other_activity['staff']['name'],
                                             'color' => $other_activity['color']
                                         );
                                         break;
                                     }
                                 }
                             }
                         }
                         
                         // Aynı adres kontrolü (aynı personelin diğer lokasyonları)
                         $same_address_locations = array();
                         if (!empty($location['address'])) {
                             foreach ($locations as $other_index => $other_location) {
                                 if ($other_index != $index && 
                                     !empty($other_location['address']) && 
                                     strtolower(trim($other_location['address'])) == strtolower(trim($location['address'])) &&
                                     strtolower(trim($other_location['clientname'])) != strtolower(trim($location['clientname']))) {
                                     $same_address_locations[] = array(
                                         'number' => $other_index + 1,
                                         'clientname' => $other_location['clientname']
                                     );
                                         }
    }
}
?>


                    <div style="margin-bottom: 5px; padding: 5px; <?php echo !empty($shared_with) ? 'background: linear-gradient(90deg, ' . $activity['color'] . ' 50%, ' . $shared_with[0]['color'] . ' 50%); color: white; border-radius: 3px;' : ''; ?>">
                        <span style="font-weight: bold;"><?php echo $location_number; ?>.</span>
                        <span style="<?php echo !empty($shared_with) ? 'text-shadow: 1px 1px 1px rgba(0,0,0,0.8);' : ''; ?>"><?php echo $location['clientname']; ?></span>
                        <span style="margin-left: 10px;"><?php echo $status_icon; ?> <?php echo $status_text; ?></span>
                                                 <?php if (!empty($shared_with)): ?>
                             <span style="margin-left: 10px; font-weight: bold; text-shadow: 1px 1px 1px rgba(0,0,0,0.8);">
                                 🤝 <?php echo t('Shared'); ?>: <?php echo implode(', ', array_column($shared_with, 'name')); ?>
                             </span>
                         <?php endif; ?>
                         <?php if (!empty($same_address_locations)): ?>
                             <span style="margin-left: 10px; font-weight: bold; color: #ff6b35;">
                                 🏢 <?php echo t('Same address'); ?>: <?php 
                                     $same_address_text = array();
                                     foreach ($same_address_locations as $sal) {
                                         $same_address_text[] = $sal['number'] . '. ' . $sal['clientname'];
                                     }
                                     echo implode(', ', $same_address_text);
                                 ?>
                             </span>
                         <?php endif; ?>
                        <?php if (!empty($location['address'])): ?>
                            <div style="font-size: 11px; color: #666; margin-top: 2px; <?php echo !empty($shared_with) ? 'color: rgba(255,255,255,0.9); text-shadow: 1px 1px 1px rgba(0,0,0,0.8);' : ''; ?>">
                                📍 <?php echo $location['address']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($location['todo'])): ?>
                            <div style="font-size: 11px; color: #666; margin-top: 2px; <?php echo !empty($shared_with) ? 'color: rgba(255,255,255,0.9); text-shadow: 1px 1px 1px rgba(0,0,0,0.8);' : ''; ?>">
                                📋 <?php echo $location['todo']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Timeline Legend -->
        <div style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 5px; font-size: 12px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
                <div style="display: flex; align-items: center;">
                    <div style="width: 20px; height: 15px; background: #28a745; border-radius: 3px; margin-right: 8px;"></div>
                    <span><?php echo t('At Location'); ?></span>
                </div>
                <div style="display: flex; align-items: center;">
                    <div style="width: 20px; height: 15px; background: #ffc107; border-radius: 3px; margin-right: 8px;"></div>
                    <span><?php echo t('Travel'); ?></span>
                </div>
                <div style="display: flex; align-items: center;">
                    <div style="width: 20px; height: 4px; background: linear-gradient(90deg, rgba(255,193,7,0.3), rgba(255,193,7,0.7), rgba(255,193,7,0.3)); border-radius: 2px; margin-right: 8px; position: relative;">
                        <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 8px; color: #ffc107;">→</span>
                    </div>
                    <span><?php echo t('Quick Travel'); ?></span>
                </div>
                <div style="display: flex; align-items: center;">
                    <div style="width: 20px; height: 15px; background: #6c757d; border-radius: 3px; margin-right: 8px;"></div>
                    <span><?php echo t('Unknown Time'); ?></span>
                </div>
                <div style="font-style: italic; color: #666; margin-left: auto;">
                    💡 <?php echo t('Hover over segments for details'); ?>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    


<script>
$(document).ready(function() {
    // Remove any existing loading spinner when page loads
    var existingOverlay = document.getElementById('date-loading-overlay');
    if (existingOverlay) {
        existingOverlay.remove();
    }
    
    $('#date').change(function() {
        var selectedDate = $(this).val();
        
        // Show loading spinner
        showDateLoadingSpinner();
        
        var url = '<?php echo $this->createUrl('staff/staffmap'); ?>?date=' + encodeURIComponent(selectedDate);
        window.location.href = url;
    });
    
    // Timeline panel modal toggle
    $('#timeline-toggle').click(function() {
        $('#timeline-panel').css({
            'opacity': '1',
            'visibility': 'visible'
        });
    });
    
    $('#close-timeline').click(function() {
        $('#timeline-panel').css({
            'opacity': '0',
            'visibility': 'hidden'
        });
    });
    
    // Modal backdrop'a tıklayınca kapat
    $('#timeline-panel').click(function(e) {
        if (e.target === this) {
            $(this).css({
                'opacity': '0',
                'visibility': 'hidden'
            });
        }
    });
    
    // ESC tuşu ile modal'ı kapat
    $(document).keyup(function(e) {
        if (e.keyCode === 27) { // ESC key
            $('#timeline-panel').css({
                'opacity': '0',
                'visibility': 'hidden'
            });
        }
    });
    

});

// Staff details toggle function
function toggleStaffDetails() {
    var content = document.getElementById('staff-details-content');
    var arrow = document.getElementById('staff-details-arrow');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        arrow.style.transform = 'rotate(180deg)';
    } else {
        content.style.display = 'none';
        arrow.style.transform = 'rotate(0deg)';
    }
}

// Date loading spinner function
function showDateLoadingSpinner() {
    // Create overlay
    var overlay = document.createElement('div');
    overlay.id = 'date-loading-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    `;
    
    // Create spinner container
    var spinnerContainer = document.createElement('div');
    spinnerContainer.style.cssText = `
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 30px 40px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    `;
    
    // Create spinner
    var spinner = document.createElement('div');
    spinner.style.cssText = `
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #4ade80;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px auto;
    `;
    
    // Create loading text
    var loadingText = document.createElement('div');
    loadingText.style.cssText = `
        font-weight: 600;
        font-size: 16px;
        color: #333;
        margin-bottom: 8px;
    `;
    loadingText.textContent = '<?php echo t('Loading'); ?>...';
    
    // Create date info
    var dateInfo = document.createElement('div');
    dateInfo.style.cssText = `
        font-size: 14px;
        color: #666;
    `;
    dateInfo.textContent = '<?php echo t('Fetching staff activities'); ?>';
    
    // Add CSS animation
    var style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    
    // Assemble elements
    spinnerContainer.appendChild(spinner);
    spinnerContainer.appendChild(loadingText);
    spinnerContainer.appendChild(dateInfo);
    overlay.appendChild(spinnerContainer);
    document.body.appendChild(overlay);
}

<?php if (!empty($all_staff_activities)): ?>
document.addEventListener('DOMContentLoaded', function() {
    
    var map = L.map('map').setView([54.5, -2.0], 6); // İngiltere merkezi
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var staffActivities = <?php echo json_encode($all_staff_activities); ?>;
    
    var staffMarkers = {};
    var staffRoutes = {};
    var bounds = L.latLngBounds([]);
    var hasValidBounds = false;

    // Rengin açıklık/koyuluğuna göre yazı rengini belirle
    function getTextColor(backgroundColor) {
        // Hex rengi RGB'ye çevir
        var hex = backgroundColor.replace('#', '');
        if (hex.length !== 6) return '#FFFFFF'; // Geçersiz renk ise beyaz döndür
        
        var r = parseInt(hex.substr(0, 2), 16);
        var g = parseInt(hex.substr(2, 2), 16);
        var b = parseInt(hex.substr(4, 2), 16);
        
        // Daha doğru luminance hesaplama (W3C standardı)
        var luminance = (0.2126 * r + 0.7152 * g + 0.0722 * b);
        
        // 140'tan büyükse siyah yazı, küçükse beyaz yazı (daha konservatif threshold)
        return luminance > 140 ? '#000000' : '#FFFFFF';
    }

    // Staff toggle events
    document.querySelectorAll('.staff-checkbox-vertical').forEach(function(checkbox) {
        console.log('Staff checkbox found:', checkbox);
        checkbox.addEventListener('click', function(e) {
            console.log('Staff checkbox clicked:', this);
            var staffId = this.getAttribute('data-staff-id');
            var isActive = this.classList.contains('active');
            
            console.log('Staff ID:', staffId, 'Is Active:', isActive);
            
            if (isActive) {
                this.classList.remove('active');
                this.classList.add('inactive');
                hideStaffOnMap(staffId);
                hideStaffTimeline(staffId);
            } else {
                this.classList.remove('inactive');
                this.classList.add('active');
                showStaffOnMap(staffId);
                showStaffTimeline(staffId);
            }
        });
    });

    // Tüm staff'ları haritaya ekle
    for (var staffId in staffActivities) {
        var activity = staffActivities[staffId];
        addStaffToMap(staffId, activity);
        createStaffTimeline(staffId, activity);
    }

    // Sadece ilk yüklemede tüm koordinatları göster
    if (hasValidBounds) {
        map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
    }
    
    // Pencere boyutu değiştiğinde sadece harita boyutunu güncelle
    window.addEventListener('resize', function() {
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    });
    


    function addStaffToMap(staffId, activity) {
        var locations = activity.locations;
        var color = activity.color;
        var staff = activity.staff;
        
        // Debug: Staff bilgisini kontrol et
        console.log('Staff Info:', staff, 'Staff Name:', staff ? staff.name : 'undefined');
        
        staffMarkers[staffId] = [];
        
        var sortedLocations = locations.slice().sort(function(a, b) {
            return a.createdtime - b.createdtime;
        });
        
        var geocodedCount = 0;
        var notGeocodedLocations = [];
        
        // Aynı koordinatlardaki lokasyonları grupla
        var locationGroups = {};
        sortedLocations.forEach(function(location, index) {
            if (location.geocoded && location.lat && location.lon) {
                var coordKey = location.lat.toFixed(6) + ',' + location.lon.toFixed(6);
                if (!locationGroups[coordKey]) {
                    locationGroups[coordKey] = [];
                }
                locationGroups[coordKey].push({
                    location: location,
                    originalIndex: index
                });
            }
        });
        
        // Gruplanan lokasyonları işle
        var processedCoords = {};
        sortedLocations.forEach(function(location, index) {
            if (location.geocoded && location.lat && location.lon) {
                geocodedCount++;
                var coordKey = location.lat.toFixed(6) + ',' + location.lon.toFixed(6);
                
                // Bu koordinat daha önce işlendiyse atla
                if (processedCoords[coordKey]) {
                    return;
                }
                processedCoords[coordKey] = true;
                
                var locationsAtSameCoord = locationGroups[coordKey];
                var timeNumber = index + 1;
                
                // Zaman bilgilerini hazırla
                var startTime = '';
                var endTime = '';
                var timeDisplay = '';
                
                if (location.real_start_time && location.real_start_time > 0) {
                    startTime = new Date(location.real_start_time * 1000).toLocaleTimeString('tr-TR', {
                        hour: '2-digit', minute: '2-digit'
                    });
                    
                    if (location.real_end_time && location.real_end_time > 0) {
                        endTime = new Date(location.real_end_time * 1000).toLocaleTimeString('tr-TR', {
                            hour: '2-digit', minute: '2-digit'
                        });
                        timeDisplay = startTime + '-' + endTime;
                    } else {
                        timeDisplay = startTime + '-<?php echo t('Ongoing'); ?>';
                    }
                } else {
                    var visitTime = new Date(location.createdtime * 1000).toLocaleTimeString('tr-TR', {
                        hour: '2-digit', minute: '2-digit'
                    });
                    timeDisplay = visitTime;
                }
                
                // Tüm marker'larda beyaz yazı kullan (daha okunabilir)
                var textColor = '#FFFFFF';
                
                // Unique class name oluştur
                var markerClass = 'marker-' + staffId + '-' + index;
                
                // Aynı koordinatta birden fazla lokasyon varsa belirt
                var multiLocationText = locationsAtSameCoord.length > 1 ? ' (+' + (locationsAtSameCoord.length - 1) + ')' : '';
                
                var customIcon = L.divIcon({
                    className: 'custom-marker',
                    html: '<div class="marker-content ' + markerClass + '" style="background: ' + color + ' !important; color: ' + textColor + ' !important; opacity: 1 !important; text-shadow: 1px 1px 2px rgba(0,0,0,0.7) !important;">' +
                          '<div class="marker-number" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">' + timeNumber + multiLocationText + '</div>' +
                          '<div class="marker-time" style="text-shadow: 1px 1px 1px rgba(0,0,0,0.8);">' + timeDisplay + '</div>' +
                          '</div>',
                    iconSize: [80, 45],
                    iconAnchor: [40, 45]
                });
                
                // Marker'ın after pseudo-element'i için dinamik CSS ekle
                var style = document.createElement('style');
                style.textContent = '.' + markerClass + '::after { border-top-color: ' + color + ' !important; }';
                document.head.appendChild(style);
                
                var marker = L.marker([location.lat, location.lon], { icon: customIcon });
                
                // Staff name'i güvenli şekilde al
                var staffName = (staff && staff.name) ? staff.name : 'Staff';
                
                var popupContent = '<div style="min-width: 200px; font-size: 12px; line-height: 1.3;">';
                
                // Aynı koordinatta birden fazla lokasyon varsa hepsini göster
                if (locationsAtSameCoord.length > 1) {
                    popupContent += '<div style="font-weight: bold; color: ' + color + '; margin-bottom: 5px;">' + 
                                   staffName + ' - ' + locationsAtSameCoord.length + ' <?php echo t('locations at same address'); ?></div>';
                    
                    locationsAtSameCoord.forEach(function(locData, locIndex) {
                        var loc = locData.location;
                        var locNum = locData.originalIndex + 1;
                        popupContent += '<div style="margin-bottom: 8px; padding: 5px; border-left: 3px solid ' + color + '; background: #f8f9fa;">' +
                                       '<div style="font-weight: bold;">' + locNum + '. ' + loc.clientname + '</div>';
                        if (loc.todo) {
                            popupContent += '<div style="font-size: 11px; color: #666;">📋 ' + loc.todo + '</div>';
                        }
                        popupContent += '</div>';
                    });
                    
                    popupContent += '<div style="margin-bottom: 3px;"><strong><?php echo t('Address'); ?>:</strong> ' + (location.address || '<?php echo t('No address information'); ?>') + '</div>';
                } else {
                    popupContent += '<div style="font-weight: bold; color: ' + color + '; margin-bottom: 5px;">' + 
                                   staffName + ' - ' + timeNumber + '. ' + location.clientname + '</div>' +
                                   '<div style="margin-bottom: 3px;"><strong><?php echo t('Address'); ?>:</strong> ' + (location.address || '<?php echo t('No address information'); ?>') + '</div>';
                }
                
                if (location.real_start_time && location.real_start_time > 0) {
                    popupContent += '<div style="margin-bottom: 3px;"><strong><?php echo t('Entry Time'); ?>:</strong> ' + startTime + '</div>';
                    if (location.real_end_time && location.real_end_time > 0) {
                        popupContent += '<div style="margin-bottom: 3px;"><strong><?php echo t('Exit Time'); ?>:</strong> ' + endTime + '</div>';
                    } else {
                        popupContent += '<div style="margin-bottom: 3px;"><strong><?php echo t('Status'); ?>:</strong> <?php echo t('Ongoing'); ?></div>';
                    }
                } else {
                    var visitTime = new Date(location.createdtime * 1000).toLocaleTimeString('tr-TR', {
                        hour: '2-digit', minute: '2-digit'
                    });
                    popupContent += '<div style="margin-bottom: 3px;"><strong><?php echo t('First Record'); ?>:</strong> ' + visitTime + '</div>';
                }
                
                popupContent += '<div style="margin-bottom: 3px;"><strong><?php echo t('Task'); ?>:</strong> ' + (location.todo || '<?php echo t('No task information'); ?>') + '</div>';
                
                if (location.workorder_id) {
                    popupContent += '<div style="margin-top: 5px;"><a href="https://insectram.io/workorder/workorder?id=' + location.workorder_id + '" target="_blank" style="background: ' + color + '; color: white; padding: 3px 8px; text-decoration: none; border-radius: 3px; font-size: 11px; font-weight: bold;">🔗 Workorder</a></div>';
                }
                
                popupContent += '</div>';
                marker.bindPopup(popupContent);
                marker.addTo(map);
                
                staffMarkers[staffId].push({
                    marker: marker,
                    location: location,
                    lat: location.lat,
                    lon: location.lon
                });
                
                bounds.extend([location.lat, location.lon]);
                hasValidBounds = true;
            } else {
                // Geocode edilemeyen lokasyonları kaydet
                notGeocodedLocations.push({
                    index: index + 1,
                    clientname: location.clientname,
                    address: location.address || 'Adres bilgisi yok',
                    reason: !location.address ? 'Adres bilgisi eksik' : 'Adres geocode edilemedi'
                });
            }
        });
        
        // Geocode edilemeyen lokasyonları logla
        if (notGeocodedLocations.length > 0) {
            console.warn('Staff ' + (staff ? staff.name : staffId) + ' - Haritada gösterilemeyen lokasyonlar:', notGeocodedLocations);
        }
        
        // Rota çiz - mesafeye göre karar ver
        if (staffMarkers[staffId].length > 1) {
            var waypoints = staffMarkers[staffId].map(function(m) {
                return L.latLng(m.lat, m.lon);
            });
            
            // Toplam mesafeyi hesapla
            var totalDistance = 0;
            var shouldUseDirectLines = false;
            
            for (var i = 0; i < waypoints.length - 1; i++) {
                var distance = calculateDistance(
                    waypoints[i].lat, waypoints[i].lng,
                    waypoints[i + 1].lat, waypoints[i + 1].lng
                );
                totalDistance += distance;
                
                // Herhangi bir segment 500km'den uzunsa direk çizgi kullan
                if (distance > 350) {
                    shouldUseDirectLines = true;
                    break;
                }
            }
            
            if (shouldUseDirectLines || totalDistance > 1000) {
                // Direk çizgiler çiz (500km+ mesafeler için)
                var polylinePoints = waypoints;
                var polyline = L.polyline(polylinePoints, {
                    color: color,
                    weight: 4,
                    opacity: 0.8,
                    dashArray: '10, 10' // Kesikli çizgi - yol tarifi olmadığını belirtmek için
                }).addTo(map);
                
                // Polyline'ı routes olarak kaydet
                staffRoutes[staffId] = polyline;
                
                console.log('📏 Staff ' + staffId + ' - Toplam mesafe: ' + totalDistance.toFixed(1) + 'km - Direk çizgi kullanıldı');
            } else {
                // Normal yol tarifi (500km altı mesafeler için)
                var routeControl = L.Routing.control({
                    waypoints: waypoints,
                    routeWhileDragging: false,
                    addWaypoints: false,
                    createMarker: function() { return null; },
                    lineOptions: {
                        styles: [{
                            color: color,
                            weight: 4,
                            opacity: 0.8
                        }]
                    },
                    show: false,
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    })
                }).addTo(map);
                
                staffRoutes[staffId] = routeControl;
                
                console.log('🛣️ Staff ' + staffId + ' - Toplam mesafe: ' + totalDistance.toFixed(1) + 'km - Yol tarifi kullanıldı');
            }
        }
    }

    function hideStaffOnMap(staffId) {
        if (staffMarkers[staffId]) {
            staffMarkers[staffId].forEach(function(markerData) {
                map.removeLayer(markerData.marker);
            });
        }
        
        if (staffRoutes[staffId]) {
            // Routing control mu yoksa polyline mı kontrol et
            if (staffRoutes[staffId].removeFrom) {
                // Polyline ise
                map.removeLayer(staffRoutes[staffId]);
            } else {
                // Routing control ise
                map.removeControl(staffRoutes[staffId]);
            }
        }
    }

    function showStaffOnMap(staffId) {
        if (staffMarkers[staffId]) {
            staffMarkers[staffId].forEach(function(markerData) {
                markerData.marker.addTo(map);
            });
        }
        
        if (staffRoutes[staffId] && staffMarkers[staffId] && staffMarkers[staffId].length > 1) {
            // Routing control mu yoksa polyline mı kontrol et
            if (staffRoutes[staffId].addTo) {
                // Polyline ise
                staffRoutes[staffId].addTo(map);
            } else {
                // Routing control ise
                staffRoutes[staffId].addTo(map);
            }
        }
    }

    function hideStaffTimeline(staffId) {
        var timeline = document.getElementById('timeline-' + staffId);
        if (timeline) {
            timeline.style.display = 'none';
        }
    }

    function showStaffTimeline(staffId) {
        var timeline = document.getElementById('timeline-' + staffId);
        if (timeline) {
            timeline.style.display = 'block';
        }
    }

    function createStaffTimeline(staffId, activity) {
        var locations = activity.locations;
        var color = activity.color;
        
        if (locations.length === 0) return;
        
        var timelineBar = document.getElementById('timeline-bar-' + staffId);
        if (!timelineBar) return;
        
        var sortedLocations = locations.slice().sort(function(a, b) {
            return a.createdtime - b.createdtime;
        });
        
        var firstTime = null;
        var lastTime = null;
        
        // İlk ve son zamanları bul (gerçek saatlerden)
        for (var i = 0; i < sortedLocations.length; i++) {
            var location = sortedLocations[i];
            if (location.real_start_time && location.real_start_time > 0) {
                if (!firstTime || location.real_start_time < firstTime) {
                    firstTime = location.real_start_time;
                }
                if (location.real_end_time && location.real_end_time > 0) {
                    if (!lastTime || location.real_end_time > lastTime) {
                        lastTime = location.real_end_time;
                    }
                }
            }
        }
        
        // Fallback: gerçek saatler yoksa createdtime kullan
        if (!firstTime) {
            firstTime = sortedLocations[0].createdtime;
            lastTime = sortedLocations[sortedLocations.length - 1].createdtime;
        }
        
        var totalDuration = lastTime - firstTime; // saniye
        if (totalDuration <= 0) return;
        
        // Timeline segmentlerini oluştur
        for (var i = 0; i < sortedLocations.length; i++) {
            var currentLocation = sortedLocations[i];
            var nextLocation = i < sortedLocations.length - 1 ? sortedLocations[i + 1] : null;
            
            // Mevcut lokasyonda kalma süresi
            if (currentLocation.real_start_time && currentLocation.real_start_time > 0) {
                var startTime = currentLocation.real_start_time;
                var endTime = currentLocation.real_end_time || (nextLocation ? nextLocation.real_start_time : lastTime);
                
                // Lokasyon segmenti (yeşil - At Location)
                var locationDuration = endTime - startTime;
                var locationStartPercent = ((startTime - firstTime) / totalDuration) * 100;
                var locationWidthPercent = (locationDuration / totalDuration) * 100;
                
                var locationSegment = document.createElement('div');
                locationSegment.style.position = 'absolute';
                locationSegment.style.left = locationStartPercent + '%';
                locationSegment.style.width = locationWidthPercent + '%';
                locationSegment.style.height = '20px';
                locationSegment.style.top = '5px';
                locationSegment.style.background = '#28a745'; // Yeşil - At Location
                locationSegment.style.border = '1px solid #fff';
                locationSegment.style.borderRadius = '3px';
                locationSegment.style.cursor = 'pointer';
                
                // Tooltip
                var startTimeStr = new Date(startTime * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                var endTimeStr = new Date(endTime * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                var durationMinutes = Math.round(locationDuration / 60);
                
                locationSegment.title = (i + 1) + '. ' + currentLocation.clientname + '\n' +
                                       '<?php echo t('Duration'); ?>: ' + durationMinutes + ' <?php echo t('minutes'); ?>';
                
                // Segment numarası - yeşil için beyaz yazı
                var segmentNumber = document.createElement('div');
                segmentNumber.style.position = 'absolute';
                segmentNumber.style.top = '50%';
                segmentNumber.style.left = '50%';
                segmentNumber.style.transform = 'translate(-50%, -50%)';
                segmentNumber.style.color = 'white'; // Yeşil için beyaz yazı
                segmentNumber.style.fontWeight = 'bold';
                segmentNumber.style.fontSize = '12px';
                segmentNumber.textContent = i + 1;
                locationSegment.appendChild(segmentNumber);
                
                // Closure ile doğru değerleri yakala
                (function(locationIndex, locationData, duration, startTimeStr, endTimeStr, staffColor) {
                    locationSegment.addEventListener('mouseenter', function(e) {
                        showTimelinePopup(e, (locationIndex + 1) + '. ' + locationData.clientname + '\n' +
                                           '<?php echo t('Start Time'); ?>: ' + startTimeStr + '\n' +
                                           '<?php echo t('End Time'); ?>: ' + endTimeStr + '\n' +
                                           '<?php echo t('Duration'); ?>: ' + duration + ' <?php echo t('minutes'); ?>');
                    });
                    locationSegment.addEventListener('mouseleave', function() {
                        hideTimelinePopup();
                    });
                })(i, currentLocation, durationMinutes, startTimeStr, endTimeStr, color);
                
                timelineBar.appendChild(locationSegment);
                
                // Yol segmenti - mesafeye göre hesaplanan travel time
                if (nextLocation && i < sortedLocations.length - 1) {
                    var currentMarker = {lat: currentLocation.lat, lon: currentLocation.lon};
                    var nextMarker = {lat: nextLocation.lat, lon: nextLocation.lon};
                    
                    // İki nokta arası mesafe hesapla (km)
                    var distance = calculateDistance(currentMarker.lat, currentMarker.lon, nextMarker.lat, nextMarker.lon);
                    
                    // Ortalama hız 30 km/h (şehir içi)
                    var avgSpeed = 30; // km/h
                    var estimatedTravelTime = (distance / avgSpeed) * 3600; // saniye
                    
                    // Gerçek travel time
                    var realTravelStartTime = endTime;
                    var realTravelEndTime = nextLocation.real_start_time || (realTravelStartTime + estimatedTravelTime);
                    var realTravelDuration = realTravelEndTime - realTravelStartTime;
                    
                    // Travel time segment
                    var travelStartPercent = ((realTravelStartTime - firstTime) / totalDuration) * 100;
                    
                    // ZAMAN BOŞLUĞU OLMASA BİLE SİLİK YOLCULUK İŞARETİ EKLE
                    if (realTravelDuration <= 60) { // 1 dakika veya daha az ise silik işaret
                        // Silik yolculuk işareti - iki segment'in üzerinde
                        var ghostTravelIndicator = document.createElement('div');
                        ghostTravelIndicator.style.position = 'absolute';
                        ghostTravelIndicator.style.left = 'calc(' + travelStartPercent + '% - 10px)'; // Biraz sola kaydır
                        ghostTravelIndicator.style.width = '20px'; // Sabit genişlik
                        ghostTravelIndicator.style.height = '6px'; // Daha ince çizgi
                        ghostTravelIndicator.style.top = '12px'; // Segment'lerin tam ortasında (20px/2 + 5px - 3px)
                        ghostTravelIndicator.style.background = 'linear-gradient(90deg, rgba(255,193,7,0.2), rgba(255,193,7,0.8), rgba(255,193,7,0.2))';
                        ghostTravelIndicator.style.borderRadius = '3px';
                        ghostTravelIndicator.style.cursor = 'pointer';
                        ghostTravelIndicator.style.zIndex = '10';
                        ghostTravelIndicator.style.boxShadow = '0 1px 3px rgba(0,0,0,0.2)';
                        
                        // Yolculuk ok işareti ekle
                        var arrowIcon = document.createElement('div');
                        arrowIcon.style.position = 'absolute';
                        arrowIcon.style.top = '50%';
                        arrowIcon.style.left = '50%';
                        arrowIcon.style.transform = 'translate(-50%, -50%)';
                        arrowIcon.style.color = 'rgba(255,193,7,1)';
                        arrowIcon.style.fontSize = '10px';
                        arrowIcon.style.fontWeight = 'bold';
                        arrowIcon.style.textShadow = '0 1px 2px rgba(0,0,0,0.3)';
                        arrowIcon.textContent = '→';
                        ghostTravelIndicator.appendChild(arrowIcon);
                        
                        (function(currentLoc, nextLoc, dist, estTime) {
                            ghostTravelIndicator.addEventListener('mouseenter', function(e) {
                                showTimelinePopup(e, '🚗 <?php echo t('Quick Travel'); ?>: ' + currentLoc.clientname + ' → ' + nextLoc.clientname + '\n' +
                                                     '<?php echo t('Distance'); ?>: ' + dist.toFixed(1) + ' km\n' +
                                                     '<?php echo t('Estimated Time'); ?>: ' + estTime + ' <?php echo t('minutes'); ?>\n' +
                                                     '<?php echo t('Status'); ?>: <?php echo t('Expected travel'); ?>');
                            });
                            ghostTravelIndicator.addEventListener('mouseleave', function() {
                                hideTimelinePopup();
                            });
                        })(currentLocation, nextLocation, distance, Math.round(estimatedTravelTime / 60));
                        
                        timelineBar.appendChild(ghostTravelIndicator);
                        
                    } else if (realTravelDuration > estimatedTravelTime + 600) { // 10 dakika fazlaysa
                        // Fazla bekleme süresi - gri alan ekle
                        var extraWaitTime = realTravelDuration - estimatedTravelTime;
                        var estimatedTravelPercent = (estimatedTravelTime / totalDuration) * 100;
                        var extraWaitPercent = (extraWaitTime / totalDuration) * 100;
                        
                        // Travel segment (sarı)
                        var travelSegment = document.createElement('div');
                        travelSegment.style.position = 'absolute';
                        travelSegment.style.left = travelStartPercent + '%';
                        travelSegment.style.width = estimatedTravelPercent + '%';
                        travelSegment.style.height = '20px';
                        travelSegment.style.top = '5px';
                        travelSegment.style.background = '#ffc107';
                        travelSegment.style.border = '1px solid #fff';
                        travelSegment.style.borderRadius = '3px';
                        travelSegment.style.cursor = 'pointer';
                        
                        var estimatedMinutes = Math.round(estimatedTravelTime / 60);
                        
                        (function(currentLoc, nextLoc, dist, estMin, travelStart, travelEnd) {
                            travelSegment.addEventListener('mouseenter', function(e) {
                                var travelStartStr = new Date(travelStart * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                                var travelEndStr = new Date(travelEnd * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                                showTimelinePopup(e, '🚗 <?php echo t('Travel'); ?>: ' + currentLoc.clientname + ' → ' + nextLoc.clientname + '\n' +
                                                     '<?php echo t('Start Time'); ?>: ' + travelStartStr + '\n' +
                                                     '<?php echo t('End Time'); ?>: ' + travelEndStr + '\n' +
                                                     '<?php echo t('Distance'); ?>: ' + dist.toFixed(1) + ' km\n' +
                                                     '<?php echo t('Estimated Time'); ?>: ' + estMin + ' <?php echo t('minutes'); ?>');
                            });
                            travelSegment.addEventListener('mouseleave', function() {
                                hideTimelinePopup();
                            });
                        })(currentLocation, nextLocation, distance, estimatedMinutes, realTravelStartTime, realTravelStartTime + estimatedTravelTime);
                        
                        timelineBar.appendChild(travelSegment);
                        
                        // Wait segment (gri)
                        var waitSegment = document.createElement('div');
                        waitSegment.style.position = 'absolute';
                        waitSegment.style.left = (travelStartPercent + estimatedTravelPercent) + '%';
                        waitSegment.style.width = extraWaitPercent + '%';
                        waitSegment.style.height = '20px';
                        waitSegment.style.top = '5px';
                        waitSegment.style.background = '#6c757d';
                        waitSegment.style.border = '1px solid #fff';
                        waitSegment.style.borderRadius = '3px';
                        waitSegment.style.cursor = 'pointer';
                        
                        var waitMinutes = Math.round(extraWaitTime / 60);
                        
                        (function(waitMin, waitStart, waitEnd) {
                            waitSegment.addEventListener('mouseenter', function(e) {
                                var waitStartStr = new Date(waitStart * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                                var waitEndStr = new Date(waitEnd * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                                showTimelinePopup(e, '⏳ <?php echo t('Unknown Time'); ?>\n' +
                                                     '<?php echo t('Start Time'); ?>: ' + waitStartStr + '\n' +
                                                     '<?php echo t('End Time'); ?>: ' + waitEndStr + '\n' +
                                                     '<?php echo t('Duration'); ?>: ' + waitMin + ' <?php echo t('minutes'); ?>');
                            });
                            waitSegment.addEventListener('mouseleave', function() {
                                hideTimelinePopup();
                            });
                        })(waitMinutes, realTravelStartTime + estimatedTravelTime, realTravelEndTime);
                        
                        timelineBar.appendChild(waitSegment);
                        
                    } else {
                        // Normal travel segment
                        var travelWidthPercent = (realTravelDuration / totalDuration) * 100;
                        
                        var travelSegment = document.createElement('div');
                        travelSegment.style.position = 'absolute';
                        travelSegment.style.left = travelStartPercent + '%';
                        travelSegment.style.width = travelWidthPercent + '%';
                        travelSegment.style.height = '20px';
                        travelSegment.style.top = '5px';
                        travelSegment.style.background = '#ffc107';
                        travelSegment.style.border = '1px solid #fff';
                        travelSegment.style.borderRadius = '3px';
                        travelSegment.style.cursor = 'pointer';
                        
                        var travelMinutes = Math.round(realTravelDuration / 60);
                        
                        (function(currentLoc, nextLoc, dist, travelMin, travelStart, travelEnd) {
                            travelSegment.addEventListener('mouseenter', function(e) {
                                var travelStartStr = new Date(travelStart * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                                var travelEndStr = new Date(travelEnd * 1000).toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                                showTimelinePopup(e, '🚗 <?php echo t('Travel'); ?>: ' + currentLoc.clientname + ' → ' + nextLoc.clientname + '\n' +
                                                     '<?php echo t('Start Time'); ?>: ' + travelStartStr + '\n' +
                                                     '<?php echo t('End Time'); ?>: ' + travelEndStr + '\n' +
                                                     '<?php echo t('Distance'); ?>: ' + dist.toFixed(1) + ' km\n' +
                                                     '<?php echo t('Duration'); ?>: ' + travelMin + ' <?php echo t('minutes'); ?>');
                            });
                            travelSegment.addEventListener('mouseleave', function() {
                                hideTimelinePopup();
                            });
                        })(currentLocation, nextLocation, distance, travelMinutes, realTravelStartTime, realTravelEndTime);
                        
                        timelineBar.appendChild(travelSegment);
                    }
                }
            }
        }
    }

    // Mesafe hesaplama fonksiyonu (Haversine formula)
    function calculateDistance(lat1, lon1, lat2, lon2) {
        var R = 6371; // Dünya'nın yarıçapı km
        var dLat = (lat2 - lat1) * Math.PI / 180;
        var dLon = (lon2 - lon1) * Math.PI / 180;
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c; // km
    }
    
    // Timeline popup fonksiyonları
    var timelinePopup = null;
    
    function showTimelinePopup(event, content) {
        hideTimelinePopup();
        
        timelinePopup = document.createElement('div');
        timelinePopup.style.position = 'fixed';
        timelinePopup.style.background = 'rgba(0,0,0,0.8)';
        timelinePopup.style.color = 'white';
        timelinePopup.style.padding = '8px 12px';
        timelinePopup.style.borderRadius = '4px';
        timelinePopup.style.fontSize = '12px';
        timelinePopup.style.zIndex = '10000';
        timelinePopup.style.whiteSpace = 'pre-line';
        timelinePopup.style.maxWidth = '200px';
        timelinePopup.style.pointerEvents = 'none';
        timelinePopup.textContent = content;
        
        document.body.appendChild(timelinePopup);
        
        // Segment'in ortasında göster
        var target = event.target;
        var targetRect = target.getBoundingClientRect();
        var popupRect = timelinePopup.getBoundingClientRect();
        
        // Segment'in ortasına yerleştir
        var centerX = targetRect.left + (targetRect.width / 2);
        var topY = targetRect.top - popupRect.height - 10;
        
        timelinePopup.style.left = (centerX - popupRect.width / 2) + 'px';
        timelinePopup.style.top = topY + 'px';
    }
    
    function hideTimelinePopup() {
        if (timelinePopup) {
            document.body.removeChild(timelinePopup);
            timelinePopup = null;
        }
    }
});
<?php else: ?>

// Veri yokken de tarih değiştirme fonksiyonunu ekle
$(document).ready(function() {
    // Remove any existing loading spinner when page loads
    var existingOverlay = document.getElementById('date-loading-overlay');
    if (existingOverlay) {
        existingOverlay.remove();
    }
    
    $('#date').change(function() {
        var selectedDate = $(this).val();
        
        // Show loading spinner
        showDateLoadingSpinner();
        
        var url = '<?php echo $this->createUrl('staff/staffmap'); ?>?date=' + encodeURIComponent(selectedDate);
        window.location.href = url;
    });
});

// Date loading spinner function
function showDateLoadingSpinner() {
    // Create overlay
    var overlay = document.createElement('div');
    overlay.id = 'date-loading-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    `;
    
    // Create spinner container
    var spinnerContainer = document.createElement('div');
    spinnerContainer.style.cssText = `
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 30px 40px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    `;
    
    // Create spinner
    var spinner = document.createElement('div');
    spinner.style.cssText = `
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #4ade80;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px auto;
    `;
    
    // Create loading text
    var loadingText = document.createElement('div');
    loadingText.style.cssText = `
        font-weight: 600;
        font-size: 16px;
        color: #333;
        margin-bottom: 8px;
    `;
    loadingText.textContent = '<?php echo t('Loading'); ?>...';
    
    // Create date info
    var dateInfo = document.createElement('div');
    dateInfo.style.cssText = `
        font-size: 14px;
        color: #666;
    `;
    dateInfo.textContent = '<?php echo t('Fetching staff activities'); ?>';
    
    // Add CSS animation
    var style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    
    // Assemble elements
    spinnerContainer.appendChild(spinner);
    spinnerContainer.appendChild(loadingText);
    spinnerContainer.appendChild(dateInfo);
    overlay.appendChild(spinnerContainer);
    document.body.appendChild(overlay);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('⚠️ No staff activities found - Loading empty map');
    var map = L.map('map').setView([54.5, -2.0], 6); // İngiltere merkezi
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    console.log('✅ Empty map loaded');
});
<?php endif; ?>
</script> 