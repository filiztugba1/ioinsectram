<?php
/* @var $this SiteController */
/* @var $model array */
/* @var $audits array */
/* @var $categoryDropdown array */
/* @var $isEdit boolean */
/* @var $editId integer */
/* @var $questions string */

$this->pageTitle=Yii::app()->name . ' - Audit List Management';
?>

<div class="row">
    <div class="col-md-12">
        <div class="clearfix">
            <h1 style="float: left;"><?=t('Inspection List Management')?></h1>
            <?php if($isEdit): ?>
            <div style="float: right; margin-top: 10px;margin-bottom: 10px;">
                <a href="<?php echo $this->createUrl('site/audits'); ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> <?=t('Back to Inspections List')?>
                </a>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php endif; ?>
        
        <!-- Main Content Area -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <div class="pull-right">
                            <button type="button" class="btn btn-success" id="addAuditBtn" style="margin-bottom: 10px;">
                                <i class="fa fa-plus"></i> <?=t('Add Inspection')?>
                            </button>
                        </div>
                        <h3 class="panel-title" style="padding-top: 7px;"><?=t('Inspection List')?></h3>
                    </div>
                    
                    <div class="panel-body" style="background-color: #fff; padding: 20px;">
                        <!-- Search Box -->
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm" style="max-width: 300px;">
                                    <input type="text" id="auditSearchInput" class="form-control" placeholder="<?=t('Search inspections...')?>" onkeyup="filterAudits()" style="height: 30px; border-radius: 3px 0 0 3px;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" style="height: 30px; padding: 5px 10px; border-radius: 0 3px 3px 0;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Audit List Content -->
                        <div id="auditListContent">
                                <?php if(empty($audits)): ?>
                                    <div class="alert alert-info"><?=t('No inspection found. Click the "Add Inspection" button to create your first Inspection.')?></div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="auditTable">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="20%"><?=t('Name')?></th>
                                                    <th width="15%"><?=t('Category')?></th>
                                                    <th width="25%"><?=t('Description')?></th>
                                                    <th width="10%"><?=t('Questions')?></th>
                                                    <th width="10%"><?=t('Created At')?></th>
                                                    <th width="15%"><?=t('Actions')?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($audits as $index => $audit): ?>
                                                    <tr>
                                                        <td><?php echo $index + 1; ?></td>
                                                        <td style="cursor: pointer;" onclick="window.location='<?php echo $this->createUrl('site/auditsedit', array('edit' => $audit['id'])); ?>'">
                                                            <span style="color: #337ab7; text-decoration: underline;"><?php echo CHtml::encode($audit['name']); ?></span>
                                                        </td>
                                                        <td><?php echo CHtml::encode($audit['category_name']); ?></td>
                                                        <td><?php echo CHtml::encode(substr($audit['description'], 0, 100)) . (strlen($audit['description']) > 100 ? '...' : ''); ?></td>
                                                        <td style="cursor: pointer;" onclick="window.location='<?php echo $this->createUrl('site/auditsedit', array('edit' => $audit['id'])); ?>'">
                                                            <span class="badge questions-badge" style="background-color: #5bc0de; font-size: 12px;" 
                                                                  data-toggle="popover" 
                                                                  data-placement="right" 
                                                                  data-html="true" 
                                                                  data-questions='<?php echo CHtml::encode($audit['questions_preview']); ?>'>
                                                                <?php echo $audit['question_count']; ?> questions
                                                            </span>
                                                        </td>
                                                        <td><?php echo date('Y-m-d', strtotime($audit['created_at'])); ?></td>
                                                        <td>
                                                            <div style="display: flex; gap: 5px;">
                                                                <a href="<?php echo $this->createUrl('site/auditsedit', array('edit' => $audit['id'])); ?>" class="btn btn-xs btn-primary" title="Edit">
                                                                    <i style="color:#fff;" class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="<?php echo $this->createUrl('site/audits', array('copy' => $audit['id'])); ?>" class="btn btn-xs btn-success" title="Copy"
                                                                   onclick="return confirm('Are you sure you want to create a copy of this Inspection?');">
                                                                    <i style="color:#fff;" class="fa fa-copy"></i>
                                                                </a>
                                                                <a href="<?php echo $this->createUrl('site/audits', array('delete' => $audit['id'])); ?>" class="btn btn-xs btn-danger" 
                                                                   onclick="return confirm('<?=t('Are you sure you want to delete this Inspection?')?>');" title="Delete">
                                                                    <i style="color:#fff;" class="fa fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Edit Audit Form Overlay -->
                        <?php if($isEdit): ?>
                        <div id="editAuditOverlay" class="audit-form-overlay" style="display: block;">
                                <form method="post" action="" id="editAuditForm">
                                    <input type="hidden" name="edit_id" value="<?php echo $editId; ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_audit_name"><?=t('Inspection Name')?></label>
                                                <input type="text" class="form-control" id="edit_audit_name" name="name" value="<?php echo CHtml::encode($model['name']); ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_audit_description"><?=t('Description')?></label>
                                                <textarea class="form-control" id="edit_audit_description" name="description" rows="2"><?php echo CHtml::encode($model['description']); ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_audit_category_id"><?=t('Category2')?></label>
                                                <select class="form-control" id="edit_audit_category_id" name="category_id" required>
                                                    <option value=""><?=t('Select a category')?></option>
                                                    <?php foreach($categoryDropdown as $id => $category): ?>
                                                        <?php if(!empty($id)): ?>
                                                            <?php if(is_array($category)): ?>
                                                                <?php if($category['is_parent']): ?>
                                                                    <option value="<?php echo $id; ?>" disabled style="font-weight: bold; color: #666;">
                                                                        <?php echo CHtml::encode($category['name']); ?>
                                                                    </option>
                                                                <?php else: ?>
                                                                    <option value="<?php echo $id; ?>" <?php echo $model['category_id'] == $id ? 'selected' : ''; ?>>
                                                                        <?php echo CHtml::encode($category['name']); ?>
                                                                    </option>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <option value="<?php echo $id; ?>" <?php echo $model['category_id'] == $id ? 'selected' : ''; ?>>
                                                                    <?php echo CHtml::encode($category); ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Question Management Interface -->
                                    <div class="form-group" style="margin-top: 10px;">
                                        <input type="hidden" id="edit-questions-json" name="questions" value='<?php echo $questions; ?>'>
                                        
                                        <div id="edit-question-management">
                                            <div class="page-header" style="margin-top: 20px;">
                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                    <h4><?=t('Manage Questions')?></h4>
                                                    <button type="button" class="btn btn-primary" onclick="addNewQuestion('edit')" style="margin-bottom: 15px;">
                                                        <span class="glyphicon glyphicon-plus"></span> <?=t('Add New Question')?>
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="edit-question-form" class="question-form" style="display: none; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                                                <h4 id="edit-question-form-title"><?=t('Add New Question')?></h4>
                                                <div class="form-group">
                                                    <label for="edit-question-text"><?=t('Question Text')?></label>
                                                    <textarea id="edit-question-text" class="form-control" rows="3" placeholder="<?=t('Enter inspection question')?>"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-question-weight"><?=t('Weight (1-5)')?></label>
                                                    <input type="number" id="edit-question-weight" class="form-control" style="width: 120px;" min="1" max="5" value="1">
                                                </div>
                                                <div style="display: flex; gap: 10px; margin-top: 20px;">
                                                    <button type="button" class="btn btn-primary" onclick="saveQuestion('edit')"><?=t('Save Question')?></button>
                                                    <button type="button" class="btn btn-default" onclick="cancelQuestionForm('edit')"><?=t('Cancel')?></button>
                                                </div>
                                            </div>

                                            <div id="edit-questions-container">
                                                <!-- Questions will be loaded here -->
                                            </div>
                                            
                                            <div id="edit-empty-questions" style="text-align: center; color: #6b7280; padding: 30px; background-color: #f9fafb; border-radius: 8px; border: 1px dashed #d1d5db; display: none;">
                                                <div style="font-size: 24px; margin-bottom: 10px;">❓</div>
                                                <div><?=t('No questions added yet. Add your first question.')?></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions" style="margin-top: 30px; text-align: left;">
                                        <button type="submit" class="btn btn-primary" id="updateAuditBtn" onclick="formChanged = false;"><?=t('Update Audit')?></button>
                                        <button type="button" id="cancelEditAuditBtn" class="btn btn-default"><?=t('Cancel')?></button>
                                    </div>
                                </form>
                            </div>
                            <?php endif; ?>
     
                            <!-- New Audit Form Overlay -->
                            <div id="newAuditOverlay" class="audit-form-overlay" style="display: none;">
                                <form method="post" action="" id="newAuditForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_audit_name"><?=t('Inspection Name')?></label>
                                                <input type="text" class="form-control" id="new_audit_name" name="name" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_audit_category_id"><?=t('Category')?></label>
                                                <select class="form-control" id="new_audit_category_id" name="category_id" required>
                                                    <option value=""><?=t('Select a category')?></option>
                                                    <?php foreach($categoryDropdown as $id => $category): ?>
                                                        <?php if(!empty($id)): ?>
                                                            <?php if(is_array($category)): ?>
                                                                <?php if($category['is_parent']): ?>
                                                                    <option value="<?php echo $id; ?>" disabled style="font-weight: bold; color: #666;">
                                                                        <?php echo CHtml::encode($category['name']); ?>
                                                                    </option>
                                                                <?php else: ?>
                                                                    <option value="<?php echo $id; ?>">
                                                                        <?php echo CHtml::encode($category['name']); ?>
                                                                    </option>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <option value="<?php echo $id; ?>">
                                                                    <?php echo CHtml::encode($category); ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="new_audit_description"><?=t('Description')?></label>
                                        <textarea class="form-control" id="new_audit_description" name="description" rows="3"></textarea>
                                    </div>
                                    
                                    <!-- Question Management Interface -->
                                    <div class="form-group">
                                        <label><?=t('Questions')?></label>
                                        <input type="hidden" id="new-questions-json" name="questions" value='[]'>
                                        
                                        <div class="alert alert-info">
                                            <strong><?=t('Note:')?></strong> <?=t('Please create the inspection first, then edit it to add questions.')?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions" style="margin-top: 30px; text-align: left;">
                                        <button type="submit" class="btn btn-primary"><?=t('Create Inspection')?></button>
                                        <button type="button" class="btn btn-default" id="cancelNewAuditBtn"><?=t('Cancel')?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<style>
.audit-form-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background-color: white;
    z-index: 100;
    padding: 20px;
    border-top: 1px solid #ddd;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-height: 80vh;
    overflow-y: auto;
}

#edit-questions-container, #new-questions-container {
    max-height: 400px;
    overflow-y: auto;
    margin-bottom: 20px;
}

.question-card {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 5px;
    padding: 10px;
    cursor: move;
    position: relative;
    z-index: 1;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.question-drag-handle {
    margin-right: 10px;
    color: #999;
    cursor: move;
    width: 20px;
    text-align: center;
}

.question-text {
    flex-grow: 1;
    margin-right: 10px;
}

.question-weight {
    width: 80px;
    text-align: right;
    margin-right: 10px;
}

.question-actions {
    width: 80px;
    text-align: right;
}

.question-form {
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-top: 15px;
    padding: 15px;
}

/* Drag and drop styles */
.dragging {
    opacity: 0.5;
    z-index: 10;
}

.drag-over {
    border: 2px dashed #007bff;
    padding: 9px; /* Compensate for the thicker border */
}

.drop-zone {
    height: 10px;
    background-color: transparent;
    transition: height 0.2s ease;
    margin: 0;
    width: 100%;
}

.drop-zone.drag-over {
    background-color: #e6f2ff;
    border: 2px dashed #007bff;
    border-radius: 4px;
}
</style>

<script>
// Question management functionality
let editQuestions = [];
let newQuestions = [];
let currentQuestionId = null;
let currentMode = null;
let formChanged = false;
let originalFormData = null;

// Load questions when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Track form changes
    const trackFormChanges = function(formId) {
        const form = document.getElementById(formId);
        if (form) {
            // Save original form data
            originalFormData = new FormData(form);
            
            // Add event listeners to form elements
            const formElements = form.querySelectorAll('input, textarea, select');
            formElements.forEach(element => {
                element.addEventListener('change', function() {
                    formChanged = true;
                });
                
                if (element.tagName === 'INPUT' && (element.type === 'text' || element.type === 'number')) {
                    element.addEventListener('keyup', function() {
                        formChanged = true;
                    });
                }
            });
        }
    };
    
    // Initialize form change tracking for edit form
    if (document.getElementById('editAuditForm')) {
        trackFormChanges('editAuditForm');
    }
    // Prevent form submission when clicking on inputs
    $(document).on('click', 'input[type="number"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    // Prevent form submission when pressing Enter in inputs
    $(document).on('keydown', 'input, textarea, select', function(e) {
        if (e.key === 'Enter' && !$(this).is('textarea')) {
            e.preventDefault();
        }
    });
    // Document ready function
    $(document).ready(function() {
        // Initialize popovers for question previews
        initQuestionPreviews();
    });
    
    // Initialize question preview popovers
    function initQuestionPreviews() {
        // Pre-process the content for each badge
        $('.questions-badge').each(function() {
            var $badge = $(this);
            var rawData = $badge.attr('data-questions');
            var questionsData;
            
            try {
                questionsData = JSON.parse(rawData);
            } catch (e) {
                console.error('Error parsing questions data:', e);
                questionsData = [];
            }
            
            // Build the content
            var content = '<div style="max-width: 300px; max-height: 300px; overflow-y: auto; padding: 5px;">';
            var questionNumber = 1;
            
            // Simple display of questions
            if (Array.isArray(questionsData)) {
                // Old format - flat array
                var currentHeader = null;
                
                for (var i = 0; i < questionsData.length; i++) {
                    var item = questionsData[i];
                    
                    if (item.isHeader || (item.type && item.type === 'header')) {
                        // It's a header
                        currentHeader = item;
                        content += '<div style="font-weight: bold; background-color: #f5f5f5; padding: 5px; margin-top: 5px; margin-bottom: 5px;">' + item.text + '</div>';
                    } else {
                        // It's a question
                        content += '<div style="margin-left: ' + (currentHeader ? '15px' : '0') + '; margin-bottom: 8px;">';
                        content += '<div><strong>' + (questionNumber++) + '.</strong> ' + item.text + '</div>';
                        if (item.weight) {
                            content += '<div><small>Weight: <span class="label label-info">' + item.weight + '</span></small></div>';
                        }
                        content += '</div>';
                    }
                }
            } else if (questionsData && questionsData.headers && questionsData.questions) {
                // New format - structured with headers and questions
                var headerMap = {};
                
                // Create header map
                for (var i = 0; i < questionsData.headers.length; i++) {
                    headerMap[questionsData.headers[i].id] = questionsData.headers[i];
                }
                
                // Group questions by header
                var questionsByHeader = {};
                var topLevelQuestions = [];
                
                for (var i = 0; i < questionsData.questions.length; i++) {
                    var q = questionsData.questions[i];
                    if (q.headerId && headerMap[q.headerId]) {
                        if (!questionsByHeader[q.headerId]) {
                            questionsByHeader[q.headerId] = [];
                        }
                        questionsByHeader[q.headerId].push(q);
                    } else {
                        topLevelQuestions.push(q);
                    }
                }
                
                // Display headers and their questions
                for (var headerId in questionsByHeader) {
                    if (questionsByHeader.hasOwnProperty(headerId) && headerMap[headerId]) {
                        // Display header
                        content += '<div style="font-weight: bold; background-color: #f5f5f5; padding: 5px; margin-top: 5px; margin-bottom: 5px;">' + 
                            headerMap[headerId].text + '</div>';
                        
                        // Display questions under this header
                        var questions = questionsByHeader[headerId];
                        for (var j = 0; j < questions.length; j++) {
                            content += '<div style="margin-left: 15px; margin-bottom: 8px;">';
                            content += '<div><strong>' + (questionNumber++) + '.</strong> ' + questions[j].text + '</div>';
                            if (questions[j].weight) {
                                content += '<div><small>Weight: <span class="label label-info">' + questions[j].weight + '</span></small></div>';
                            }
                            content += '</div>';
                        }
                    }
                }
                
                // Display top-level questions
                if (topLevelQuestions.length > 0) {
                    content += '<div style="font-weight: bold; background-color: #f5f5f5; padding: 5px; margin-top: 5px; margin-bottom: 5px;"><?=t("General Questions")?></div>';
                    
                    for (var i = 0; i < topLevelQuestions.length; i++) {
                        content += '<div style="margin-left: 15px; margin-bottom: 8px;">';
                        content += '<div><strong>' + (questionNumber++) + '.</strong> ' + topLevelQuestions[i].text + '</div>';
                        if (topLevelQuestions[i].weight) {
                            content += '<div><small>Weight: <span class="label label-info">' + topLevelQuestions[i].weight + '</span></small></div>';
                        }
                        content += '</div>';
                    }
                }
            } else {
                content += '<div><?=t("No questions available")?></div>';
            }
            
            content += '</div>';
            
            // Initialize the popover with the pre-processed content
            $badge.popover({
                trigger: 'manual',
                content: content,
                container: 'body',
                title: 'Question Preview',
                html: true,
                placement: 'right'
            });
            
            // Custom hover behavior to keep popover open when hovering over it
            $badge.on('mouseenter', function() {
                var $this = $(this);
                $this.popover('show');
                
                // Add event handler to the popover
                $('.popover').on('mouseenter', function() {
                    // Keep popover open when hovering over it
                    $(this).data('hover', true);
                }).on('mouseleave', function() {
                    // Allow popover to close when mouse leaves it
                    $(this).data('hover', false);
                    $this.popover('hide');
                });
            }).on('mouseleave', function() {
                var $this = $(this);
                
                // Delay hiding to check if mouse moved to the popover
                setTimeout(function() {
                    var $popover = $('.popover');
                    if ($popover.length && !$popover.data('hover')) {
                        $this.popover('hide');
                    }
                }, 300);
            });
        });
    }
    
    // Add Audit button functionality
    $('#addAuditBtn').click(function() {
        // Show the new audit overlay
        $('#newAuditOverlay').show();
    });
    
    // Cancel new audit button
    $('#cancelNewAuditBtn').click(function() {
        // Hide the new audit overlay
        $('#newAuditOverlay').hide();
        // Clear form fields
        $('#newAuditForm')[0].reset();
        // Reset questions
        newQuestions = [];
        document.getElementById('new-questions-json').value = '[]';
        renderQuestions('new');
    });
    
    // Cancel edit audit button
    $('#cancelEditAuditBtn').click(function(e) {
        // Check if there are unsaved changes
        if (formChanged) {
            e.preventDefault();
            if (confirm('<?=t('You have unsaved changes. Are you sure you want to leave this page? Your changes will be lost.')?>')) {
                // Redirect to the audits page without the edit parameter
                window.location.href = '<?php echo $this->createUrl('site/audits'); ?>';
            }
        } else {
            // Redirect to the audits page without the edit parameter
            window.location.href = '<?php echo $this->createUrl('site/audits'); ?>';
        }
    });
    
    // Add beforeunload event to warn about unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            // Standard message for unsaved changes (browser will show its own message)
            const message = '<?=t('You have unsaved changes. Are you sure you want to leave this page?')?>';
            e.returnValue = message;
            return message;
        }
    });
    
    // Load questions
    loadQuestions();
    
    <?php if($isEdit): ?>
    // If in edit mode, show the edit overlay
    // No additional action needed as it's already set to display: block
    <?php endif; ?>
});

// Load questions from hidden inputs
function loadQuestions() {
    try {
        // Load edit questions if in edit mode
        <?php if($isEdit): ?>
        const editQuestionsJson = document.getElementById('edit-questions-json').value;
        
        // Safely parse JSON or initialize as empty array
        try {
            if (editQuestionsJson && editQuestionsJson !== 'Array') {
                editQuestions = JSON.parse(editQuestionsJson);
            } else {
                // Invalid JSON format, initialize as empty array
                editQuestions = [];
                // Update the hidden input with valid JSON
                document.getElementById('edit-questions-json').value = '[]';
            }
        } catch (jsonError) {
            console.error('Error parsing questions JSON:', jsonError);
            editQuestions = [];
            // Update the hidden input with valid JSON
            document.getElementById('edit-questions-json').value = '[]';
        }
        
        renderQuestions('edit');
        <?php endif; ?>
        
        // Initialize new questions as empty array
        newQuestions = [];
        document.getElementById('new-questions-json').value = '[]';
    } catch (error) {
        console.error('Error loading questions:', error);
        editQuestions = [];
        newQuestions = [];
    }
}

// Save questions to hidden input
function saveQuestionsToForm(mode) {
    try {
        if (mode === 'edit') {
            document.getElementById('edit-questions-json').value = JSON.stringify(editQuestions);
        } else if (mode === 'new') {
            document.getElementById('new-questions-json').value = JSON.stringify(newQuestions);
        }
    } catch (error) {
        console.error('Error saving questions:', error);
        alert('Error saving questions!');
    }
}

// Render questions with drag and drop functionality
function renderQuestions(mode) {
    const questions = mode === 'edit' ? editQuestions : newQuestions;
    const container = document.getElementById(mode + '-questions-container');
    const emptyState = document.getElementById(mode + '-empty-questions');
    
    container.innerHTML = '';
    
    if (questions.length === 0) {
        emptyState.style.display = 'block';
        return;
    }
    
    emptyState.style.display = 'none';
    
    // Create a list container for better drag and drop
    const listContainer = document.createElement('div');
    listContainer.className = 'sortable-list';
    container.appendChild(listContainer);
    
    questions.forEach((question, index) => {
        const questionCard = document.createElement('div');
        questionCard.className = 'question-card';
        questionCard.setAttribute('draggable', 'true');
        questionCard.setAttribute('data-question-id', question.id);
        questionCard.setAttribute('data-index', index);
        
        // Add drag event listeners
        questionCard.addEventListener('dragstart', handleDragStart);
        questionCard.addEventListener('dragover', handleDragOver);
        questionCard.addEventListener('dragenter', handleDragEnter);
        questionCard.addEventListener('dragleave', handleDragLeave);
        questionCard.addEventListener('drop', handleDrop);
        questionCard.addEventListener('dragend', handleDragEnd);
        
        questionCard.innerHTML = `
            <div class="question-header">
                <div class="question-drag-handle" title="Drag to reorder">
                    <i class="fa fa-bars"></i>
                </div>
                <div class="question-text">${question.text}</div>
                <div class="question-weight">Weight: ${question.weight}</div>
                <div class="question-actions" style="display: flex; gap: 5px;">
                    <button type="button" class="btn btn-xs btn-primary" title="Edit" onclick="editQuestion(${question.id}, '${mode}')">
                        <i style="color:#fff;" class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-danger" title="Delete" onclick="deleteQuestion(${question.id}, '${mode}')">
                        <i style="color:#fff;" class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        // Add a drop zone before each item (except the first one)
        if (index > 0) {
            const dropZone = document.createElement('div');
            dropZone.className = 'drop-zone';
            dropZone.setAttribute('data-index', index);
            dropZone.addEventListener('dragover', handleDragOver);
            dropZone.addEventListener('dragenter', handleDragEnter);
            dropZone.addEventListener('dragleave', handleDragLeave);
            dropZone.addEventListener('drop', handleDrop);
            listContainer.appendChild(dropZone);
        }
        
        listContainer.appendChild(questionCard);
        
        // Add a drop zone after the last item
        if (index === questions.length - 1) {
            const dropZone = document.createElement('div');
            dropZone.className = 'drop-zone';
            dropZone.setAttribute('data-index', index + 1);
            dropZone.addEventListener('dragover', handleDragOver);
            dropZone.addEventListener('dragenter', handleDragEnter);
            dropZone.addEventListener('dragleave', handleDragLeave);
            dropZone.addEventListener('drop', handleDrop);
            listContainer.appendChild(dropZone);
        }
    });
}

// Drag and drop functionality
let dragSrcEl = null;
// currentMode is already declared at the top of the script

function handleDragStart(e) {
    dragSrcEl = this;
    
    // Safely determine the current mode
    const container = this.closest('.questions-container');
    if (container && container.id) {
        currentMode = container.id.includes('edit') ? 'edit' : 'new';
    } else {
        // Fallback if container can't be found
        currentMode = document.getElementById('edit-questions-container') ? 'edit' : 'new';
    }
    
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.outerHTML);
    
    this.classList.add('dragging');
}

function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    e.dataTransfer.dropEffect = 'move';
    return false;
}

function handleDragEnter(e) {
    this.classList.add('drag-over');
    
    // If this is a drop zone, make it more visible
    if (this.classList.contains('drop-zone')) {
        this.style.height = '30px';
    }
}

function handleDragLeave(e) {
    this.classList.remove('drag-over');
    
    // Reset drop zone height
    if (this.classList.contains('drop-zone')) {
        this.style.height = '10px';
    }
}

function handleDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    
    // Check if we have a valid source element and current mode
    if (dragSrcEl && dragSrcEl !== this && currentMode) {
        // Safely get indices with fallbacks
        const sourceIndex = dragSrcEl.hasAttribute('data-index') ? 
            parseInt(dragSrcEl.getAttribute('data-index')) : 0;
        const targetIndex = this.hasAttribute('data-index') ? 
            parseInt(this.getAttribute('data-index')) : 0;
        
        // Only proceed if we have valid indices
        if (!isNaN(sourceIndex) && !isNaN(targetIndex)) {
            // Get the questions array based on the mode
            const questions = currentMode === 'edit' ? editQuestions : newQuestions;
            
            // Make sure we have questions to reorder
            if (questions && questions.length > 0 && sourceIndex < questions.length) {
                // Reorder the questions array
                const movedItem = questions[sourceIndex];
                questions.splice(sourceIndex, 1);
                
                // Make sure target index is valid
                const safeTargetIndex = Math.min(targetIndex, questions.length);
                questions.splice(safeTargetIndex, 0, movedItem);
                
                // Update the hidden input with the new order
                const jsonInput = document.getElementById(currentMode + '-questions-json');
                if (jsonInput) {
                    jsonInput.value = JSON.stringify(questions);
                }
                
                // Mark form as changed
                formChanged = true;
                
                // Re-render the questions
                renderQuestions(currentMode);
            }
        }
    }
    
    return false;
}

function handleDragEnd(e) {
    // Remove all drag-related classes
    const questionCards = document.querySelectorAll('.question-card');
    questionCards.forEach(card => {
        card.classList.remove('dragging');
        card.classList.remove('drag-over');
    });
}

// Add new question
function addNewQuestion(mode) {
    currentQuestionId = null;
    currentMode = mode;
    
    document.getElementById(mode + '-question-form-title').textContent = 'Add New Question';
    document.getElementById(mode + '-question-text').value = '';
    document.getElementById(mode + '-question-weight').value = '1';
    document.getElementById(mode + '-question-form').style.display = 'block';
    document.getElementById(mode + '-question-text').focus();
}

// Edit question
function editQuestion(questionId, mode) {
    const questions = mode === 'edit' ? editQuestions : newQuestions;
    const question = questions.find(q => q.id === questionId);
    if (!question) return;
    
    currentQuestionId = questionId;
    currentMode = mode;
    
    document.getElementById(mode + '-question-form-title').textContent = '<?=t('Edit Question')?>';
    document.getElementById(mode + '-question-text').value = question.text;
    document.getElementById(mode + '-question-weight').value = question.weight;
    document.getElementById(mode + '-question-form').style.display = 'block';
    document.getElementById(mode + '-question-text').focus();
}

// Cancel question form
function cancelQuestionForm(mode) {
    document.getElementById(mode + '-question-form').style.display = 'none';
}

// Save question
function saveQuestion(mode) {
    const questions = mode === 'edit' ? editQuestions : newQuestions;
    const questionText = document.getElementById(mode + '-question-text').value.trim();
    const questionWeight = parseFloat(document.getElementById(mode + '-question-weight').value) || 1;
    
    if (!questionText) {
        alert('<?=t('Please enter question text')?>');
        return;
    }
    
    if (questionWeight < 1 || questionWeight > 5) {
        alert('<?=t('Weight must be between 1 and 5')?>');
        return;
    }
    
    if (currentQuestionId === null) {
        // Add new question
        const newId = questions.length > 0 ? Math.max(...questions.map(q => q.id)) + 1 : 1;
        questions.push({
            id: newId,
            text: questionText,
            weight: questionWeight
        });
    } else {
        // Update existing question
        const questionIndex = questions.findIndex(q => q.id === currentQuestionId);
        if (questionIndex !== -1) {
            questions[questionIndex].text = questionText;
            questions[questionIndex].weight = questionWeight;
        }
    }
    
    if (mode === 'edit') {
        editQuestions = questions;
    } else {
        newQuestions = questions;
    }
    
    saveQuestionsToForm(mode);
    renderQuestions(mode);
    cancelQuestionForm(mode);
}

// Delete question
function deleteQuestion(questionId, mode) {
    if (!confirm('<?=t('Are you sure you want to delete this question?')?>')) return;
    
    const questions = mode === 'edit' ? editQuestions : newQuestions;
    const questionIndex = questions.findIndex(q => q.id === questionId);
    
    if (questionIndex !== -1) {
        questions.splice(questionIndex, 1);
        
        if (mode === 'edit') {
            editQuestions = questions;
        } else {
            newQuestions = questions;
        }
        
        saveQuestionsToForm(mode);
        renderQuestions(mode);
    }
}


function filterAudits() {
    // Get the search input value
    var input = document.getElementById("auditSearchInput");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("auditTable");
    var tr = table.getElementsByTagName("tr");
    var noResults = true;
    
    // Loop through all table rows, and hide those who don't match the search query
    for (var i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
        var tdName = tr[i].getElementsByTagName("td")[1]; // Name column
        var tdCategory = tr[i].getElementsByTagName("td")[2]; // Category column
        var tdDescription = tr[i].getElementsByTagName("td")[3]; // Description column
        var tdQuestions = tr[i].getElementsByTagName("td")[4]; // Questions column
        var tdCreatedAt = tr[i].getElementsByTagName("td")[5]; // Created At column
        
        if (tdName && tdCategory && tdDescription && tdQuestions && tdCreatedAt) {
            var nameText = tdName.textContent || tdName.innerText;
            var categoryText = tdCategory.textContent || tdCategory.innerText;
            var descriptionText = tdDescription.textContent || tdDescription.innerText;
            var questionsText = tdQuestions.textContent || tdQuestions.innerText;
            var createdAtText = tdCreatedAt.textContent || tdCreatedAt.innerText;
            
            // Search across all visible text fields
            if (nameText.toUpperCase().indexOf(filter) > -1 || 
                categoryText.toUpperCase().indexOf(filter) > -1 || 
                descriptionText.toUpperCase().indexOf(filter) > -1 ||
                questionsText.toUpperCase().indexOf(filter) > -1 ||
                createdAtText.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                noResults = false;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    
    // Show a message if no results found
    var noResultsRow = document.getElementById("noResultsRow");
    if (noResultsRow) {
        if (noResults && filter !== "") {
            noResultsRow.style.display = "";
        } else {
            noResultsRow.style.display = "none";
        }
    } else if (noResults && filter !== "") {
        // Create a new row for no results message if it doesn't exist
        var tbody = table.getElementsByTagName("tbody")[0];
        var newRow = document.createElement("tr");
        newRow.id = "noResultsRow";
        newRow.innerHTML = '<td colspan="8" class="text-center"><?=t('No matching inspections found')?></td>';
        tbody.appendChild(newRow);
    }
}
</script>