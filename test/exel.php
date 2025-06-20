<?php function exportExcel($filename='ExportExcel',$columns=array(),$data=array(),$replaceDotCol=array()){
    header('Content-Encoding: UTF-8');
   header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8' );
    header("Content-disposition: attachment; filename=".$filename.".xlsx");
    echo "\xEF\xBB\xBF"; // UTF-8 BOM
     
    $say=count($columns);
     
    echo '<table border="1"><tr>';
    foreach($columns as $v){
        echo '<th style="background-color:#FFA500">'.trim($v).'</th>';
    }
    echo '</tr>';
 
    foreach($data as $val){
        echo '<tr>';
        for($i=0; $i < $say; $i++){
 
            if(in_array($i,$replaceDotCol)){
                echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
            }else{
                echo '<td>'.$val[$i].'</td>';
            }
        }
        echo '</tr>';
    }
}


/* TANIMLAMALAR */

$columns=array();

$data=array();

/*
 $replaceDotCol
 Decimal kolonlardaki noktayı (.) virgüle (,) dönüştürüelecek kolon numarası belirtilmelidir.
 Örneğin; Kolon 4'ün verilerinde nokta değilde virgül görülmesini istiyorsanız
 ilgili kolonun array key numarasını belirtmelisiniz. İlk kolonun key numarası 0'dır.
*/
$replaceDotCol=array(3); 


/* Sütun Başlıkları */
$columns=array(
    'Kolon 1',
    'Kolon 2',
    'Kolon 3',
    'Kolon 4 Decimal'
);


/* Satır Verileri */
$data[]=array(
    'Satır 1 Kolon 1 Verisi',
    'Satır 1 Kolon 2 Verisi',
    'Satır 1 Kolon 3 Verisi',
    17.45
);

$data[]=array(
    'Satır 2 Kolon 1 Verisi',
    'Satır 2 Kolon 2 Verisi',
    'Satır 2 Kolon 3 Verisi',
    35.10
);

$data[]=array(
    'Satır 3 Kolon 1 Verisi',
    'Satır 3 Kolon 2 Verisi',
    'Satır 3 Kolon 3 Verisi',
    40.01
);

exportExcel('DosyaAdi',$columns,$data,$replaceDotCol);
?>