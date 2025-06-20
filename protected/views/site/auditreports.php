<?php
/* @var $this SiteController */
/* @var $workorders array */

$this->pageTitle=Yii::app()->name . ' - Inspection Reports';
?>

<div class="row">
    <div class="col-md-12">
        <div class="clearfix">
            <h1 style="float: left;"> <?=t('Inspection Reports')?></h1>
        </div>
        
        <?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
        <?php endif; ?>
        
        <!-- Main Content Area -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title" style="padding-top: 7px;"> <?=t('Completed Inspection Workorders')?></h3>
                    </div>
                    
                    <div class="panel-body" style="background-color: #fff; padding: 20px;">
                        <!-- Panel Description -->
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-12">
                                <p> <?=t('View and download completed audit reports')?></p>
                            </div>
                        </div>
                        
                        <!-- Workorders Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="workorderTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%"><?=t('Workorder ID')?></th>
                                        <th width="20%"><?=t('Customer')?></th>
                                        <th width="20%"><?=t('Date')?></th>
                                        <th width="25%"><?=t('Success Rate')?></th>
                                        <th width="15%"><?=t('Checklists')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($workorders) > 0): ?>
                                        <?php foreach($workorders as $index => $workorder): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo CHtml::encode($workorder['id']); ?></td>
                                                <td><?php echo CHtml::encode($workorder['customer_name']); ?></td>
                                                <td><?php echo CHtml::encode($workorder['date']); ?></td>
                                                <td>
                                                    <?php
                                                    // Get audit items for this workorder
                                                    $auditItems = Yii::app()->db->createCommand()
                                                        ->select('*')
                                                        ->from('audit_report_items')
                                                        ->where('workorder_id=:workorder_id', array(':workorder_id'=>$workorder['id']))
                                                        ->queryAll();
                                                    
                                                    // Calculate overall success rate from result column
                                                    $totalSuccessRates = 0;
                                                    $totalItemCount = count($auditItems);
                                                    $publishedItemCount = 0;
                                                    $overallSuccessRate = 0;
                                                    
                                                    if($totalItemCount > 0) {
                                                        // First check if ALL items are published
                                                        $allPublished = true;
                                                        
                                                        foreach($auditItems as $item) {
                                                            if (!(isset($item['is_published']) && $item['is_published'] == 1)) {
                                                                $allPublished = false;
                                                                break;
                                                            }
                                                            $publishedItemCount++;
                                                        }
                                                        
                                                        // Only calculate success rate if ALL items are published
                                                        if ($allPublished && $publishedItemCount == $totalItemCount) {
                                                            $totalSuccessRates = 0;
                                                            
                                                            foreach($auditItems as $item) {
                                                                // Use the result column directly
                                                                if (isset($item['result']) && $item['result'] !== null && $item['result'] !== '') {
                                                                    $itemSuccessRate = (int)$item['result'];
                                                                } else {
                                                                    // If no result is stored, default to 100%
                                                                    $itemSuccessRate = 100;
                                                                }
                                                                
                                                                // Ensure success rate is valid
                                                                if ($itemSuccessRate < 0) {
                                                                    $itemSuccessRate = 0;
                                                                } else if ($itemSuccessRate > 100) {
                                                                    $itemSuccessRate = 100;
                                                                }
                                                                
                                                                $totalSuccessRates += $itemSuccessRate;
                                                            }
                                                            
                                                            $overallSuccessRate = round($totalSuccessRates / $totalItemCount, 1);
                                                        } else {
                                                            // If not all items are published, set success rate to 0%
                                                            $overallSuccessRate = 0;
                                                        }
                                                    }
                                                    
                                                    // Determine color based on overall success rate
                                                    $barColor = '#dc3545'; // red
                                                    if ($overallSuccessRate >= 70) {
                                                        $barColor = '#28a745'; // green
                                                    } else if ($overallSuccessRate >= 50) {
                                                        $barColor = '#ffc107'; // yellow
                                                    } else if ($overallSuccessRate >= 30) {
                                                        $barColor = '#fd7e14'; // orange
                                                    }
                                                    ?>
                                                    
                                                    <div style="width: 100%; background-color: #e9ecef; border-radius: 4px; height: 20px; position: relative;">
                                                        <div style="width: <?php echo $overallSuccessRate; ?>%; background-color: <?php echo $barColor; ?>; height: 20px; border-radius: 4px; position: absolute; top: 0; left: 0;"></div>
                                                        <div style="position: absolute; width: 100%; text-align: center; color: #000; font-weight: bold; font-size: 12px; line-height: 20px;">
                                                            <?php echo $overallSuccessRate; ?>%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="display: flex; gap: 5px;">
                                                        <a href="<?php echo $this->createUrl('site/viewauditreport', array('id' => $workorder['id'])); ?>" class="btn btn-xs btn-primary" title="<?=t('View Report')?>">
                                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center"><?=t('No completed inspection workorders found')?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Document ready function
    $(document).ready(function() {
        // Initialize any plugins or components
    });
</script>
