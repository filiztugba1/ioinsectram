<div id="splash" style="background-color: #fff; width:100%; height:100%; position:absolute;z-index:1100;"> 
   
    <center>    <img src="https://i1.wp.com/coursekeyeducation.com//wp-content/uploads/2017/06/CK_anim_04.gif?w=1300&ssl=1" alt="splash" /> </center>
		
</div>

<?php $monitoricid=$_GET['id']; ?>
<form action="/mobile/monitorkaydet/<?=$monitoricid?>?workorderid=<?=$_GET['workorderid']?>" method="post">
<?php
$id=$_GET['id'];
$monitor=Monitoring::model()->findbypk($id);
$monitortype=$monitor->mtypeid;
$controls=Monitoringtypepets::model()->findall(array('condition'=>'monitoringtypeid='.$monitortype));

$controls=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$_GET['workorderid'].' and monitorid='.$monitoricid));
foreach ($controls as $m)
{
	$pet=Pets::model()->findbypk($m->petid);

	?>
<div class="yuz">
	<div class="elli"> <?=$pet->name?></div>
	<div class="elli"><?php
	if ($m->pettype==0){
	?>
	<center>	
	<input type="checkbox" name="<?=$m->id?>" value="1" style=" float:right;"></center>
		<?php
	}
	else{
?>
		<input type="number" name="<?=$m->id?>" value="" style="-webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px; text-align:center;width:40px!important; float:right; font-weight:bold;">	
	<?php
	}
	?> </div>
</div>

		<?
}

?>

					  <button type="submit"  class="btn btn--full">Save</button>
					  </form>