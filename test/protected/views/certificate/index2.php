
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Certificate','',0,'certificate');?>
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
             
            <div class="card mb-4" id="certificateTable">
                <div class="card-header">
                    <span class=""> <?=t('Sertifika Listesi');?></span>
                    <a id="certificate-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Sertifika Ekle') ?></a>
                </div>

                <div class="card-body">
                    <div id="certificateListTable">
                    </div>
                </div>
            </div>
          
          
        </div>
    </div>

  




    <div class="modal fade" id="certificate-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="certificate-cu">
                  <div class="card-header" id="certificate-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="certificate-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="certificate-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="certificate-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="certificate-delete">
                  <div class="card-header" id="certificate-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="certificate-delete-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="certificate-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>

    <script>
     
  var listUrl="/certificate/certificatelist";
 

        ////liste çekme başlangıç
        var certificateListColumnArray = [
            {"key": "name", "value": "<?= t('Name') ?>"}
        ];
        listButtonArray=[
            {
                "class":"btn btn-warning btn-sm certificate-update",
                "title":"<?= t( 'Güncelle'); ?>",
                "iconClass":"fa fa-edit text-white",
                "data":[
                    "name","id"
                ]
            },
            {
                "class":"btn btn-danger btn-sm certificate-delete",
                "title":"<?= t( 'Sil'); ?>",
                "iconClass":"fa fa-trash text-white",
                "data":[
                    "name","id"
                ]
            }
        ]

        tableList("certificateListTable", "certificateList", certificateListColumnArray, listButtonArray, listUrl, "POST", null, "certificate","","certificateSay"); //listenin çekildiği fonksiyon

        //////// create update modal oluşturma //////
        var certificateHeader = {
            "card-header-id": "certificate-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Sertifika Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var certificateBody = {
            "card-body-id": "certificate-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
                   {
                    "type": "input-text",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Name') ?>",
                    "id": "name_cu",
                    "url": "",
                },
            ]
        };


        var certificateFooter = {
            "card-footer-id": "certificate-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "certificate-create-button",
                    "url": ""
                },
            ]
        };

      
        $('#certificate-create-modal-button').on('click', function (e) {
            formBosalt(certificateBody);
            certificateHeader.data[0].title="<?= t( 'Sertifika Ekleme') ?>";
            certificateFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(certificateHeader, certificateBody, certificateFooter);
            $('#certificate-cu-table').modal('show');
        });

        $("#certificate-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/certificate/certificatecreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#certificate-cu-table').modal('hide');
                     tableUpdate([{"class":"certificateList","url":""}]);
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
      
      $('.certificateList').on('click', 'div a.certificate-update', function (e) {  /// güncelleme yapılacağında açılacak modalın içerisi dolduruluyor
            formBosalt(certificateBody);
            certificateHeader.data[0].title="<?= t( 'Setifika Güncelleme') ?>";
            certificateFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(certificateHeader, certificateBody, certificateFooter);
            var formData = new FormData(); 
             formData.append('id', $(this).data('id'));
         $("#backgroundLoading").addClass("backgroundLoading");
            datam=serviscek('/certificate/certificatedetail',actionType='POST',formData);
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
                   $('#certificate-cu-table').modal('show');
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

       //////// create update modal oluşturma //////
        var certificateDHeader = {
            "card-header-id": "certificate-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Sertifika Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var certificateDBody = {
            "card-body-id": "certificate-delete-body",
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


        var certificateDFooter = {
            "card-footer-id": "certificate-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "certificate-delete-button",
                    "url": ""
                },
            ]
        };


 ///////////// firma silme işlemleri //////////
         $('.certificateList').on('click', 'div a.certificate-delete', function (e) { 
            certificateDBody.data[0].defaultValue=$(this).data('id');
            formOlustur(certificateDHeader, certificateDBody, certificateDFooter);
            $('#certificate-delete-table').modal('show');
        });
      
         $("#certificate-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
           datam=serviscek('/certificate/certificatedelete',actionType='POST', new FormData(this));
          datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").removeClass("backgroundLoading");
              let donenData=JSON.parse(res.data);
            console.log(donenData);
              if(donenData.status==true)
                 {
                    $('#certificate-delete-table').modal('hide');
                   tableUpdate([{"class":"certificateList","url":""}]);
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
      
      //////////// userlar çekiliyor ////////
      
      
    </script>

  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
