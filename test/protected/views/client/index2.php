
<!-- Sayfada neredeyiz -->
<?php if(isset($firmbranchid)){?>
<?=User::model()->geturl('client','Branch',$_GET['id'],'client/index2');?>
<?php }
else if(isset($clientid)){?>
<?=User::model()->geturl('Client','Branch',$_GET['id'],'client/branch');?>
<?php }
else{?>
<?=User::model()->geturl('Client','',0,'client');?>
<?php }?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="text-primary"><i
                            class="feather icon-alert-triangle"></i> <?= t('BİLGİ') ?>!</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <p><?= t('Bilgi Gelecek.') ?></p>
                    </div>
                </div>
            </div>
            <?php if(isset($firmbranchid) || $clientid){?>
                <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12">
                     <div class="card">
                        <div class="card-header" style="">
                           <ul class="nav nav-tabs">
                             <?php if(isset($clientid)){?>
                             <li class="nav-item">
                               <a id="sayfaDetay" class="nav-link active"  ><?php if(isset($clientid)){echo t('Client Detay');}?>
                               </a>
                             </li>
                             <?php }?>

                             <?php if((isset($detay["parentid"]) || intval($detay["parentid"])==0) && !(!isset($firmbranchid) && intval($detay["parentid"])!=0)){?>
                             <li class="nav-item">
                               <a id="clientSaya" class="nav-link active"  >
                                 <span id="clientSay" class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;"></span><?php if(isset($firmbranchid)){echo t('Client');}else{echo t('Client Branch');}?>
                               </a>
                             </li>
                             <?php }?>
                             <li class="nav-item">
                               <a id="userSaya" class="nav-link" >
                                 <span id="userSay"  class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;"></span> <?=t('Staff');?>
                               </a>
                             </li>
                             <?php if(isset($firmbranchid)){?>
                                <li class="nav-item">
                                   <a id="teamSaya" class="nav-link" >
                                     <span id="teamSay"  class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;"></span> <?=t('Team');?>
                                   </a>
                                 </li>
                             <?php }?>
                             <?php if(!isset($firmbranchid) && isset($detay["parentid"]) && intval($detay["parentid"])!=0){?>
                                <li class="nav-item">
                                   <a id="depSaya" class="nav-link" >
                                     <span id="depSay"  class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;">0</span> <?=t('Department');?>
                                   </a>
                                 </li>
                                <li class="nav-item">
                                   <a id="monSaya" class="nav-link" >
                                     <span id="monSay"  class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;">0</span> <?=t('Monitör Noktaları');?>
                                   </a>
                                 </li>
                                <li class="nav-item">
                                   <a id="rapSaya" class="nav-link" >
                                    <span class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Raporlar');?>
                                   </a>
                                 </li>
                                 <li class="nav-item">
                                   <a id="dokSaya" class="nav-link" >
                                      <span class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span> <?=t('Dosya Yönetimi');?>
                                   </a>
                                 </li>
                                <li class="nav-item">
                                   <a id="musQra" class="nav-link" >
                                      <span class="badge badge badge-primary badge-pill float-right mr-1" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span> <?=t('Müşteri Qr');?>
                                   </a>
                                 </li>
                             <?php }?>
                          </ul>
                        </div>
                      </div>
                  </div>
                </div>
             <div class="card mb-4" id="UserTable">
                <div class="card-header">
                    <span class=""> <?php echo $detay["name"].' '.t('User List');?></span>
                    <a id="user-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Add User') ?></a>
                </div>

                <div class="card-body">
                    <div id="userListTable" class="row">
                    </div>
                </div>
            </div>
            <?php }?>
          <?php if (Yii::app()->user->checkAccess('client.view')){ ?>
            <div class="card mb-4" id="clientTable">
                <div class="card-header">
                    <span class=""> <?php if(isset($detay)){echo $detay["name"].' '.t('Client Branch List');  }else{ echo t('Client List'); }?></span>
                   <?php if (Yii::app()->user->checkAccess('client.create')){ ?>
                  <a id="client-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Add Client') ?></a>
                   <?php }?>
                </div>

                <div class="card-body">
                    <div id="clientListTable">
                    </div>
                </div>
            </div>
          <?php }?>
           <?php if (Yii::app()->user->checkAccess('staffteam.view')){ ?>
            <div class="card mb-4" id="teamTable">
                <div class="card-header">
                    <span class=""> <?php if(isset($detay)){echo $detay["name"].' '.t('Team List');  }?></span>
                  <?php if (Yii::app()->user->checkAccess('staffteam.create')){ ?>
                  <a id="team-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Add Team') ?></a>
                   <?php }?>
                </div>

                <div class="card-body">
                    <div id="teamListTable">
                    </div>
                </div>
            </div>
            <?php }?>
            <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>
             <div class="card mb-4" id="departTable">
                <div class="card-header">
                    <span class=""> <?php if(isset($detay)){echo $detay["name"].' '.t('Department List');  }?></span>

                </div>

                   <div class="card-content collapse show">
                      <div class="card-body card-dashboard">

                          <div class="treex well" id="depList">

                          </div>



                      </div>
                </div>
            </div>
           <?php }?>
           <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
         <div class="card mb-4" id="monTable">
                <div class="card-header">
                    <span class=""> <?php if(isset($detay)){echo $detay["name"].' '.t('Monitör List');  }?></span>
                    <a id="mon-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Monitör Ekle') ?></a>
                </div>

                <div class="card-body">
                    <div id="monListTable">
                    </div>
                </div>
            </div>
          <?php }?>
           <?php if(isset($detay) && isset($clientid)){?>
           <?php if (Yii::app()->user->checkAccess('client.detail.view')){ ?>
          <div class="card mb-4" id="clientDetay">
                <div class="card-body">
                    <div class="row">
                         <div class="col-md-3">
                          <img src="/uploads/1543480708.png" style="width: 100%;width: 100%; border: 1px solid #ecf0f7;margin-top: 9px;border-radius: 6px; padding: 15px;box-shadow: 0px 0px 3px 1px #e7ecf3;margin-bottom: 13px;" alt="<?php if(isset($detay)){echo $detay["name"];  }?>">
                      </div>
                      <div class="col-md-9" style="padding: 20px;margin-top: 9px;border: 1px solid #ecf0f7;border-radius: 4px;">
                          <h6><?php if(isset($detay)){echo $detay["name"];  }?></h6>
                        <div class="row">
                        <div class="col-md-12">

                         <table class="detayy table table-striped table-bordered dataTable no-footer">
                           <tr>
                             <td><b>Commercial Title</b></td>
                             <td>:</td>
                             <td colspan="4"><?php if(isset($detay)){echo $detay["title"];  }?></td>

                           </tr>

                             <tr>
                             <td><b>Tax Office</b></td>
                                  <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["taxoffice"];  }?></td>

                                  <td><b>Contract start date</b></td>
                                  <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["contractstartdate"];  }?></td>
                           </tr>
                             <tr>
                             <td style="min-width: 112px;"><b>Tax No</b></td>
                                  <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["taxno"];  }?></td>

                                  <td style="min-width: 112px;"><b>Contract finish date</b></td>
                                  <td >:</td>
                             <td style="min-width: 100px;"><?php if(isset($detay)){echo $detay["contractfinishdate"];  }?></td>
                           </tr>
                             <tr>
                             <td><b>Sector</b></td>
                                  <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["sectorname"];  }?></td>

                                  <td><b>Contract Amount</b></td>
                                  <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["productsamount_cu"];  }?></td>
                           </tr>
                            <tr>
                             <td><b>Land Phone</b></td>
                                 <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["landphone"];  }?></td>

                                 <td><b>VAT</b></td>
                                 <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["iskdv_cu"];  }?></td>
                           </tr>
                             <tr>
                             <td><b>Email</b></td>
                                  <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["email"];  }?></td>

                               <td><b>Aktif / Pasif</b></td>
                                <td>:</td>
                             <td><?php if(isset($detay)){echo $detay["isactiven"];  }?></td>
                           </tr>

                        </table>
                  </div>
                         </div>
                      </div>

                   <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="row">
                           <div class="col-md-3" style="text-align: center;padding: 2px;">
                             <a  data-id="" class="btn btn-secondary btn-xs conStatus" style="width: 100%;color:#fff"><span>All</span></a>
                           </div>

                           <?php

                          if(isset($status) && !empty($status['data'])){
                          foreach($status['data'] as $statuss){?>
                          <div class="col-md-3" style="text-align: center;padding: 2px;">
                             <a  data-id="<?=$statuss['id'];?>" class="btn btn-<?=$statuss['btncolor'];?> btn-xs conStatus" style="width: 100%;"><span><?=$statuss['name'];?></span></a>
                           </div>

                          <?php }}?>
                        </div>
                        </div>


                        </div>
                </div>
            </div>
           <?php }?>
        <!-- uygunsuzlık kısımları başlangıç- -->
           <?php if (Yii::app()->user->checkAccess('nonconformitymanagement.view')){ ?>

            <div class="card mb-4" id="csTable">
                <div class="card-header">
                    <span class=""> <?=t('Uygulama Tip Listesi');?></span>
                  <?php if (Yii::app()->user->checkAccess('nonconformitymanagement.create')){ ?>
                  <a id="c-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Uygunsuzluk Ekle') ?></a>
                   <?php }?>
                </div>

                <div class="card-body">
                    <div id="cListTable">
                    </div>
                </div>
            </div>
            <?php }?>
       <!-- uygunsuzlık kısımları bitiş- -->

          <?php }?>

        </div>
    </div>



 <?php if (Yii::app()->user->checkAccess('staffteam.create') || Yii::app()->user->checkAccess('staffteam.update')){ ?>
 <div class="modal fade" id="team-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="team-cu">
                  <div class="card-header" id="team-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="team-cu-body"></div>

                    </div>
                       <div class="card-footer">
                        <div class="row" id="team-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>
<?php if (Yii::app()->user->checkAccess('client.create') || Yii::app()->user->checkAccess('client.update') || Yii::app()->user->checkAccess('client.branch.create') || Yii::app()->user->checkAccess('client.branch.update') ){ ?>
 <div class="modal fade" id="client-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="client-cu">
                  <div class="card-header" id="client-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="client-cu-body"></div>

                    </div>
                       <div class="card-footer">
                        <div class="row" id="client-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>
<?php if (Yii::app()->user->checkAccess('client.delete') || Yii::app()->user->checkAccess('client.branch.delete')){ ?>

 <div class="modal fade" id="client-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="client-delete">
                  <div class="card-header" id="client-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="client-delete-body"></div>

                    </div>
                       <div class="card-footer">
                        <div class="row" id="client-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>
  <?php if (Yii::app()->user->checkAccess('client.branch.department.delete')){ ?>
 <div class="modal fade" id="dep-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="dep-delete">
                  <div class="card-header" id="dep-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="dep-delete-body"></div>

                    </div>
                       <div class="card-footer">
                        <div class="row" id="dep-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>
 <?php if (Yii::app()->user->checkAccess('client.branch.department.create') || Yii::app()->user->checkAccess('client.branch.department.update')){ ?>
 <div class="modal fade" id="dep-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="dep-cu">
                  <div class="card-header" id="dep-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="dep-cu-body"></div>

                    </div>
                       <div class="card-footer">
                        <div class="row" id="dep-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>
 <?php if (Yii::app()->user->checkAccess('client.staff.view')){ ?>
 <div class="modal fade" id="user-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="user-cu">
                  <div class="card-header" id="user-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="user-cu-body"></div>

                    </div>
                       <div class="card-footer">
                        <div class="row" id="user-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>


<?php if (Yii::app()->user->checkAccess('client.branch.monitoring.create') || Yii::app()->user->checkAccess('client.branch.monitoring.update')){ ?>
<div class="modal fade" id="mon-cu-table" tabindex="-1">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
                   <form id="mon-cu">
                 <div class="card-header" id="mon-cu-header"></div>
                     <div class="card-body">
                       <div class="row" id="mon-cu-body"></div>

                   </div>
                      <div class="card-footer">
                       <div class="row" id="mon-cu-footer"></div>
                   </div>
                   </form>
           </div>
       </div>
   </div>
<?php }?>

<style>
  a>span{
    font-size: 12px!important;
  }

  .detayy>tbody>tr{
     border: 1px solid #ecf0f7;
  }
  .detayy>tbody>tr>td{
     border: 1px solid #ecf0f7;
    padding:2px
  }
</style>
    <script>
      clientListColumnArrayUrl="";
      var listUrl="";
           $('#departTable').hide(500);

      <?php if(isset($firmbranchid)){?>
           listUrl="/client/clientlist/<?=$firmbranchid;?>";
           clientListColumnArrayUrl="/client/cdetail";
           userCartList('userListTable',0,"<?=$_GET['id'];?>",0,0,"userSay");
      <?php }else if(isset($clientid)){?>
            clientListColumnArrayUrl="/client/branch";
            userCartList('userListTable',0,0,<?=$_GET['id'];?>,0,"userSay");
            var listUrlClient="/conformity/conformitylist?cid=<?=$_GET['id'];?>&pid=<?=$detay["parentid"];?>";
            ////liste çekme başlangıç
            var conformityListColumnArray = [
                {"key": "cnumber", "value": "<?= t('Uygunsuzluk Numarası') ?>"},
                {"key": "userName", "value": "<?= t('Kim') ?>"},
                {"key": "clientName", "value": "<?= t('Kime') ?>"},
                {"key": "departmentName", "value": "<?= t('Bölüm') ?>"},
                {"key": "subName", "value": "<?= t('Alt Bölüm') ?>"},
                {"key": "acilmaTarihi", "value": "<?= t('Açılış Tarihi') ?>"},
                {"key": "definition", "value": "<?= t('Faaliyet Tanımı') ?>"},
                {"key": "deadline", "value": "<?= t('Tarih') ?>"},
                {"key": "closedtime", "value": "<?= t('Kapatılma Zamanı') ?>"},
                {"key": "conStatus", "value": "<?= t('Durum') ?>"},
                {"key": "conType", "value": "<?= t('Uygunsuzluk Tipi') ?>"},
                {"key": "suggestion", "value": "<?= t('Tanım') ?>"},
                {"key": "nokdefinition", "value": "<?= t('NOK-Tamamlanmadı Açıklaması') ?>"},
                {"key": "etkinlik", "value": "<?= t('Etkinlik Açıklaması') ?>"},
            ];
            tableList("cListTable", "conformityList", conformityListColumnArray, null, listUrlClient, "POST", null, "conformity","","conformitySay"); //listenin çekildiği fonksiyon
            $('.conformityList').on( 'select.dt', function ( e, dt, type, indexes ) {
                     var data = dt.rows(indexes).data();
                      window.open('<?=Yii::app()->baseUrl?>/conformity/activity/'+data["0"]["id"], '_blank');
              } );
            $('.conStatus').on('click', function (e) {
             tableUpdate([{"class":"conformityList","url":listUrlClient+'&status='+$(this).data('id')}]);
            });
            listUrl="/client/clientbranchlist/<?=$clientid;?>";
      <?php }else{?>
            listUrl="/client/clientlist";
            clientListColumnArrayUrl="/client/branch";
      <?php }?>

      ////client liste çekme başlangıç
      var clientListColumnArray = [
            {"key": "name", "value": "<?= t('Name') ?>","data":["id"],"type":"url","url":clientListColumnArrayUrl},
            {"key": "sectorname", "value": "<?= t('Sector') ?>"},
            {"key": "time", "value": "<?= t('Created Time') ?>"},
           {"key": "active", "value": "<?= t('Active') ?>","data":["id"],"type":"checbox"},
        ];
      listButtonArray=[
            {
                "class":"btn btn-warning btn-sm client-update",
                "title":"<?= t( 'Güncelle'); ?>",
                "iconClass":"fa fa-edit text-white",
                "data":[
                    "name","id"
                ]
            },
            {
                "class":"btn btn-danger btn-sm client-delete",
                "title":"<?= t( 'Sil'); ?>",
                "iconClass":"fa fa-trash text-white",
                "data":[
                    "name","id"
                ]
            }
        ]
      tableList("clientListTable", "clientList", clientListColumnArray, listButtonArray, listUrl, "POST", null, "client","","clientSay"); //listenin çekildiği fonksiyon


      function isactive(obj){
             $("#backgroundLoading").addClass("backgroundLoading");
             var formData = new FormData();
             formData.append('id', $(obj).data("id"));
             datam=serviscek('/client/clientisactive',actionType='POST', formData);
               datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                     tableUpdate([{"class":"clientList","url":""}]);
                        toastr.success("<center><?=t('Kaydetme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                   }
              else
                {
                   tableUpdate([{"class":"clientList","url":""}]);
                     toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                     });
                }
              })
          );
        }
      //////////// client ekleme-güncelleme işlemleri ////////////
      var clientHeader = {
            "card-header-id": "client-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'client Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
      var clientBody = {
            "card-body-id": "client-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "parentid_cu",
                    "defaultValue":"<?=isset($clientid)?$clientid:0;?>"
                },
                   {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Name') ?>",
                    "id": "name_cu",
                    "url": "",
                },

                     {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Commercial Title') ?>",
                    "id": "title_cu",
                    "url": "",
                },
                  {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Tax Office') ?>",
                    "id": "tax_office_cu",
                    "url": "",
                },
               {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Tax No') ?>",
                    "id": "tax_no_cu",
                    "url": "",
                },
                 {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Sector') ?>",
                    "id": "sector_cu",
                    "isurl": true,
                    "data": {
                        "url": "/sector/sectors?type=select",
                        "key": "id",
                        "value": "name",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                        "formType": "post",
                        "checked":null
                    }
                },

               {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Land Phone') ?>",
                    "id": "land_phone_cu",
                    "url": "",
                },
               {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Email') ?>",
                    "id": "email_cu",
                    "url": "",
                },
               {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Adres') ?>",
                    "id": "adres_cu",
                    "url": "",
                },
                {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Aktif / Pasif') ?>",
                    "id": "active_cu",
                    "isurl": false,
                    "data": [
                      {"key":"1","value":"Aktif"},
                      {"key":"0","value":"Pasif"}
                    ]
                },
                {
                    "type": "input-datepicker",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Contract start date') ?>",
                    "id": "contractstartdate_cu",
                    "url": "",
                },
               {
                    "type": "input-datepicker",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Contract finish date') ?>",
                    "id": "contractfinishdate_cu",
                    "url": "",
                },
               {
                    "type": "input-number",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Contract Amount') ?>",
                    "id": "productsamount_cu",
                    "url": "",
                },
                {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'VAT') ?>",
                    "id": "iskdv_cu",
                    "isurl": false,
                    "data": [
                      {"key":"1","value":"<?=t('Including')?>"},
                      {"key":"0","value":"<?=t('Excluding')?>"}
                    ]
                },
                 {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "firm_id_cu",
                    "url": "",
                   "defaultValue":'<?=$firmbranchid;?>'
                },

            ]
        };
      var clientFooter = {
            "card-footer-id": "client-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "client-create-button",
                    "url": ""
                },
            ]
        };
      $('#client-create-modal-button').on('click', function (e) {
            formBosalt(clientBody);
            clientHeader.data[0].title="<?= t( 'Müşteri Ekleme') ?>";
            clientFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(clientHeader, clientBody, clientFooter);
            $('#client-cu-table').modal('show');
        });
      $("#client-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/client/clientcreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#client-cu-table').modal('hide');
                     tableUpdate([{"class":"clientList","url":""}]);
                        toastr.success("<center><?=t('Kaydetme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                   }
              else
                {
                     toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                     });
                }
              })
          );
            return false;
        });
      $('.clientList').on('click', 'div a.client-update', function (e) {  /// güncelleme yapılacağında açılacak modalın içerisi dolduruluyor
            formBosalt(clientBody);
            clientHeader.data[0].title="<?= t( 'Müşteri Güncelleme') ?>";
            clientFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(clientHeader, clientBody, clientFooter);
            var formData = new FormData();
        console.log($(this).data('id'));
             formData.append('id', $(this).data('id'));
         $("#backgroundLoading").addClass("backgroundLoading");
            datam=serviscek('/client/clientdetail',actionType='POST',formData);
            datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").removeClass("backgroundLoading");
              let donenData=JSON.parse(res.data);
              if(donenData.status==true)
                 {
                   $('#id_cu').val(donenData.data[0].id);
                   $('#parentid_cu').val(donenData.data[0].parentid);
                   $('#name_cu').val(donenData.data[0].name);
                   $('#package_cu').val(donenData.data[0].package);
                   $('#title_cu').val(donenData.data[0].title);
                   $('#tax_office_cu').val(donenData.data[0].taxoffice);
                   $('#tax_no_cu').val(donenData.data[0].taxno);
                   $('#land_phone_cu').val(donenData.data[0].landphone);
                   $('#email_cu').val(donenData.data[0].email);
                   $('#adres_cu').val(donenData.data[0].address);
                    $('#sector_cu').val(donenData.data[0].branchid);
                   $('#active_cu').val(donenData.data[0].active);
                   $('#contractstartdate_cu').val(donenData.data[0].contractstartdate);
                   $('#contractfinishdate_cu').val(donenData.data[0].contractfinishdate);
                   $('#productsamount_cu').val(donenData.data[0].productsamount);
                   $('#iskdv_cu').val(donenData.data[0].iskdv);
                   $('#client-cu-table').modal('show');
                 }
              else
                {
                   toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                     positionClass: "toast-top-right",
                     containerId: "toast-top-right"
                   });

                }
            })
        );

      });

      ///////////// clienta silme işlemleri //////////
      var clientDHeader = {
            "card-header-id": "client-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'client Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
      var clientDBody = {
            "card-body-id": "client-delete-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "id_delete",
                  "defaultValue":"0"
                },
              {
                    "type": "text",
                    "div-class": "col-md-12",
                    "id": "id_text",
                    "defaultValue":"<?=t("Silmek istediğinize emin misiniz?");?>"
                },
            ]
        };
      var clientDFooter = {
            "card-footer-id": "client-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "client-delete-button",
                    "url": ""
                },
            ]
        };
      $('.clientList').on('click', 'div a.client-delete', function (e) {
            clientDBody.data[0].defaultValue=$(this).data('id');
            formOlustur(clientDHeader, clientDBody, clientDFooter);
            $('#client-delete-table').modal('show');
        });
      $("#client-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
           datam=serviscek('/client/clientdelete',actionType='POST', new FormData(this));
          datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").removeClass("backgroundLoading");
              let donenData=JSON.parse(res.data);
              if(donenData.status==true)
                 {
                    $('#client-delete-table').modal('hide');
                   tableUpdate([{"class":"clientList","url":""}]);
                      toastr.success("<center><?=t('Silme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                   });
                 }
            else
              {
                   toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                     positionClass: "toast-top-right",
                     containerId: "toast-top-right"
                   });
              }
            })
          );
            return false;
        });


      ////// takım listesi çekiliyor //////
       $('#departTable').hide(500);
      $('#teamTable').hide(500);
       $('#monTable').hide(500);


      <?php if(isset($firmbranchid)){?>
      var teamListColumnArray = [
                 {"key": "teamname", "value": "<?= t('Team Name') ?>"},
                {"key": "leadername", "value": "<?= t('Leader Name') ?>"},
                  // {"key": "teamstaff", "value": "<?= t('Takım Personelleri') ?>"},
                {"key": "color", "value": "<?= t('Takım Rengi') ?>"},
                 {"key": "active", "value": "<?= t('Active') ?>","data":["id"],"type":"checbox"},
            ];
      var teamButtonArray=[
                  {
                      "class":"btn btn-warning btn-sm team-update",
                      "title":"<?= t( 'Güncelle'); ?>",
                      "iconClass":"fa fa-edit text-white",
                      "data":[
                          "teamname","id"
                      ]
                  },
                  {
                      "class":"btn btn-danger btn-sm team-delete",
                      "title":"<?= t( 'Sil'); ?>",
                      "iconClass":"fa fa-trash text-white",
                      "data":[
                          "teamname","id"
                      ]
                  }
              ];
      tableList("teamListTable", "teamList", teamListColumnArray, teamButtonArray, "/staffteam/staffteamlist", "POST",{branchid : <?=$firmbranchid;?>}, "team","","teamSay"); //listenin çekildiği fonksiyon
      var teamHeader = {
            "card-header-id": "team-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Takım Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
      var teamBody = {
            "card-body-id": "team-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "clientid_cu",
                    "defaultValue":"<?=isset($clientid)?$clientid:0;?>"
                },
                   {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Name') ?>",
                    "id": "teamname_cu",
                    "url": "",
                },
                   {
                    "type": "selectbox",
                    "div-class": "col-md-4",
                    "label": "<?= t( 'Takım Lideri') ?>",
                    "id": "leaderid_cu",
                    "isurl": true,
                    "data": {
                        "url": "/staffteam/teamuserlist?clientid=<?=$firmbranchid;?>&type=select",
                        "key": "id",
                        "value": "staff",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                        "formType": "Get",
                        "checked":null
                    }
                },
               {
                    "type": "selectbox",
                    "div-class": "col-md-4",
                    "label": "<?= t( 'Takım Personelleri') ?>",
                    "id": "staff_cu",
                    "isurl": false,
                    "data": {},
                  "disabled":true
                },
                     {
                    "type": "input-color",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Takım Rengi') ?>",
                    "id": "color_cu",
                    "url": "",
                },

            ]
        };
      var teamFooter = {
            "card-footer-id": "team-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "team-create-button",
                    "url": ""
                },
            ]
        };
      $('#team-create-modal-button').on('click', function (e) {
            formBosalt(teamBody);
            teamHeader.data[0].title="<?= t( 'Takım Ekleme') ?>";
            teamFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(teamHeader, teamBody, teamFooter);
            $('#team-cu-table').modal('show');
        });
      <?php }?>

      <?php if(isset($detay)){?>
       <?php if(!isset($firmbranchid)){?>
        $('#clientTable').hide(500);
         $('#clientSaya').removeClass('active');
      <?php }?>
      <?php }?>

       $('#sayfaDetay').on('click', function (e) {
          $('#csTable').show(500);
        $('#clientDetay').show(500);
        $('#UserTable').hide(500);
         $('#clientTable').hide(500);
         $('#teamTable').hide(500);
          $('#monTable').hide(500);
         $('#departTable').hide(500);

        $('#sayfaDetay').addClass('active');
        $('#clientSaya').removeClass('active');
        $('#teamSaya').removeClass('active');
        $('#userSaya').removeClass('active');
        $('#depSaya').removeClass('active');
         $('#monSaya').removeClass('active');
      });


       $('#clientSaya').on('click', function (e) {
          $('#departTable').hide(500);
            $('#clientDetay').hide(500);
        $('#UserTable').hide(500);
        $('#clientTable').show(500);
         $('#teamTable').hide(500);
          $('#monTable').hide(500);
        $('#csTable').hide(500);
             $('#csTable').hide(500);
         $('#userSaya').removeClass('active');
         $('#teamSaya').removeClass('active');
        $('#clientSaya').addClass('active');
         $('#monSaya').removeClass('active');
            $('#clientDetay').hide(500);
            $('#sayfaDetay').removeClass('active');
         $('#depSaya').removeClass('active');
           tableList("clientListTable", "clientList", clientListColumnArray, listButtonArray, listUrl, "POST", null, "client","","clientSay"); //listenin çekildiği fonksiyon

      });
       $('#teamSaya').on('click', function (e) {
        $('#UserTable').hide(500);
        $('#teamTable').show(500);
         $('#clientTable').hide(500);
          $('#departTable').hide(500);
            $('#clientDetay').hide(500);
          $('#monTable').hide(500);
             $('#csTable').hide(500);
         $('#userSaya').removeClass('active');
         $('#clientSaya').removeClass('active');
        $('#teamSaya').addClass('active');
          $('#depSaya').removeClass('active');
          $('#sayfaDetay').removeClass('active');
         $('#monSaya').removeClass('active');
         <?php if(isset($firmbranchid)){?>
           tableList("teamListTable", "teamList", teamListColumnArray, teamButtonArray, "/staffteam/staffteamlist", "POST",{branchid : <?=$firmbranchid;?>}, "team","","teamSay"); //listenin çekildiği fonksiyon
        <?php }?>
      });
      $('#depSaya').on('click', function (e) {
        $('#UserTable').hide(500);
        $('#departTable').show(500);
         $('#clientTable').hide(500);
         $('#teamTable').hide(500);
           $('#clientDetay').hide(500);
          $('#monTable').hide(500);
            $('#csTable').hide(500);
         $('#userSaya').removeClass('active');
         $('#clientSaya').removeClass('active');
        $('#teamSaya').removeClass('active');
        $('#depSaya').addClass('active');
        $('#sayfaDetay').removeClass('active');
        $('#monSaya').removeClass('active');
      });

      $('#monSaya').on('click', function (e) {
        $('#UserTable').hide(500);
        $('#departTable').hide(500);
         $('#clientTable').hide(500);
         $('#teamTable').hide(500);
        $('#monTable').show(500);

           $('#clientDetay').hide(500);
            $('#csTable').hide(500);
         $('#userSaya').removeClass('active');
         $('#clientSaya').removeClass('active');
        $('#teamSaya').removeClass('active');
        $('#monSaya').addClass('active');
        $('#sayfaDetay').removeClass('active');
         $('#depSaya').removeClass('active');
      });




      ////////// departman başlangıç //////
        $('.confirmation').on('click', function () {
            return confirm('Emin misiniz?');
        });


      department();
         function department()
         {
            var formDatam = new FormData();
          formDatam.append('id', <?=$_GET['id'];?>);
        // $("#backgroundLoading").removeClass("loadingDisplay");
            datam=serviscek('/departments/departmanlistesi',actionType='POST',formDatam);
            datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").removeClass("backgroundLoading");
              let donenData=JSON.parse(res.data);
              if(donenData.status==true)
                 {
                   var list='<div class="col-md-12 text-center">';
                   list+=' <a id="dep-create-modal-button" data-id="0" data-name="" class="btn btn-sm btn-round btn-primary text-white"><i class="fa fa-plus cu_button"></i><?=t('NEW DEPARTMENT ADD');?></a>';
                       list+='</div>'+(donenData.data);

                   $('#depList').html(list);
                   $('#depSay').html(donenData['depSay']);
                     $(function () {
                        $('.treex li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
                        $('.treex li.parent_li > span').on('click', function (e) {
                            var children = $(this).parent('li.parent_li').find(' > ul > li');
                            if (children.is(":visible")) {
                                children.hide('fast');
                                $(this).attr('title', 'Expand this branch').find(' > i').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
                            } else {
                                children.show('fast');
                                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
                            }
                            e.stopPropagation();
                        });
                    });
                   $('.accordian-body').on('show.bs.collapse', function () {
                        $(this).closest("table")
                            .find(".collapse.in")
                            .not(this)
                            .collapse('toggle')
                    });
                   //$('#departTable').show();
                 }
              else
                {
                   toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                     positionClass: "toast-top-right",
                     containerId: "toast-top-right"
                   });

                }

            })
               );
         }



      var depHeader = {
            "card-header-id": "dep-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Departman Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
      var depBody = {
            "card-body-id": "dep-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
               {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "parentid_cu",
                  "defaultValue":"0"
                },
               {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "clientid_cu",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
                   {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Name') ?>",
                    "id": "name_cu",
                    "url": "",
                },
                   {
                    "type": "selectbox",
                    "div-class": "col-md-4",
                    "label": "<?= t( 'Aktif') ?>",
                    "id": "active_cu",
                    "isurl": false,
                    "data": [
                      {
                        "key": "1",
                        "value": "Aktif"
                       },
                       {
                        "key": "0",
                        "value": "Pasif"
                       }
                    ]
                },

            ]
        };
      var depFooter = {
            "card-footer-id": "dep-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "dep-create-button",
                    "url": ""
                },
            ]
        };

      $('#depList').on('click','#dep-create-modal-button', function (e) {
            formBosalt(depBody);
            depHeader.data[0].title="<?= t( 'Departman Ekleme') ?>";
            depFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(depHeader, depBody, depFooter);
            $('#dep-cu-table').modal('show');
        });

         $('#departTable').on('click','#depList>ul>li.parent_li>a.depupdate', function (e) {
            formBosalt(depBody);

           console.log($(this).data("id"));
              depHeader.data[0].title="<?= t( 'Departman Güncelleme') ?>";
            depFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(depHeader, depBody, depFooter);

           $('#id_cu').val($(this).data("id"));
           $('#name_cu').val($(this).data("name"));
           $('#active_cu').val($(this).data("active"));
            $('#dep-cu-table').modal('show');
        });

        $('#departTable').on('click','#depList>ul>li.parent_li>a.subcreate', function (e) {
            formBosalt(depBody);

              depHeader.data[0].title=$(this).data("name")+" <?= t( 'Alt Departman Ekleme') ?>";
            depFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(depHeader, depBody, depFooter);
             $('#id_cu').val(0);
          $('#parentid_cu').val($(this).data("id"));
            $('#dep-cu-table').modal('show');
        });

          $('#departTable').on('click','#depList>ul>li.parent_li>ul>li>a.subupdate', function (e) {
            formBosalt(depBody);

           console.log($(this).data("id"));
              depHeader.data[0].title="<?= t( 'Alt Departman Güncelleme') ?>";
            depFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(depHeader, depBody, depFooter);

           $('#id_cu').val($(this).data("id"));
           $('#parentid_cu').val($(this).data("parent"));
           $('#name_cu').val($(this).data("name"));
           $('#active_cu').val($(this).data("active"));
            $('#dep-cu-table').modal('show');
        });

                ///////////// clienta silme işlemleri //////////
      var depDHeader = {
            "card-header-id": "dep-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Departman Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
      var depDBody = {
            "card-body-id": "dep-delete-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "id_delete",
                  "defaultValue":"0"
                },
              {
                    "type": "text",
                    "div-class": "col-md-12",
                    "id": "id_text",
                    "defaultValue":"<?=t("Silmek istediğinize emin misiniz?");?>"
                },
            ]
        };
      var depDFooter = {
            "card-footer-id": "dep-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "client-delete-button",
                    "url": ""
                },
            ]
        };
         $('#departTable').on('click','#depList>ul>li.parent_li>a.depdelete', function (e) {
            depDBody.data[0].defaultValue=$(this).data('id');
           depDHeader.data.title="<?= t( 'Departman Silme') ?>";
            formOlustur(depDHeader, depDBody, depDFooter);
            $('#dep-delete-table').modal('show');
        });
         $('#departTable').on('click','#depList>ul>li.parent_li>ul>li>a.subdelete', function (e) {
            depDBody.data[0].defaultValue=$(this).data('id');
            depDHeader.data.title="<?= t( 'Alt Departman Silme') ?>";
            formOlustur(depDHeader, depDBody, depDFooter);
            $('#dep-delete-table').modal('show');
        });





      $("#dep-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
           datam=serviscek('/departments/departmentdelete',actionType='POST', new FormData(this));
          datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").removeClass("backgroundLoading");
              let donenData=JSON.parse(res.data);
              if(donenData.status==true)
                 {
                    $('#dep-delete-table').modal('hide');
                    department();
                   tableUpdate([{"class":"clientList","url":""}]);
                      toastr.success("<center><?=t('Silme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                   });
                 }
            else
              {
                   toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                     positionClass: "toast-top-right",
                     containerId: "toast-top-right"
                   });
              }
            })
          );
            return false;
        });
      $("#dep-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            //$("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/departments/departmentcreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
               //  $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#dep-cu-table').modal('hide');
                      department();
                   }
              else
                {
                     toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                     });
                }
              })
          );
            return false;
        });
      $('.depList').on('click', 'div a.dep-update', function (e) {  /// güncelleme yapılacağında açılacak modalın içerisi dolduruluyor
            formBosalt(clientBody);
            clientHeader.data[0].title="<?= t( 'Müşteri Güncelleme') ?>";
            clientFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(clientHeader, clientBody, clientFooter);
            var formData = new FormData();
        console.log($(this).data('id'));
             formData.append('id', $(this).data('id'));
         $("#backgroundLoading").addClass("backgroundLoading");
            datam=serviscek('/client/clientdetail',actionType='POST',formData);
            datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").removeClass("backgroundLoading");
              let donenData=JSON.parse(res.data);
              if(donenData.status==true)
                 {
                   $('#id_cu').val(donenData.data[0].id);
                   $('#parentid_cu').val(donenData.data[0].parentid);
                   $('#name_cu').val(donenData.data[0].name);
                   $('#package_cu').val(donenData.data[0].package);
                   $('#title_cu').val(donenData.data[0].title);
                   $('#tax_office_cu').val(donenData.data[0].taxoffice);
                   $('#tax_no_cu').val(donenData.data[0].taxno);
                   $('#land_phone_cu').val(donenData.data[0].landphone);
                   $('#email_cu').val(donenData.data[0].email);
                   $('#adres_cu').val(donenData.data[0].address);
                    $('#sector_cu').val(donenData.data[0].branchid);
                   $('#active_cu').val(donenData.data[0].active);
                   $('#contractstartdate_cu').val(donenData.data[0].contractstartdate);
                   $('#contractfinishdate_cu').val(donenData.data[0].contractfinishdate);
                   $('#productsamount_cu').val(donenData.data[0].productsamount);
                   $('#iskdv_cu').val(donenData.data[0].iskdv);
                   $('#client-cu-table').modal('show');
                 }
              else
                {
                   toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                     positionClass: "toast-top-right",
                     containerId: "toast-top-right"
                   });

                }
            })
        );

      });

            var monListColumnArray = [
                 {"key": "name", "value": "<?= t('Bölüm') ?>"},
                {"key": "name", "value": "<?= t('Alt Bölüm') ?>"},
                 {"key": "name", "value": "<?= t('M.No') ?>"},
                {"key": "name", "value": "<?= t('Lokasyon') ?>"},
              {"key": "name", "value": "<?= t('Monitör Tipleri') ?>"},
               {"key": "name", "value": "<?= t('İzleme Noktası Yer Tanımı') ?>"},
                 {"key": "active", "value": "<?= t('Active') ?>","data":["id"],"type":"checbox"},
            ];
      var monButtonArray=[
                  {
                      "class":"btn btn-warning btn-sm mon-update",
                      "title":"<?= t( 'Güncelle'); ?>",
                      "iconClass":"fa fa-edit text-white",
                      "data":[
                          "teamname","id"
                      ]
                  },
                  {
                      "class":"btn btn-danger btn-sm mon-delete",
                      "title":"<?= t( 'Sil'); ?>",
                      "iconClass":"fa fa-trash text-white",
                      "data":[
                          "teamname","id"
                      ]
                  }
              ];
         data={clientid : '<?=$_GET['id'];?>'}
      tableList("monListTable", "monList", monListColumnArray, monButtonArray, "/monitoring/monitorlist", "POST",data, "mon","","monSay"); //listenin çekildiği fonksiyon
      var monHeader = {
            "card-header-id": "mon-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Monitör Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
      var monBody = {
            "card-body-id": "mon-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
              {
               "type": "search-selectbox",
               "div-class": "col-md-4 bolum",
               "label": "<?= t( 'Bölüm') ?>",
               "id": "dapartmentid",
               "isurl": true,
               "data": {
                   "url": "/departments/clientdepartmant?id=<?=isset($clientid)?$clientid:0;?>&type=select",
                   "key": "id",
                   "value": "name",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                   "formType": "Get",
                   "checked":null
               }
           },
          {
            "type": "search-selectbox",
            "div-class": "col-md-4",
            "label": "<?= t('Alt Bölüm') ?>",
            "id": "subid",
            "isurl": false,
            "data":{},
            'disabled':true
            },
            {
             "type": "input-number",
             "div-class": "col-md-4",
             "label": "<?= t( 'İzleme Noktası Numarası') ?>",
             "id": "mno",
             "url": "",
           },

           {
             "type": "search-selectbox",
             "div-class": "col-md-4",
             "label": "<?= t( 'Monitör Lokasyonu') ?>",
             "id": "mlocationid",
             "isurl": true,
             "data": {
                 "url": "/departments/clientdepartmant?id=<?=isset($clientid)?$clientid:0;?>&type=select",
                 "key": "id",
                 "value": "name",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                 "formType": "Get",
                 "checked":null
             }
         },
         {
          "type": "search-selectbox",
          "div-class": "col-md-4",
          "label": "<?= t( 'İzleme Noktası Tipi') ?>",
          "id": "mtypeid",
          "isurl": true,
          "data": {
              "url": "/departments/clientdepartmant?id=<?=isset($clientid)?$clientid:0;?>&type=select",
              "key": "id",
              "value": "name",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
              "formType": "Get",
              "checked":null
          }
        },
        {
         "type": "input-text",
         "div-class": "col-md-4",
         "label": "<?= t( 'İzleme Noktası Tanımı Yeri') ?>",
         "id": "definationlocation",
         "url": "",
        },
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
                {
                    "type": "input-hidden",
                    "div-class": "col-md-6",
                    "id": "clientid_cu",
                    "defaultValue":"<?=isset($clientid)?$clientid:0;?>"
                },

            ]
        };
      var monFooter = {
            "card-footer-id": "mon-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "mon-create-button",
                    "url": ""
                },
            ]
        };
      $('#monTable').on('click','#mon-create-modal-button', function (e) {
            formBosalt(monBody);
            monHeader.data[0].title="<?= t( 'Monitör Ekleme') ?>";
            monFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(monHeader, monBody, monFooter);
            $('#mon-cu-table').modal('show');
        });

        


      //////////// user başlangıç ///////////
       var userHeader = {
            "card-header-id": "user-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Kullanıcı Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
       var userBody = {
            "card-body-id": "user-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
                {
                    "type": "input-hidden",
                    "id": "clientid",
                    "defaultValue":"<?=isset($clientid)?$clientid:0;?>"
                },
                {
                    "type": "input-hidden",
                    "id": "branchid",
                    "defaultValue":"<?=isset($branchid)?$branchid:0;?>"
                },
                 {
                    "type": "input-hidden",
                    "id": "clientid",
                    "defaultValue":"<?=isset($clientid)?$clientid:0;?>"
                },
                {
                    "type": "input-hidden",
                    "id": "clientbranchid",
                    "defaultValue":"<?=isset($firmbranchid)?$firmbranchid:0;?>"
                },
                  {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Kullanıcı Tipi') ?>",
                    "id": "yetki_cu",
                    "data": [
                      {
                        "key": "0",
                        "value": "Admin",
                      },
                       {
                        "key": "1",
                        "value": "Staff",
                      }
                    ]
                },
               {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Kullanıcı Adı') ?>",
                    "id": "username_cu",
                    "url": "",
                    "required":true
                },
               {
                    "type": "input-password",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Şifre') ?>",
                    "id": "password_cu",
                    "url": "",
                    "required":false
                },
                {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Email') ?>",
                    "id": "email_cu",
                    "url": "",
                    "required":true
                },
                   {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Adı') ?>",
                    "id": "name_cu",
                    "url": "",
                    "required":true
                },
                   {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Soyadı') ?>",
                    "id": "surname_cu",
                    "url": "",
                     "required":true
                },
                 {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Doğum Yeri') ?>",
                    "id": "birth_place_cu",
                    "url": "",
                   "required":true
                },
               {
                    "type": "input-datepicker",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Doğum Tarihi') ?>",
                    "id": "birth_year_cu",
                    "url": "",
                 "required":true
                },
                {
                    "type": "selectbox",
                    "div-class": "col-md-3",
                    "label": "<?= t( 'Dil') ?>",
                    "id": "language_cu",
                    "data": [
                      {
                        "key": "1",
                        "value": "Türkçe",
                      },
                       {
                        "key": "2",
                        "value": "İngilizce",
                      }
                    ]
                },
                {
                    "type": "selectbox",
                    "div-class": "col-md-3",
                    "label": "<?= t( 'Cinsiyet') ?>",
                    "id": "genger_cu",
                    "data": [
                      {
                        "key": "0",
                        "value": "Erkek",
                      },
                       {
                        "key": "1",
                        "value": "Kadın",
                      }
                    ]
                },
                   {
                    "type": "selectbox",
                    "div-class": "col-md-3",
                    "label": "<?= t( 'Aktif/Pasif') ?>",
                    "id": "isactive_cu",
                    "data": [
                      {
                        "key": "1",
                        "value": "Aktif",
                      },
                       {
                        "key": "0",
                        "value": "Pasif",
                      }
                    ]
                },
                    {
                    "type": "selectbox",
                    "div-class": "col-md-3",
                    "label": "<?= t( 'Uygunsuzluk Maili Aktif/Pasif') ?>",
                    "id": "isemailactive_cu",
                    "data": [
                      {
                        "key": "1",
                        "value": "Aktif",
                      },
                       {
                        "key": "0",
                        "value": "Pasif",
                      }
                    ]
                },
                {
                    "type": "input-text",
                    "div-class": "col-md-3",
                    "label": "<?= t( 'Telefon') ?>",
                    "id": "phone_cu",
                    "url": "",
                  "required":true
                },
                <?php if(isset($firmbranchid)){?>
               {
                    "type": "input-color",
                    "div-class": "col-md-6",
                    "label": "<?= t('Renk') ?>",
                    "id": "color_cu",
                    "url": "",
                },

                  {
                    "type": "selectbox",
                    "div-class": "col-md-4",
                    "label": "<?= t( 'client Branch Trasfer') ?>",
                    "id": "clientbranchtransfer_cu",
                    "isurl": true,
                    "data": {
                        "url": "/client/clientusertransferlist/<?=$firmbranchid;?>",
                        "key": "id",
                        "value": "name",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                        "formType": "Get",
                        "checked":null
                    }
                }
               <?php }?>
            ]
        };
       var userFooter = {
            "card-footer-id": "user-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "user-create-button",
                    "url": ""
                },
            ]
        };
       $('#UserTable').hide(500);
       $('#userSaya').on('click', function (e) {
        $('#UserTable').show(500);
         $('#clientTable').hide(500);
         $('#teamTable').hide(500);
         $('#departTable').hide(500);
         $('#clientDetay').hide(500);
          $('#monTable').hide(500);
        $('#csTable').hide(500);
            $('#sayfaDetay').removeClass('active');
        $('#clientSaya').removeClass('active');
        $('#teamSaya').removeClass('active');
       $('#monSaya').removeClass('active');
       $('#depSaya').removeClass('active');
        $('#userSaya').addClass('active');
      });
       $('#user-create-modal-button').on('click', function (e) {
            formBosalt(userBody);
            userHeader.data[0].title="<?= t( 'Kullanıcı Ekleme') ?>";
            userFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(userHeader, userBody, userFooter);
            $('#user-cu-table').modal('show');
        });
       $('#userListTable').on('click','.userUpdate', function (e) {
            formBosalt(userBody);
            userHeader.data[0].title="<?= t( 'Kullanıcı Güncelleme') ?>";
            userFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(userHeader, userBody, userFooter);
            $("#backgroundLoading").addClass("backgroundLoading");
             var formData = new FormData();
             formData.append('userid', $(this).data("id"));
             datam=serviscek('/user/userdetay',actionType='POST', formData);
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                   //  console.log(donenData.data[0].typmem);
                     $('#user-cu-table').modal('show');
                     $('#yetki_cu').val(donenData.data[0].typmem);
                     $('#username_cu').val(donenData.data[0].username);
                     $('#email_cu').val(donenData.data[0].email);
                     $('#name_cu').val(donenData.data[0].name);
                     $('#surname_cu').val(donenData.data[0].surname);
                     $('#birth_place_cu').val(donenData.data[0].birthplace);
                     $('#birth_year_cu').val(donenData.data[0].birthdate);
                     $('#language_cu').val(donenData.data[0].userlgid);
                     $('#genger_cu').val(donenData.data[0].gender);
                     $('#isactive_cu').val(donenData.data[0].active);
                     $('#phone_cu').val(donenData.data[0].primaryphone);
                     $('#color_cu').val(donenData.data[0].color);
                     $('#id_cu').val(donenData.data[0].id);
                     $('#clientid').val(donenData.data[0].clientid);
                     $('#branchid').val(donenData.data[0].branchid);
                     $('#clientid').val(donenData.data[0].clientid);
                     $('#clientbranchid').val(donenData.data[0].clientbranchid);
                     $('#mainbranchid').val(donenData.data[0].mainbranchid);
                     $('#mainclientbranchid').val(donenData.data[0].mainclientbranchid);
                   }
              else
                {
                     toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                     });
                }
              })
          );

        });
       $("#user-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/user/usercreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      userCartList('userListTable',"<?=$_GET['id'];?>",0,0,0,"userSay");
                       $('#user-cu-table').modal('hide');
                        toastr.success("<center><?=t('Kaydetme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                   }
              else
                {
                     toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                     });
                }
              })
          );
            return false;
        });
       //////////// user bitiş ///////////
    </script>

  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
