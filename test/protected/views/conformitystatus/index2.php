
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity Status','',0,'conformitystatus');?>
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
                    <span class=""> <?=t('Uygunsuzluk Durum Listesi');?></span>
                    <a id="cs-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Uygunsuzluk Durumu Ekle') ?></a>
                </div>

                <div class="card-body">
                    <div id="csListTable">
                    </div>
                </div>
            </div>
          
          
        </div>
    </div>

  




    <div class="modal fade" id="cs-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="cs-cu">
                  <div class="card-header" id="cs-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="cs-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="cs-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="cs-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="cs-delete">
                  <div class="card-header" id="cs-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="cs-delete-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="cs-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <script>
     
  var listUrl="/conformitystatus/conformitystatuslist";
 

        ////liste çekme başlangıç
        var conformitystatusListColumnArray = [
            {"key": "firmname", "value": "<?= t('Firma') ?>"},
            {"key": "branchname", "value": "<?= t('Firma Şube') ?>"},
            {"key": "clientname", "value": "<?= t('Müşteri') ?>"},
            {"key": "clientbranchname", "value": "<?= t('Müşteri Şube') ?>"},
            {"key": "name", "value": "<?= t('Name') ?>"},
            {"key": "isactive", "value": "<?= t('Active') ?>","data":["id"],"type":"checbox"},
        ];
        listButtonArray=[
            {
                "class":"btn btn-warning btn-sm cs-update",
                "title":"<?= t( 'Güncelle'); ?>",
                "iconClass":"fa fa-edit text-white",
                "data":[
                    "name","id"
                ]
            },
            {
                "class":"btn btn-danger btn-sm cs-delete",
                "title":"<?= t( 'Sil'); ?>",
                "iconClass":"fa fa-trash text-white",
                "data":[
                    "name","id"
                ]
            }
        ]

        tableList("csListTable", "conformitystatusList", conformitystatusListColumnArray, listButtonArray, listUrl, "POST", null, "conformitystatus","","conformitystatusSay"); //listenin çekildiği fonksiyon

        //////// create update modal oluşturma //////
        var conformitystatusHeader = {
            "card-header-id": "cs-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Durumu Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var conformitystatusBody = {
            "card-body-id": "cs-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "id_cu",
                  "defaultValue":"0"
                },
               {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "btncolor_cu",
                  "defaultValue":"default"
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


        var conformitystatusFooter = {
            "card-footer-id": "cs-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "cs-create-button",
                    "url": ""
                },
            ]
        };

       function isactive(obj){
             $("#backgroundLoading").addClass("backgroundLoading");
             var formData = new FormData(); 
             formData.append('id', $(obj).data("id"));
             datam=serviscek('/conformitystatus/conformitystatusisactive/',actionType='POST', formData);
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
 
      
        $('#cs-create-modal-button').on('click', function (e) {
            formBosalt(conformitystatusBody);
            conformitystatusHeader.data[0].title="<?= t( 'Uygunsuzluk Durum Ekleme') ?>";
            conformitystatusFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(conformitystatusHeader, conformitystatusBody, conformitystatusFooter);
            $('#cs-cu-table').modal('show');
        });

        $("#cs-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/conformitystatus/conformitystatuscreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#cs-cu-table').modal('hide');
                     tableUpdate([{"class":"conformitystatusList","url":""}]);
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
      
      $('.conformitystatusList').on('click', 'div a.cs-update', function (e) {  /// güncelleme yapılacağında açılacak modalın içerisi dolduruluyor
            formBosalt(conformitystatusBody);
            conformitystatusHeader.data[0].title="<?= t( 'Uygunsuzluk Durum Güncelleme') ?>";
            conformitystatusFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(conformitystatusHeader, conformitystatusBody, conformitystatusFooter);
            var formData = new FormData(); 
             formData.append('id', $(this).data('id'));
         $("#backgroundLoading").addClass("backgroundLoading");
            datam=serviscek('/conformitystatus/conformitystatusdetail',actionType='POST',formData);
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
                   $('#cs-cu-table').modal('show');
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
        var conformitystatusDHeader = {
            "card-header-id": "cs-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Durumu Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var conformitystatusDBody = {
            "card-body-id": "cs-delete-body",
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


        var conformitystatusDFooter = {
            "card-footer-id": "cs-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "cs-delete-button",
                    "url": ""
                },
            ]
        };


 ///////////// firma silme işlemleri //////////
         $('.conformitystatusList').on('click', 'div a.cs-delete', function (e) { 
            conformitystatusDBody.data[0].defaultValue=$(this).data('id');
            formOlustur(conformitystatusDHeader, conformitystatusDBody, conformitystatusDFooter);
            $('#cs-delete-table').modal('show');
        });
      
         $("#cs-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
           datam=serviscek('/conformitystatus/conformitystatusdelete',actionType='POST', new FormData(this));
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
                    $('#cs-delete-table').modal('hide');
                   tableUpdate([{"class":"conformitystatusList","url":""}]);
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
      
     $("#cs-cu-body").on('change','#firm_cu',function(){
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
      
      $("#cs-cu-body").on('change','#branch_cu',function(){
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
