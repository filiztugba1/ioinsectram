
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Treatment Type','',0,'treatmenttype');?>
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
             
            <div class="card mb-4" id="csTable">
                <div class="card-header">
                    <span class=""> <?=t('Uygulama Tip Listesi');?></span>
                    <a id="tt-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Uygulama Tipi Ekle') ?></a>
                </div>

                <div class="card-body">
                    <div id="ttListTable">
                    </div>
                </div>
            </div>
          
          
        </div>
    </div>

  




    <div class="modal fade" id="tt-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="tt-cu">
                  <div class="card-header" id="tt-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="tt-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="tt-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="tt-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="tt-delete">
                  <div class="card-header" id="tt-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="tt-delete-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="tt-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <script>
     
  var listUrl="/treatmenttype/treatmenttypelist";
 

        ////liste çekme başlangıç
        var treatmenttypeListColumnArray = [
            {"key": "firmname", "value": "<?= t('Firma') ?>"},
            {"key": "branchname", "value": "<?= t('Firma Şube') ?>"},
            {"key": "name", "value": "<?= t('Name') ?>"},
            {"key": "isactive", "value": "<?= t('Active') ?>","data":["id"],"type":"checbox"},
        ];
        listButtonArray=[
            {
                "class":"btn btn-warning btn-sm tt-update",
                "title":"<?= t( 'Güncelle'); ?>",
                "iconClass":"fa fa-edit text-white",
                "data":[
                    "name","id"
                ]
            },
            {
                "class":"btn btn-danger btn-sm tt-delete",
                "title":"<?= t( 'Sil'); ?>",
                "iconClass":"fa fa-trash text-white",
                "data":[
                    "name","id"
                ]
            }
        ]

        tableList("ttListTable", "treatmenttypeList", treatmenttypeListColumnArray, listButtonArray, listUrl, "POST", null, "treatmenttype","","treatmenttypeSay"); //listenin çekildiği fonksiyon

        //////// create update modal oluşturma //////
        var treatmenttypeHeader = {
            "card-header-id": "tt-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygulama Tipi Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var treatmenttypeBody = {
            "card-body-id": "tt-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
                {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Firma') ?>",
                    "id": "firm_cu",
                    "isurl": true,
                    "selectAllorselect":1,
                    "data": {
                        "url": "/firm/firmlist",
                        "key": "id",
                        "value": "name",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                        "formType": "Get",
                        "checked":null
                    }
                },
                 {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Firma Şube') ?>",
                    "id": "branch_cu",
                    "isurl": false,
                    "disabled":true,
                    "data":[]
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
               "div-class": "col-md-6",
                "label": "<?=t('Aktif/Pasif') ?>",
                "id": "isactive_cu",
                "isurl": false,
                "defaultValue":"1",
                "data": [
                  {"key": "1", "value": "<?= t('Aktif') ?>"},
                  {"key": "0", "value": "<?= t('Pasif') ?>"}
                ]
              },

            ]
        };


        var treatmenttypeFooter = {
            "card-footer-id": "tt-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "tt-create-button",
                    "url": ""
                },
            ]
        };

       function isactive(obj){
             $("#backgroundLoading").removeClass("loadingDisplay");
             var formData = new FormData(); 
             formData.append('id', $(obj).data("id"));
             datam=serviscek('/treatmenttype/treatmenttypeisactive/',actionType='POST', formData);
               datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
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
 
      
        $('#tt-create-modal-button').on('click', function (e) {
            formBosalt(treatmenttypeBody);
            treatmenttypeHeader.data[0].title="<?= t( 'Uygulama Tipi Ekleme') ?>";
            treatmenttypeFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(treatmenttypeHeader, treatmenttypeBody, treatmenttypeFooter);
            $('#tt-cu-table').modal('show');
        });

        $("#tt-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
             datam=serviscek('/treatmenttype/treatmenttypecreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#tt-cu-table').modal('hide');
                     tableUpdate([{"class":"treatmenttypeList","url":""}]);
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
      
      $('.treatmenttypeList').on('click', 'div a.tt-update', function (e) {  /// güncelleme yapılacağında açılacak modalın içerisi dolduruluyor
            formBosalt(treatmenttypeBody);
            treatmenttypeHeader.data[0].title="<?= t( 'Uygulama Tipi Güncelleme') ?>";
            treatmenttypeFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(treatmenttypeHeader, treatmenttypeBody, treatmenttypeFooter);
            var formData = new FormData(); 
             formData.append('id', $(this).data('id'));
         $("#backgroundLoading").removeClass("loadingDisplay");
            datam=serviscek('/treatmenttype/treatmenttypedetail',actionType='POST',formData);
            datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").addClass("loadingDisplay");
              let donenData=JSON.parse(res.data);
              if(donenData.status==true)
                 {
                   $('#id_cu').val(donenData.data[0].id);
                   $('#firm_cu').val(donenData.data[0].firmid);
                   $('#name_cu').val(donenData.data[0].name);
                   $('#isactive_cu').val(donenData.data[0].isactive);
                
                   
                    selectOption("/firm/firmbranchlist/"+donenData.data[0].firmid, "id", "name", "GET", "branch_cu", "",donenData.data[0].branchid,"selectbox","",1);
                    selectOption("/client/clientlist/"+donenData.data[0].branchid, "id", "name", "GET", "clientbranch_cu", "",donenData.data[0].clientid,"selectbox",true,1);
                      $("#branch_cu").removeAttr('disabled');
                    $("#clientbranch_cu").removeAttr('disabled');
                   $('#tt-cu-table').modal('show');
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
        var treatmenttypeDHeader = {
            "card-header-id": "tt-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygulama Tipiu Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var treatmenttypeDBody = {
            "card-body-id": "tt-delete-body",
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


        var treatmenttypeDFooter = {
            "card-footer-id": "tt-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "tt-delete-button",
                    "url": ""
                },
            ]
        };


 ///////////// firma silme işlemleri //////////
         $('.treatmenttypeList').on('click', 'div a.tt-delete', function (e) { 
            treatmenttypeDBody.data[0].defaultValue=$(this).data('id');
            formOlustur(treatmenttypeDHeader, treatmenttypeDBody, treatmenttypeDFooter);
            $('#tt-delete-table').modal('show');
        });
      
         $("#tt-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
           datam=serviscek('/treatmenttype/treatmenttypedelete',actionType='POST', new FormData(this));
          datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").addClass("loadingDisplay");
              let donenData=JSON.parse(res.data);
            console.log(donenData);
              if(donenData.status==true)
                 {
                    $('#tt-delete-table').modal('hide');
                   tableUpdate([{"class":"treatmenttypeList","url":""}]);
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
      
      
      //////. firma listesi çekme ////
      
     $("#tt-cu-body").on('change','#firm_cu',function(){
        var value = $("#firm_cu").val();
        if(+value===0)
        {
          $("#branch_cu").prop('disabled', true);
        }
        else {
          $("#branch_cu").removeAttr('disabled');
         // var formData = JSON.stringify({faculty: value});
          //  $("#dep").select('destroy');
        }
        selectOption("/firm/firmbranchlist/"+value, "id", "name", "GET", "branch_cu", "",null,"selectbox","",1);
      });
      
    
      
      
    </script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
