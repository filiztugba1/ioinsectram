
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity Type','',0,'conformitytype');?>
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
                    <span class=""> <?=t('Uygunsuzluk Tip Listesi');?></span>
                    <a id="ct-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Uygunsuzluk Tipi Ekle') ?></a>
                </div>

                <div class="card-body">
                    <div id="csListTable">
                    </div>
                </div>
            </div>
          
          
        </div>
    </div>

  




    <div class="modal fade" id="ct-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="ct-cu">
                  <div class="card-header" id="ct-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="ct-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="ct-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ct-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="ct-delete">
                  <div class="card-header" id="ct-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="ct-delete-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="ct-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <script>
     
  var listUrl="/conformitytype/conformitytypelist";
 

        ////liste çekme başlangıç
        var conformitytypeListColumnArray = [
            {"key": "firmname", "value": "<?= t('Firma') ?>"},
            {"key": "branchname", "value": "<?= t('Firma Şube') ?>"},
            {"key": "clientname", "value": "<?= t('Müşteri') ?>"},
            {"key": "clientbranchname", "value": "<?= t('Müşteri Şube') ?>"},
            {"key": "name", "value": "<?= t('Name') ?>"},
            {"key": "isactive", "value": "<?= t('Active') ?>","data":["id"],"type":"checbox"},
        ];
        listButtonArray=[
            {
                "class":"btn btn-warning btn-sm ct-update",
                "title":"<?= t( 'Güncelle'); ?>",
                "iconClass":"fa fa-edit text-white",
                "data":[
                    "name","id"
                ]
            },
            {
                "class":"btn btn-danger btn-sm ct-delete",
                "title":"<?= t( 'Sil'); ?>",
                "iconClass":"fa fa-trash text-white",
                "data":[
                    "name","id"
                ]
            }
        ]

        tableList("csListTable", "conformitytypeList", conformitytypeListColumnArray, listButtonArray, listUrl, "POST", null, "conformitytype","","conformitytypeSay"); //listenin çekildiği fonksiyon

        //////// create update modal oluşturma //////
        var conformitytypeHeader = {
            "card-header-id": "ct-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Tipi Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var conformitytypeBody = {
            "card-body-id": "ct-cu-body",
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
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Müşteri / Müşteri şube') ?>",
                    "id": "clientbranch_cu",
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


        var conformitytypeFooter = {
            "card-footer-id": "ct-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "ct-create-button",
                    "url": ""
                },
            ]
        };

       function isactive(obj){
             $("#backgroundLoading").addClass("backgroundLoading");
             var formData = new FormData(); 
             formData.append('id', $(obj).data("id"));
             datam=serviscek('/conformitytype/conformitytypeisactive/',actionType='POST', formData);
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
 
      
        $('#ct-create-modal-button').on('click', function (e) {
            formBosalt(conformitytypeBody);
            conformitytypeHeader.data[0].title="<?= t( 'Uygunsuzluk Tipi Ekleme') ?>";
            conformitytypeFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(conformitytypeHeader, conformitytypeBody, conformitytypeFooter);
            $('#ct-cu-table').modal('show');
        });

        $("#ct-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/conformitytype/conformitytypecreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#ct-cu-table').modal('hide');
                     tableUpdate([{"class":"conformitytypeList","url":""}]);
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
      
      $('.conformitytypeList').on('click', 'div a.ct-update', function (e) {  /// güncelleme yapılacağında açılacak modalın içerisi dolduruluyor
            formBosalt(conformitytypeBody);
            conformitytypeHeader.data[0].title="<?= t( 'Uygunsuzluk Tipi Güncelleme') ?>";
            conformitytypeFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(conformitytypeHeader, conformitytypeBody, conformitytypeFooter);
            var formData = new FormData(); 
             formData.append('id', $(this).data('id'));
         $("#backgroundLoading").addClass("backgroundLoading");
            datam=serviscek('/conformitytype/conformitytypedetail',actionType='POST',formData);
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
                   $('#firm_cu').val(donenData.data[0].firmid);
                   $('#name_cu').val(donenData.data[0].name);
                   $('#isactive_cu').val(donenData.data[0].isactive);
                
                   
                    selectOption("/firm/firmbranchlist/"+donenData.data[0].firmid, "id", "name", "GET", "branch_cu", "",donenData.data[0].branchid,"selectbox","",1);
                    selectOption("/client/clientlist/"+donenData.data[0].branchid, "id", "name", "GET", "clientbranch_cu", "",donenData.data[0].clientid,"selectbox",true,1);
                      $("#branch_cu").removeAttr('disabled');
                    $("#clientbranch_cu").removeAttr('disabled');
                   $('#ct-cu-table').modal('show');
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
        var conformitytypeDHeader = {
            "card-header-id": "ct-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Tipi Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var conformitytypeDBody = {
            "card-body-id": "ct-delete-body",
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


        var conformitytypeDFooter = {
            "card-footer-id": "ct-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "ct-delete-button",
                    "url": ""
                },
            ]
        };


 ///////////// firma silme işlemleri //////////
         $('.conformitytypeList').on('click', 'div a.ct-delete', function (e) { 
            conformitytypeDBody.data[0].defaultValue=$(this).data('id');
            formOlustur(conformitytypeDHeader, conformitytypeDBody, conformitytypeDFooter);
            $('#ct-delete-table').modal('show');
        });
      
         $("#ct-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
           datam=serviscek('/conformitytype/conformitytypedelete',actionType='POST', new FormData(this));
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
                    $('#ct-delete-table').modal('hide');
                   tableUpdate([{"class":"conformitytypeList","url":""}]);
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
      
     $("#ct-cu-body").on('change','#firm_cu',function(){
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
      
      $("#ct-cu-body").on('change','#branch_cu',function(){
        var value = $("#branch_cu").val();
        if(+value===0)
        {
          $("#clientbranch_cu").prop('disabled', true);
        }
        else {
          $("#clientbranch_cu").removeAttr('disabled');
         // var formData = JSON.stringify({faculty: value});
          //  $("#dep").select('destroy');
        }
        selectOption("/client/clientlist/"+value, "id", "name", "GET", "clientbranch_cu", "",null,"selectbox",true,1);
      });

      
      
    </script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
