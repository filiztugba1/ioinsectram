<?php	
$workid=$_GET['id'];

$wo=Workorder::model()->findbypk($workid);
$wo->status=1;
$wo->update();
$clientid=$wo->branchid;
$client=Client::model()->findbypk($wo->branchid);
$name=$client->name;


//definationlocation

if (!isset($_GET['sp'])){
?>

<div id="splash" style="background-color: #fff; width:100%; height:100%; position:absolute;z-index:1100;"> 
   
    <center>    <img src="https://i1.wp.com/coursekeyeducation.com//wp-content/uploads/2017/06/CK_anim_04.gif?w=1300&ssl=1" alt="splash" /> </center>
		
</div>
<?php } ?>

<div class="yuz jobstarthead"  style="font-size:15px; font-weight:bold;">
	<div class="elli  pad10">
		<?=$name?>	
	</div>	
	<div class="elli  pad10">
		<div class="pad10" style=" float:left; width:30%; text-align:center; background:#503cee;"><a href="/mobile/stopjob/<?=$workid?>"><span class="fa fa-stop-circle" style="font-size:30px; color:orange;"></span></a> </div>
		<div class="pad10" style=" float:left; width:30%; margin-left:3%; text-align:center; background:#503cee"><a href="/mobile/"><span class="fa fa-pause-circle" style="font-size:30px; color:red;"></span></a></div>
		<div class="pad10" style=" float:left; width:30%; margin-left:3%; text-align:center; background:#503cee; "><a href="/mobile/nc"><span class="fa fa-list-alt" style="font-size:30px; color:white;"></span></a>  </div>
	</div>
</div>
<?php
$monitors=Mobileworkordermonitors::model()->findall(array('condition'=>'workorderid='.$wo->id));
foreach ($monitors as $i){
	
	$type1=Monitoring::model()->findbypk($i->monitorid);
	$type=Monitoringtype::model()->findbypk($type1->mtypeid);
	$monitortitle=$type->detailed;

	$monitorid=$i->monitorid;
	$monitorno=Monitoring::model()->getmonitorno($i->monitorid);
?>
<div class="yuz pad10"  style=" font-weight:bold; 
    font-weight: bold;
    border-bottom: solid;
    border-bottom-color: lightgray;
    border-bottom-width: 1px;
	">
	<div  class="atmisbes pad10" >
		<label class="containerx" style="font-size:12px;"><?=$monitorno?> - <?=$monitortitle?>
		  <input type="checkbox" <?php if ($i->checkdate<>0){?> checked="checked" <?php } ?> disabled>
		  <span class="checkmarkx"></span>
		</label>
	</div>	

	<div class="otuzbes pad10" >	<?php if ($i->checkdate==0){ ?> <a class="pad10" href="/mobile/monitoric/<?=$monitorid?>?workorderid=<?=$_GET['id']?>" style="padding:5px; background:#503cee; color:white; width:100%; float:right; text-align:center;"><i style="font-size:30px;" class="fa fa-qrcode" aria-hidden="true"></i></a>
	<?php } else {echo  '<center><span style="color:#03a84a;">Saved</span></center>';} ?>
	</div>
</div>
<?php
}
?>
