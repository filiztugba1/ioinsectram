<?php
/**
 * PDF template for audit item reports
 * This file is used by the downloadaudititemreport action to generate PDF reports
 */

// Create PDF using mPDF with image optimization settings
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 16,
    'margin_bottom' => 16,
    'margin_header' => 9,
    'margin_footer' => 9,
    'setAutoTopMargin' => 'stretch',
    'setAutoBottomMargin' => 'stretch',
    // Image optimization settings
    'img_dpi' => 72,  // Lower DPI for images (default is 96)
    'jpeg_quality' => 70, // Lower quality for JPEG images (0-100)
    'img_debug' => false, // Disable debug for images
]);

// Set document information
$mpdf->SetTitle($auditItem['name'] . ' - Audit Report');
$mpdf->SetAuthor('Denetim Yönetim Sistemi');

// No special configuration needed

// Create header HTML
$headerHtml = '<div style="text-align: center; color: #999; font-style: italic; font-size: 9pt;">
    Bu rapor, Purean Solutions üzerinden otomatik oluşturulmuştur.
</div>';

// Try to get firm image if firm_id is available
$logoUrl = 'https://insectram.io/images/purean_logo.png';
if (isset($auditItem['firm_id']) && !empty($auditItem['firm_id'])) {
    try {
        $firm = Yii::app()->db->createCommand()
            ->select('image')
            ->from('firm')
            ->where('id=:id', array(':id'=>$auditItem['firm_id']))
            ->queryRow();
        
        if ($firm && isset($firm['image']) && !empty($firm['image'])) {
            $firmImageUrl = $firm['image'];
            // Check if URL is already absolute
            if (strpos($firmImageUrl, 'http') !== 0) {
                // Ensure the image URL is properly prefixed with the insectram.io domain
                if (strpos($firmImageUrl, '/') === 0) {
                    // If the image path starts with a slash, remove it
                    $firmImageUrl = ltrim($firmImageUrl, '/');
                }
                $firmImageUrl = 'https://insectram.io/' . $firmImageUrl;
            }
            // Replace the default logo with the firm's logo
            $logoUrl = $firmImageUrl;
        }
    } catch (Exception $e) {
        // If there's an error, just continue with the default logo
    }
}

// Main header with logo and title
$mainHeader = '<div style="text-align: center; margin-bottom: 20px;">
    <img src="' . $logoUrl . '" style="max-height: 80px; max-width: 200px;">
</div>
<div style="text-align: center; border-top: 1px solid #0056b3; border-bottom: 1px solid #0056b3; padding: 10px 0; margin: 10px 0 20px 0;">
    <div style="font-size: 18px; font-weight: bold; font-style: italic;">' . htmlspecialchars($auditItem['name']) . '</div>
</div>';

// Create main content HTML
$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        .logo-container { text-align: center; margin-bottom: 20px; }
        .title-container { text-align: center; border-top: 1px solid #0056b3; border-bottom: 1px solid #0056b3; padding: 10px 0; margin: 10px 0 20px 0; }
        .report-title { font-size: 18px; font-weight: bold; font-style: italic; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 5px; text-align: left; font-size: 9pt; }
        th { background-color: #f2f2f2; font-size: 9pt; }
        .header-table { margin-bottom: 15px; }
        .header-table th { background-color: #f8f8f8; }
        .score-table td { text-align: center; }
        .grade-A-plus { background-color: #4da6ff; }
        .grade-A { background-color: #80c1ff; }
        .grade-B { background-color: #ffeb99; }
        .grade-C { background-color: #ff9966; }
        .grade-D { background-color: #ff6666; }
        .notes { font-size: 8pt; margin-top: 15px; }
        .footer-table { margin-top: 20px; border: none; }
        .footer-table td { border: none; vertical-align: top; }
        .nc-badge { display: inline-block; padding: 2px 4px; margin-right: 3px; margin-bottom: 3px; font-size: 8pt; }
        .nc-img { max-width: 40px; max-height: 40px; margin-right: 3px; vertical-align: middle; }
        h3 { font-size: 11pt; margin-top: 10px; margin-bottom: 5px; }
    </style>
</head>
<body>';

// Add logo and title at the beginning of the document
$html .= '<div class="logo-container" style="text-align: center; margin-bottom: 20px;">
    <img src="' . $logoUrl . '" style="max-height: 80px; max-width: 200px;">
</div>
<div class="title-container">
    <div class="report-title">' . htmlspecialchars($auditItem['name']) . '</div>
</div>';

// Get inspector name from questions JSON if available (selected in fillaudititem.php)
$inspectorName = '';
$reportWriterName = '';
$reportApproverName = '';
$inspectorSignature = '';
$reportWriterSignature = '';
$reportApproverSignature = '';

// Tesis bilgilerini al
$facilityName = t('Tesis Yetkilisi');
$facilitySignatureUrl = '';

// servicereport tablosundan tesis bilgilerini al
try {
    $serviceReport = Yii::app()->db->createCommand()
        ->select('trade_name, client_sign')
        ->from('servicereport')
        ->where('reportno=:reportno', array(':reportno'=>$workorder_id))
        ->queryRow();
    
    if ($serviceReport && isset($serviceReport['trade_name']) && !empty($serviceReport['trade_name'])) {
        $facilityName = $serviceReport['trade_name'];
    }
    
    if ($serviceReport && isset($serviceReport['client_sign']) && !empty($serviceReport['client_sign'])) {
        $facilitySignatureUrl = $serviceReport['client_sign'];
    }
} catch (Exception $e) {
    // Hata durumunda varsayılan değerleri kullan
}

// Parse the questions JSON to get the selected personnel
if (is_string($questions)) {
    $questionsData = json_decode($questions, true);
} else {
    $questionsData = $questions;
}

// Check which JSON structure we have
if (isset($questionsData['meta'])) {
    // Flat array structure with meta data
    $inspectorId = isset($questionsData['meta']['inspector_id']) ? $questionsData['meta']['inspector_id'] : null;
    $reportWriterId = isset($questionsData['meta']['report_writer_id']) ? $questionsData['meta']['report_writer_id'] : null;
    $reportApproverId = isset($questionsData['meta']['report_approver_id']) ? $questionsData['meta']['report_approver_id'] : null;
} else {
    // Nested structure
    $inspectorId = isset($questionsData['inspector_id']) ? $questionsData['inspector_id'] : null;
    $reportWriterId = isset($questionsData['report_writer_id']) ? $questionsData['report_writer_id'] : null;
    $reportApproverId = isset($questionsData['report_approver_id']) ? $questionsData['report_approver_id'] : null;
}

// Get inspector details
if ($inspectorId) {
    try {
        $inspector = Yii::app()->db->createCommand()
            ->select('name, surname, signature_photo')
            ->from('user')
            ->where('id=:id', array(':id'=>$inspectorId))
            ->queryRow();
        
        if ($inspector && isset($inspector['name']) && isset($inspector['surname'])) {
            $inspectorName = $inspector['name'] . ' ' . $inspector['surname'];
            if (!empty($inspector['signature_photo'])) {
                $inspectorSignature = $inspector['signature_photo'];
            }
        }
    } catch (Exception $e) {
        // If there's an error, just continue without the details
    }
}

// Get report writer details
if ($reportWriterId) {
    try {
        $reportWriter = Yii::app()->db->createCommand()
            ->select('name, surname, signature_photo')
            ->from('user')
            ->where('id=:id', array(':id'=>$reportWriterId))
            ->queryRow();
        
        if ($reportWriter && isset($reportWriter['name']) && isset($reportWriter['surname'])) {
            $reportWriterName = $reportWriter['name'] . ' ' . $reportWriter['surname'];
            if (!empty($reportWriter['signature_photo'])) {
                $reportWriterSignature = $reportWriter['signature_photo'];
            }
        }
    } catch (Exception $e) {
        // If there's an error, just continue without the details
    }
}

// Get report approver details
if ($reportApproverId) {
    try {
        $reportApprover = Yii::app()->db->createCommand()
            ->select('name, surname, signature_photo')
            ->from('user')
            ->where('id=:id', array(':id'=>$reportApproverId))
            ->queryRow();
        
        if ($reportApprover && isset($reportApprover['name']) && isset($reportApprover['surname'])) {
            $reportApproverName = $reportApprover['name'] . ' ' . $reportApprover['surname'];
            if (!empty($reportApprover['signature_photo'])) {
                $reportApproverSignature = $reportApprover['signature_photo'];
            }
        }
    } catch (Exception $e) {
        // If there's an error, just continue without the details
    }
}

// Fallback to staffid if no inspector was selected
if (empty($inspectorName) && isset($workorder['staffid']) && !empty($workorder['staffid'])) {
    try {
        $inspector = Yii::app()->db->createCommand()
            ->select('name, surname')
            ->from('user')
            ->where('id=:id', array(':id'=>$workorder['staffid']))
            ->queryRow();
        
        if ($inspector && isset($inspector['name']) && isset($inspector['surname'])) {
            $inspectorName = $inspector['name'] . ' ' . $inspector['surname'];
        }
    } catch (Exception $e) {
        // If there's an error, just continue without the details
    }
}

// Get branch and company information from client table
$branchName = '';
$branchAddress = '';
$companyName = '';

if (isset($workorder['clientid']) && !empty($workorder['clientid'])) {
    try {
        // Get branch information
        $branch = Yii::app()->db->createCommand()
            ->select('name, address, address2, address3, address4, county, town_or_city, parentid')
            ->from('client')
            ->where('id=:id', array(':id'=>$workorder['clientid']))
            ->queryRow();
        
        if ($branch) {
            // Combine branch name and address
            $branchName = isset($branch['name']) ? $branch['name'] : '';
            
            // Combine address fields
            $addressParts = [];
            if (!empty($branch['address'])) $addressParts[] = $branch['address'];
            if (!empty($branch['address2'])) $addressParts[] = $branch['address2'];
            if (!empty($branch['address3'])) $addressParts[] = $branch['address3'];
            if (!empty($branch['address4'])) $addressParts[] = $branch['address4'];
            if (!empty($branch['county'])) $addressParts[] = $branch['county'];
            if (!empty($branch['town_or_city'])) $addressParts[] = $branch['town_or_city'];
            
            $branchAddress = implode(', ', $addressParts);
            
            // Get company information from parentid
            if (isset($branch['parentid']) && !empty($branch['parentid'])) {
                $company = Yii::app()->db->createCommand()
                    ->select('name')
                    ->from('client')
                    ->where('id=:id', array(':id'=>$branch['parentid']))
                    ->queryRow();
                
                if ($company && isset($company['name'])) {
                    $companyName = $company['name'];
                }
            }
        }
    } catch (Exception $e) {
        // If there's an error, just continue without the details
    }
}

// General information table
$html .= '<h3 style="background-color: #4da6ff; color: white; padding: 8px; border-radius: 4px;">' . t('İşletme Genel Bilgileri') . '</h3>
<table class="header-table">
    <tr>
        <th>' . t('İşletme Adı') . '</th>
        <td>' . $companyName . '</td>
        <th>' . t('Denetçi') . '</th>
        <td>' . $inspectorName . '</td>
    </tr>
    <tr>
        <th>' . t('Şube Adı / Adresi') . '</th>
        <td>' . $branchName . ' | ' . $branchAddress . '</td>
        <th>' . t('Form No') . '</th>
        <td>' . sprintf('%08d', $workorder_id) . '</td>
    </tr>
    <tr>
        <th>' . t('Denetim Tarihi') . '</th>
        <td>' . date('d.m.Y', strtotime($workorder['date'])) . '</td>
        <th>' . t('Denetim Saati') . '</th>
        <td>' . (isset($workorder['realstarttime']) && !empty($workorder['realstarttime']) && isset($workorder['realendtime']) && !empty($workorder['realendtime']) ? date('H:i', strtotime($workorder['realstarttime'])) . ' - ' . date('H:i', strtotime($workorder['realendtime'])) : date('H:i', strtotime($workorder['date']))) . '</td>
    </tr>
</table>';

// Operation score table
$html .= '<h3>İşletmenin Operasyon Puanı</h3>
<table class="score-table">
    <tr>
        <th>Denetim Puanı</th>
        <td>' . $successRate . '%</td>
    </tr>
    <tr>
        <th>Başarı Derecesi</th>
        <td class="grade-' . str_replace('+', '-plus', $successGrade) . '">' . $successGrade . '</td>
    </tr>
</table>';

// Questions and answers
$html .= '<h3 style="background-color: #5cb85c; color: white; padding: 8px; border-radius: 4px;">Denetim Soruları ve Bulgular</h3>
<table>
    <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 35%;">Soru</th>
        <th style="width: 8%;">Ağırlık</th>
        <th style="width: 8%;">Puan</th>
        <th style="width: 24%;">Bulgular</th>
        <th style="width: 20%;">Uygunsuzluklar</th>
    </tr>';

// Process questions data
$questionNumber = 1;

// Initialize an array to store all nonconformity IDs
$allNonconformityIds = [];

// Function to get nonconformity HTML and collect nonconformity IDs
function getNonconformityHtml($question, &$allNonconformityIds) {
    $nonconformityHtml = '';
    if (isset($question['nonconformity_ids']) && !empty($question['nonconformity_ids'])) {
        $nonconformityIds = explode(',', $question['nonconformity_ids']);
        foreach ($nonconformityIds as $ncId) {
            if (empty($ncId)) continue;
            
            // Add to the global list of nonconformities if not already there
            if (!in_array($ncId, $allNonconformityIds)) {
                $allNonconformityIds[] = $ncId;
            }
            
            // Try to get the numberid from the database
            $numberid = $ncId; // Default to ID if numberid not found
            try {
                $nonconformity = Yii::app()->db->createCommand()
                    ->select('numberid')
                    ->from('conformity')
                    ->where('id=:id', array(':id'=>$ncId))
                    ->queryRow();
                
                if ($nonconformity && isset($nonconformity['numberid']) && !empty($nonconformity['numberid'])) {
                    $numberid = $nonconformity['numberid'];
                }
            } catch (Exception $e) {
                // If there's an error, just use the ID
            }
            
            // Use a simple style without background color
            $nonconformityHtml .= '<a href="#uygunsuzluk-' . $ncId . '" style="display: inline-block; color: #0056b3; font-weight: bold; padding: 2px 5px; text-decoration: none; margin-right: 3px;">' . $ncId . ' (' . $numberid . ')</a> ';
        }
    }
    return $nonconformityHtml;
}

// Check if questions is a string (JSON) and parse it
if (is_string($questions)) {
    $questions = json_decode($questions, true);
}

// If questions is still a string after json_decode, try decoding again
if (is_string($questions)) {
    $questions = json_decode($questions, true);
}

// Group questions by headers
$topLevelQuestions = [];
$questionsByHeader = [];
$hasQuestions = false;

// Check if we have the expected structure with headers and questions arrays
if (isset($questions['headers']) && isset($questions['questions'])) {
    $hasQuestions = true;
    $headers = $questions['headers'];
    $allQuestions = $questions['questions'];
    
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
            
            // Initialize the header entry if it doesn't exist
            if (!isset($questionsByHeader[$headerId])) {
                $questionsByHeader[$headerId] = [
                    'header' => $headerMap[$headerId]['text'],
                    'questions' => []
                ];
            }
            
            // Add the question to this header
            $questionsByHeader[$headerId]['questions'][$question['id']] = $question;
        } else {
            // This is a top-level question
            $topLevelQuestions[$question['id']] = $question;
        }
    }
} else if (is_array($questions)) {
    // Fallback to the old structure if needed
    $hasQuestions = true;
    foreach ($questions as $questionId => $question) {
        // Skip if not an array (malformed data)
        if (!is_array($question)) continue;
        
        // Check if this is a header or a question
        if (isset($question['is_header']) && $question['is_header']) {
            // This is a header
            $questionsByHeader[$questionId] = [
                'header' => $question['text'],
                'questions' => []
            ];
        } else {
            // This is a question, check if it belongs to a header
            if (isset($question['header_id']) && !empty($question['header_id']) && isset($questionsByHeader[$question['header_id']])) {
                $questionsByHeader[$question['header_id']]['questions'][$questionId] = $question;
            } else {
                // This is a top-level question
                $topLevelQuestions[$questionId] = $question;
            }
        }
    }
}

// First render top-level questions
if (!empty($topLevelQuestions)) {
    $questionNumber = 1;
    foreach ($topLevelQuestions as $questionId => $question) {
        // Get question data based on structure
        if (isset($questions['headers']) && isset($questions['questions'])) {
            // New structure
            $weight = isset($question['weight']) ? (int)$question['weight'] : 0;
            $score = isset($question['score']) ? (int)$question['score'] : 0;
            $findings = isset($question['findings']) ? $question['findings'] : '';
            $text = isset($question['text']) ? $question['text'] : '';
            $timestamp = (isset($question['timestamp']) && $question['timestamp']<>'') ? '<br> Zaman: '.$question['timestamp'] : '';
        } else {
            // Old structure
            $weight = isset($question['weight']) ? (int)$question['weight'] : 0;
            $score = isset($question['score']) ? (int)$question['score'] : 0;
            $findings = isset($question['findings']) ? $question['findings'] : '';
            $text = isset($question['text']) ? $question['text'] : '';
            $timestamp = (isset($question['timestamp']) && $question['timestamp']<>'') ? '<br> Zaman: '.$question['timestamp'] : '';
        }
        
        // Get nonconformity HTML
        $nonconformityHtml = getNonconformityHtml($question, $allNonconformityIds);
        
        $html .= '<tr>
            <td>' . $questionNumber . '</td>
            <td>' . htmlspecialchars($text).$timestamp . '</td>
            <td style="text-align: center;">' . $weight . '</td>
            <td style="text-align: center;">' . $score . '</td>
            <td>' . nl2br(htmlspecialchars($findings)) . '</td>
            <td>' . $nonconformityHtml . '</td>
        </tr>';
        
        $questionNumber++;
    }
}

// Then render questions grouped by headers
$headerCount = 1;
foreach ($questionsByHeader as $headerId => $headerData) {
    // Add header row
    $html .= '<tr>
        <td colspan="7" style="background-color: #e9ecef; font-weight: bold;">' . $headerCount . '. ' . htmlspecialchars($headerData['header']) . ' (' . count($headerData['questions']) . ')</td>
    </tr>';
    $questionNumber = 1;
    // Add questions under this header
    foreach ($headerData['questions'] as $questionId => $question) {
        // Get question data based on structure
        if (isset($questions['headers']) && isset($questions['questions'])) {
            // New structure
            $weight = isset($question['weight']) ? (int)$question['weight'] : 0;
            $score = isset($question['score']) ? (int)$question['score'] : 0;
            $findings = isset($question['findings']) ? $question['findings'] : '';
            $text = isset($question['text']) ? $question['text'] : '';
            $timestamp = (isset($question['timestamp']) && $question['timestamp']<>'') ? '<br> Zaman: '.$question['timestamp'] : '';
        } else {
            // Old structure
            $weight = isset($question['weight']) ? (int)$question['weight'] : 0;
            $score = isset($question['score']) ? (int)$question['score'] : 0;
            $findings = isset($question['findings']) ? $question['findings'] : '';
            $text = isset($question['text']) ? $question['text'] : '';
            $timestamp = (isset($question['timestamp']) && $question['timestamp']<>'') ? '<br> Zaman: '.$question['timestamp'] : '';
        }
        
        // Get nonconformity HTML
        $nonconformityHtml = getNonconformityHtml($question, $allNonconformityIds);
        if ($score=='1' && $findings=='' && $nonconformityHtml=='') {
            $findings = 'Uygun görülmüştür.';
        }
        $html .= '<tr>
            <td>' . $questionNumber . '</td>
            <td>' . htmlspecialchars($text).$timestamp . '</td>
            <td style="text-align: center;">' . $weight . '</td>
            <td style="text-align: center;">' . $score . '</td>
            <td>' . nl2br(htmlspecialchars($findings)) . '</td>
            <td>' . $nonconformityHtml . '</td>
        </tr>';
        
        $questionNumber++;
    }
    
    $headerCount++;
}

$html .= '</table>';

// Calculate the maximum possible points (sum of all weights * 5)
$totalWeight = 0;

// Calculate from top-level questions
foreach ($topLevelQuestions as $questionId => $question) {
    $weight = isset($question['weight']) ? (int)$question['weight'] : 0;
    $totalWeight += $weight;
}

// Calculate from questions grouped by headers
foreach ($questionsByHeader as $headerId => $headerData) {
    foreach ($headerData['questions'] as $questionId => $question) {
        $weight = isset($question['weight']) ? (int)$question['weight'] : 0;
        $totalWeight += $weight;
    }
}

// Calculate maximum points (weight * 5)
$maxPoints = $totalWeight * 5;

// Get checklist name from audit item
$checklistName = isset($auditItem['name']) ? $auditItem['name'] : 'Denetim';

// Notes and important information
$html .= '<div style="page-break-inside: avoid;">
<div class="notes">
    <h3 style="background-color: #f0ad4e; color: white; padding: 8px; border-radius: 4px;">Açıklama ve Önemli Not</h3>
    <table>
        <tr>
            <td>
                <ol>
                    <li>Bu raporun hiçbir bölümü ayrı olarak kullanılamaz.</li>
                    <li>İmzasız raporların geçerliliği yoktur.</li>
                    <li>Raporda yalnızca <strong>denetim tarihi ve zamanındaki</strong> bulgular yer almaktadır.</li>
                    <li>Tarafımızca hazırlanan 3. göz denetim raporları, yasal olarak bağlayıcı
nitelikte olmamakla birlikte, sürecin objektifliğini artırmayı ve
işletme süreçlerinde sürekli iyileştirme sağlamayı amaçlamaktadır.
İşletme içerisinde gelen şikayetlerin değerlendirilmesi ve farklı
süreçlerde destekleyici veri olarak kullanılmasında herhangi bir sakınca
bulunmamaktadır.</li>
                    <li>Bu denetim raporu, risklerin olasılık ve şiddet düzeylerine göre değerlendirilmesini esas alan 5 × 5 Matris Yöntemi kullanılarak hazırlanmıştır. Bu yöntemle, tespit edilen her bir risk; olasılık (1-5) ve şiddet (1-5) puanları ile çarpılarak risk skoru belirlenmiş, elde edilen skora göre riskin önceliği ve alınması gereken aksiyonlar değerlendirilmiştir.</li>
                    <li>Toplam puan ' . $maxPoints . ' birim üzerinden yüzde olarak hesaplanır. Alınabilecek en yüksek puan %100 dür.</li>
                    <li>BAŞARI DERECESİ; Toplam Puan % 0-54 arasında ise D, 55-69 arasında ise C, 70-79 arasında ise B, 80-89 arasında ise A, 90-100 arasında ise A+ harfi ile ifade edilmektedir. Harflerin açıklamaları aşağıdaki gibidir.</li>
                </ol>
            </td>
        </tr>
    </table>
    
    <table style="page-break-inside: avoid;">
        <tr>
            <td style="width: 15%; background-color: #4da6ff; text-align: center;">A+ 90 - 100</td>
            <td>İşletmenin denetim kriterlerine uyum durumu çok iyi düzeydedir.</td>
        </tr>
        <tr>
            <td style="width: 15%; background-color: #80c1ff; text-align: center;">A 80-89</td>
            <td>İşletmenin denetim kriterlerine uyum durumu iyi düzeydedir.</td>
        </tr>
        <tr>
            <td style="width: 15%; background-color: #ffeb99; text-align: center;">B 70-79</td>
            <td>İşletmenin denetim kriterlerine uyum durumu iyi düzeyedir ancak ' . $checklistName . ' güvenliği uygulamalarında iyileştirmesi gereken eksikler mevcutur.</td>
        </tr>
        <tr>
            <td style="width: 15%; background-color: #ff9966; text-align: center;">C 55-69</td>
            <td>İşletmenin denetim kriterlerine uyum durumu orta düzeydedir. ' . $checklistName . ' güvenliği uygulamalarının kritik noktalarında eksiklikler mevcuttur. Alt yapısal olarak işletmede iyileştirilmesi gereken yerler bulunmaktadır.</td>
        </tr>
        <tr>
            <td style="width: 15%; background-color: #ff6666; text-align: center;">D 0-54</td>
            <td>İşletmenin denetim kriterlerine uyum durumu zayıftır. İşletme alt yapısal ve ' . $checklistName . ' uygulamaları açısından gereklilikleri karşılamamaktadır. Acil önlem alınmalıdır.</td>
        </tr>
    </table>
</div>
</div>';

// Footer with approvers
$html .= '<table class="footer-table" style="width: 100%; margin-top: 40px;">
    <tr>
        <td style="width: 33%; text-align: center;">
            <strong>' . t('Raporu Düzenleyen') . '</strong><br>
            ' . (!empty($reportWriterName) ? $reportWriterName : t('Belirtilmemiş')) . '<br>
            ' . (!empty($reportWriterSignature) ? '<img src="data:image/jpeg;base64,' . $reportWriterSignature . '" style="max-width: 150px; max-height: 80px; margin-top: 10px;">' : '') . '
        </td>
        <td style="width: 33%; text-align: center;">
            <strong>' . t('Raporu Onaylayan') . '</strong><br>
            ' . (!empty($reportApproverName) ? $reportApproverName : t('Belirtilmemiş')) . '<br>
            ' . (!empty($reportApproverSignature) ? '<img src="data:image/jpeg;base64,' . $reportApproverSignature . '" style="max-width: 150px; max-height: 80px; margin-top: 10px;">' : '') . '
        </td>
        <td style="width: 33%; text-align: center;">
            <strong>' . t('Tesis') . '</strong><br>
            ' . $facilityName . '<br>
            ' . (!empty($facilitySignatureUrl) ? '<img src="' . $facilitySignatureUrl . '" style="display:none;max-width: 150px; max-height: 80px; margin-top: 10px;">' : '') . '
        </td>
    </tr>
</table>';

// Add nonconformities list section if any nonconformities were found
if (!empty($allNonconformityIds)) {
    // Sort nonconformity IDs numerically
    sort($allNonconformityIds, SORT_NUMERIC);
    
    // Add CSS for repeating table headers
    $mpdf->WriteHTML('<style>
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
    </style>', \Mpdf\HTMLParserMode::HEADER_CSS);
    
    $html .= '<div style="page-break-before: always;"></div>';
    $html .= '<h3 style="margin-top: 20px; font-size: 14px; color: white; background-color: #d9534f; padding: 8px; border-radius: 4px;">' . t('Uygunsuzluklar Listesi') . '</h3>';
    $html .= '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr>
                <th style="width: 15%; background-color: #f2f2f2; padding: 8px; text-align: center;">' . t('Uygunsuzluk ID') . '</th>
                <th style="width: 25%; background-color: #f2f2f2; padding: 8px; text-align: center;">' . t('Uygunsuzluk Numarası') . '</th>
                <th style="width: 20%; background-color: #f2f2f2; padding: 8px; text-align: center;">' . t('Görsel') . '</th>
                <th style="width: 40%; background-color: #f2f2f2; padding: 8px; text-align: left;">' . t('Tanım') . '</th>
            </tr>
        </thead>
        <tbody>';
    
    foreach ($allNonconformityIds as $index => $ncId) {
        $rowColor = ($index % 2 == 0) ? '#ffffff' : '#f9f9f9';
        
        // Get nonconformity details from database
        $nonconformity = null;
        $imageHtml = '';
        $definition = '';
        
        try {
            $nonconformity = Yii::app()->db->createCommand()
                ->select('id, type, definition, priority, filesf, numberid')
                ->from('conformity')
                ->where('id=:id', array(':id'=>$ncId))
                ->queryRow();
                
            if ($nonconformity) {
                $definition = isset($nonconformity['definition']) ? $nonconformity['definition'] : '';
                
                // Get image URL from filesf field if available
                if (!empty($nonconformity['filesf'])) {
                    $originalImageUrl = $nonconformity['filesf'];
                    
                    // Check if URL is already absolute
                    if (strpos($originalImageUrl, 'http') !== 0) {
                        $originalImageUrl = Yii::app()->getBaseUrl(true) . $originalImageUrl;
                    }
                    
                    // Create an optimized version of the image
                    $optimizedImagePath = $this->optimizeImageForPdf($originalImageUrl, $ncId);
                    
                    if ($optimizedImagePath) {
                        // Use the optimized image with 20% larger size
                        $imageHtml = '<img src="' . $optimizedImagePath . '" style="width: auto; max-height: 120px;" alt="' . t('Uygunsuzluk') . ' #' . $ncId . '">';
                    } else {
                        // Fallback to original image with reduced size
                        $imageHtml = '<img src="' . $originalImageUrl . '" style="width: auto; max-height: 120px;" alt="' . t('Uygunsuzluk') . ' #' . $ncId . '">';
                    }
                }
            }
        } catch (Exception $e) {
            // If there's an error, just continue without the details
        }
        
        // Get the numberid if available, otherwise use the ID
        $numberid = isset($nonconformity['numberid']) && !empty($nonconformity['numberid']) ? $nonconformity['numberid'] : $ncId;
        
        // Add an anchor with the matching ID for the links
        $html .= '<a name="uygunsuzluk-' . $ncId . '"></a>';
        $html .= '<tr style="background-color: ' . $rowColor . ';">
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd;">#' . $ncId . '</td>
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd;">' . $numberid . '</td>
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd;">' . $imageHtml . '</td>
            <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . htmlspecialchars($definition) . '</td>
        </tr>';
    }
    
    $html .= '</tbody></table>';
}

// No footer needed here as it's already added above

$html .= '</body></html>';

// Set page numbers in footer
$footerHtml = '<div style="text-align: center; font-size: 9pt; color: #666;">{PAGENO}/{nbpg}</div>';
$mpdf->SetHTMLFooter($footerHtml);

// Write header to PDF
$mpdf->SetHTMLHeader($headerHtml);

// Add the main header with logo and title to the HTML content
$html = $mainHeader . $html;

// Write content to PDF
$mpdf->WriteHTML($html);

// Output PDF
$mpdf->Output($auditItem['name'] . ' - Audit Report.pdf', 'D');
