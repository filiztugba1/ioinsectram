<?php
$workid=$_GET['id'];

$wo=Workorder::model()->findbypk($workid);
$clientid=$wo->clientid;
$client=Client::model()->findbypk($wo->clientid);
$name=$client->name;
$detail=$wo->todo;
$date=$wo->date.' '.$wo->start_time.' - '.$wo->finish_time;
$phone='-';
$address='-';
$depertmant='';
$depertmants=Departmentvisited::model()->findall(array('condition'=>'workorderid='.$wo->id));
foreach ($depertmants as $d){
	if ($d->departmentid<>''){
	$depertmant=$depertmant.Departments::model()->getname($d->departmentid).'-';
	}
}

$subdepertmant='';
$subdepertmantS=Departmentvisited::model()->findall(array('condition'=>'workorderid='.$wo->id));
foreach ($subdepertmantS as $d){
	if ($d->subdepartmentid<>''){
	$subdepertmant=$subdepertmant.Departments::model()->getname($d->subdepartmentid).'-';
	}
}
?>
 <div id="pages_maincontent" style="background:white;">			 
			 <div class="page_single layout_fullwidth_padding">		
			   <div class="shop_item">	
				  <div class="shop_item_details">
					  <h3><strong>Client: </strong><?=$name?></h3>
					  <h3><strong>Detail: </strong><?=$detail?></h3>
					  <h3><strong>Date: </strong><?=$date?></h3>
					  <h3><strong>Phone: </strong><?=$phone?></h3>
					  <h3><strong>Address: </strong><?=$address?> </h3>
					  <h3><strong>Department: </strong><?=$depertmant?> </h3>  
					  <h3><strong>Sub Department: </strong><?=$subdepertmant?> </h3>  
					  <a href="/mobile/startjob/<?=$workid?>" class="btn btn--full">Start</a>					  
				  </div>			  
			  </div>
					  
			</div>
			  
		 </div>