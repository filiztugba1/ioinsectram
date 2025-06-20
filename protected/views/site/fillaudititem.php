<?php
/* @var $this SiteController */
/* @var $workorder array */
/* @var $auditItem array */
/* @var $questions array */

$this->pageTitle=Yii::app()->name . ' - Fill Audit Item';
?>

<style>
    * {
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    body {
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }
    .main-content {
        flex: 1;
        padding: 40px 20px;
    }
    .container {
        width: 100%;
        max-width: 1700px;
        margin: 0 auto;
        background-color: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    .title-input-container {
        margin-bottom: 24px;
    }
    .title-label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #374151;
    }
    .title-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }
    .title-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .button-group {
        display: flex;
        gap: 12px;
    }
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .btn-primary {
        background-color: #2563eb;
        color: white;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
    .btn-success {
        background-color: #10b981;
        color: white;
    }
    .btn-success:hover {
        background-color: #059669;
    }
    .btn-secondary {
        background-color: #f3f4f6;
        color: #1f2937;
    }
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    .btn-danger {
        background-color: #ef4444;
        color: white;
    }
    .btn-danger:hover {
        background-color: #dc2626;
    }
    .btn-default {
        background-color: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }
    .btn-default:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
    }
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.875rem;
        white-space: nowrap;
    }
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }
    .icon {
        margin-right: 8px;
    }
    .icon-only {
        margin-right: 0;
    }
    .report-title {
        background-color: #fff7ed;
        padding: 16px;
        text-align: center;
        font-weight: 700;
        font-size: 1.25rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        margin-bottom: 16px;
        color: #7c2d12;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        table-layout: fixed;
    }
    th, td {
        border: 1px solid #e5e7eb;
        padding: 12px;
        vertical-align: top;
    }
    
    /* Column widths */
    th:nth-child(1) { width: 28%; } /* Question */
    th:nth-child(2) { width: 8%; } /* Weight */
    th:nth-child(3) { width: 8%; } /* Score */
    th:nth-child(4) { width: 8%; } /* Total */
    th:nth-child(5) { width: 24%; } /* Findings */
    th:nth-child(6) { width: 15%; } /* Nonconformity */
    th {
        background-color: #f9fafb;
        text-align: left;
        font-weight: 600;
        color: #374151;
    }
    tr:hover {
        background-color: #f9fafb;
    }
    input, textarea, select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: border-color 0.2s;
    }
    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    input[type="number"] {
        text-align: center;
    }
    .time-input {
        max-width: 150px;
    }
    .text-center {
        text-align: center;
    }
    .font-bold {
        font-weight: 700;
    }
    .text-xs {
        font-size: 0.75rem;
    }
    .text-blue {
        color: #2563eb;
    }
    
    .section-header {
        background-color: #e9ecef;
        border-bottom: 2px solid #6c757d;
        width: 100%;
        font-weight: bold;
    }
    
    .question-row td {
        padding: 16px;
    }
    
    .question-row {
        width: 100%;
        border-bottom: 1px solid #e9ecef;
        height: auto;
    }
    
    .question-row td {
        padding: 10px;
        vertical-align: middle;
    }
    
    .question-row textarea {
        height: 80px;
        min-height: 80px;
        margin-top: 5px;
        resize: vertical;
    }
    
    .time-input {
        width: 100px;
        margin-top: 5px;
    }
    
    /* Fix alignment of text in cells */
    .text-center {
        text-align: center !important;
    }
    
    /* Make sure all form elements have consistent styling */
    input, select, textarea {
        border: 1px solid #d1d5db;
        border-radius: 4px;
        padding: 6px 8px;
    }
    
    /* Style for the question text */
    .question-text {
        font-weight: 500;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    
    .header-content {
        display: flex;
        align-items: center;
        padding: 12px;
        gap: 8px;
    }
    
    .header-toggle {
        cursor: pointer;
        color: #64748b;
        transition: transform 0.2s;
    }
    
    .header-toggle.collapsed {
        transform: rotate(-90deg);
    }
    
    .header-text {
        font-weight: 600;
        color: #334155;
        flex-grow: 1;
    }
    
    .question-row.collapsed {
        display: none;
    }
    .mt-1 {
        margin-top: 4px;
    }
    .alert {
        padding: 12px 16px;
        border-radius: 4px;
        margin-bottom: 16px;
    }
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .alert-info {
        background-color: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }
    .score-input {
        width: 60px;
        text-align: center;
    }
    .weight-display {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        background-color: #f3f4f6;
        border-radius: 50%;
        font-weight: 600;
    }
    .total-display {
        font-weight: 600;
        color: #1e40af;
    }
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    .modal {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 24px;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
    }
    .modal-close:hover {
        color: #111827;
    }
    .modal-body {
        margin-bottom: 24px;
    }
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }
    
    /* Nonconformity Grid */
    .nonconformity-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }
    .nonconformity-item {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        cursor: pointer;
        transition: border-color 0.2s, transform 0.2s;
        text-align: center;
    }
    .nonconformity-item:hover {
        border-color: #93c5fd;
        transform: translateY(-2px);
    }
    .nonconformity-item.selected {
        border-color: #2563eb;
        background-color: #eff6ff;
    }
    
    /* Selected Nonconformity */
    .selected-nonconformities {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .selected-nonconformity {
        display: flex;
        align-items: center;
        background-color: #f3f4f6;
        border-radius: 6px;
        padding: 8px;
    }
    .selected-nonconformity-info {
        flex: 1;
    }
    .selected-nonconformity-number {
        font-weight: 600;
        color: #111827;
        margin: 0;
        font-size: 0.875rem;
    }
    .selected-nonconformity-actions {
        display: flex;
        gap: 4px;
    }
    .add-nonconformity-btn {
        margin-top: 8px;
    }
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        .button-group {
            width: 100%;
        }
        .btn {
            flex: 1;
        }
        th, td {
            padding: 8px;
        }
    }
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    .modal {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 24px;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
    }
    .modal-close:hover {
        color: #111827;
    }
    .modal-body {
        margin-bottom: 24px;
    }
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }
    
    /* Nonconformity Grid */
    .nonconformity-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }
    .nonconformity-item {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        cursor: pointer;
        transition: border-color 0.2s, transform 0.2s;
        text-align: center;
    }
    .nonconformity-item:hover {
        border-color: #93c5fd;
        transform: translateY(-2px);
    }
    .nonconformity-item.selected {
        border-color: #2563eb;
        background-color: #eff6ff;
    }
    .nonconformity-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }
    .nonconformity-number {
        font-weight: 600;
        color: #111827;
    }
    
    /* Selected Nonconformity */
    .selected-nonconformities {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .selected-nonconformity {
        display: flex;
        align-items: center;
        background-color: #f3f4f6;
        border-radius: 6px;
        padding: 8px;
    }
    .selected-nonconformity-image {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 8px;
    }
    .selected-nonconformity-info {
        flex: 1;
    }
    .selected-nonconformity-number {
        font-weight: 600;
        color: #111827;
        margin: 0;
        font-size: 0.875rem;
    }
    .selected-nonconformity-actions {
        display: flex;
        gap: 4px;
    }
    .add-nonconformity-btn {
        margin-top: 8px;
    }
</style>

<div class="main-content">
    <div class="container">
        <div class="clearfix" style="margin-bottom: 20px;">
            <h1 style="float: left;"><?php echo CHtml::encode($auditItem['name']); ?></h1>
            <div style="float: right; margin-top: 10px;">
                <a href="<?php echo $this->createUrl('viewauditreport', array('id' => $workorder['id'])); ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Back to Audit Report
                </a>
            </div>
        </div>
        
        <div style="margin-bottom: 20px; padding: 15px; background-color: #f9fafb; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin-bottom: 10px; color: #374151; font-size: 1.1rem;">Yayın Durumu</h3>
                    <div style="display: inline-block; padding: 6px 12px; border-radius: 4px; font-weight: 500; font-size: 0.9rem; <?php echo isset($auditItem['is_published']) && $auditItem['is_published'] == 1 ? 'background-color: #10b981; color: white;' : 'background-color: #f3f4f6; color: #374151;'; ?>">
                        <?php echo isset($auditItem['is_published']) && $auditItem['is_published'] == 1 ? 'Yayında' : 'Yayında Değil'; ?>
                    </div>
                </div>
                <div>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="publish_report" value="<?php echo isset($auditItem['is_published']) && $auditItem['is_published'] == 1 ? '0' : '1'; ?>">
                        <button type="submit" class="btn <?php echo isset($auditItem['is_published']) && $auditItem['is_published'] == 1 ? 'btn-danger' : 'btn-success'; ?>">
                            <i class="fa <?php echo isset($auditItem['is_published']) && $auditItem['is_published'] == 1 ? 'fa-times' : 'fa-check'; ?>"></i> 
                            <?php echo isset($auditItem['is_published']) && $auditItem['is_published'] == 1 ? 'Yayından Kaldır' : 'Bu Raporu Yayınla'; ?>
                        </button>
                    </form>
                </div>
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
        

        

        
        <div class="title-input-container">
            <label for="assessment-title" class="title-label">Workorder #<?php echo CHtml::encode($workorder['id']); ?> - <?php echo CHtml::encode($workorder['client_name']); ?></label>
            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <p><strong>Date:</strong> <?php echo CHtml::encode(date('Y-m-d', strtotime($workorder['date']))); ?></p>
                    <p><strong>Category:</strong> 
                        <?php 
                        $categoryName = Yii::app()->db->createCommand()
                            ->select('name')
                            ->from('audit_categories')
                            ->where('id=:id', array(':id'=>$auditItem['category_id']))
                            ->queryScalar();
                        echo CHtml::encode($categoryName); 
                        ?>
                    </p>
                </div>
                <div style="flex: 1;">
                    <p><strong>Description:</strong> <?php echo CHtml::encode($auditItem['description']); ?></p>
                </div>
            </div>
        </div>

        <div class="page-header">
            <h1 id="form-title" class="page-title">Audit Assessment</h1>
        </div>

        <!-- Audit Summary and Success Rate -->
        <?php
        // Calculate initial values from the saved data
        $totalWeight = 0;
        $totalPoint = 0;
        $maxPoint = 0;
        $successRate = 100;
        
        // Loop through questions to calculate totals
        foreach ($questions as $question) {
            // Skip headers
            if (isset($question['isHeader']) && $question['isHeader']) {
                continue;
            }
            if (isset($question['type']) && $question['type'] === 'header') {
                continue;
            }
            
            $weight = isset($question['weight']) ? intval($question['weight']) : 0;
            $score = isset($question['score']) ? intval($question['score']) : 1; // Default to 1 instead of 0
            
            // Ensure score is at least 1 (new minimum)
            if ($score < 1) {
                $score = 1;
            }
            
            $totalWeight += $weight;
            $totalPoint += ($weight * $score);
        }
        
        // Calculate max point (total weight * 5)
        $maxPoint = $totalWeight * 5;
        
        // Calculate success rate
        if ($maxPoint > 0) {
            $successRate = round(100 - (($totalPoint / $maxPoint) * 100));
        }
        ?>
        <div class="audit-summary" style="margin-bottom: 20px; background-color: #f9fafb; border-radius: 8px; padding: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
                <div style="flex: 1; min-width: 120px; background-color: white; padding: 10px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <div style="font-size: 12px; color: #6b7280;">Total Weight</div>
                    <div style="font-size: 16px; font-weight: bold; color: #111827;" id="total-weight"><?php echo $totalWeight; ?></div>
                </div>
                
                <div style="flex: 1; min-width: 120px; background-color: white; padding: 10px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <div style="font-size: 12px; color: #6b7280;">Max Point</div>
                    <div style="font-size: 16px; font-weight: bold; color: #111827;" id="max-point"><?php echo $maxPoint; ?></div>
                </div>
                
                <div style="flex: 1; min-width: 120px; background-color: white; padding: 10px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <div style="font-size: 12px; color: #6b7280;">Total Point</div>
                    <div style="font-size: 16px; font-weight: bold; color: #111827;" id="total-point"><?php echo $totalPoint; ?></div>
                </div>
            </div>
            
            <!-- Success Percentage Bar -->
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="font-weight: bold; font-size: 12px;">Success Rate:</span>
                    <span id="success-percentage" style="font-weight: bold; font-size: 12px;"><?php echo $successRate; ?>%</span>
                </div>
                <div style="height: 18px; background-color: #ef4444; border-radius: 4px; overflow: hidden;">
                    <div id="success-bar-inner" style="height: 100%; background-color: #22c55e; width: <?php echo $successRate; ?>%; transition: width 0.5s ease;"></div>
                </div>
                <!-- Success rate will be added dynamically by JavaScript -->
            </div>
        </div>

        <div id="report-title-container" style="display: none;" class="report-title"></div>

        <div id="assessment-table-container">
            <form method="post" id="audit-form" action="">
                <table id="assessment-table">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th style="width: 80px; text-align: center;">Weight</th>
                            <th style="width: 80px; text-align: center;">Score (1-5)</th>
                            <th style="width: 80px; text-align: center;">Total</th>
                            <th style="width: 25%;">Findings</th>
                            <th style="width: 150px;">Nonconformity</th>
                        </tr>
                    </thead>
                    <tbody id="assessment-table-body">
                        <?php 
                        // Parse the JSON structure if it's a string
                        if (is_string($questions)) {
                            $questionsData = json_decode($questions, true);
                        } else {
                            $questionsData = $questions;
                        }
                        
                        $hasQuestions = false;
                        $questionsByHeader = [];
                        $topLevelQuestions = [];
                        
                        // Check if we have the expected structure with headers and questions arrays
                        if (isset($questionsData['headers']) && isset($questionsData['questions'])) {
                            $hasQuestions = true;
                            $headers = $questionsData['headers'];
                            $allQuestions = $questionsData['questions'];
                            
                            // Create a map of headers for easy lookup
                            $headerMap = [];
                            foreach ($headers as $header) {
                                $headerMap[$header['id']] = $header;
                            }
                            
                            // Group questions by header
                            foreach ($allQuestions as $question) {
                                // If the question has a valid headerId
                                if (isset($question['headerId']) && !empty($question['headerId']) && 
                                    isset($headerMap[$question['headerId']])) {
                                    
                                    $headerId = $question['headerId'];
                                    
                                    if (!isset($questionsByHeader[$headerId])) {
                                        $questionsByHeader[$headerId] = [
                                            'header' => $headerMap[$headerId]['text'],
                                            'questions' => []
                                        ];
                                    }
                                    
                                    $questionsByHeader[$headerId]['questions'][] = $question;
                                } else {
                                    // No header or invalid header, add to top level
                                    $topLevelQuestions[] = $question;
                                }
                            }
                        } elseif (is_array($questions) && count($questions) > 0) {
                            $hasQuestions = true;
                            
                            // Check each question for headerId
                            foreach ($questions as $question) {
                                if (isset($question['headerId']) && !empty($question['headerId'])) {
                                    $headerId = $question['headerId'];
                                    
                                    if (!isset($questionsByHeader[$headerId])) {
                                        $headerText = isset($question['headerText']) ? $question['headerText'] : 'Section ' . $headerId;
                                        $questionsByHeader[$headerId] = [
                                            'header' => $headerText,
                                            'questions' => []
                                        ];
                                    }
                                    
                                    $questionsByHeader[$headerId]['questions'][] = $question;
                                } else {
                                    $topLevelQuestions[] = $question;
                                }
                            }
                        }
                        
                        if ($hasQuestions):
                            
                            // First render top-level questions under 'General Questions' header
                            if (!empty($topLevelQuestions)): ?>
                                <tr class="header-row">
                                    <td colspan="6" class="section-header">
                                        <div class="header-content">
                                            <span class="header-text">1. General Questions (<?php echo count($topLevelQuestions); ?>)</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php $questionNumber = 1; // Initialize question counter for general questions
                                foreach($topLevelQuestions as $question): 
                                    $questionId = $question['id']; 
                                    $weight = isset($question['weight']) ? (int)$question['weight'] : 1;
                                    $score = isset($question['score']) ? (int)$question['score'] : 0;
                                    $total = $weight * $score;
                                    $findings = isset($question['findings']) ? $question['findings'] : '';
                                ?>
                                <tr>
                                    <td>
                                        <div style="font-weight: 500;"><?php echo $questionNumber . '. ' . CHtml::encode($question['text']); ?></div>
                                        <div class="text-xs text-blue mt-1">
                                            <span>Time:</span>
                                            <input type="text" name="timestamps[<?php echo $questionId; ?>]" id="timestamp-<?php echo $questionId; ?>" class="time-input" value="<?php echo CHtml::encode($timestamp); ?>" style="width: 120px; height: 22px; padding: 2px 5px; display: inline-block; font-size: 12px;">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="weight-display"><?php echo $weight; ?></span>
                                        <input type="hidden" name="weights[<?php echo $questionId; ?>]" value="<?php echo $weight; ?>">
                                    </td>
                                    <td class="text-center">
                                        <select name="scores[<?php echo $questionId; ?>]" class="score-input" onchange="updateTotal(this, <?php echo $weight; ?>, '<?php echo $questionId; ?>')">
                                            <option value="1" <?php echo $score == 1 ? 'selected' : ''; ?>>1</option>
                                            <option value="2" <?php echo $score == 2 ? 'selected' : ''; ?>>2</option>
                                            <option value="3" <?php echo $score == 3 ? 'selected' : ''; ?>>3</option>
                                            <option value="4" <?php echo $score == 4 ? 'selected' : ''; ?>>4</option>
                                            <option value="5" <?php echo $score == 5 ? 'selected' : ''; ?>>5</option>
                                        </select>
                                    </td>
                                    <td class="text-center font-bold">
                                        <span id="total-<?php echo $questionId; ?>" class="total-display"><?php echo $total; ?></span>
                                    </td>
                                    <td>
                                        <textarea name="findings[<?php echo $questionId; ?>]" id="findings-<?php echo $questionId; ?>" placeholder="Enter findings..." style="height: 60px;"><?php echo CHtml::encode($findings); ?></textarea>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="openNonconformityModal('<?php echo $questionId; ?>')">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                        <input type="hidden" name="nonconformity_ids[<?php echo $questionId; ?>]" id="nonconformity-ids-<?php echo $questionId; ?>" value="<?php echo isset($question['nonconformity_ids']) ? $question['nonconformity_ids'] : ''; ?>">
                                        
                                        <!-- Container to display selected nonconformities -->
                                        <div id="nonconformity-display-<?php echo $questionId; ?>" class="mt-2" style="min-height: 24px;">
                                            <?php if (!empty($question['nonconformity_ids'])): ?>
                                                <?php 
                                                $nonconformityIds = explode(',', $question['nonconformity_ids']);
                                                foreach ($nonconformityIds as $ncId): 
                                                    if (empty($ncId)) continue;
                                                    // Uygunsuzluk bilgilerini bul
                                                    $nonconformityItem = null;
                                                    foreach ($nonconformities as $nc) {
                                                        if ($nc['id'] == $ncId) {
                                                            $nonconformityItem = $nc;
                                                            break;
                                                        }
                                                    }
                                                ?>
                                                    <span class="nc-badge" 
                                                        style="display: inline-block; background: #4a86e8; color: white; padding: 2px 6px; border-radius: 4px; margin-right: 5px; margin-bottom: 5px; font-size: 11px; cursor: pointer; position: relative;"
                                                        data-id="<?php echo $ncId; ?>"
                                                        onmouseover="showTooltip(this, <?php echo $ncId; ?>)"
                                                        onmouseout="hideTooltip(this)">
                                                        #<?php echo $ncId; ?>
                                                        <?php if ($nonconformityItem): ?>
                                                        <div class="nc-tooltip" style="display: none; position: absolute; top: 50%; right: 100%; transform: translateY(-50%); width: 220px; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); padding: 8px; z-index: 9999; margin-right: 10px; text-align: left; max-height: 300px; overflow-y: auto;">
                                                             <?php if (!empty($nonconformityItem['filesf'])): ?>
                                                             <?php
                                                                 // Make sure the URL is properly formatted
                                                                 $imageUrl = $nonconformityItem['filesf'];
                                                                 // If the URL doesn't start with http or /, add a / to make it relative to the root
                                                                 if (!preg_match('/^(http|\/)/i', $imageUrl)) {
                                                                     $imageUrl = '/' . $imageUrl;
                                                                 }
                                                             ?>
                                                             <div style="height: 100px; background-image: url('<?php echo $imageUrl; ?>'); background-size: cover; background-position: center; margin-bottom: 5px; border-radius: 3px;"></div>
                                                             <?php endif; ?>
                                                            
                                                            <?php if (!empty($nonconformityItem['definition'])): ?>
                                                            <div style="font-size: 11px; color: #333; margin-bottom: 5px;"><?php echo CHtml::encode($nonconformityItem['definition']); ?></div>
                                                            <?php endif; ?>
                                                            
                                                            <?php if (!empty($nonconformityItem['suggestion'])): ?>
                                                            <div style="font-size: 10px; color: #3a87ad; background-color: #d9edf7; padding: 3px; border-radius: 2px;">
                                                                <strong>Suggestion:</strong> <?php echo CHtml::encode($nonconformityItem['suggestion']); ?>
                                                            </div>
                                                            <?php endif; ?>
                                                            
                                                            <?php if (!empty($nonconformityItem['department_name'])): ?>
                                                            <div style="font-size: 10px; color: #777; margin-top: 5px;">
                                                                <strong>Dept:</strong> <?php echo CHtml::encode($nonconformityItem['department_name']); ?>
                                                                <?php if (!empty($nonconformityItem['subdepartment_name'])): ?>
                                                                / <?php echo CHtml::encode($nonconformityItem['subdepartment_name']); ?>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php endif; ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <em>No nonconformities selected</em>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <?php 
                            // Then render questions grouped by headers
                            $headerCount = 1; // Start from 1 for all headers
                            foreach($questionsByHeader as $headerId => $headerData): ?>
                                <tr class="header-row">
                                    <td colspan="6" class="section-header">
                                        <div class="header-content">
                                            <span class="header-text"><?php echo $headerCount; ?>. <?php echo CHtml::encode($headerData['header']); ?> (<?php echo count($headerData['questions']); ?>)</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php $headerCount++; ?>
                                <?php $questionNumber = 1; // Reset question counter for this section
                                foreach($headerData['questions'] as $question): 
                                    $questionId = $question['id']; 
                                    $weight = isset($question['weight']) ? (int)$question['weight'] : 1;
                                    $score = isset($question['score']) ? (int)$question['score'] : 0;
                                    $total = $weight * $score;
                                    $findings = isset($question['findings']) ? $question['findings'] : '';
                                ?>
                                <tr class="question-row">
                                    <td>
                                        <div class="question-text"><?php echo $questionNumber . '. ' . CHtml::encode($question['text']); ?></div>
                                        <div class="text-xs text-blue">
                                            <span>Time:</span>
                                            <input type="text" name="timestamps[<?php echo $questionId; ?>]" value="<?php echo CHtml::encode($timestamp); ?>" class="time-input" id="timestamp-<?php echo $questionId; ?>">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" name="weights[<?php echo $questionId; ?>]" value="<?php echo $weight; ?>" style="width: 50px; margin: 0 auto;" readonly>
                                    </td>
                                    <td class="text-center">
                                        <select name="scores[<?php echo $questionId; ?>]" style="width: 60px; margin: 0 auto;">
                                            <option value="1"<?php echo $score == 1 ? ' selected' : ''; ?>>1</option>
                                            <option value="2"<?php echo $score == 2 ? ' selected' : ''; ?>>2</option>
                                            <option value="3"<?php echo $score == 3 ? ' selected' : ''; ?>>3</option>
                                            <option value="4"<?php echo $score == 4 ? ' selected' : ''; ?>>4</option>
                                            <option value="5"<?php echo $score == 5 ? ' selected' : ''; ?>>5</option>
                                        </select>
                                    </td>
                                    <td class="text-center total-cell"><?php echo $total; ?></td>
                                    <td>
                                        <textarea name="findings[<?php echo $questionId; ?>]" rows="3" placeholder="Findings"><?php echo CHtml::encode($findings); ?></textarea>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="openNonconformityModal('<?php echo $questionId; ?>')">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                        <input type="hidden" name="nonconformity_ids[<?php echo $questionId; ?>]" id="nonconformity-ids-<?php echo $questionId; ?>" value="<?php echo isset($question['nonconformity_ids']) ? $question['nonconformity_ids'] : ''; ?>">
                                        <div id="nonconformity-display-<?php echo $questionId; ?>" class="mt-2" style="min-height: 24px;">
                                            <?php if (!empty($question['nonconformity_ids'])): ?>
                                                <?php 
                                                $nonconformityIds = explode(',', $question['nonconformity_ids']);
                                                foreach ($nonconformityIds as $ncId): 
                                                    if (empty($ncId)) continue;
                                                ?>
                                                    <span class="nc-badge" 
                                                        style="display: inline-block; background: #4a86e8; color: white; padding: 2px 6px; border-radius: 4px; margin-right: 5px; margin-bottom: 5px; font-size: 11px; cursor: pointer; position: relative;"
                                                        data-id="<?php echo $ncId; ?>"
                                                        onmouseover="showTooltip(this, <?php echo $ncId; ?>)"
                                                        onmouseout="hideTooltip(this)">
                                                        NC-<?php echo $ncId; ?>
                                                        <span class="nc-remove" onclick="removeNonconformity('<?php echo $questionId; ?>', '<?php echo $ncId; ?>')">×</span>
                                                    </span>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <em>No nonconformities selected</em>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php $questionNumber++; // Increment question number
                                endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (!$hasQuestions): ?>
                            <tr>
                                <td colspan="6" class="text-center">No questions found for this audit.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    </tbody>
                </table>
                

                
                <!-- Hidden input to store success rate -->
                <input type="hidden" name="success_rate" id="success-rate-input" value="100">
                
                <div style="margin-top: 30px; padding: 20px; background-color: #f9fafb; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 15px; color: #374151; font-size: 1.25rem;">Rapor Bilgileri</h3>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
                        <?php
                        // Firma ID'sini al
                        $firmId = $auditItem['firm_id'];
                        
                        // Firmaya ait aktif kullanıcıları getir (clientid ve clientbranchid 0 olanlar)
                        $users = Yii::app()->db->createCommand()
                            ->select('id, name, surname')
                            ->from('user')
                            ->where('firmid=:firmid AND active=1 AND clientid=0 AND clientbranchid=0', array(':firmid'=>$firmId))
                            ->queryAll();
                        
                        // Mevcut değerleri al (eğer daha önce kaydedilmişse)
                        $questionsData = json_decode($auditItem['questions'], true);
                        
                        // JSON yapısı kontrolü ve değerleri alma
                        if (isset($questionsData['meta'])) {
                            // Flat array yapısı için meta dizisinden al
                            $inspectorId = isset($questionsData['meta']['inspector_id']) ? $questionsData['meta']['inspector_id'] : '';
                            $reportWriterId = isset($questionsData['meta']['report_writer_id']) ? $questionsData['meta']['report_writer_id'] : '';
                            $reportApproverId = isset($questionsData['meta']['report_approver_id']) ? $questionsData['meta']['report_approver_id'] : '';
                        } else {
                            // Nested yapı için doğrudan al
                            $inspectorId = isset($questionsData['inspector_id']) ? $questionsData['inspector_id'] : '';
                            $reportWriterId = isset($questionsData['report_writer_id']) ? $questionsData['report_writer_id'] : '';
                            $reportApproverId = isset($questionsData['report_approver_id']) ? $questionsData['report_approver_id'] : '';
                        }
                        ?>
                        
                        <!-- Denetçi Seçimi -->
                        <div style="flex: 1; min-width: 250px;">
                            <label for="inspector_id" style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Denetçi</label>
                            <select name="inspector_id" id="inspector_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                                <option value="">Seçiniz</option>
                                <?php foreach($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>" <?php echo ($inspectorId == $user['id']) ? 'selected' : ''; ?>>
                                    <?php echo $user['name'] . ' ' . $user['surname']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Raporu Yazan Kişi Seçimi -->
                        <div style="flex: 1; min-width: 250px;">
                            <label for="report_writer_id" style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Raporu Yazan Kişi</label>
                            <select name="report_writer_id" id="report_writer_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                                <option value="">Seçiniz</option>
                                <?php foreach($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>" <?php echo ($reportWriterId == $user['id']) ? 'selected' : ''; ?>>
                                    <?php echo $user['name'] . ' ' . $user['surname']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Raporu Onaylayan Kişi Seçimi -->
                        <div style="flex: 1; min-width: 250px;">
                            <label for="report_approver_id" style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Raporu Onaylayan Kişi</label>
                            <select name="report_approver_id" id="report_approver_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                                <option value="">Seçiniz</option>
                                <?php foreach($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>" <?php echo ($reportApproverId == $user['id']) ? 'selected' : ''; ?>>
                                    <?php echo $user['name'] . ' ' . $user['surname']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-center" style="margin-top: 20px;">
                    <input type="hidden" name="save_answers" value="1">
                    <button type="submit" class="btn btn-primary" id="save-button">
                        <i class="fa fa-save"></i> Save Audit Answers
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Modal for Nonconformity Selection (No Bootstrap) -->
<div id="nc-modal-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 9998;"></div>

<div id="nc-modal-container" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%; max-width: 500px; background: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index: 9999;">
    <div id="nc-modal-header" style="padding: 10px 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 16px;">Select Nonconformity</h3>
        <span id="nc-modal-close" style="cursor: pointer; font-size: 20px;">&times;</span>
    </div>
    
    <div id="nc-modal-body" style="padding: 15px; max-height: 60vh; overflow-y: auto;">
        <?php if (empty($nonconformities)): ?>
            <p>No nonconformities found for this workorder.</p>
        <?php else: ?>
            <div id="nc-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                <?php foreach ($nonconformities as $nonconformity): ?>
                <div class="nc-item" data-id="<?php echo $nonconformity['id']; ?>" data-priority="<?php echo isset($nonconformity['priority']) ? $nonconformity['priority'] : '0'; ?>" style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden; cursor: pointer;">
                    <?php if (!empty($nonconformity['filesf'])): ?>
                    <div class="nc-image" style="height: 100px; background-image: url('<?php echo $nonconformity['filesf']; ?>'); background-size: cover; background-position: center;"></div>
                    <?php else: ?>
                    <div class="nc-image-placeholder" style="height: 70px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-image" style="color: #aaa;"></i>
                    </div>
                    <?php endif; ?>
                    
                    <div class="nc-content" style="padding: 8px;">
                        <div class="nc-title" style="font-weight: bold; font-size: 12px; margin-bottom: 3px;">Nonconformity #<?php echo $nonconformity['id']; ?> / Priority: <?php echo isset($nonconformity['priority']) ? $nonconformity['priority'] : '0'; ?></div>
                        
                        <?php if (!empty($nonconformity['definition'])): ?>
                        <div class="nc-definition" style="font-size: 11px; margin-bottom: 3px;">
                            <?php echo CHtml::encode($nonconformity['definition']); ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($nonconformity['suggestion'])): ?>
                        <div class="nc-suggestion" style="font-size: 10px; color: #3a87ad; margin-bottom: 3px; background-color: #d9edf7; padding: 3px; border-radius: 2px;">
                            <strong>Suggestion:</strong> <?php echo CHtml::encode($nonconformity['suggestion']); ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($nonconformity['department_name'])): ?>
                        <div class="nc-department" style="font-size: 10px; color: #777;">
                            <strong>Dept:</strong> <?php echo CHtml::encode($nonconformity['department_name']); ?>
                            <?php if (!empty($nonconformity['subdepartment_name'])): ?>
                            / <?php echo CHtml::encode($nonconformity['subdepartment_name']); ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div id="nc-modal-footer" style="padding: 10px 15px; border-top: 1px solid #eee; text-align: right;">
        <button id="nc-cancel-btn" style="background: #f5f5f5; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px; margin-right: 5px; cursor: pointer;">Cancel</button>
        <button id="nc-select-btn" style="background: #4a86e8; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Select</button>
    </div>
</div>

<!-- Hidden inputs for tracking state -->
<input type="hidden" id="nc-current-question" value="">
<input type="hidden" id="nc-selected-ids" value="">

<script>
    // Global variables
    let isReportView = false;
    let isEditMode = false;
    let currentEditingId = null;
    let globalSuccessRate = <?php echo $successRate; ?>; // Initialize with PHP value
    let selectedNonconformityIds = [];
    
    // Function to update total score
    function updateTotal(scoreSelect, weight, questionId) {
        var score = parseInt(scoreSelect.value) || 0;
        var total = weight * score;
        document.getElementById('total-' + questionId).textContent = total;
        calculateTotalWeight();
    }
    
    // Function to calculate and update total weight and points
    function calculateTotalWeight() {
        const weightElements = document.querySelectorAll('.weight-display');
        const totalElements = document.querySelectorAll('.total-display');
        let totalWeight = 0;
        
        // Get all weight inputs
        const weights = document.querySelectorAll('input[name^="weights"]');
        
        // Sum up all weights
        weights.forEach(weight => {
            totalWeight += parseInt(weight.value) || 0;
        });
        
        // Update the UI
        document.getElementById('total-weight').textContent = totalWeight;
        
        // Calculate max point (total weight * 5)
        const maxPoint = totalWeight * 5;
        document.getElementById('max-point').textContent = maxPoint;
        
        // Calculate total points
        let totalPoint = 0;
        const scores = document.querySelectorAll('select[name^="scores"]');
        
        // Match weights with scores and calculate total points
        for (let i = 0; i < Math.min(weights.length, scores.length); i++) {
            const weight = parseInt(weights[i].value) || 0;
            // Ensure score is at least 1 (new minimum)
            let score = parseInt(scores[i].value) || 1;
            if (score < 1) score = 1;
            totalPoint += weight * score;
        }
        
        // Update total point in UI
        document.getElementById('total-point').textContent = totalPoint;
        
        // Calculate success rate using the 5x5 risk matrix formula
        let successRate = 100;
        if (maxPoint > 0) {
            // Minimum risk (all questions scored 1)
            const minRisk = totalWeight * 1;
            // Maximum risk (all questions scored 5)
            const maxRisk = totalWeight * 5;
            
            if (maxRisk > minRisk) {
                // Use the correct formula: 100 - ((totalRisk - minRisk) / (maxRisk - minRisk)) * 100
                successRate = Math.round(100 - ((totalPoint - minRisk) / (maxRisk - minRisk)) * 100);
                // Ensure the success rate is between 0 and 100
                successRate = Math.max(0, Math.min(100, successRate));
            }
        }
        
        // Update the global success rate variable
        globalSuccessRate = successRate;
        console.log('Updated global success rate to:', globalSuccessRate, 'using correct 5x5 risk matrix formula');
        
        // Update success rate in UI
        document.getElementById('success-percentage').textContent = successRate + '%';
        document.getElementById('success-bar-inner').style.width = successRate + '%';
        
        // Explicitly update the hidden input field with the calculated success rate
        const successRateInput = document.getElementById('success-rate-input');
        if (successRateInput) {
            successRateInput.value = successRate;
        }
        
        return {
            totalWeight: totalWeight,
            maxPoint: maxPoint,
            totalPoint: totalPoint,
            successRate: successRate
        };
    }
    
    // Function to update the success percentage bar
    function updateSuccessBar(totalPoint, maxPoint) {
        // Calculate success percentage (100% - percentage of points earned)
        let successPercentage = 100;
        if (maxPoint > 0) {
            const pointPercentage = (totalPoint / maxPoint) * 100;
            successPercentage = Math.max(0, 100 - pointPercentage);
        }
        
        // Round to 2 decimal places
        successPercentage = Math.round(successPercentage * 100) / 100;
        
        // Update the percentage text
        document.getElementById('success-percentage').textContent = successPercentage.toFixed(2) + '%';
        
        // Update the progress bar width
        document.getElementById('success-bar-inner').style.width = successPercentage + '%';
        
        // Update the hidden input field with the success rate value
        document.getElementById('success-rate-input').value = successPercentage.toFixed(2);
    }
    
    // Function to save all assessments
    function saveAllAssessments() {
        // Check if all time fields are filled
        // Get all time inputs by both class and name attribute
        const timeInputs = Array.from(document.querySelectorAll('.time-input'));
        const timestampInputs = Array.from(document.querySelectorAll('input[name^="timestamps"]'));
        
        // Combine both arrays and remove duplicates
        const allTimeInputs = [...new Set([...timeInputs, ...timestampInputs])];
        
        let missingTime = false;
        
        allTimeInputs.forEach(input => {
            if (!input.value.trim()) {
                missingTime = true;
                input.style.borderColor = '#ef4444';
            } else {
                input.style.borderColor = '#d1d5db';
            }
        });
        
        if (missingTime) {
            alert('<?=t("Please enter time information for all questions.")?>'); 
            return;
        }
        
        console.log('Current global success rate:', globalSuccessRate);
        
        // DIRECT APPROACH: Remove the existing success_rate input and create a new one
        const form = document.getElementById('audit-form');
        
        // Remove any existing success_rate inputs to avoid duplicates
        const existingInputs = form.querySelectorAll('input[name="success_rate"]');
        existingInputs.forEach(input => input.remove());
        
        // Create a brand new input with the global value
        const newInput = document.createElement('input');
        newInput.type = 'hidden';
        newInput.name = 'success_rate';
        newInput.value = globalSuccessRate;
        form.appendChild(newInput);
        
        console.log('Added new success_rate input with value:', globalSuccessRate);
        
        // Submit the form
        form.submit();
    }
    
    // Function to toggle between edit and report view
    function toggleReportView() {
        isReportView = !isReportView;
        
        const reportViewBtn = document.getElementById('report-view-btn');
        const editViewBtn = document.getElementById('edit-view-btn');
        const saveAllBtn = document.getElementById('save-all-btn');
        
        if (isReportView) {
            document.querySelectorAll('input, textarea, select').forEach(el => {
                el.setAttribute('disabled', 'disabled');
            });
            reportViewBtn.style.display = 'none';
            editViewBtn.style.display = 'inline-block';
            saveAllBtn.style.display = 'none';
        } else {
            document.querySelectorAll('input, textarea, select').forEach(el => {
                el.removeAttribute('disabled');
            });
            reportViewBtn.style.display = 'inline-block';
            editViewBtn.style.display = 'none';
            saveAllBtn.style.display = 'inline-block';
        }
    }
    
    // Open nonconformity selection modal
    function openNonconformityModal(questionId) {
        currentQuestionId = questionId;
        selectedNonconformityIds = [];
        
        // Clear previous selections
        document.querySelectorAll('.nonconformity-item').forEach(item => {
            item.classList.remove('selected');
        });
        
        // Mark already selected nonconformities
        const hiddenInput = document.getElementById('nonconformity-ids-' + questionId);
        if (hiddenInput && hiddenInput.value) {
            const ids = hiddenInput.value.split(',').map(id => parseInt(id));
            ids.forEach(id => {
                const item = document.querySelector(`.nonconformity-item[data-id="${id}"]`);
                if (item) {
                    item.classList.add('selected');
                    selectedNonconformityIds.push(id);
                }
            });
        }
        
        // Show the modal
        document.getElementById('nonconformity-modal').style.display = 'flex';
    }
    
    // Close nonconformity selection modal
    function closeNonconformityModal() {
        document.getElementById('nonconformity-modal').style.display = 'none';
        currentQuestionId = null;
        selectedNonconformityIds = [];
    }
    
    // Toggle selection of a nonconformity item
    function toggleNonconformitySelection(item) {
        const id = parseInt(item.getAttribute('data-id'));
        item.classList.toggle('selected');
        
        if (item.classList.contains('selected')) {
            // Add to selected ids if not already there
            if (!selectedNonconformityIds.includes(id)) {
                selectedNonconformityIds.push(id);
            }
        } else {
            // Remove from selected ids
            selectedNonconformityIds = selectedNonconformityIds.filter(selectedId => selectedId !== id);
        }
    }
    
    // Select nonconformities and update the form
    function selectNonconformities() {
        if (!currentQuestionId) {
            closeNonconformityModal();
            return;
        }
        
        // Update the hidden input with selected IDs
        const hiddenInput = document.getElementById('nonconformity-ids-' + currentQuestionId);
        if (hiddenInput) {
            hiddenInput.value = selectedNonconformityIds.join(',');
            
            // Ask if definition and suggestion should be added to findings
            if (selectedNonconformityIds.length > 0) {
                const shouldAddToFields = confirm('Tanım ve öneri otomatik olarak ilgili alanlara eklensin mi?');
                
                if (shouldAddToFields) {
                    // Get the findings field for this question
                    const findingsField = document.querySelector(`textarea[name="findings[${currentQuestionId}]"]`);
                    
                    if (findingsField) {
                        // First, find the highest priority among all selected nonconformities
                        let highestPriority = 0;
                        
                        // Collect all nonconformity items first
                        const nonconformityItems = [];
                        selectedNonconformityIds.forEach(id => {
                            const nonconformityItem = findNonconformityById(id);
                            if (nonconformityItem) {
                                nonconformityItems.push(nonconformityItem);
                                // Update highest priority if this one is higher
                                if (nonconformityItem.priority && parseInt(nonconformityItem.priority) > highestPriority) {
                                    highestPriority = parseInt(nonconformityItem.priority);
                                }
                            }
                        });
                        
                        // Now process each nonconformity item
                        nonconformityItems.forEach(nonconformityItem => {
                            // Add definition to findings if available
                            if (nonconformityItem.definition) {
                                const currentFindings = findingsField.value.trim();
                                findingsField.value = currentFindings ? 
                                    currentFindings + '\n' + nonconformityItem.definition : 
                                    nonconformityItem.definition;
                            }
                        });
                        
                        // Set time field based on the highest priority
                        const timeField = document.querySelector(`input[name="timestamps[${currentQuestionId}]"]`);
                        if (timeField) {
                            let timeText = '-';
                            
                            // Map highest priority to time text
                            switch(highestPriority) {
                                case 1: timeText = '1 ay içinde'; break;
                                case 2: timeText = '15 gün içinde'; break;
                                case 3: timeText = '1 hafta içinde'; break;
                                case 4: timeText = 'Bir kaç gün içinde'; break;
                                case 5: timeText = 'Hemen'; break;
                                default: timeText = '-';
                            }
                            
                            // Force update the time field value
                            timeField.value = timeText;
                            
                            // Trigger a change event to ensure any event listeners are notified
                            const event = new Event('change', { bubbles: true });
                            timeField.dispatchEvent(event);
                        }
                        
                        // Mark form as having unsaved changes
                        formHasUnsavedChanges = true;
                    }
                }
                
                // Update the display without submitting the form
                updateNonconformityDisplay(currentQuestionId, selectedNonconformityIds.join(','));
            }
            
            hideNonconformityModal();
        }
    }
    
    // Remove a nonconformity from a question
    function removeNonconformity(questionId, nonconformityId) {
        const hiddenInput = document.getElementById('nonconformity-ids-' + questionId);
        if (hiddenInput) {
            const ids = hiddenInput.value.split(',').map(id => parseInt(id));
            const updatedIds = ids.filter(id => id !== nonconformityId);
            hiddenInput.value = updatedIds.join(',');
            
            // Update the display without refreshing the page
            updateNonconformityDisplay(questionId, updatedIds.join(','));
        }
    }
    
    // Tooltip fonksiyonları
    function showTooltip(element, id) {
        // Önce tooltip'i bulalım
        const tooltip = element.querySelector('.nc-tooltip');
        
        // Eğer tooltip bulunamazsa, hiçbir şey yapma
        if (!tooltip) return;
        
        // Tooltip'i görünür yap
        tooltip.style.display = 'block';
        
        // Tooltip'i sol tarafta, ortalanmış şekilde göster
        tooltip.style.top = '50%';
        tooltip.style.bottom = 'auto';
        tooltip.style.left = 'auto';
        tooltip.style.right = '100%';
        tooltip.style.transform = 'translateY(-50%)';
        tooltip.style.marginRight = '10px';
    }
    
    function hideTooltip(element) {
        // Tooltip'i bul ve gizle
        const tooltip = element.querySelector('.nc-tooltip');
        if (tooltip) {
            tooltip.style.display = 'none';
        }
    }
    
    // Custom modal functionality with unique class names
    // Variable to track if form has unsaved changes
    let formHasUnsavedChanges = false;
    
        function toggleQuestionSection(toggleIcon) {
        const headerRow = toggleIcon.closest('.header-row');
        const isCollapsed = toggleIcon.classList.toggle('collapsed');
        
        // Find all question rows until the next header-row
        let currentRow = headerRow.nextElementSibling;
        while (currentRow && !currentRow.classList.contains('header-row')) {
            if (currentRow.classList.contains('question-row')) {
                currentRow.classList.toggle('collapsed', isCollapsed);
            }
            currentRow = currentRow.nextElementSibling;
        }
    }
    
    // Calculate row total (weight * score)
    function updateRowTotal(questionId) {
        const weightInput = document.querySelector(`input[name="weights[${questionId}]"]`);
        const scoreSelect = document.querySelector(`select[name="scores[${questionId}]"]`);
        const totalCell = document.querySelector(`input[name="weights[${questionId}]"]`).closest('tr').querySelector('.total-cell');
        
        if (weightInput && scoreSelect && totalCell) {
            const weight = parseInt(weightInput.value) || 0;
            const score = parseInt(scoreSelect.value) || 0;
            const total = weight * score;
            
            totalCell.textContent = total;
        }
    }
    
    // Calculate all totals (max point, total point, success rate) using 5x5 risk matrix
    function calculateTotals() {
        let totalRisk = 0;
        let totalWeight = 0;
        let questionCount = 0;
        
        // Get all weights and scores
        const weights = document.querySelectorAll('input[name^="weights"]');
        const scores = document.querySelectorAll('select[name^="scores"]');
        
        // Calculate total weight and total risk points
        for (let i = 0; i < weights.length; i++) {
            const weight = parseInt(weights[i].value) || 0;
            const score = parseInt(scores[i].value) || 0;
            
            if (weight > 0) { // Sadece ağırlığı olan soruları sayalım
                totalWeight += weight;
                totalRisk += weight * score;
                questionCount++;
            }
        }
        
        // Minimum ve maksimum risk hesaplama
        // Minimum risk: Tüm sorular için en düşük puan (1) alındığında
        const minRisk = totalWeight * 1;
        
        // Maksimum risk: Tüm sorular için en yüksek puan (5) alındığında
        const maxRisk = totalWeight * 5;
        
        // Başarı yüzdesi hesaplama (5x5 risk matrisine göre)
        // Minimum risk = %100 başarı, Maksimum risk = %0 başarı
        let successRate = 100;
        
        if (maxRisk > minRisk) {
            // Doğrusal dönüşüm formülü
            successRate = Math.round(100 - ((totalRisk - minRisk) / (maxRisk - minRisk)) * 100);
            
            // Başarı oranını 0-100 aralığında sınırla
            successRate = Math.max(0, Math.min(100, successRate));
        }
        
        // Konsola detaylı bilgileri yazdır (debug için)
        console.log('Risk Hesaplama Detayları:');
        console.log('Toplam Ağırlık:', totalWeight);
        console.log('Toplam Risk Puanı:', totalRisk);
        console.log('Minimum Risk:', minRisk);
        console.log('Maksimum Risk:', maxRisk);
        console.log('Başarı Yüzdesi:', successRate);
        
        // UI'ı güncelle
        document.getElementById('total-weight').textContent = totalWeight;
        document.getElementById('max-point').textContent = maxRisk;
        document.getElementById('total-point').textContent = totalRisk;
        document.getElementById('success-percentage').textContent = successRate + '%';
        document.getElementById('success-bar-inner').style.width = successRate + '%';
        document.getElementById('success-rate-input').value = successRate;
    }

document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, initializing calculations...');
        
        // Variable to track unsaved changes
        window.formHasUnsavedChanges = false;
        
        // Log the questions data structure for debugging
        console.log('Questions data:', <?php echo json_encode($questions); ?>);
        
        // Ensure all timestamps are properly displayed
        const questionsData = <?php echo json_encode($questions); ?>;
        console.log('Raw questions data:', questionsData);
        
        // Veritabanından gelen success rate değerini göster
        const dbSuccessRate = <?php echo (int)$auditItem['result']; ?>;
        console.log('Database success rate:', dbSuccessRate);
        
        // Eğer veritabanında değer varsa onu kullan, yoksa %100 göster
        if (dbSuccessRate > 0) {
            // Veritabanındaki değeri kullan
            document.getElementById('success-rate-input').value = dbSuccessRate;
            document.getElementById('success-percentage').textContent = dbSuccessRate + '%';
            document.getElementById('success-bar-inner').style.width = dbSuccessRate + '%';
        } else {
            // Veritabanında değer yoksa %100 göster
            document.getElementById('success-rate-input').value = 100;
            document.getElementById('success-percentage').textContent = '100%';
            document.getElementById('success-bar-inner').style.width = '100%';
        }
        
        // Otomatik hesaplama yapmayı kaldırıyoruz
        // calculateTotals() fonksiyonu sadece kullanıcı değer değiştirdiğinde çalışacak
        
        // Function to fill timestamp fields
        function fillTimestampFields() {
            // Get all timestamp input fields
            const timestampInputs = document.querySelectorAll('input[name^="timestamps"]');
            console.log('Found timestamp inputs:', timestampInputs.length);
            
            // For each input field, try to find its corresponding timestamp in the questions data
            timestampInputs.forEach(input => {
                const questionId = input.id.replace('timestamp-', '');
                console.log('Processing input for question ID:', questionId);
                
                // Find the timestamp in the questions data
                let timestamp = findTimestampForQuestion(questionId, questionsData);
                
                if (timestamp) {
                    console.log('Found timestamp for question ' + questionId + ':', timestamp);
                    input.value = timestamp;
                } else {
                    console.log('No timestamp found for question ' + questionId);
                }
            });
        }
        
        // Function to find the timestamp for a specific question
        function findTimestampForQuestion(questionId, data) {
            // If data is a string, parse it
            const parsedData = typeof data === 'string' ? JSON.parse(data) : data;
            
            // Check if we have the expected structure with headers and questions arrays
            if (parsedData && parsedData.questions) {
                // Search in the questions array
                for (const question of parsedData.questions) {
                    if (question.id == questionId) {
                        return question.timestamp || '';
                    }
                }
            } else if (Array.isArray(parsedData)) {
                // Search in an array of questions
                for (const question of parsedData) {
                    if (question.id == questionId) {
                        return question.timestamp || '';
                    }
                }
            } else if (typeof parsedData === 'object') {
                // Search in an object of questions
                for (const key in parsedData) {
                    const question = parsedData[key];
                    if (question && question.id == questionId) {
                        return question.timestamp || '';
                    }
                }
            }
            
            return '';
        }
        
        // Call the function to fill timestamp fields
        fillTimestampFields();
        
        // First, ensure all scores are properly read from the select elements
        document.querySelectorAll('select[name^="scores"]').forEach(select => {
            const questionId = select.name.match(/\d+/)[0];
            updateRowTotal(questionId);
        });
        
        // Calculate total weight and all related metrics immediately
        const results = calculateTotalWeight();
        console.log('Initial calculations with 1-5 score range:', results);
        
        // Make sure the success rate is visible in the UI
        document.getElementById('success-percentage').textContent = results.successRate + '%';
        document.getElementById('success-bar-inner').style.width = results.successRate + '%';
        
        // Make the success rate visible in the UI
        const successPercentage = document.getElementById('success-percentage');
        const successBarInner = document.getElementById('success-bar-inner');
        if (successPercentage && successBarInner) {
            // Calculate success rate based on current scores
            let maxPoint = 0;
            let totalPoint = 0;
            let totalWeight = 0;
            
            // Get all weights and scores
            const weights = document.querySelectorAll('input[name^="weights"]');
            const scores = document.querySelectorAll('select[name^="scores"]');
            
            // Calculate total weight and total points
            for (let i = 0; i < weights.length; i++) {
                const weight = parseInt(weights[i].value) || 0;
                const score = parseInt(scores[i].value) || 0;
                
                totalWeight += weight;
                totalPoint += weight * score;
            }
            
            // Calculate max point (total weight * 5)
            maxPoint = totalWeight * 5;
            
            // Calculate success rate using the formula
            let successRate = 100;
            if (maxPoint > 0) {
                successRate = Math.round(100 - ((totalPoint / maxPoint) * 100));
            }
            
            // Update the UI
            successPercentage.textContent = successRate + '%';
            successBarInner.style.width = successRate + '%';
            document.getElementById('success-rate-input').value = successRate;
            document.getElementById('total-weight').textContent = totalWeight;
            document.getElementById('max-point').textContent = maxPoint;
            document.getElementById('total-point').textContent = totalPoint;
        }
        
        // Add event listeners to score selects for recalculation
        document.querySelectorAll('select[name^="scores"]').forEach(select => {
            select.addEventListener('change', function() {
                // Update the total for this row
                const questionId = this.name.match(/\d+/)[0];
                updateRowTotal(questionId);
                
                // Recalculate all totals
                calculateTotals();
                
                // Mark form as having unsaved changes
                window.formHasUnsavedChanges = true;
            });
        });
        
        // Add change event listeners to all input fields and textareas
        document.querySelectorAll('input[type="text"], textarea').forEach(element => {
            element.addEventListener('input', function() {
                window.formHasUnsavedChanges = true;
            });
        });
        
        // Specifically add event listeners to time inputs
        document.querySelectorAll('input[name^="timestamps"]').forEach(element => {
            element.addEventListener('input', function() {
                window.formHasUnsavedChanges = true;
                // Make sure this element has the time-input class
                if (!element.classList.contains('time-input')) {
                    element.classList.add('time-input');
                }
            });
        });
        
        // Add form submission handler
        const auditForm = document.getElementById('audit-form');
        if (auditForm) {
            auditForm.addEventListener('submit', function(e) {
                console.log('Form is being submitted...');
                
                // Form gönderilmeden önce success_rate değerini güncelle
                const successRateInput = document.getElementById('success-rate-input');
                const successPercentage = document.getElementById('success-percentage');
                
                // Eğer success rate gösteriliyorsa, o değeri al
                if (successPercentage) {
                    const successRateValue = parseInt(successPercentage.textContent);
                    if (!isNaN(successRateValue)) {
                        successRateInput.value = successRateValue;
                    } else {
                        successRateInput.value = 100; // Varsayılan değer
                    }
                } else {
                    successRateInput.value = 100; // Varsayılan değer
                }
                
                console.log('Success rate being submitted:', successRateInput.value);
                
                // Reset the unsaved changes flag when submitting the form
                window.formHasUnsavedChanges = false;
                
                // Log all form data to ensure it's being submitted
                const formData = new FormData(this);
                console.log('Form data being submitted:');
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                
                // Ensure all textareas and inputs are properly included in the form submission
                document.querySelectorAll('textarea, input[type="text"], select').forEach(function(element) {
                    if (element.name) {
                        console.log('Checking element: ' + element.name + ' with value: ' + element.value);
                    }
                });
            });
        }
        
        // Add click handler to the save button to prevent the warning
        const saveButton = document.querySelector('button[onclick="saveAllAssessments()"]');
        if (saveButton) {
            saveButton.addEventListener('click', function() {
                // Disable the warning when clicking the save button
                window.formHasUnsavedChanges = false;
            });
        }
        
        // Add beforeunload event to show confirmation dialog when leaving the page
        window.addEventListener('beforeunload', function(e) {
            if (window.formHasUnsavedChanges) {
                // Standard message (browsers will show their own standard message)
                const confirmationMessage = '<?=t("You have unsaved changes. Are you sure you want to leave?")?>'; 
                e.returnValue = confirmationMessage; // Standard for most browsers
                return confirmationMessage; // For some older browsers
            }
        });
        
        // Test butonu kaldırıldı
        
        // Add custom styles for nonconformity items
        const style = document.createElement('style');
        style.textContent = `
            .nc-item {
                transition: all 0.2s ease;
            }
            .nc-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .nc-item.nc-selected {
                border: 2px solid #4a86e8 !important;
                background-color: #e8f0fe;
            }
        `;
        document.head.appendChild(style);
        
        // Function to show the modal
        function showNcModal() {
            document.getElementById('nc-modal-container').style.display = 'block';
            document.getElementById('nc-modal-overlay').style.display = 'block';
        }
        
        // Function to hide the modal
        function hideNcModal() {
            document.getElementById('nc-modal-container').style.display = 'none';
            document.getElementById('nc-modal-overlay').style.display = 'none';
        }
        
        // Open modal and show nonconformities for a question
        window.openNonconformityModal = function(questionId) {
            // Store current question ID
            document.getElementById('nc-current-question').value = questionId;
            
            // Clear previous selections
            document.querySelectorAll('.nc-item').forEach(function(item) {
                item.classList.remove('nc-selected');
            });
            
            // Get previously selected nonconformities
            const hiddenInput = document.getElementById('nonconformity-ids-' + questionId);
            let selectedIds = [];
            
            if (hiddenInput && hiddenInput.value) {
                selectedIds = hiddenInput.value.split(',').filter(id => id);
                
                // Mark selected items
                selectedIds.forEach(function(id) {
                    const item = document.querySelector('.nc-item[data-id="' + id + '"]');
                    if (item) {
                        item.classList.add('nc-selected');
                    }
                });
            }
            
            // Store selected IDs
            document.getElementById('nc-selected-ids').value = selectedIds.join(',');
            
            // Show the modal
            showNcModal();
        };
        
        // Handle clicking on nonconformity items
        document.querySelectorAll('.nc-item').forEach(function(item) {
            item.addEventListener('click', function() {
                this.classList.toggle('nc-selected');
                
                // Update selected IDs
                const selectedItems = document.querySelectorAll('.nc-item.nc-selected');
                const selectedIds = Array.from(selectedItems).map(function(item) {
                    return item.getAttribute('data-id');
                });
                
                document.getElementById('nc-selected-ids').value = selectedIds.join(',');
            });
        });
        
        // Handle close button click
        document.getElementById('nc-modal-close').addEventListener('click', function() {
            hideNcModal();
        });
        
        // Handle cancel button click
        document.getElementById('nc-cancel-btn').addEventListener('click', function() {
            hideNcModal();
        });
        
        // Handle select button click
        document.getElementById('nc-select-btn').addEventListener('click', function() {
            const questionId = document.getElementById('nc-current-question').value;
            const selectedIds = document.getElementById('nc-selected-ids').value;
            
            if (questionId) {
                const hiddenInput = document.getElementById('nonconformity-ids-' + questionId);
                if (hiddenInput) {
                    // Check if the value is changing
                    if (hiddenInput.value !== selectedIds) {
                        // Mark form as having unsaved changes since nonconformities were modified
                        window.formHasUnsavedChanges = true;
                        hiddenInput.value = selectedIds;
                    }
                    
                    // Ask if definition and suggestion should be added to findings
                    if (selectedIds) {
                        const idArray = selectedIds.split(',').filter(id => id);
                        
                        if (idArray.length > 0) {
                            const shouldAddToFields = confirm('Tanım ve zaman bilgisi otomatik olarak ilgili alanlara eklensin mi?');
                            
                            if (shouldAddToFields) {
                                // Get the findings field for this question
                                const findingsField = document.querySelector(`textarea[name="findings[${questionId}]"]`);
                                
                                if (findingsField) {
                                    // First, find the highest priority among all selected nonconformities
                                    let highestPriority = 0;
                                    
                                    // Collect all nonconformity items first
                                    const nonconformityItems = [];
                                    idArray.forEach(id => {
                                        const nonconformityItem = findNonconformityById(id);
                                        if (nonconformityItem) {
                                            nonconformityItems.push(nonconformityItem);
                                            // Update highest priority if this one is higher
                                            if (nonconformityItem.priority && parseInt(nonconformityItem.priority) > highestPriority) {
                                                highestPriority = parseInt(nonconformityItem.priority);
                                            }
                                        }
                                    });
                                    
                                    // Now process each nonconformity item
                                    nonconformityItems.forEach(nonconformityItem => {
                                        // Add definition to findings if available
                                        if (nonconformityItem.definition) {
                                            const currentFindings = findingsField.value.trim();
                                            findingsField.value = currentFindings ? 
                                                currentFindings + '\n' + nonconformityItem.definition : 
                                                nonconformityItem.definition;
                                        }
                                        

                                    });
                                    
                                    // Set time field based on the highest priority
                                    // Always update the time field regardless of whether it's empty
                                    const timeField = document.querySelector(`input[name="timestamps[${questionId}]"]`);
                                    if (timeField) {
                                        let timeText = '-';
                                        
                                        // Map highest priority to time text - using the priority values from the database
                                        // As seen in the image, priority values are: 1, 4, etc.
                                        switch(highestPriority) {
                                            case 1: timeText = '1 ay içinde'; break;
                                            case 2: timeText = '15 gün içinde'; break;
                                            case 3: timeText = '1 hafta içinde'; break;
                                            case 4: timeText = 'Bir kaç gün içinde'; break;
                                            case 5: timeText = 'Hemen'; break;
                                            default: timeText = '-';
                                        }
                                        
                                        // Force update the time field value
                                        timeField.value = timeText;
                                        
                                        // Trigger a change event to ensure any event listeners are notified
                                        const event = new Event('change', { bubbles: true });
                                        timeField.dispatchEvent(event);
                                    }
                                    
                                    // Mark form as having unsaved changes
                                    formHasUnsavedChanges = true;
                                }
                            }
                        }
                    }
                    
                    // Update the display without submitting the form
                    updateNonconformityDisplay(questionId, selectedIds);
                }
            }
            
            hideNcModal();
        });
        
        // Function to update the nonconformity display for a question
        function updateNonconformityDisplay(questionId, selectedIds) {
            // Find the display container for this question
            const displayContainer = document.getElementById('nonconformity-display-' + questionId);
            
            if (!displayContainer) return;
            
            // Clear current display
            displayContainer.innerHTML = '';
            
            // If no IDs selected, show a message
            if (!selectedIds) {
                displayContainer.innerHTML = '<em>No nonconformities selected</em>';
                return;
            }
            
            // Get the IDs array
            const idArray = selectedIds.split(',').filter(id => id);
            
            // Create display for each selected nonconformity
            idArray.forEach(function(id) {
                // Find the nonconformity data
                const nonconformityItem = findNonconformityById(id);
                
                // Create a badge with the nonconformity ID
                const badge = document.createElement('span');
                badge.className = 'nc-badge';
                badge.setAttribute('data-id', id);
                badge.style.cssText = 'display: inline-block; background: #4a86e8; color: white; padding: 2px 6px; border-radius: 4px; margin-right: 5px; margin-bottom: 5px; font-size: 11px; cursor: pointer; position: relative;';
                badge.textContent = 'Nonconformity #' + id + ' / Priority: ' + (nonconformityItem.priority || '0');
                
                // Add tooltip events
                badge.addEventListener('mouseover', function() {
                    showTooltip(this, id);
                });
                badge.addEventListener('mouseout', function() {
                    hideTooltip(this);
                });
                
                // Create tooltip if we have nonconformity data
                if (nonconformityItem) {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'nc-tooltip';
                    tooltip.style.cssText = 'display: none; position: absolute; top: 50%; right: 100%; transform: translateY(-50%); width: 220px; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); padding: 8px; z-index: 9999; margin-right: 10px; text-align: left; max-height: 300px; overflow-y: auto;';
                    
                    // Add image if available
                    if (nonconformityItem.filesf) {
                        const imgDiv = document.createElement('div');
                        imgDiv.style.cssText = 'height: 100px; background-image: url("' + nonconformityItem.filesf + '"); background-size: cover; background-position: center; margin-bottom: 5px; border-radius: 3px;';
                        tooltip.appendChild(imgDiv);
                    }
                    
                    // Add definition if available
                    if (nonconformityItem.definition) {
                        const defDiv = document.createElement('div');
                        defDiv.style.cssText = 'font-size: 11px; color: #333; margin-bottom: 5px;';
                        defDiv.textContent = nonconformityItem.definition;
                        tooltip.appendChild(defDiv);
                    }
                    
                    // Add suggestion if available
                    if (nonconformityItem.suggestion) {
                        const suggDiv = document.createElement('div');
                        suggDiv.style.cssText = 'font-size: 10px; color: #3a87ad; background-color: #d9edf7; padding: 3px; border-radius: 2px;';
                        suggDiv.innerHTML = '<strong>Suggestion:</strong> ' + nonconformityItem.suggestion;
                        tooltip.appendChild(suggDiv);
                    }
                    
                    // Add department info if available
                    if (nonconformityItem.department_name) {
                        const deptDiv = document.createElement('div');
                        deptDiv.style.cssText = 'font-size: 10px; color: #777; margin-top: 5px;';
                        let deptText = '<strong>Dept:</strong> ' + nonconformityItem.department_name;
                        if (nonconformityItem.subdepartment_name) {
                            deptText += ' / ' + nonconformityItem.subdepartment_name;
                        }
                        deptDiv.innerHTML = deptText;
                        tooltip.appendChild(deptDiv);
                    }
                    
                    badge.appendChild(tooltip);
                }
                
                // Add the badge to the display container
                displayContainer.appendChild(badge);
            });
        }
        
        // Helper function to find nonconformity by ID
        function findNonconformityById(id) {
            // Try to find the nonconformity in the DOM first
            const item = document.querySelector('.nc-item[data-id="' + id + '"]');
            if (item) {
                // Extract data from the item
                const imgDiv = item.querySelector('.nc-image');
                const defDiv = item.querySelector('.nc-definition');
                const suggDiv = item.querySelector('.nc-suggestion');
                const deptDiv = item.querySelector('.nc-department');
                
                // Get priority from the data-priority attribute
                const priorityAttr = item.getAttribute('data-priority');
                
                return {
                    id: id,
                    filesf: imgDiv ? imgDiv.style.backgroundImage.replace(/url\(['"](.*)['"]\)/, '$1') : null,
                    definition: defDiv ? defDiv.textContent.trim() : null,
                    suggestion: suggDiv ? suggDiv.textContent.replace('Suggestion:', '').trim() : null,
                    department_name: deptDiv ? deptDiv.textContent.replace(/Dept:([^\/]*).*/, '$1').trim() : null,
                    subdepartment_name: deptDiv && deptDiv.textContent.includes('/') ? deptDiv.textContent.replace(/.*\/(.*)/, '$1').trim() : null,
                    priority: priorityAttr ? parseInt(priorityAttr) : 0
                };
            }
            
            // If not found, return a basic object with just the ID
            return { id: id };
        }
        
        // Close modal when clicking on overlay
        document.getElementById('nc-modal-overlay').addEventListener('click', function() {
            hideNcModal();
        });
        
        // Calculate total weight when page loads
        calculateTotalWeight();
        
        // Initialize tooltips for existing nonconformity badges
        initializeExistingNonconformityTooltips();
        
        // Standardize all nonconformity badge formats
        standardizeNonconformityBadges();
    });

// Helper function to find nonconformity by ID
function findNonconformityById(id) {
    // Try to find the nonconformity in the DOM first
    const item = document.querySelector('.nc-item[data-id="' + id + '"]');
    if (item) {
        // Extract data from the item
        const imgDiv = item.querySelector('.nc-image');
        const defDiv = item.querySelector('.nc-definition');
        const suggDiv = item.querySelector('.nc-suggestion');
        const deptDiv = item.querySelector('.nc-department');
        
        // Get priority from the data-priority attribute
        const priorityAttr = item.getAttribute('data-priority');
        
        return {
            id: id,
            filesf: imgDiv ? imgDiv.style.backgroundImage.replace(/url\(['"](.*)['"\)]/, '$1') : null,
            definition: defDiv ? defDiv.textContent.trim() : null,
            suggestion: suggDiv ? suggDiv.textContent.replace('Suggestion:', '').trim() : null,
            department_name: deptDiv ? deptDiv.textContent.replace(/Dept:([^\/]*).*/, '$1').trim() : null,
            subdepartment_name: deptDiv && deptDiv.textContent.includes('/') ? deptDiv.textContent.replace(/.*\/(.*)/, '$1').trim() : null,
            priority: priorityAttr ? parseInt(priorityAttr) : 0
        };
    }
    
    // If not found, return a basic object with just the ID
    return { id: id };
}

// Function to show tooltip
function showTooltip(element, id) {
    const tooltip = element.querySelector('.nc-tooltip');
    if (tooltip) {
        tooltip.style.display = 'block';
    } else {
        // If tooltip doesn't exist yet, create it
        // First try to find the nonconformity data from the PHP-generated array
        let nonconformityItem = null;
        
        // This array contains all nonconformities from the database
        const nonconformitiesData = <?php echo json_encode($nonconformities); ?>;
        
        // Find the nonconformity with the matching ID
        for (let i = 0; i < nonconformitiesData.length; i++) {
            if (nonconformitiesData[i].id == id) {
                nonconformityItem = nonconformitiesData[i];
                break;
            }
        }
        
        // If not found in the array, try to find it in the DOM
        if (!nonconformityItem) {
            nonconformityItem = findNonconformityById(id);
        }
        
        if (nonconformityItem) {
            const tooltip = document.createElement('div');
            tooltip.className = 'nc-tooltip';
            tooltip.style.cssText = 'position: absolute; top: 50%; right: 100%; transform: translateY(-50%); width: 220px; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); padding: 8px; z-index: 9999; margin-right: 10px; text-align: left; max-height: 300px; overflow-y: auto;';
            
            // Add image if available
            if (nonconformityItem.filesf) {
                const imgDiv = document.createElement('div');
                // Make sure the URL is properly formatted
                let imageUrl = nonconformityItem.filesf;
                // If the URL doesn't start with http or /, add a / to make it relative to the root
                if (imageUrl && typeof imageUrl === 'string' && !imageUrl.startsWith('http') && !imageUrl.startsWith('/')) {
                    imageUrl = '/' + imageUrl;
                }
                imgDiv.style.cssText = 'height: 100px; background-image: url("' + imageUrl + '"); background-size: cover; background-position: center; margin-bottom: 5px; border-radius: 3px;';
                tooltip.appendChild(imgDiv);
                
                // Log for debugging
                console.log('Image URL:', imageUrl);
            } else {
                console.log('No image found for nonconformity ID:', id);
            }
            
            // Add definition if available
            if (nonconformityItem.definition) {
                const defDiv = document.createElement('div');
                defDiv.style.cssText = 'font-size: 11px; color: #333; margin-bottom: 5px;';
                defDiv.textContent = nonconformityItem.definition;
                tooltip.appendChild(defDiv);
            }
            
            // Add suggestion if available
            if (nonconformityItem.suggestion) {
                const suggDiv = document.createElement('div');
                suggDiv.style.cssText = 'font-size: 10px; color: #3a87ad; background-color: #d9edf7; padding: 3px; border-radius: 2px;';
                suggDiv.innerHTML = '<strong>Suggestion:</strong> ' + nonconformityItem.suggestion;
                tooltip.appendChild(suggDiv);
            }
            
            // Add department info if available
            if (nonconformityItem.department_name) {
                const deptDiv = document.createElement('div');
                deptDiv.style.cssText = 'font-size: 10px; color: #777; margin-top: 5px;';
                let deptText = '<strong>Dept:</strong> ' + nonconformityItem.department_name;
                if (nonconformityItem.subdepartment_name) {
                    deptText += ' / ' + nonconformityItem.subdepartment_name;
                }
                deptDiv.innerHTML = deptText;
                tooltip.appendChild(deptDiv);
            }
            
            element.appendChild(tooltip);
            tooltip.style.display = 'block';
        }
    }
}

// Function to hide tooltip
function hideTooltip(element) {
    const tooltip = element.querySelector('.nc-tooltip');
    if (tooltip) {
        tooltip.style.display = 'none';
    }
}

// Function to initialize tooltips for existing nonconformity badges
function initializeExistingNonconformityTooltips() {
    // Find all existing nonconformity badges
    document.querySelectorAll('.nc-badge').forEach(function(badge) {
        const id = badge.getAttribute('data-id');
        if (id) {
            // Add tooltip events
            badge.addEventListener('mouseover', function() {
                showTooltip(this, id);
            });
            badge.addEventListener('mouseout', function() {
                hideTooltip(this);
            });
        }
    });
}

// Function to standardize all nonconformity badge formats
function standardizeNonconformityBadges() {
    // Find all nonconformity badges
    document.querySelectorAll('.nc-badge').forEach(function(badge) {
        const id = badge.getAttribute('data-id');
        if (id) {
            // Update all badges to show only the ID number
            badge.textContent = '#' + id;
        }
    });
}
</script>
