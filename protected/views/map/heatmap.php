<?php
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


$clientid=$_GET['cbid'];
$mapid=$_GET['mapid'];
$shapes=Maps::model()->findByPk($mapid);
$datas=json_decode($shapes->points);
$canvasSize=json_decode($shapes->canvasSize);
if ($canvasSize==''){
  $canvasSize='{"width":1024,"height":768}';
}
$mapBackgroundImage=json_decode($shapes->mapBackgroundImage);
$imageSize=json_decode($shapes->imageSize);
$points=json_decode($shapes->monitor);



$monitoring=Monitoring::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'clientid='.$clientid.' and active=1',
							   ));

// Monitoring type renk bilgilerini alalım
$monitoringTypes = Yii::app()->db->createCommand()
    ->select('short_code, monitor_map_color, monitor_map_color_font, monitorbackgroundcolor, monitorfontcolor')
    ->from('monitoringtype')
    ->queryAll();

$typeColors = array();
foreach($monitoringTypes as $type) {
    $typeColors[$type['short_code']] = array(
        'bgColor' => !empty($type['monitor_map_color']) ? $type['monitor_map_color'] : $type['monitorbackgroundcolor'],
        'fontColor' => !empty($type['monitor_map_color_font']) ? $type['monitor_map_color_font'] : $type['monitorfontcolor'],
        'name' => $type['short_code']
    );
}

$lbls=[];
if (isset($_GET['mnos'])){
  
  
  $mnos=json_decode($points);
  //print_r($points);
  foreach ($mnos as $p){
    $lbls[get_string_between($p->label,'(',')')]=$p->id;
  }
 // print_r($lbls);

  $mnnn=explode(',',$_GET['mnos']);
  $mtypes = isset($_GET['mtypes']) ? explode(',',$_GET['mtypes']) : array();
  $mtypes=json_encode($mtypes);

  $yays=[];
  $buyuksayi=0;
    foreach($mnnn as $mit){
    $veri=explode('-',$mit);
      if ($buyuksayi<$veri[1]){
         $buyuksayi=$veri[1];
      }
    
  }
  if ($buyuksayi==0){
      $carpan=0;
  }else{
      $carpan=100/$buyuksayi;
  }

  
  
  foreach($mnnn as $mit){
    $veri=explode('-',$mit);
    $yays[$lbls[$veri[0]]]=floor($veri[1]*$carpan);
    
  }
  //print_r($yays);
  
  
  $heatMapRadii=json_encode($yays);
    $heatMapValues=json_encode($yays);
 
  
  //{"1742288602553":100,"1742288686831":20,"1742288774382":33}

  
  
} else {
  $mtypes = json_encode(array());
  $heatMapRadii = json_encode(array());
  $heatMapValues = json_encode(array());
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=t('Heat Map')?> <?=$mapid?></title>
    <link rel="stylesheet" href="/hmap/css/shared.css">
    <link rel="stylesheet" href="/hmap/css/heat-map.css?12">
</head>
<body>
    <style>
  .toolbar {
    float: none;
    }
      .nav{
        background: none;
            box-shadow: none;
    margin-bottom: 0;
      }
      .nav-link:hover{
          background-color: transparent !important;
      }
      
  </style>
    <script>
  
  
            localStorage.setItem('mapShapes', <?=$shapes->points?>);
            localStorage.setItem('canvasSize', '<?=$canvasSize?>');
            localStorage.setItem('mapBackgroundImage', '<?=$mapBackgroundImage?>');
            localStorage.setItem('imageSize', '<?=$imageSize?>');
            localStorage.setItem('observationPoints', '<?=$points?>');
            localStorage.setItem('heatMapRadii', '<?=$heatMapRadii?>');
            localStorage.setItem('heatMapValues', '<?=$heatMapValues?>');
            localStorage.setItem('typeColors', '<?=json_encode($typeColors)?>');
  
  </script>
    <nav class="nav" style="display:none;">
        <div class="container">
            <div class="nav-content">
                <a href="/map/" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7l5-5 5 5M3 17l5-5 5 5M13 7h8M13 17h8"/></svg>
                    <span><?=t('Map Drawing')?></span>
                </a>
                <a href="/map/monitors" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span><?=t('Monitoring Points')?></span>
                </a>
                <a href=/map/heatmap class="nav-link active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>
                    <span><?=t('Heat Map')?></span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container" >
        <div class="toolbar" style="display:none;">
            <div class="flex items-center justify-between">
                <div class="text-gray-600">
                    Gözlem noktalarına tıklayarak değerlerini düzenleyebilirsiniz
                </div>
                <button id="saveImageButton" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                    <span>Resim Olarak Kaydet</span>
                </button>
            </div>
        </div>

        <div class="canvas-container">
            <canvas id="canvas" width="1024" height="768"></canvas>
        </div>

        <div class="legend">
            <div class="monitor-types">
                <?php 
                // Haritada bulunan monitoring type'ları tespit et
                $mapMonitorTypes = array();
                if (isset($points) && !empty($points)) {
                    $pointsArray = json_decode($points, true);
                    if ($pointsArray) {
                        foreach($pointsArray as $point) {
                            if (isset($point['label'])) {
                                $typeCode = explode('(', $point['label'])[0];
                                $mapMonitorTypes[$typeCode] = true;
                            }
                        }
                    }
                }
                
                $activeTypes = isset($_GET['mtypes']) ? explode(',', $_GET['mtypes']) : array();
                foreach($typeColors as $code => $colors): 
                    // Sadece haritada bulunan ve aktif olan type'ları göster
                    if (!isset($mapMonitorTypes[$code])) continue;
                    if (!empty($activeTypes) && !in_array($code, $activeTypes)) continue;
                ?>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: <?=$colors['bgColor']?>; width: 20px; height: 20px; border-radius: 50%;"></div>
                    <span><?=$code?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if (!isset($_GET['noact'])): ?>
            <div class="activity-levels">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: rgba(0, 0, 255, 0.5);"></div>
                    <span><?=t('Low Activity')?></span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: rgba(255, 165, 0, 0.5);"></div>
                    <span><?=t('Medium Activity')?></span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: rgba(255, 0, 0, 0.5);"></div>
                    <span><?=t('High Activity')?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div id="pointModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Monitör Noktası Detayları</h2>
                    <button class="close-button">×</button>
                </div>
                <div class="modal-body">
                    <div id="pointLabel" class="text-lg font-semibold text-center mb-4"></div>
                    <div class="slider-container">
                        <span class="slider-label">Değer:</span>
                        <input type="range" id="modalValueSlider" min="0" max="100" value="0" class="slider">
                        <span id="modalValueDisplay" class="slider-value">0</span>
                    </div>
                    <div class="slider-container mt-4">
                        <span class="slider-label">Yayılım:</span>
                        <input type="range" id="modalRadiusSlider" min="20" max="100" value="40" class="slider">
                        <span id="modalRadiusDisplay" class="slider-value">40</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .legend {
        background: white;
        padding: 20px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        max-width: 1024px;
    }

    .monitor-types {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
        justify-content: center;
    }

    .activity-levels {
        display: flex;
        gap: 30px;
        align-items: center;
        justify-content: center;
    }

    .legend-item {
        display: flex;
        align-items: center;
        white-space: nowrap;
        font-size: 13px;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        margin-right: 8px;
        border-radius: 4px;
        flex-shrink: 0;
    }
    </style>

    <script src="/hmap/js/utils.js"></script>
<script>
  class HeatMap {
    constructor() {
        this.canvas = document.getElementById('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.points = [];
        this.shapes = [];
        this.selectedPoint = null;
        this.pointValues = {};
        this.pointRadii = {};
        this.backgroundImage = null;
        this.canvasSize = { width: 1024, height: 768 };
        this.imageSize = { width: 0, height: 0, scale: 1 };
        this.typeColors = JSON.parse(localStorage.getItem('typeColors') || '{}');
        
        this.initializeModalElements();
        this.loadSavedData();
        this.setupEventListeners();
        this.draw();
    }

    initializeModalElements() {
        this.modal = document.getElementById('pointModal');
        this.modalPointLabel = document.getElementById('pointLabel');
        this.modalValueSlider = document.getElementById('modalValueSlider');
        this.modalValueDisplay = document.getElementById('modalValueDisplay');
        this.modalRadiusSlider = document.getElementById('modalRadiusSlider');
        this.modalRadiusDisplay = document.getElementById('modalRadiusDisplay');
        
        if (!this.modal || !this.modalPointLabel || !this.modalValueSlider || 
            !this.modalValueDisplay || !this.modalRadiusSlider || !this.modalRadiusDisplay) {
            console.error('Modal elements not found');
        }
    }

    loadSavedData() {
        const savedPoints = localStorage.getItem('observationPoints');
        const savedShapes = localStorage.getItem('mapShapes');
        const savedValues = localStorage.getItem('heatMapValues');
        const savedRadii = localStorage.getItem('heatMapRadii');
        const savedImageData = localStorage.getItem('mapBackgroundImage');
        const savedCanvasSize = localStorage.getItem('canvasSize');
        const savedImageSize = localStorage.getItem('imageSize');
        
        if (savedPoints) {
            this.points = JSON.parse(savedPoints);
        }
        
        if (savedShapes) {
            this.shapes = JSON.parse(savedShapes);
        }
        
        if (savedValues) {
            this.pointValues = JSON.parse(savedValues);
        }
        
        if (savedRadii) {
            this.pointRadii = JSON.parse(savedRadii);
        }

        if (savedCanvasSize) {
            const newSize = JSON.parse(savedCanvasSize);
            this.canvas.width = newSize.width;
            this.canvas.height = newSize.height;
            this.canvasSize = newSize;
        }

        if (savedImageSize) {
            this.imageSize = JSON.parse(savedImageSize);
        }
        
        if (savedImageData) {
            const img = new Image();
            img.src = savedImageData;
            img.onload = () => {
                this.backgroundImage = img;
                if (!savedImageSize) {
                    const scale = Math.min(
                        this.canvas.width / img.width,
                        this.canvas.height / img.height
                    );
                    this.imageSize = {
                        width: img.width,
                        height: img.height,
                        scale: scale
                    };
                }
                this.draw();
            };
        }
    }

    setupEventListeners() {
        //this.canvas.addEventListener('click', this.handlePointClick.bind(this));
        
        if (this.modalValueSlider) {
            this.modalValueSlider.addEventListener('input', (e) => {
                if (!this.selectedPoint) return;
                const value = parseInt(e.target.value);
                this.modalValueDisplay.textContent = value;
                this.pointValues[this.selectedPoint.id] = value;
                localStorage.setItem('heatMapValues', JSON.stringify(this.pointValues));
                this.draw();
            });
        }

        if (this.modalRadiusSlider) {
            this.modalRadiusSlider.addEventListener('input', (e) => {
                if (!this.selectedPoint) return;
                const radius = parseInt(e.target.value);
                this.modalRadiusDisplay.textContent = radius;
                this.pointRadii[this.selectedPoint.id] = radius;
                localStorage.setItem('heatMapRadii', JSON.stringify(this.pointRadii));
                this.draw();
            });
        }

        const saveImageButton = document.getElementById('saveImageButton');
        if (saveImageButton) {
            saveImageButton.addEventListener('click', this.saveImage.bind(this));
        }

        // Modal close button
        if (this.modal) {
            const closeButton = this.modal.querySelector('.close-button');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    this.modal.style.display = 'none';
                });
            }

            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.modal.style.display = 'none';
                }
            });

            // Close modal with Escape key
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.modal.style.display = 'none';
                }
            });
        }
    }

    handlePointClick(e) {
        const rect = this.canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const clickedPoint = this.points.find(point => {
            const distance = Math.sqrt(Math.pow(point.x - x, 2) + Math.pow(point.y - y, 2));
            return distance < 10;
        });

        if (clickedPoint) {
            this.selectedPoint = clickedPoint;
            this.showPointModal(clickedPoint);
        } else {
            this.selectedPoint = null;
            if (this.modal) {
                this.modal.style.display = 'none';
            }
        }

        this.draw();
    }

    showPointModal(point) {
        if (!this.modal || !this.modalPointLabel || !this.modalValueSlider || 
            !this.modalValueDisplay || !this.modalRadiusSlider || !this.modalRadiusDisplay) return;

        this.modalPointLabel.textContent = point.label;
        
        const currentValue = this.pointValues[point.id] || 0;
        this.modalValueSlider.value = currentValue;
        this.modalValueDisplay.textContent = currentValue;

        const currentRadius = this.pointRadii[point.id] || 40;
        this.modalRadiusSlider.value = currentRadius;
        this.modalRadiusDisplay.textContent = currentRadius;

        this.modal.style.display = 'flex';
    }

    // Renkleri karşılaştıran yardımcı fonksiyon
    normalizeColor(color) {
        // Renk kodunu standart formata çevirir (#RRGGBB)
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = color;
        return ctx.fillStyle;
    }

    // İki rengin aynı olup olmadığını kontrol eden fonksiyon
    areSameColors(color1, color2) {
        return this.normalizeColor(color1) === this.normalizeColor(color2);
    }

    draw() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        if (this.backgroundImage) {
            const scaledWidth = this.backgroundImage.width * this.imageSize.scale;
            const scaledHeight = this.backgroundImage.height * this.imageSize.scale;
            const x = (this.canvas.width - scaledWidth) / 2;
            const y = (this.canvas.height - scaledHeight) / 2;
            this.ctx.drawImage(this.backgroundImage, x, y, scaledWidth, scaledHeight);
        }

        // Draw shapes
        this.shapes.forEach(shape => {
            this.ctx.beginPath();
            this.ctx.strokeStyle = shape.color;
            this.ctx.fillStyle = shape.color;
            this.ctx.lineWidth = 2;

            if (shape.isDashed) {
                this.ctx.setLineDash([5, 5]);
            } else {
                this.ctx.setLineDash([]);
            }

            if (shape.type === 'text') {
                this.ctx.font = '16px Arial';
                this.ctx.textBaseline = 'top';
                const text = shape.text || '';
                this.ctx.fillText(text, shape.x, shape.y);
            } else if (shape.type.includes('arrow')) {
                const headLength = 15;
                const angle = Math.atan2(shape.height, shape.width);
                
                this.ctx.beginPath();
                this.ctx.moveTo(shape.x, shape.y);
                this.ctx.lineTo(shape.x + shape.width, shape.y + shape.height);
                this.ctx.stroke();

                this.ctx.beginPath();
                this.ctx.moveTo(shape.x + shape.width, shape.y + shape.height);
                this.ctx.lineTo(
                    shape.x + shape.width - headLength * Math.cos(angle - Math.PI / 6),
                    shape.y + shape.height - headLength * Math.sin(angle - Math.PI / 6)
                );
                this.ctx.moveTo(shape.x + shape.width, shape.y + shape.height);
                this.ctx.lineTo(
                    shape.x + shape.width - headLength * Math.cos(angle + Math.PI / 6),
                    shape.y + shape.height - headLength * Math.sin(angle + Math.PI / 6)
                );
                this.ctx.stroke();
            } else if (shape.type === 'line' || shape.type === 'dashed-line') {
                this.ctx.moveTo(shape.x, shape.y);
                this.ctx.lineTo(shape.x + shape.width, shape.y + shape.height);
                this.ctx.stroke();
            } else if (shape.type.includes('rectangle')) {
                this.ctx.rect(shape.x, shape.y, shape.width, shape.height);
                if (shape.type.includes('filled')) {
                    this.ctx.fill();
                }
                this.ctx.stroke();
            } else if (shape.type.includes('triangle')) {
                this.ctx.moveTo(shape.x + shape.width / 2, shape.y);
                this.ctx.lineTo(shape.x, shape.y + shape.height);
                this.ctx.lineTo(shape.x + shape.width, shape.y + shape.height);
                this.ctx.closePath();
                if (shape.type.includes('filled')) {
                    this.ctx.fill();
                }
                this.ctx.stroke();
            } else if (shape.type.includes('circle')) {
                const radius = Math.min(Math.abs(shape.width), Math.abs(shape.height)) / 2;
                this.ctx.arc(
                    shape.x + shape.width /  2,
                    shape.y + shape.height / 2,
                    radius,
                    0,
                    2 * Math.PI
                );
                if (shape.type.includes('filled')) {
                    this.ctx.fill();
                }
                this.ctx.stroke();
            }
        });

        // Draw points
        this.points.forEach(point => {
            const value = this.pointValues[point.id] || 0;
            const radius = this.pointRadii[point.id] || 0;

            const labels = <?=$mtypes?>;

            if (labels && labels.length > 0 && labels.some(label => point.label.includes(label+'('))) {
            } else if (labels && labels.length > 0) {
                return;
            }

            // Draw heat gradient with multiple layers for intensity
            for (let i = 0; i < 3; i++) {
                const gradient = this.ctx.createRadialGradient(
                    point.x,
                    point.y,
                    0,
                    point.x,
                    point.y,
                    radius * (1 - i * 0.2)
                );
                
                gradient.addColorStop(0, getHeatMapColor(value, 0.4));
                gradient.addColorStop(1, getHeatMapColor(value, 0.1));
                
                this.ctx.beginPath();
                this.ctx.fillStyle = gradient;
                this.ctx.arc(point.x, point.y, radius * (1 - i * 0.2), 0, 2 * Math.PI);
                this.ctx.fill();
            }

            // Get monitoring type code (text before parenthesis)
            const typeCode = point.label.split('(')[0];
            const colors = this.typeColors[typeCode] || { bgColor: '#3B82F6', fontColor: '#FFFFFF' };

            // Draw point
            this.ctx.beginPath();
            const pointColor = this.selectedPoint?.id === point.id ? '#3B82F6' : colors.bgColor;
            this.ctx.fillStyle = pointColor;
            this.ctx.arc(point.x, point.y, 15, 0, 2 * Math.PI);
            this.ctx.fill();
            
            // Draw label
            this.ctx.font = 'bold 12px Arial';
            
            // Kontrastı artırmak için daha basit renk seçimi
            let textColor = colors.fontColor || '#FFFFFF';
            
            // Eğer arka plan rengi açık renkse (beyaz, sarı vb.) siyah yazı kullan
            const bgColor = colors.bgColor || '#3B82F6';
            if (bgColor === '#FFFFFF' || bgColor === '#ffffff' || 
                bgColor === '#FFFF00' || bgColor === '#ffff00' ||
                bgColor === '#YELLOW' || bgColor === 'yellow' ||
                bgColor.toLowerCase().includes('white') || 
                bgColor.toLowerCase().includes('yellow')) {
                textColor = '#000000';
            }
            
            this.ctx.fillStyle = textColor;
            this.ctx.textAlign = 'center';
            this.ctx.textBaseline = 'middle';
            
            // Yazının etrafına gölge ekleyelim görünürlüğü artırmak için
            this.ctx.shadowColor = textColor === '#000000' ? '#FFFFFF' : '#000000';
            this.ctx.shadowBlur = 2;
            this.ctx.shadowOffsetX = 1;
            this.ctx.shadowOffsetY = 1;
            
            const labelNumber = point.label.match(/\((\d+)\)/);
            if (labelNumber && labelNumber[1]) {
                this.ctx.fillText(labelNumber[1], point.x, point.y);
            }
            
            // Gölgeyi sıfırla
            this.ctx.shadowColor = 'transparent';
            this.ctx.shadowBlur = 0;
            this.ctx.shadowOffsetX = 0;
            this.ctx.shadowOffsetY = 0;
        });
    }

    saveImage() {
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = this.canvas.width;
        tempCanvas.height = this.canvas.height;
        const tempCtx = tempCanvas.getContext('2d');

        tempCtx.fillStyle = '#ffffff';
        tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
        tempCtx.drawImage(this.canvas, 0, 0);

        const link = document.createElement('a');
        link.download = 'heat-map.png';
        link.href = tempCanvas.toDataURL('image/png');
        link.click();
    }
}

// Initialize the heat map
document.addEventListener('DOMContentLoaded', () => {
    new HeatMap();
});
  </script>
</body>
</html>