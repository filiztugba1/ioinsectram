<section id="html5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row" style="border-bottom: 1px solid #e3ebf3;">
                        <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
                            <h4 class="card-title"><?=mb_strtoupper(t('Monitors'));?></h4>
                        </div>
                    </div>
                </div>

                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">

                        <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                            <thead>

                            <tr>
                                <th><?=t('Number');?></th>
                                <th><?=t('Yeri');?></th>
                                <th><?=t('Tipi');?></th>
                                <th><?=t('Monitor Konum');?></th>
                                <th><?=t('Bölüm');?></th>
                                <th><?=t('Alt Bölüm');?></th>
								<th><?=t('Active/Passive');?></th>
								<th><?=t('Created Date');?></th>
								<th><?=t('Passive Date');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql="";
                           if(isset($_POST["Monitoring"]["subid"]))
							{
								if(count($_POST['Monitoring']['subid'])>1)
								{
								$sql=$sql. " (";
								foreach ($_POST['Monitoring']['subid'] as $item)
								{
									$sql= $sql."subid=".$item." or ";
								}
								$sql=rtrim($sql,"or ");
								$sql= $sql.") and ";
								}
								else{
									  $sql= $sql."subid=".$_POST['Monitoring']['subid'][0]." and ";
								}
							}

                            if($_POST['Report']['dapartmentid'] <> 0)
                            {
                                $sql= $sql." dapartmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
                            }
                            if($_POST['Monitoring']['mtypeid'] <> 0)
                            {
                                $sql= $sql." mtypeid=".$_POST['Monitoring']['mtypeid']." and ";
                            }

                            $monitors=Monitoring::model()->findAll(array('condition'=>$sql.'clientid='.$_POST['Report']['clientid']));
                            foreach ($monitors as $monitor)
                            {
                                $department=Departments::model()->findByPk($monitor->dapartmentid);
                                $subdepartment=Departments::model()->findByPk($monitor->subid);
                                $monitoringlocation=Monitoringlocation::model()->findByPk($monitor->mlocationid);
                                $monitortype=Monitoringtype::model()->findByPk($monitor->mtypeid);
                                ?>
                                <tr>
                                    <td><?=$monitor->mno?></td>
                                    <td><?=$monitoringlocation->detailed." (".$monitoringlocation->name.")"?></td>
                                    <td> <?=$monitortype->name.' - '.t($monitortype->detailed);?></td>
                                    <td><?=$monitor->definationlocation?></td>
                                    <td><?=$department->name?></td>
                                    <td><?=$subdepartment->name?></td>
									<td>
									<?php if($monitor->active==1){echo t('Active');}else{echo 'Passive';}?>
									</td>
									<td>
									<?php if($monitor->createdtime!=0){echo date('Y-m-d',$monitor->createdtime);}?>
									</td>
									<td>
									<?php if($monitor->passivetime!=0 && $monitor->active!=1){echo date('Y-m-d',$monitor->passivetime);}else{echo '-';}?>
									</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>

                            <tr>
                                 <th><?=t('Number');?></th>
                                <th><?=t('Yeri');?></th>
                                <th><?=t('Tipi');?></th>
                                <th><?=t('Monitor Konum');?></th>
                                <th><?=t('Bölüm');?></th>
                                <th><?=t('Alt Bölüm');?></th>
								<th><?=t('Active/Passive');?></th>
								<th><?=t('Created Date');?></th>
								<th><?=t('Passive Date');?></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .switchery,.switch{
        margin-left:auto !important;
        margin-right:auto !important;
    }
</style>
<script>
    $("#createpage").hide();
    $("#createbutton").click(function(){
        $("#createpage").toggle(500);
    });
    $("#cancel").click(function(){
        $("#createpage").hide(500);
    });




    $(document).ready(function() {
        $('.block-page').on('click', function() {
            $.blockUI({
                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                timeout: 20000, //unblock after 20 seconds
                overlayCSS: {
                    backgroundColor: '#FFF',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

    });


    function openmodal(obj)
    {
        $('#modalmobileworkorderdataid').val($(obj).data('id'));
        $('#modalmobileworkorderdatavalue').val($(obj).data('name'));
        $('#modalmobileworkorderdatapet').empty();
        $('#modalmobileworkorderdatapet').append($(obj).data('pet'));



        $('#duzenle').modal('show');

    }

    function openmodalsil(obj)
    {
        $('#modalmobileworkorderdataids').val($(obj).data('id'));
        $('#sil').modal('show');

    }




    $(document).ready(function() {

        /******************************************
         *       js of HTML5 export buttons        *
         ******************************************/

        $('.dataex-html5-export').DataTable( {
            dom: 'Bfrtip',
			lengthMenu: [[50,100,5,10, -1], [50,100,5,10, "<?=t('All');?>"]],
            language: {
                buttons: {
                    pageLength: {
                        _: "<?=t('Show');?> %d <?=t('rows');?>",
                        '-1': "<?=t('Tout afficher');?>",
                        className: 'd-none d-sm-none d-md-block',
                    },
                    colvis: "<?=t('Columns Visibility');?>",

                },
                "sDecimal": ",",
                "sEmptyTable": "<?=t('Data is not available in the table');?>",
                //"sInfo": "_TOTAL_ kay�ttan _START_ - _END_ aras�ndaki kay�tlar g�steriliyor",
                "sInfo": "<?=t('Total number of records');?> : _TOTAL_",
                "sInfoEmpty": "<?=t('No records found');?> ! ",
                "sInfoFiltered": "(_MAX_ <?=t('records');?>)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "<?=t('Top of page');?> _MENU_ <?=t('record');?>",
                "sLoadingRecords": "<?=t('Loading');?>...",
                "sProcessing": "<?=t('Processing');?>...",
                "sSearch": "<?=t('Search');?>:",
                "sZeroRecords": "<?=t('No records found');?> !",
                "oPaginate": {
                    "sFirst": "<?=t('First page');?>",
                    "sLast": "<?=t('Last page');?>",
                    "sNext": "<?=t('Next');?>",
                    "sPrevious": "<?=t('Previous');?>"
                },
            },
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    text:'<?=t('Copy');?>',
                    className: 'd-none d-sm-none d-md-block',
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    text:'<?=t('Excel');?>',
                    className: 'd-none d-sm-none d-md-block',
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    text:'<?=t('Pdf');?>',
                    className: 'd-none d-sm-none d-md-block',
                },
                'colvis',
                'pageLength'
            ]


        } );
        <?php        $ax= User::model()->userobjecty('');
        $pageUrl=explode('?',$_SERVER['REQUEST_URI'])[0];
        $pageLength=5;
        $table=Usertablecontrol::model()->find(array(
        							 'condition'=>'userid=:userid and sayfaname=:sayfaname',
        							 'params'=>array(
        								 'userid'=>$ax->id,
        								 'sayfaname'=>$pageUrl)
        						 ));
        if($table){
        	$pageLength=$table->value;
        }
        ?>
        var table = $('.dataex-html5-export').DataTable();
        table.page.len( <?=$pageLength;?> ).draw();
        var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
        var info = table.page.info();
        var lengthMenuSetting = info.length; //The value you want
        // alert(table.page.info().length);
        } );
</script>
<style>
    @media (max-width: 991.98px) {

        .hidden-xs,.buttons-collection{
            display:none;
        }
        div.dataTables_wrapper div.dataTables_filter label{
            white-space: normal !important;
        }
        div.dataTables_wrapper div.dataTables_filter input{
            margin-left:0px !important;
        }

    }
</style>
<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/switch.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';?>
