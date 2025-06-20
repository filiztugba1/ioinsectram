<?php
Yii::app()->db->createCommand(
'UPDATE conformity SET statusid=4 WHERE statusid=2')->execute();
User::model()->login();
$ax= User::model()->userobjecty('');

$conformity=Conformity::model()->findAll(array('condition'=>$where,'order'=>'clientid asc,id asc,date asc'));

$yaz="";

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
					$resim="<img src='".Yii::app()->getbaseUrl(true)."/".$conformityx['filesf']."' width='200px' height='200px' >";
				}
				else{
					$resim="";
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


	   </tr>";
						}


/*<meta http-equiv="Content-Type" content="text/html; charset=utf-8">*/
$html="<html><head></head><body><style>
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
							<th>".t('NON-CONFORMITY NO')."</th>
							<th>".t('WHO')."</th>
                            <th>".t('TO WHO')."</th>
                            <th>".t('DEPARTMENT')."</th>
                            <th>".t('SUB-DEPARTMENT')."</th>
                            <th>".t('OPENING DATE')."</th>
                            <th>".t('TYPE')."</th>
                            <th>".t('DEFINITION')."</th>
                            <th>".t('SUGGESTION')."</th>
                            <th>".t('STATUS')."</th>
                            <th>".t('PRIORITY')."</th>
							<th>".t('ACTION DEFINITION')."</th>
							<th>".t('DEADLINE')."</th>
							<th>".t('ASSIGNED AUTHORIZED')."</th>
							<th>".t('CLOSED TIME')."</th>
							<th>".t('ACTIVITY STATUS')."</th>
							<th>".t('IMAGE')."</th>



                          </tr>
                        </thead>
                        <tbody>
                         ".$yaz."



                        </tbody>
                      </table>";


					  ?>
