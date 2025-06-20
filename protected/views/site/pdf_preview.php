<?php
/* @var $this SiteController */
/* @var $workorderId string */
/* @var $itemId string */
/* @var $pdfUrl string */

$this->pageTitle = Yii::app()->name . ' - PDF Preview';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?=t('PDF Report Preview')?></title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <?php
    // Use Google Docs Viewer to display the PDF
    $googleViewerUrl = 'https://docs.google.com/viewer?url=' . urlencode($pdfUrl) . '&embedded=true';
    ?>
    <iframe src="<?php echo $googleViewerUrl; ?>"></iframe>
</body>
</html>
