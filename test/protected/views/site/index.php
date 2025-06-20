<?php
/* @var $this SiteController */

$ax= User::model()->userobjecty('');
if ($ax->firmid ==0)     // if ($ax->type ==1)
{ // 1-superadmin 2-firm-admin  4-branch-admin  6-customer-admin
    $model=Firm::model()->findAll(array('condition'=>'parentid=0')); // firm
    $modela=Firm::model()->findAll(array('condition'=>'parentid!=0')); // branch
    $modelb=Client::model()->findAll(array('condition'=>'parentid=0')); // client
    $modelc=Client::model()->findAll(array('condition'=>'parentid!=0')); // client branch
    $firm=count($model);
    $branch=count($modela);
    $client=count($modelb);
    $clientbranch=count($modelc);
}
else
{
    $modela=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid)); // branch
    $clients=Firm::model()->find(array('condition'=>'parentid='.$ax->firmid));

	if(isset($clients))
	{
		$modelb=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$clients->id)); // client
		$modelc=Client::model()->findAll(array('condition'=>'parentid!=0 and firmid='.$clients->id)); // client branch
		$branch=count($modela);
		$client=count($modelb);
		$clientbranch=count($modelc);
	}
	else
	{
		$branch=0;
		$client=0;
		$clientbranch=0;
	}
}
?>
<div class="row">

    <?php if($ax->clientbranchid==0 && 1==0){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>
    <div class="col-xl-4 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-info bg-darken-2">
                        <i class="icon-user font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-info white media-body">
                        <h5><?=t('Client Branchs');?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=$clientbranch;?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>



    <?php if($ax->firmid==0 && 1==0){ //if($ax->type==1) ?>
    <div class="col-xl-4 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success bg-darken-2">
                        <i class="icon-user font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-success white media-body">
                        <h5><?=t('Firms');?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=$firm;?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($ax->branchid==0 && 1==0){  //if($ax->type==1 || $ax->type==2)?>
    <div class="col-xl-4 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="icon-users font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-primary white media-body">
                        <h5><?=t('Branchs');?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=$branch;?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($ax->clientid==0 && 1==0){  //if($ax->type==1 || $ax->type==2 || $ax->type==4)?>
	 <div class="col-xl-4 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-lighten-3">
                        <i class="icon-user font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-primary bg-lighten-3 white media-body">
                        <h5><?=t('Clients');?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=$client;?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($ax->clientbranchid==0 && 1==0){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>
    <div class="col-xl-4 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-info bg-darken-2">
                        <i class="icon-user font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-info white media-body">
                        <h5><?=t('Client Branchs');?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=$clientbranch;?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

   <?php

   ////alper

   ?>
   <div class="col-xl-12 col-lg-12 col-12">
	<div class="row">
		<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>
		<div class="col-xl-6 col-lg-6 col-6">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">
						<div class="p-2 text-center bg-info bg-darken-2">
							<i class="icon-user font-large-2 white"></i>
						</div>
						<div class="p-2 bg-gradient-x-info white media-body">
							<h5><?=t('New Customer / Total Customer');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>0/0</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
				<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>
		<div class="col-xl-6 col-lg-6 col-6">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">
						<div class="p-2 text-center bg-info bg-darken-2">
							<i class="icon-user font-large-2 white"></i>
						</div>
						<div class="p-2 bg-gradient-x-info white media-body">
							<h5><?=t('Opened / Closed Non-Conformities');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>0/0</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
    </div>
    </div>

<!--Product sale & buyers -->
    <div class="col-xl-8 col-lg-12"  class="height-300">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?=t('Callouts/Total Visits');?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="products-sales"></div>
                </div>
            </div>
        </div>
    </div>

<div class="col-xl-4 col-lg-12"  class="height-300">
        <div class="card" >
            <div class="card-content" >
                <div class="card-body sales-growth-chart">
                    <div id="monthly-sales"></div>
                </div>
            </div>
            <div class="card-footer">
                <div class="chart-title mb-1 text-center">
                    <h6><?=t('Total monthly Visits.');?></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!--/ Product sale & buyers -->
<script>

$(window).on("load", function() {

    var e = ["<?=t('Jan');?>", "<?=t('Feb');?>", "<?=t('Mar');?>", "<?=t('Apr');?>", "<?=t('May');?>", "<?=t('Jun');?>", "<?=t('Jul');?>", "<?=t('Aug');?>", "<?=t('Sep');?>", "<?=t('Oct');?>", "<?=t('Nov');?>", "<?=t('Dec');?>"];
    Morris.Area({
        element: "products-sales",
        data: [
            {
            month: "2019-01",
            Visits: 0,
            },
            {
            month: "2019-02",
            Visits: 0,
            },
            {
            month: "2019-03",
            Visits: 0,
            },
            {
            month: "2019-04",
            Visits: 0,
            },
            {
            month: "2019-05",
            Visits: 0,
            },

        ],
        xkey: "<?='month';?>",
        ykeys: ["<?='Visits';?>"],
        labels: ["<?='Visits'?>"],
        xLabelFormat: function(r) {
            return e[r.getMonth()]
        },
        dateFormat: function(r) {
            return e[new Date(r).getMonth()]
        },
        behaveLikeLine: !0,
        ymax: 10,
        resize: !0,
        pointSize: 1,
        pointStrokeColors: ["#00B5B8", "#FA8E57", "#F25E75"],
        smooth: !0,
        gridLineColor: "#E4E7ED",
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 1,
        fillOpacity: .9,
        hideHover: "auto",
        lineColors: ["#00B5B8", "#FA8E57", "#F25E75"]
    }), Morris.Bar.prototype.fillForSeries = function(e) {
        return "0-#fff-#f00:20-#000"
    }, Morris.Bar({
        element: "monthly-sales",
        data: [{
            month: "<?=t('Jan');?>",
            sales: 0
        }, {
            month: "<?=t('Feb');?>",
            sales: 0
        }, {
            month: "<?=t('Mar');?>",
            sales: 0
        }, {
            month: "<?=t('Apr');?>",
            sales: 0
        }, {
            month: "<?=t('May');?>",
            sales: 0
        }, {
            month: "<?=t('Jun');?>",
            sales: 0
        }, {
            month: "<?=t('Jul');?>",
            sales: 0
        }, {
            month: "<?=t('Aug');?>",
            sales: 0
        }, {
            month: "<?=t('Sep');?>",
            sales: 0
        }, {
            month: "<?=t('Oct');?>",
            sales: 0
        }, {
            month: "<?=t('Nov');?>",
            sales: 0
        }, {
            month: "<?=t('Dec');?>",
            sales: 0
        }],
        xkey: "<?='month';?>",
        ykeys: ["<?='sales';?>"],
        ymax: 100,
        labels: ["<?='Sales';?>"],
        barGap: 4,
        barSizeRatio: .3,
        gridTextColor: "#bfbfbf",
        gridLineColor: "#E4E7ED",
        numLines: 5,
        gridtextSize: 14,
        resize: !0,
        barColors: ["#00B5B8"],
        hideHover: "auto"
    });


            // Block Element
            $('.card').block({
                message: '<?=t('Insufficient Data')?>',
                timeout: 20000, //unblock after 2 seconds
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none',
                }
            });

 });

</script>
<STYLE>.blockOverlay,.blockMsg{
z-index:10 !important;
}

</STYLE>
<?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/morris.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/raphael-min.js;';


?>
