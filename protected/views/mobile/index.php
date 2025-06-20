<?php
/* @var $this MobileController */
$wo=Workorder::model()->findall();
?>
	<div class="timeline homepage">
<?php foreach ($wo as $item) { ?>

				  <a href="<?php if ($item->status==4){  echo '#';}else{?>/mobile/jobdetail/<?=$item->id?> <?php }?>">
				  <div class="container right">
					<div class="content">
					  <h2><?=Client::model()->getclientname($item->branchid)?>  / <?=Client::model()->getclientname($item->clientid)?></h2>
					  <p><?php
					  
					  if ($item->status==0){
						  echo 'Not Started';
					  }else if ($item->status==1){
						  echo 'Paused';
					  }else if ($item->status==2){
						  echo 'Done';

					  }
					  
					  ?></p>
					</div>
				  </div>
				  </a>
<?php } ?>		 
				</div>