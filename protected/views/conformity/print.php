<?php
Yii::app()->db->createCommand(
'UPDATE conformity SET statusid=4 WHERE statusid=2')->execute();
User::model()->login();
$ax= User::model()->userobjecty('');

$conformity=Conformity::model()->findAll(array('condition'=>$where,'order'=>'clientid asc,id asc,date asc'));

$yaz="";
function tr_strtoupper($text)
{
    $search=array("ç","i","ı","ğ","ö","ş","ü");
    $replace=array("Ç","İ","I","Ğ","Ö","Ş","Ü");
    $text=str_replace($search,$replace,$text);
    $text=strtoupper($text);
    return $text;
}
if (isset($_GET) &&isset($_GET['data'])) {
	$data=json_decode($_GET['data']);
	$request['firm']=$data->firm;
	$request['branch']=$data->branch;
	$request['client']=$data->client;
	$request['department']=$data->department;
	$request['subdepartment']=$data->subdepartment;
	$request['conformitytype']=$data->conformitytype;
	$request['status']=$data->status;
	$request['finishDate']=$data->finishDate;
	$request['startDate']=$data->startDate;
}

$response=Conformity::model()->conformityList($request)['response'];
			foreach($response as $conformityx){
				if($conformityx['filesf'])
				{
					$resim="<img src='".Yii::app()->getbaseUrl(true)."/".$conformityx['filesf']."' width='150px' height='150px' >";
				}
				else{
					$resim="";
				}
				
				if($conformityx['filesf2'])
				{
					$resim2="<img src='".Yii::app()->getbaseUrl(true)."/".$conformityx['filesf2']."' width='150px' height='150px' >";
				}
				else{
					$resim2="";
				}
				
				$yaz .="
			<tr>
				<td>".$conformityx['cnumber']."</td>
				 <td>".$conformityx['userName']."</td>
				 <td>".$conformityx['clientName']."</td>
				 <td>".$conformityx['departmentName']."</td>
				 <td>".$conformityx['subName']."</td>
				  <td>".$conformityx['acilmaTarihi']."</td>
					<td>".$conformityx['conType']."</td>
				 <td>".$conformityx['definition']."</td>
				 <td>".$conformityx['suggestion']."</td>
				 <td>".$conformityx['conStatus']."</td>
				<td>".$conformityx['priority']."</td>
				<td>".$conformityx['activitydefinition']."</td>
				<td>".$conformityx['deadline']."</td>
				<td>".$conformityx['assignNameSurname']."</td>
				<td>".$conformityx['closedtime']."</td>
				<td>".$conformityx['etkinlikDurumu']."</td>
				<td>".$resim."</td>
				<td>".$resim2."</td>

	   </tr>";
						}


/*<meta http-equiv="Content-Type" content="text/html; charset=utf-8">*/
$html="<html><head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head><body><style>
.f12
{
	font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
}
td {
font-family:Arial;
}
</style><table border='0'  width='100%' cellpadding='0' cellspacing='0'>
                        <thead>
                          <tr>
							<th>".tr_strtoupper(t('NON-CONFORMITY NO'))."</th>
							<th>".tr_strtoupper(t('WHO'))."</th>
                            <th>".tr_strtoupper(t('TO WHO'))."</th>
                            <th>".tr_strtoupper(t('Department'))."</th>
                            <th>".tr_strtoupper(t('Alt Bölüm'))."</th>
                            <th>".tr_strtoupper(t('OPENING DATE'))."</th>
                            <th>".tr_strtoupper(t('TYPE'))."</th>
                            <th>".tr_strtoupper(t('Definition'))."</th>
                            <th>".tr_strtoupper(t('SUGGESTION'))."</th>
                            <th>".tr_strtoupper(t('STATUS'))."</th>
                            <th>".tr_strtoupper(t('Priority'))."</th>
							<th>".tr_strtoupper(t('Action Definition'))."</th>
							<th>".tr_strtoupper(t('Deadline'))."</th>
							<th>".tr_strtoupper(t('ASSIGNED AUTHORIZED'))."</th>
							<th>".tr_strtoupper(t('CLOSED TIME'))."</th>
							<th>".tr_strtoupper(t('ACTIVITY STATUS'))."</th>
							<th>".tr_strtoupper(t('Image'))."</th>
							<th>".tr_strtoupper(t('Completion File'))."</th>


                          </tr>
                        </thead>
                        <tbody>
                         ".$yaz."



                        </tbody>
                      </table>";


					  ?>
