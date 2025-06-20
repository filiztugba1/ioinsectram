<?php include "header.php"; ?>

<div class="yuz jobstarthead"  style="font-size:15px; font-weight:bold;">
	<div class="elli  pad10">
		Test Musteri
	</div>	
	<div class="elli  pad10">
		<div class="pad10" style=" float:left; width:30%; text-align:center; background:#503cee;"><span class="fa fa-stop-circle" style="font-size:30px;"></span> </div>
		<div class="pad10" style=" float:left; width:30%; margin-left:3%; text-align:center; background:#503cee"><span class="fa fa-pause-circle" style="font-size:30px;"></span> </div>
		<div class="pad10" style=" float:left; width:30%; margin-left:3%; text-align:center; background:#503cee"><span class="fa fa-list-alt" style="font-size:30px;"></span>  </div>
	</div>
</div>
<?php
for ($i = 1; $i <= 10; $i++){
?>
<div class="yuz pad10"  style=" font-weight:bold;">
	<div  class="atmisbes pad10" >
		<label class="containerx" style="font-size:12px;"><?=$i?> - Test Bocek Monitor
		  <input type="checkbox" checked="checked">
		  <span class="checkmarkx"></span>
		</label>
	</div>	
	<div class="otuzbes pad10"> <a class="pad10" href="monitoric.php" style="padding:5px; background:#503cee; color:white; width:100%;">Okutamiyorum</a>			
	</div>
</div>
<?php
}
?>




<?php include "footer.php";?>
