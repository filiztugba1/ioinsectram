<?php
/* @var $this SiteController */
/* @var $model array */
/* @var $categoryDropdown array */
/* @var $editId integer */
/* @var $questions string */

$this->pageTitle=Yii::app()->name . ' - Edit Inspection';
?>

<div class="row">
    <div class="col-md-12">
        <div class="clearfix">
            <h1 style="float: left;"><?=t('Edit Inspection')?></h1>
            <div style="float: right; margin-top: 10px;margin-bottom: 10px;">
                <a href="<?php echo $this->createUrl('site/audits'); ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> <?=t('Back to Inspections List')?>
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
        
        <!-- Main Content Area -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-body" style="background-color: #fff; padding: 20px;">
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
                                        <label for="edit_audit_category_id"><?=t('Category')?></label>
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
                                <input type="hidden" id="edit-questions-json" name="questions" value='<?php echo htmlspecialchars($questions, ENT_QUOTES, 'UTF-8'); ?>'>
                                
                                <div id="edit-question-management">
                                    <div class="page-header" style="margin-top: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <h4><?=t('Manage Questions')?></h4>
                                                <p class="text-muted" style="font-size: 12px; margin-top: 5px;">
                                                    <i class="fa fa-info-circle"></i> <?=t('Double-click on question text or weight values for quick inline editing')?>
                                                </p>
                                            </div>
                                            <div style="display: flex; gap: 10px;">
                                                <button type="button" class="btn btn-info" onclick="addNewHeader('edit')" style="margin-bottom: 15px;">
                                                    <i class="fa fa-header"></i> <?=t('Add New Header')?>
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="addNewQuestion('edit')" style="margin-bottom: 15px;">
                                                    <i class="fa fa-plus"></i> <?=t('Add New Question')?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Header Form -->
                                    <div id="edit-header-form" class="question-form" style="display: none; background-color: #f0f7ff; border: 1px solid #cce5ff; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                                        <h4 id="edit-header-form-title"><?=t('Add New Header')?></h4>
                                        <div class="form-group">
                                            <label for="edit-header-text"><?=t('Header Text')?></label>
                                            <input type="text" id="edit-header-text" class="form-control" placeholder="Enter section header">
                                        </div>
                                        <div style="display: flex; gap: 10px; margin-top: 20px;">
                                            <button type="button" class="btn btn-primary" onclick="saveHeader('edit')"><?=t('Save Header')?></button>
                                            <button type="button" class="btn btn-default" onclick="cancelHeaderForm('edit')"><?=t('Cancel')?></button>
                                        </div>
                                    </div>
                                    
                                    <!-- Question Form -->
                                    <div id="edit-question-form" class="question-form" style="display: none; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                                        <h4 id="edit-question-form-title"><?=t('Add New Question')?></h4>
                                        <div class="form-group">
                                            <label for="edit-question-text"><?=t('Question Text')?></label>
                                            <textarea id="edit-question-text" class="form-control" rows="3" placeholder="Enter audit question"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit-question-weight"><?=t('Weight (1-5)')?></label>
                                            <input type="number" id="edit-question-weight" class="form-control" style="width: 120px;" min="1" max="5" value="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="edit-question-header"><?=t('Section Header')?></label>
                                            <select id="edit-question-header" class="form-control">
                                                <option value=""><?=t('No Header (Top Level)')?></option>
                                                <!-- Header options will be populated by JavaScript -->
                                            </select>
                                        </div>
                                        <div style="display: flex; gap: 10px; margin-top: 20px;">
                                            <button type="button" class="btn btn-primary" onclick="saveQuestion('edit')"><?=t('Save Question')?></button>
                                            <button type="button" class="btn btn-default" onclick="cancelQuestionForm('edit')"><?=t('Cancel')?></button>
                                        </div>
                                    </div>

                                    <div id="edit-empty-questions" class="alert alert-info" style="display: none;">
                                        <?=t('No questions added yet. Click "Add New Question" to add your first inspection.')?>
                                    </div>

                                    <div id="edit-questions-container" class="questions-container">
                                        <!-- Questions will be rendered here by JavaScript -->
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary" onclick="formChanged = false;"><?=t('Update Inspection')?></button>
                                <a href="<?php echo $this->createUrl('site/audits'); ?>" class="btn btn-default" id="cancelEditAuditBtn"><?=t('Cancel')?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Question card styles */
.questions-container {
    margin-top: 20px;
}

.question-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.question-header {
    display: flex;
    align-items: center;
    padding: 10px 15px;
}

.question-drag-handle {
    cursor: grab;
    margin-right: 15px;
    color: #999;
}

.question-text {
    flex-grow: 1;
    margin-right: 15px;
}

.question-weight {
    margin-right: 15px;
    color: #666;
    white-space: nowrap;
}

.question-actions {
    display: flex;
    gap: 5px;
}

.question-form {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 15px;
}

/* Section header styles */
.section-header {
    background-color: #f0f7ff;
    border: 1px solid #cce5ff;
    border-radius: 4px;
    margin-top: 20px;
    margin-bottom: 10px;
    padding: 10px 15px;
}

.top-level-header {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}

.header-content {
    display: flex;
    align-items: center;
}

.header-text {
    flex-grow: 1;
    margin-right: 15px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.header-toggle {
    cursor: pointer;
    margin-right: 10px;
    color: #666;
    transition: transform 0.2s;
}

.header-toggle.collapsed {
    transform: rotate(-90deg);
}

.question-count {
    font-size: 14px;
    color: #666;
    font-weight: normal;
    margin-left: 8px;
}

.header-questions.collapsed {
    display: none;
}

.header-drag-handle {
    cursor: grab;
    margin-right: 15px;
    color: #007bff;
}

.header-actions {
    margin-left: auto;
    display: flex;
    gap: 5px;
}

.header-questions {
    margin-left: 20px;
    padding-left: 10px;
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

.section-drag-over {
    background-color: #e6f7ff;
    border: 2px dashed #007bff;
    border-radius: 4px;
}

.sortable-list {
    min-height: 30px; /* Ensure empty lists can still be drop targets */
    padding: 5px 0;
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
let editHeaders = [];
let currentQuestionId = null;
let currentHeaderId = null;
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
    
    // Cancel edit audit button
    $('#cancelEditAuditBtn').click(function(e) {
        // Check if there are unsaved changes
        if (formChanged) {
            e.preventDefault();
            if (confirm("<?=t('You have unsaved changes. Are you sure you want to leave this page? Your changes will be lost.')?>")) {
                // Temporarily disable the beforeunload handler to prevent double confirmation
                const tempHandler = window.onbeforeunload;
                window.onbeforeunload = null;
                
                // Redirect to the audits page without the edit parameter
                window.location.href = '<?php echo $this->createUrl('site/audits'); ?>';
                
                // Restore the handler (in case navigation fails)
                setTimeout(function() {
                    window.onbeforeunload = tempHandler;
                }, 1000);
            }
        } else {
            // No changes, just navigate away
            window.location.href = '<?php echo $this->createUrl('site/audits'); ?>';
        }
    });
    
    // Add beforeunload event to warn about unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            // Standard message for unsaved changes (browser will show its own message)
            const message = "<?=t('You have unsaved changes. Are you sure you want to leave this page?')?>";
            e.returnValue = message;
            return message;
        }
    });
    
    // Load questions and headers
    loadQuestions();
});

// Load questions from hidden inputs
function loadQuestions() {
    try {
        let editQuestionsJson = document.getElementById('edit-questions-json').value;
        
        // Decode HTML entities before parsing JSON
        const decodeHTMLEntities = function(text) {
            const textArea = document.createElement('textarea');
            textArea.innerHTML = text;
            return textArea.value;
        };
        
        editQuestionsJson = decodeHTMLEntities(editQuestionsJson);
        
        // Safely parse JSON or initialize as empty array
        try {
            if (editQuestionsJson && editQuestionsJson !== 'Array') {
                const parsedData = JSON.parse(editQuestionsJson);
                
                // Check if the data includes headers
                if (parsedData.headers && Array.isArray(parsedData.headers)) {
                    editHeaders = parsedData.headers;
                    editQuestions = parsedData.questions || [];
                } else {
                    // Old format - just questions array
                    editHeaders = [];
                    editQuestions = parsedData;
                }
            } else {
                // Invalid JSON format, initialize as empty arrays
                editHeaders = [];
                editQuestions = [];
                // Update the hidden input with valid JSON
                document.getElementById('edit-questions-json').value = JSON.stringify({headers: [], questions: []});
            }
        } catch (jsonError) {
            console.error('Error parsing questions JSON:', jsonError);
            editHeaders = [];
            editQuestions = [];
            // Update the hidden input with valid JSON
            document.getElementById('edit-questions-json').value = JSON.stringify({headers: [], questions: []});
        }
        
        // Update header dropdown in question form
        updateHeaderDropdown('edit');
        
        // Render questions and headers
        renderQuestions('edit');
    } catch (error) {
        console.error('Error loading questions:', error);
    }
}

// Render questions in the container
function renderQuestions(mode) {
    const questions = editQuestions;
    const headers = editHeaders;
    const container = document.getElementById(mode + '-questions-container');
    const emptyState = document.getElementById(mode + '-empty-questions');
    
    container.innerHTML = '';
    
    if (questions.length === 0 && headers.length === 0) {
        emptyState.style.display = 'block';
        return;
    }
    
    emptyState.style.display = 'none';
    
    // Create a list container for top-level questions
    const topLevelContainer = document.createElement('div');
    topLevelContainer.className = 'sortable-list top-level-questions';
    topLevelContainer.setAttribute('data-header-id', 'null');
    container.appendChild(topLevelContainer);
    
    // Add header for top-level questions
    const topLevelHeader = document.createElement('div');
    topLevelHeader.className = 'section-header top-level-header';
    topLevelHeader.innerHTML = `
        <h4><?=t('General Questions')?></h4>
    `;
    container.insertBefore(topLevelHeader, topLevelContainer);
    
    // Render top-level questions (questions without a header)
    const topLevelQuestions = questions.filter(q => !q.headerId);
    renderQuestionsForSection(topLevelQuestions, topLevelContainer, mode, null);
    
    // Render each header and its questions
    headers.forEach((header, headerIndex) => {
        // Create header section
        // Get questions count for this header
        const headerQuestions = questions.filter(q => q.headerId === header.id);
        const questionCount = headerQuestions.length;
        
        const headerSection = document.createElement('div');
        headerSection.className = 'section-header';
        headerSection.setAttribute('data-header-id', header.id);
        headerSection.innerHTML = `
            <div class="header-content">
                <div class="header-drag-handle" title="Drag to reorder">
                    <i class="fa fa-bars"></i>
                </div>
                <div class="header-toggle" onclick="toggleHeader(${header.id}, '${mode}')">
                    <i class="fa fa-chevron-down"></i>
                </div>
                <div class="header-text-container" style="display: flex; align-items: center;">
                    <div class="header-text" data-id="${header.id}" data-mode="${mode}" title="Double-click to edit" ondblclick="inlineEditHeaderText(this)" style="margin-right: 5px;">
                        ${header.text}
                    </div>
                    <span class="question-count" style="font-size: 11px; color: #666;">(${questionCount} <?=t('questions')?>)</span>
                </div>
                <div class="header-actions">
                    <button type="button" class="btn btn-xs btn-primary" title="Edit Header" onclick="editHeader(${header.id}, '${mode}')">
                        <i style="color:#fff;" class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-danger" title="Delete Header" onclick="deleteHeader(${header.id}, '${mode}')">
                        <i style="color:#fff;" class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(headerSection);
        
        // Create container for questions under this header
        const headerQuestionsContainer = document.createElement('div');
        headerQuestionsContainer.className = 'sortable-list header-questions';
        headerQuestionsContainer.setAttribute('data-header-id', header.id);
        
        // Make the header section droppable for questions
        headerSection.addEventListener('dragover', handleSectionDragOver);
        headerSection.addEventListener('dragenter', handleSectionDragEnter);
        headerSection.addEventListener('dragleave', handleSectionDragLeave);
        headerSection.addEventListener('drop', handleSectionDrop);
        
        container.appendChild(headerQuestionsContainer);
        
        // Get questions for this header
        const questionsInHeader = questions.filter(q => q.headerId === header.id);
        renderQuestionsForSection(questionsInHeader, headerQuestionsContainer, mode, header.id);
    });
    
    // Add drag and drop for headers
    const headerElements = document.querySelectorAll('.section-header:not(.top-level-header)');
    headerElements.forEach(headerElement => {
        headerElement.setAttribute('draggable', 'true');
        headerElement.addEventListener('dragstart', handleHeaderDragStart);
        headerElement.addEventListener('dragover', handleHeaderDragOver);
        headerElement.addEventListener('dragenter', handleHeaderDragEnter);
        headerElement.addEventListener('dragleave', handleHeaderDragLeave);
        headerElement.addEventListener('drop', handleHeaderDrop);
        headerElement.addEventListener('dragend', handleHeaderDragEnd);
    });
}

// Render questions for a specific section (header or top-level)
function renderQuestionsForSection(questions, container, mode, headerId) {
    questions.forEach((question, index) => {
        const questionCard = document.createElement('div');
        questionCard.className = 'question-card';
        questionCard.setAttribute('draggable', 'true');
        questionCard.setAttribute('data-question-id', question.id);
        questionCard.setAttribute('data-index', index);
        questionCard.setAttribute('data-header-id', headerId || 'null');
        
        // Add drag event listeners
        questionCard.addEventListener('dragstart', handleDragStart);
        questionCard.addEventListener('dragover', handleDragOver);
        questionCard.addEventListener('dragenter', handleDragEnter);
        questionCard.addEventListener('dragleave', handleDragLeave);
        questionCard.addEventListener('drop', handleDrop);
        questionCard.addEventListener('dragend', handleDragEnd);
        
        questionCard.innerHTML = `
            <div class="question-header">
                <div class="question-drag-handle" title="Drag to reorder or move to another section">
                    <i class="fa fa-bars"></i>
                </div>
                <div class="question-text" data-id="${question.id}" data-mode="${mode}" title="Double-click to edit" ondblclick="inlineEditQuestionText(this)">${question.text}</div>
                <div class="question-weight" data-id="${question.id}" data-mode="${mode}" title="Double-click to edit weight" ondblclick="inlineEditQuestionWeight(this)">Weight: <span>${question.weight}</span></div>
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
        
        container.appendChild(questionCard);
    });
}

// Drag and drop functionality
let dragSrcEl = null;
let currentMode = null;

function handleDragStart(e) {
    dragSrcEl = this;
    currentMode = this.closest('.questions-container').id.includes('edit') ? 'edit' : 'new';
    
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
}

function handleDragLeave(e) {
    this.classList.remove('drag-over');
}

function handleDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    
    // Check if we have a valid source element and current mode
    if (dragSrcEl && dragSrcEl !== this && currentMode) {
        const sourceQuestionId = parseInt(dragSrcEl.getAttribute('data-question-id'));
        const targetQuestionId = parseInt(this.getAttribute('data-question-id'));
        const targetHeaderId = this.closest('.sortable-list').getAttribute('data-header-id');
        
        // Get the source and target questions
        const sourceQuestion = editQuestions.find(q => q.id === sourceQuestionId);
        const targetQuestion = editQuestions.find(q => q.id === targetQuestionId);
        
        if (sourceQuestion && targetQuestion) {
            // Get all questions in the same header as the target
            const targetHeaderQuestions = targetHeaderId === 'null' 
                ? editQuestions.filter(q => !q.headerId) 
                : editQuestions.filter(q => q.headerId === parseInt(targetHeaderId));
            
            // Get the index of the target question in its header group
            const targetIndexInHeader = targetHeaderQuestions.findIndex(q => q.id === targetQuestionId);
            
            // Remove the source question from its current position
            const sourceIndex = editQuestions.findIndex(q => q.id === sourceQuestionId);
            editQuestions.splice(sourceIndex, 1);
            
            // Update the header ID of the source question
            sourceQuestion.headerId = targetHeaderId === 'null' ? null : parseInt(targetHeaderId);
            
            // Find the correct position to insert in the global questions array
            // This is more complex because we need to find where in the global array this position is
            const allQuestionsWithSameHeader = editQuestions.filter(q => 
                (targetHeaderId === 'null' && !q.headerId) || 
                (targetHeaderId !== 'null' && q.headerId === parseInt(targetHeaderId))
            );
            
            if (allQuestionsWithSameHeader.length === 0) {
                // No questions with this header yet, just add it to the end
                editQuestions.push(sourceQuestion);
            } else if (targetIndexInHeader >= allQuestionsWithSameHeader.length) {
                // Insert at the end of this header's questions
                const lastQuestionWithHeader = allQuestionsWithSameHeader[allQuestionsWithSameHeader.length - 1];
                const lastIndex = editQuestions.findIndex(q => q.id === lastQuestionWithHeader.id);
                editQuestions.splice(lastIndex + 1, 0, sourceQuestion);
            } else {
                // Insert at the target position
                const targetGlobalIndex = editQuestions.findIndex(q => q.id === targetQuestion.id);
                editQuestions.splice(targetGlobalIndex, 0, sourceQuestion);
            }
            
            // Update the form data
            formChanged = true;
            
            // Save the reordered questions to the form
            saveQuestionsToForm(currentMode);
            
            // Re-render the questions
            renderQuestions(currentMode);
        }
    }
    
    this.classList.remove('drag-over');
    
    return false;
}

// Header drag and drop functionality
let headerDragSrcEl = null;

function handleHeaderDragStart(e) {
    headerDragSrcEl = this;
    currentMode = 'edit'; // We only have edit mode for headers
    
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.outerHTML);
    
    this.classList.add('dragging');
}

function handleHeaderDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    
    e.dataTransfer.dropEffect = 'move';
    
    return false;
}

function handleHeaderDragEnter(e) {
    this.classList.add('drag-over');
}

function handleHeaderDragLeave(e) {
    this.classList.remove('drag-over');
}

function handleHeaderDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    
    // Check if we have a valid source element
    if (headerDragSrcEl && headerDragSrcEl !== this) {
        // Get source and target header IDs
        const sourceHeaderId = parseInt(headerDragSrcEl.getAttribute('data-header-id'));
        const targetHeaderId = parseInt(this.getAttribute('data-header-id'));
        
        // Find the headers in the array
        const sourceHeaderIndex = editHeaders.findIndex(h => h.id === sourceHeaderId);
        const targetHeaderIndex = editHeaders.findIndex(h => h.id === targetHeaderId);
        
        if (sourceHeaderIndex !== -1 && targetHeaderIndex !== -1) {
            // Reorder the headers array
            const movedHeader = editHeaders[sourceHeaderIndex];
            editHeaders.splice(sourceHeaderIndex, 1);
            editHeaders.splice(targetHeaderIndex, 0, movedHeader);
            
            // Update the form data
            formChanged = true;
            
            // Save to form
            saveQuestionsToForm('edit');
            
            // Re-render everything
            renderQuestions('edit');
        }
    }
    
    this.classList.remove('drag-over');
    
    return false;
}

function handleHeaderDragEnd(e) {
    this.classList.remove('dragging');
    
    const headerElements = document.querySelectorAll('.section-header');
    headerElements.forEach(header => {
        header.classList.remove('drag-over');
    });
}

// Inline edit header text
function inlineEditHeaderText(element) {
    const headerId = parseInt(element.getAttribute('data-id'));
    const mode = element.getAttribute('data-mode');
    const header = editHeaders.find(h => h.id === headerId);
    
    if (!header) return;
    
    // Use the header text from the data model, not from the DOM
    // This ensures we don't include the question count
    const originalText = header.text;
    
    // Create an input for editing
    const input = document.createElement('input');
    input.type = 'text';
    input.value = originalText;
    input.className = 'form-control';
    input.style.width = '100%';
    input.style.display = 'inline-block';
    
    // Replace the text with the input
    element.innerHTML = '';
    element.appendChild(input);
    
    // Focus the input
    input.focus();
    
    // Handle saving on blur
    input.addEventListener('blur', function() {
        const newText = input.value.trim();
        
        if (newText && newText !== originalText) {
            // Update the header
            header.text = newText;
            formChanged = true;
            saveQuestionsToForm(mode);
            updateHeaderDropdown(mode);
        }
        
        // Restore the element with updated or original text
        element.innerHTML = header.text;
    });
    
    // Handle Enter key to save
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            input.blur();
        }
        
        // Cancel on Escape
        if (e.key === 'Escape') {
            input.value = originalText;
            input.blur();
        }
    });
}

function handleDragEnd(e) {
    this.classList.remove('dragging');
    
    const questionCards = document.querySelectorAll('.question-card');
    questionCards.forEach(card => {
        card.classList.remove('drag-over');
    });
    
    const headerSections = document.querySelectorAll('.section-header');
    headerSections.forEach(header => {
        header.classList.remove('drag-over');
    });
}

// Handler functions for dragging questions onto header sections
function handleSectionDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    
    // Only allow dropping questions onto headers
    if (dragSrcEl && dragSrcEl.classList.contains('question-card')) {
        e.dataTransfer.dropEffect = 'move';
    }
    
    return false;
}

function handleSectionDragEnter(e) {
    // Only highlight if dragging a question
    if (dragSrcEl && dragSrcEl.classList.contains('question-card')) {
        this.classList.add('section-drag-over');
    }
}

function handleSectionDragLeave(e) {
    this.classList.remove('section-drag-over');
}

function handleSectionDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    
    // Only process if dragging a question onto a header
    if (dragSrcEl && dragSrcEl.classList.contains('question-card') && this.classList.contains('section-header')) {
        const sourceQuestionId = parseInt(dragSrcEl.getAttribute('data-question-id'));
        const targetHeaderId = this.getAttribute('data-header-id');
        
        // Get the source question
        const sourceQuestion = editQuestions.find(q => q.id === sourceQuestionId);
        
        if (sourceQuestion) {
            // Remove the source question from its current position
            const sourceIndex = editQuestions.findIndex(q => q.id === sourceQuestionId);
            editQuestions.splice(sourceIndex, 1);
            
            // Update the header ID of the source question
            sourceQuestion.headerId = targetHeaderId === 'null' ? null : parseInt(targetHeaderId);
            
            // Add the question to the end of the questions array
            editQuestions.push(sourceQuestion);
            
            // Update the form data
            formChanged = true;
            
            // Save the reordered questions to the form
            saveQuestionsToForm(currentMode);
            
            // Re-render the questions
            renderQuestions(currentMode);
        }
    }
    
    this.classList.remove('section-drag-over');
    
    return false;
}

// Save questions to the form input
function saveQuestionsToForm(mode) {
    const data = {
        headers: editHeaders,
        questions: editQuestions
    };
    document.getElementById(mode + '-questions-json').value = JSON.stringify(data);
}

// Update header dropdown in question form
function updateHeaderDropdown(mode) {
    const headerSelect = document.getElementById(mode + '-question-header');
    
    // Clear existing options except the default
    while (headerSelect.options.length > 1) {
        headerSelect.remove(1);
    }
    
    // Add header options
    editHeaders.forEach(header => {
        const option = document.createElement('option');
        option.value = header.id;
        option.textContent = header.text;
        headerSelect.appendChild(option);
    });
}

function renderHeader(header) {
    const headerDiv = document.createElement('div');
    headerDiv.className = 'header';
    headerDiv.dataset.headerId = header.id;

    const dragHandle = document.createElement('span');
    dragHandle.className = 'header-drag-handle';
    dragHandle.innerHTML = '&#8942;&#8942;';
    headerDiv.appendChild(dragHandle);

    const toggle = document.createElement('span');
    toggle.className = 'header-toggle';
    toggle.innerHTML = '&#9660;';
    toggle.onclick = (e) => {
        e.stopPropagation();
        const questions = document.querySelector(`.header-questions[data-header-id="${header.id}"]`);
        const isCollapsed = questions.classList.toggle('collapsed');
        toggle.classList.toggle('collapsed', isCollapsed);
    };
    headerDiv.appendChild(toggle);

    const headerText = document.createElement('div');
    headerText.className = 'header-text';
    headerText.textContent = header.text;
    headerDiv.appendChild(headerText);

    const questionCount = document.createElement('span');
    questionCount.className = 'question-count';
    const count = editQuestions.filter(q => q.headerId === header.id).length;
    questionCount.textContent = `(${count} questions)`;
    headerText.appendChild(questionCount);

    const questionsDiv = document.createElement('div');
    questionsDiv.className = 'header-questions';
    questionsDiv.dataset.headerId = header.id;

    return { headerDiv, questionsDiv };
}

// Add a new header
function addNewHeader(mode) {
    // Hide question form if open
    document.getElementById(mode + '-question-form').style.display = 'none';
    
    // Show header form
    document.getElementById(mode + '-header-form-title').textContent = "<?=t('Add New Header')?>";
    document.getElementById(mode + '-header-text').value = '';
    document.getElementById(mode + '-header-form').style.display = 'block';
    currentHeaderId = null;
}

// Cancel header form
function cancelHeaderForm(mode) {
    document.getElementById(mode + '-header-form').style.display = 'none';
    currentHeaderId = null;
}

// Save header
function saveHeader(mode) {
    const headerText = document.getElementById(mode + '-header-text').value.trim();
    
    if (!headerText) {
        alert("<?=t('Please enter header text')?>");
        return;
    }
    
    if (currentHeaderId === null) {
        // Add new header
        const newId = editHeaders.length > 0 ? Math.max(...editHeaders.map(h => h.id)) + 1 : 1;
        editHeaders.push({
            id: newId,
            text: headerText
        });
    } else {
        // Update existing header
        const headerIndex = editHeaders.findIndex(h => h.id === currentHeaderId);
        if (headerIndex !== -1) {
            editHeaders[headerIndex].text = headerText;
        }
    }
    
    // Update form state
    formChanged = true;
    
    // Update header dropdown
    updateHeaderDropdown(mode);
    
    // Save to form
    saveQuestionsToForm(mode);
    
    // Hide the header form
    document.getElementById(mode + '-header-form').style.display = 'none';
    currentHeaderId = null;
    
    // Render the updated questions and headers
    renderQuestions(mode);
}

// Edit an existing header
function editHeader(headerId, mode) {
    const header = editHeaders.find(h => h.id === headerId);
    
    if (header) {
        // Hide question form if open
        document.getElementById(mode + '-question-form').style.display = 'none';
        
        document.getElementById(mode + '-header-form-title').textContent = "<?=t('Edit Header')?>";
        document.getElementById(mode + '-header-text').value = header.text;
        document.getElementById(mode + '-header-form').style.display = 'block';
        currentHeaderId = headerId;
    }
}

// Delete a header
function deleteHeader(headerId, mode) {
    if (!confirm("<?=t('Are you sure you want to delete this header? Questions under this header will be moved to top level.')?>")) return;
    
    const headerIndex = editHeaders.findIndex(h => h.id === headerId);
    
    if (headerIndex !== -1) {
        // Remove the header
        editHeaders.splice(headerIndex, 1);
        
        // Update questions that were under this header
        editQuestions.forEach(question => {
            if (question.headerId === headerId) {
                question.headerId = null;
            }
        });
        
        // Update form state
        formChanged = true;
        
        // Update header dropdown
        updateHeaderDropdown(mode);
        
        // Save to form
        saveQuestionsToForm(mode);
        
        // Render the updated questions and headers
        renderQuestions(mode);
    }
}

// Add a new question
function addNewQuestion(mode) {
    // Hide any existing question forms
    document.getElementById(mode + '-question-form-title').textContent = "<?=t('Add New Question')?>";
    document.getElementById(mode + '-question-text').value = '';
    document.getElementById(mode + '-question-weight').value = '1';
    document.getElementById(mode + '-question-form').style.display = 'block';
    currentQuestionId = null;
}

// Edit an existing question
function editQuestion(questionId, mode) {
    const questions = editQuestions;
    const question = questions.find(q => q.id === questionId);
    
    if (question) {
        // Hide header form if open
        document.getElementById(mode + '-header-form').style.display = 'none';
        
        document.getElementById(mode + '-question-form-title').textContent = "<?=t('Edit Question')?>";
        document.getElementById(mode + '-question-text').value = question.text;
        document.getElementById(mode + '-question-weight').value = question.weight;
        
        // Set the header dropdown value
        const headerSelect = document.getElementById(mode + '-question-header');
        headerSelect.value = question.headerId || '';
        
        document.getElementById(mode + '-question-form').style.display = 'block';
        currentQuestionId = questionId;
    }
}

// Cancel question form
function cancelQuestionForm(mode) {
    document.getElementById(mode + '-question-form').style.display = 'none';
    currentQuestionId = null;
}

// Save question
function saveQuestion(mode) {
    const questionText = document.getElementById(mode + '-question-text').value.trim();
    const questionWeight = parseInt(document.getElementById(mode + '-question-weight').value);
    const headerId = document.getElementById(mode + '-question-header').value;
    
    if (!questionText) {
        alert("<?=t('Please enter question text')?>");
        return;
    }
    
    if (isNaN(questionWeight) || questionWeight < 1 || questionWeight > 5) {
        alert("<?=t('Weight must be a number between 1 and 5')?>");
        return;
    }
    
    const questions = editQuestions;
    
    if (currentQuestionId === null) {
        // Add new question
        const newId = questions.length > 0 ? Math.max(...questions.map(q => q.id)) + 1 : 1;
        questions.push({
            id: newId,
            text: questionText,
            weight: questionWeight,
            headerId: headerId ? parseInt(headerId) : null
        });
    } else {
        // Update existing question
        const questionIndex = questions.findIndex(q => q.id === currentQuestionId);
        if (questionIndex !== -1) {
            questions[questionIndex].text = questionText;
            questions[questionIndex].weight = questionWeight;
            questions[questionIndex].headerId = headerId ? parseInt(headerId) : null;
        }
    }
    
    // Update form state
    formChanged = true;
    
    // Save questions to form
    saveQuestionsToForm(mode);
    
    // Hide the question form
    document.getElementById(mode + '-question-form').style.display = 'none';
    currentQuestionId = null;
    
    // Render the updated questions
    renderQuestions(mode);
}

// Delete a question
function deleteQuestion(questionId, mode) {
    if (!confirm('<?=t('Are you sure you want to delete this question?')?>')) return;
    
    const questions = editQuestions;
    const questionIndex = questions.findIndex(q => q.id === questionId);
    
    if (questionIndex !== -1) {
        questions.splice(questionIndex, 1);
        
        // Update form state
        formChanged = true;
        
        saveQuestionsToForm(mode);
        renderQuestions(mode);
    }
}

// Inline edit question text
function inlineEditQuestionText(element) {
    const questionId = parseInt(element.getAttribute('data-id'));
    const mode = element.getAttribute('data-mode');
    const questions = editQuestions;
    const question = questions.find(q => q.id === questionId);
    
    if (!question) return;
    
    // Save the original content in case we need to revert
    const originalText = element.textContent;
    
    // Create a textarea for editing
    const textarea = document.createElement('textarea');
    textarea.value = originalText;
    textarea.className = 'form-control';
    textarea.style.width = '100%';
    textarea.style.minHeight = '60px';
    
    // Replace the text with the textarea
    element.innerHTML = '';
    element.appendChild(textarea);
    
    // Focus the textarea
    textarea.focus();
    
    // Handle saving on blur
    textarea.addEventListener('blur', function() {
        const newText = textarea.value.trim();
        
        if (newText && newText !== originalText) {
            // Update the question
            question.text = newText;
            formChanged = true;
            saveQuestionsToForm(mode);
        }
        
        // Restore the element with updated or original text
        element.innerHTML = question.text;
    });
    
    // Handle Enter key to save (Shift+Enter for new line)
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            textarea.blur();
        }
        
        // Cancel on Escape
        if (e.key === 'Escape') {
            textarea.value = originalText;
            textarea.blur();
        }
    });
}

// Inline edit question weight
// Toggle header collapse/expand
function toggleHeader(headerId, mode) {
    const headerSection = document.querySelector(`.section-header[data-header-id="${headerId}"]`);
    const questionsContainer = document.querySelector(`.header-questions[data-header-id="${headerId}"]`);
    const toggleIcon = headerSection.querySelector('.header-toggle i');
    
    const isCollapsed = questionsContainer.classList.toggle('collapsed');
    toggleIcon.className = isCollapsed ? 'fa fa-chevron-right' : 'fa fa-chevron-down';
}

function inlineEditQuestionWeight(element) {
    const questionId = parseInt(element.getAttribute('data-id'));
    const mode = element.getAttribute('data-mode');
    const questions = editQuestions;
    const question = questions.find(q => q.id === questionId);
    
    if (!question) return;
    
    // Get the weight span
    const weightSpan = element.querySelector('span');
    const originalWeight = question.weight;
    
    // Create a select dropdown for weights
    const select = document.createElement('select');
    select.className = 'form-control input-sm';
    select.style.width = '60px';
    select.style.display = 'inline-block';
    
    // Add options 1-5
    for (let i = 1; i <= 5; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        if (i === originalWeight) {
            option.selected = true;
        }
        select.appendChild(option);
    }
    
    // Replace the weight span with the select
    weightSpan.innerHTML = '';
    weightSpan.appendChild(select);
    
    // Focus the select
    select.focus();
    
    // Handle saving on change and blur
    select.addEventListener('change', function() {
        const newWeight = parseInt(select.value);
        
        if (!isNaN(newWeight) && newWeight >= 1 && newWeight <= 5 && newWeight !== originalWeight) {
            // Update the question
            question.weight = newWeight;
            formChanged = true;
            saveQuestionsToForm(mode);
        }
    });
    
    select.addEventListener('blur', function() {
        // Restore the element with updated weight
        renderQuestions(mode);
    });
    
    // Handle Enter key to save
    select.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            select.blur();
        }
        
        // Cancel on Escape
        if (e.key === 'Escape') {
            select.value = originalWeight;
            select.blur();
        }
    });
}
</script>
