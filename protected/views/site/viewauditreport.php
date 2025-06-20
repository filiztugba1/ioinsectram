<?php
/* @var $this SiteController */
/* @var $workorder array */
/* @var $auditReportItems array */
/* @var $availableAudits array */

$this->pageTitle=Yii::app()->name . ' - View Inspection Report';
?>

<div class="row">
    <div class="col-md-12">
        <div class="clearfix">
            <h1 style="float: left;"><?=t('Inspection Report for Workorder')?> #<?php echo CHtml::encode($workorder['id']); ?></h1>
            <div style="float: right; margin-top: 20px;">
                <a href="<?php echo $this->createUrl('auditreports'); ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> <?=t('Back to Reports')?>
                </a>
            </div>
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
        
        <?php if(Yii::app()->user->hasFlash('info')): ?>
        <div class="alert alert-info">
            <?php echo Yii::app()->user->getFlash('info'); ?>
        </div>
        <?php endif; ?>
        
        <!-- Workorder Details Panel -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?=t('Workorder Details')?></h3>
            </div>
            <div class="panel-body" style="background-color: #fff; padding: 20px;">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%"><?=t('Workorder ID')?></th>
                                <td><?php echo CHtml::encode($workorder['id']); ?></td>
                            </tr>
                            <tr>
                                <th><?=t('Customer')?></th>
                                <td><?php echo CHtml::encode($workorder['customer_name']); ?></td>
                            </tr>
                        
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%"><?=t('Date')?></th>
                                <td><?php echo CHtml::encode($workorder['date']); ?></td>
                            </tr>
                            <tr>
                                <th><?=t('Status')?></th>
                                <td>
                                    <?php 
                                    $statusLabels = array(
                                        0 => '<span class="label label-default">Active</span>',
                                        1 => '<span class="label label-info">Doing</span>',
                                        2 => '<span class="label label-warning">Paused</span>',
                                        3 => '<span class="label label-success">Done</span>',
                                        4 => '<span class="label label-danger">Missing Monitor</span>',
                                        5 => '<span class="label label-danger">Missing Report</span>'
                                    );
                                    echo isset($statusLabels[$workorder['status']]) ? $statusLabels[$workorder['status']] : 'Unknown';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?=t('Checklist')?></th>
                                <td>
                                    <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#addAuditModal">
                                        <i class="fa fa-plus"></i> <?=t('Checklist Ekle')?>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Audit Items Panel -->
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <h3 class="panel-title" style="padding-top: 7px;"><?=t('Inspection Items')?></h3>
            </div>
            <?php
            // Calculate overall success rate
            $totalSuccessRates = 0;
            $totalItemCount = count($auditReportItems);
            $publishedItemCount = 0;
            $overallSuccessRate = 0;
            
            // Log for debugging
            error_log('Calculating success rates for items: ' . $totalItemCount);
            
            // First check if ALL items are published
            $allPublished = true;
            
            if($totalItemCount > 0) {
                foreach($auditReportItems as $item) {
                    if (!(isset($item['is_published']) && $item['is_published'] == 1)) {
                        $allPublished = false;
                        error_log('Item #' . $item['id'] . ' is not published, setting overall success rate to 0');
                        break;
                    }
                    $publishedItemCount++;
                }
                
                // Only calculate success rate if ALL items are published
                if ($allPublished && $publishedItemCount == $totalItemCount) {
                    error_log('All ' . $publishedItemCount . ' items are published, calculating success rate');
                    
                    foreach($auditReportItems as $item) {
                        // Check if result is stored in the database
                        if (isset($item['result']) && $item['result'] !== null && $item['result'] !== '') {
                            // Use the stored success rate from the database
                            $itemSuccessRate = (int)$item['result'];
                            error_log('Item #' . $item['id'] . ' has success rate: ' . $itemSuccessRate);
                        } else {
                            // If no result is stored, default to 100% (same as fillaudititem)
                            $itemSuccessRate = 100;
                            
                            // Update the database with the default value
                            try {
                                Yii::app()->db->createCommand()->update('audit_report_items', 
                                    array('result' => $itemSuccessRate), 
                                    'id=:id', array(':id' => $item['id']));
                                error_log('Updated item #' . $item['id'] . ' with default success rate: 100');
                            } catch (Exception $e) {
                                error_log('Error updating success rate: ' . $e->getMessage());
                            }
                        }
                        
                        $totalSuccessRates += $itemSuccessRate;
                    }
                    
                    if ($totalItemCount > 0) {
                        $overallSuccessRate = round($totalSuccessRates / $totalItemCount, 1);
                        error_log('Overall success rate calculated: ' . $overallSuccessRate . '%');
                    }
                } else {
                    // If not all items are published, set success rate to 0%
                    $overallSuccessRate = 0;
                    error_log('Not all items are published (' . $publishedItemCount . '/' . $totalItemCount . '), success rate set to 0%');
                }
            }
            
            // Determine color based on overall success rate
            $overallBarColor = '#dc3545'; // red
            if ($overallSuccessRate >= 70) {
                $overallBarColor = '#28a745'; // green
            } else if ($overallSuccessRate >= 50) {
                $overallBarColor = '#ffc107'; // yellow
            } else if ($overallSuccessRate >= 30) {
                $overallBarColor = '#fd7e14'; // orange
            }
            ?>
            
            <!-- Overall Success Rate Bar -->
            <div class="panel-body" style="background-color: #f8f9fa; padding: 15px; border-bottom: 1px solid #ddd;">
                <h4 style="margin-top: 0; margin-bottom: 10px;"><?=t('Toplam Başarı')?></h4>
                <div style="width: 100%; background-color: #e9ecef; border-radius: 4px; height: 25px; position: relative;">
                    <div style="width: <?php echo $overallSuccessRate; ?>%; background-color: <?php echo $overallBarColor; ?>; height: 25px; border-radius: 4px; position: absolute; top: 0; left: 0;"></div>
                    <div style="position: absolute; width: 100%; text-align: center; color: #000; font-weight: bold; font-size: 14px; line-height: 25px;">
                        <?php echo $overallSuccessRate; ?>%
                    </div>
                </div>
            </div>
            <div class="panel-body" style="background-color: #fff; padding: 20px;">
                <?php if(count($auditReportItems) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%"><?=t('Name')?></th>
                                    <th width="15%"><?=t('Category')?></th>
                                    <th width="25%"><?=t('Description')?></th>
                                    <th width="20%"><?=t('Success Rate')?></th>
                                    <th width="15%"><?=t('Actions')?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($auditReportItems as $index => $item): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo CHtml::encode($item['name']); ?></td>
                                        <td>
                                            <?php 
                                            // Get category name
                                            $categoryName = Yii::app()->db->createCommand()
                                                ->select('name')
                                                ->from('audit_categories')
                                                ->where('id=:id', array(':id'=>$item['category_id']))
                                                ->queryScalar();
                                            echo CHtml::encode($categoryName); 
                                            ?>
                                        </td>
                                        <td><?php echo CHtml::encode(substr($item['description'], 0, 100)) . (strlen($item['description']) > 100 ? '...' : ''); ?></td>
                                        <td>
                                            <?php
                                            // Check if item is published
                                            if (isset($item['is_published']) && $item['is_published'] == 1) {
                                                // Get success rate from the database result field
                                                if (isset($item['result']) && $item['result'] !== null && $item['result'] !== '') {
                                                    $successRate = (int)$item['result'];
                                                } else {
                                                    // If no result is stored, default to 100% (same as fillaudititem)
                                                    $successRate = 100;
                                                }
                                            } else {
                                                // If item is not published, set success rate to 0%
                                                $successRate = 0;
                                            }
                                            
                                            // Log for debugging
                                            error_log('Item ID: ' . $item['id'] . ' has result value: ' . $successRate . ', is_published: ' . (isset($item['is_published']) ? $item['is_published'] : 'not set'));
                                            
                                            // Determine color based on success rate
                                            $barColor = '#dc3545'; // red
                                            if ($successRate >= 70) {
                                                $barColor = '#28a745'; // green
                                            } else if ($successRate >= 50) {
                                                $barColor = '#ffc107'; // yellow
                                            } else if ($successRate >= 30) {
                                                $barColor = '#fd7e14'; // orange
                                            }
                                            ?>
                                            
                                            <div style="width: 100%; background-color: #e9ecef; border-radius: 4px; height: 20px; position: relative;">
                                                <div style="width: <?php echo $successRate; ?>%; background-color: <?php echo $barColor; ?>; height: 20px; border-radius: 4px; position: absolute; top: 0; left: 0;"></div>
                                                <div style="position: absolute; width: 100%; text-align: center; color: #000; font-weight: bold; font-size: 12px; line-height: 20px;">
                                                    <?php echo $successRate; ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 5px;">
                                                <a href="<?php echo $this->createUrl('fillaudititem', array('id' => $workorder['id'], 'item_id' => $item['id'])); ?>" class="btn btn-xs btn-success" title="Fill Inspection">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="<?php echo $this->createUrl('downloadaudititemreport', array('workorder_id' => $workorder['id'], 'item_id' => $item['id'])); ?>" class="btn btn-xs btn-primary" title="Download PDF Report">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="<?php echo $this->createUrl('viewauditreport', array('id' => $workorder['id'], 'remove' => $item['id'])); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to remove this inspection from the report?');" title="Remove Inspection">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <?=t('No inspection items have been added to this report yet. Click the "Add Inspection" button to add an inspection.')?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- PDF Preview Modal -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%; height: 90%;">
        <div class="modal-content" style="height: 90vh;">
            <div class="modal-header">
               <center> <h4 class="modal-title" id="pdfPreviewModalLabel"><?=t('PDF Report Preview')?></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" style="height: calc(100% - 120px); padding: 0; position: relative;">
                <!-- Loading indicator -->
                <div id="pdfLoadingIndicator" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #f5f5f5; z-index: 10; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw" style="color: #337ab7; margin-bottom: 15px;"></i>
                        <h4><?=t('PDF Yükleniyor...')?></h4>
                        <p><?=t('Lütfen bekleyin, PDF raporu hazırlanıyor.')?></p>
                    </div>
                </div>
                <iframe id="pdfPreviewFrame" style="width: 100%; height: 100%; border: none;" onload="document.getElementById('pdfLoadingIndicator').style.display='none';"></iframe>
            </div>
            <div class="modal-footer">
                <a id="downloadPdfLink" href="#" class="btn btn-primary" target="_blank"><?=t('Download PDF')?></a>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=t('Close')?></button>
            </div>
        </div>
    </div>
</div>

<!-- Add Audit Modal -->
<div class="modal fade" id="addAuditModal" tabindex="-1" role="dialog" aria-labelledby="addAuditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addAuditModalLabel"><?=t('Add Inspection to Report')?></h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="audit_id"><?=t('Select Inspection')?></label>
                        <select name="audit_id" id="audit_id" class="form-control" required>
                            <option value="">-- <?=t('Select an Inspection')?> --</option>
                            <?php if(count($availableAudits) > 0): ?>
                                <?php foreach($availableAudits as $audit): ?>
                                    <option value="<?php echo $audit['id']; ?>">
                                        <?php echo CHtml::encode($audit['name']); ?> 
                                        (<?php echo CHtml::encode($audit['category_name']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled><?=t('All inspection have been added to this report')?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=t('Cancel')?></button>
                    <button type="submit" class="btn btn-primary"><?=t('Add to Report')?></button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        // JavaScript code for other functionality can go here
    });
    
    // Function to show PDF preview in modal
    function showPdfPreview(workorderId, itemId) {
        // Use the new preview action for viewing in browser
        var previewUrl = '<?php echo $this->createUrl("previewaudititemreport"); ?>?workorder_id=' + workorderId + '&item_id=' + itemId;
        // Regular download URL
        var downloadUrl = '<?php echo $this->createUrl("downloadaudititemreport"); ?>?workorder_id=' + workorderId + '&item_id=' + itemId;
        
        // Set the iframe source and download link
        $('#pdfPreviewFrame').attr('src', previewUrl);
        $('#downloadPdfLink').attr('href', downloadUrl);
        
        // Show the modal
        $('#pdfPreviewModal').modal('show');
    }
</script>
