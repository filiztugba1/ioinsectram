
<!-- Sayfada neredeyiz -->
<?php if(isset($firmdetay)){?>
<?=User::model()->geturl('Firm','Branch',$_GET['id'],'firm/index');?>
<?php }else{?>
<?=User::model()->geturl('Firm','',0,'firm');?>
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
              <?php if(isset($firmdetay)){?>
                <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12">
                     <div class="card">
                        <div class="card-header" style="">
                           <ul class="nav nav-tabs">
                             <li class="nav-item">
                               <a id="firmSaya" class="nav-link active"  >
                                 <span id="firmSay" class="btn-effect2" style="font-size: 15px;"></span> <?=t('Branch');?>
                               </a>
                             </li>
                             <li class="nav-item">
                               <a id="userSaya" class="nav-link" >
                                 <span id="userSay"  class="btn-effect2" style="font-size: 15px;"></span> <?=t('Staff');?>
                               </a>
                             </li>
                          </ul>
                        </div>
                      </div>
                  </div>
                </div>
             <div class="card mb-4" id="UserTable">
                <div class="card-header">
                    <span class=""> <?php echo $firmdetay["name"].' '.t('User List');?></span>
                    <a id="user-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Add User') ?></a>
                </div>

                <div class="card-body">
                    <div id="userListTable" class="row">
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="card mb-4" id="firmmTable">
                <div class="card-header">
                    <span class=""> <?php if(isset($firmdetay)){echo $firmdetay["name"].' '.t('Branch List');  }else{ echo t('Firma Listesi'); }?></span>
                    <?php if(Yii::app()->user->checkAccess('firm.create') || (isset($firmid) && Yii::app()->user->checkAccess('firm.branch.create'))){?>
                  <a id="firm-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Add Firm') ?></a>
                   <?php }?>
                </div>
                 <?php if(Yii::app()->user->checkAccess('firm.view') || (isset($firmid) && Yii::app()->user->checkAccess('firm.branch.view'))){?>
                <div class="card-body">
                    <div id="firmListTable">
                    </div>
                </div>
              <?php }?>
            </div>
          
          
        </div>
    </div>

  



 <?php if (Yii::app()->user->checkAccess('firm.create') || Yii::app()->user->checkAccess('firm.update') || (isset($firmid) && (Yii::app()->user->checkAccess('firm.branch.create') || Yii::app()->user->checkAccess('firm.branch.update')))){ ?>
    <div class="modal fade" id="firm-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="firm-cu">
                  <div class="card-header" id="firm-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="firm-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="firm-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>

  <?php if (Yii::app()->user->checkAccess('firm.delete') || (isset($firmid) && Yii::app()->user->checkAccess('firm.branch.delete'))){ ?>
    <div class="modal fade" id="firm-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="firm-delete">
                  <div class="card-header" id="firm-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="firm-delete-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="firm-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
<?php }?>
  <?php if (Yii::app()->user->checkAccess('firm.staff.view')){ ?>
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
    <script>
      firmListColumnArrayUrl="";
  var listUrl="";
      <?php if(isset($firmid)){?>
        listUrl="/firm/branchlist/<?=$firmid;?>";
      firmListColumnArrayUrl="/client/index";
      <?php }else if(isset($firmbranchid)){?>
        listUrl="/client/clientlist/<?=$firmbranchid;?>";
      
      <?php }else{?>
      listUrl="/firm/firmlist";
       firmListColumnArrayUrl="/firm/branch";
      <?php }?>

        ////liste çekme başlangıç
        <?php if(Yii::app()->user->checkAccess('firm.view') || (isset($firmid) && Yii::app()->user->checkAccess('firm.branch.view'))){?>
        var firmListColumnArray = [
            {"key": "name", "value": "<?= t('Name') ?>","data":["id"],"type":"url","url":firmListColumnArrayUrl},
            <?php if(!(isset($firmid) || isset($firmbranchid))){?>{"key": "package", "value": "<?= t('Package') ?>"},<?php }?>
            {"key": "time", "value": "<?= t('Created Time') ?>"},
           {"key": "active", "value": "<?= t('Active') ?>","data":["id"],"type":"checbox"},
        ];
        listButtonArray=[
          <?php if(Yii::app()->user->checkAccess('firm.update') || (isset($firmid) && Yii::app()->user->checkAccess('firm.branch.update'))){?>
            {
                "class":"btn btn-warning btn-sm firm-update",
                "title":"<?= t( 'Güncelle'); ?>",
                "iconClass":"fa fa-edit text-white",
                "data":[
                    "name","id"
                ]
            },
          <?php }?>
           <?php if(Yii::app()->user->checkAccess('firm.delete') || (isset($firmid) && Yii::app()->user->checkAccess('firm.branch.delete'))){?>
            {
                "class":"btn btn-danger btn-sm firm-delete",
                "title":"<?= t( 'Sil'); ?>",
                "iconClass":"fa fa-trash text-white",
                "data":[
                    "name","id"
                ]
            }
           <?php }?>
        ]

        tableList("firmListTable", "firmList", firmListColumnArray, listButtonArray, listUrl, "POST", null, "firm","","firmSay"); //listenin çekildiği fonksiyon
      <?php }?>
        //////// create update modal oluşturma //////
      <?php if (Yii::app()->user->checkAccess('firm.create') || Yii::app()->user->checkAccess('firm.update') || (isset($firmid) && (Yii::app()->user->checkAccess('firm.branch.create') || Yii::app()->user->checkAccess('firm.branch.update')))){ ?>
        var firmHeader = {
            "card-header-id": "firm-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Firm Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var firmBody = {
            "card-body-id": "firm-cu-body",
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
                    "id": "parent_cu",
                    "defaultValue":"<?=isset($firmid)?$firmid:0;?>"
                },
                   {
                    "type": "input-text",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Name') ?>",
                    "id": "name_cu",
                    "url": "",
                },
              <?php if(!(isset($firmid) || isset($firmbranchid))){?>
                   {
                    "type": "search-selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Package') ?>",
                    "id": "package_cu",
                    "isurl": true,
                    "data": {
                        "url": "/packages/packages?type=select",
                        "key": "code",
                        "value": "name",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                        "formType": "Get",
                        "checked":null
                    }
                },
              <?php }?>
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
         
            ]
        };
        var firmFooter = {
            "card-footer-id": "firm-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "firm-create-button",
                    "url": ""
                },
            ]
        };

        function isactive(obj){
             $("#backgroundLoading").addClass("backgroundLoading");
             var formData = new FormData(); 
             formData.append('id', $(obj).data("id"));
             datam=serviscek('/firm/firmisactive/',actionType='POST', formData);
               datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                     tableUpdate([{"class":"firmList","url":""}]);
                        toastr.success("<center><?=t('Kaydetme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                   }
              else
                {
                   tableUpdate([{"class":"firmList","url":""}]);
                     toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                     });
                }
              })
          );
        }
 
        $('#firm-create-modal-button').on('click', function (e) {
            formBosalt(firmBody);
            firmHeader.data[0].title="<?= t( 'Firma Ekleme') ?>";
            firmFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(firmHeader, firmBody, firmFooter);
            $('#firm-cu-table').modal('show');
        });

        $("#firm-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/firm/firmcreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#firm-cu-table').modal('hide');
                     tableUpdate([{"class":"firmList","url":""}]);
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
      
      $('.firmList').on('click', 'div a.firm-update', function (e) {  /// güncelleme yapılacağında açılacak modalın içerisi dolduruluyor
            formBosalt(firmBody);
            firmHeader.data[0].title="<?= t( 'Firma Güncelleme') ?>";
            firmFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(firmHeader, firmBody, firmFooter);
            var formData = new FormData(); 
             formData.append('id', $(this).data('id'));
         $("#backgroundLoading").addClass("backgroundLoading");
            datam=serviscek('/firm/firmdetail',actionType='POST',formData);
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
                   $('#firm-cu-table').modal('show');
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
      <?php }?>
       //////// create update modal oluşturma //////
      <?php if (Yii::app()->user->checkAccess('firm.delete') || (isset($firmid) && Yii::app()->user->checkAccess('firm.branch.delete'))){ ?>
        var firmDHeader = {
            "card-header-id": "firm-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Firm Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var firmDBody = {
            "card-body-id": "firm-delete-body",
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
        var firmDFooter = {
            "card-footer-id": "firm-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "firm-delete-button",
                    "url": ""
                },
            ]
        };

 ///////////// firma silme işlemleri //////////
         $('.firmList').on('click', 'div a.firm-delete', function (e) { 
            firmDBody.data[0].defaultValue=$(this).data('id');
            formOlustur(firmDHeader, firmDBody, firmDFooter);
            $('#firm-delete-table').modal('show');
        });
      
         $("#firm-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
           datam=serviscek('/firm/newfirmdelete',actionType='POST', new FormData(this));
          datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").removeClass("backgroundLoading");
              let donenData=JSON.parse(res.data);
            
                    $('#firm-delete-table').modal('hide');
              if(donenData.status==true)
                 {
                   tableUpdate([{"class":"firmList","url":""}]);
                      toastr.success("<center><?=t('Silme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                       positionClass: "toast-top-right",
                       containerId: "toast-top-right"
                   });
                 }
            else
              {
                   toastr.error("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                     positionClass: "toast-top-right",
                     containerId: "toast-top-right"
                   });
              }
            })
          );
            return false;
        });
      <?php }?>
      
      //////////// userlar çekiliyor ////////
      
      
  <?php if(isset($firmdetay)){?>
    userCartList('userListTable',"<?=$_GET['id'];?>",0,0,0,"userSay");
     $('#UserTable').hide(500);
      $('#userSaya').on('click', function (e) {
        $('#UserTable').show(500);
        $('#firmmTable').hide(500);
        $('#firmSaya').removeClass('active');
        $('#userSaya').addClass('active');
      });
      
      $('#firmSaya').on('click', function (e) {
        $('#UserTable').hide(500);
        $('#firmmTable').show(500);
         $('#userSaya').removeClass('active');
        $('#firmSaya').addClass('active');
      });
      
      
      <?php if (Yii::app()->user->checkAccess('firm.staff.create') || Yii::app()->user->checkAccess('firm.staff.update')){ ?>
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
                    "id": "firmid",
                    "defaultValue":"<?=isset($firmid)?$firmid:0;?>"
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
                    "defaultValue":"<?=isset($clientbranchid)?$clientbranchid:0;?>"
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
                    "label": "<?= t( 'Firm Branch Trasfer') ?>",
                    "id": "firmbranchtransfer_cu",
                    "isurl": true,
                    "data": {
                        "url": "/firm/firmusertransferlist/<?=$firmbranchid;?>",
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
                     $('#firmid').val(donenData.data[0].firmid);
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
      <?php }}?>
      
      
    </script>


  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
