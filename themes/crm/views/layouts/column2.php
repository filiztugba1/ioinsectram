<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row col-md-12" style="padding-top: 15px">
<div class="col-md-12">
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'breadcrumb','style'=>'padding:0px'),
                     'encodeLabel'=>false,
		));
		$this->endWidget();
	?>
	</div><!-- sidebar -->
</div>
<div class="col-md-12">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
    </div>

<?php $this->endContent(); ?>