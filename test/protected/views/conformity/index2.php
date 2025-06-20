
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity','',0,'conformity');?>
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
          
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="text-primary"><i
                            class="feather icon-alert-triangle"></i> <?= t('Uygunsuzluk Durumları') ?>!</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                           <div class="col-md-3" style="text-align: center;padding: 2px;">
                             <a  data-id="" class="btn btn-secondary btn-xs conStatus" style="width: 100%;color:#fff"><span>All</span></a>
                           </div>
                          
                          <?php if(isset($status) && !empty($status['data'])){
                          foreach($status['data'] as $statuss){?>
                          <div class="col-md-3" style="text-align: center;padding: 2px;">
                             <a  data-id="<?=$statuss['id'];?>" class="btn btn-<?=$statuss['btncolor'];?> btn-xs conStatus" style="width: 100%;"><span><?=$statuss['name'];?></span></a>
                           </div>
                         
                          <?php }}?>
                    </div>
                </div>
            </div>
             
          
             
            <div class="card mb-4" id="csTable">
                <div class="card-header">
                    <span class=""> <?=t('Uygulama Tip Listesi');?></span>
                    <a id="c-create-modal-button" class="btn btn-sm btn-round btn-primary text-white float-right ml-3">
                        <i class="fa fa-plus cu_button"></i><?= t('Uygunsuzluk Ekle') ?></a>
                </div>

                <div class="card-body">
                    <div id="cListTable">
                    </div>
                </div>
            </div>
          
          
        </div>
    </div>

  




    <div class="modal fade" id="c-cu-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="c-cu">
                  <div class="card-header" id="c-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="c-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="c-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="c-delete-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="c-delete">
                  <div class="card-header" id="c-delete-header"></div>
                      <div class="card-body">
                        <div class="row" id="c-delete-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="c-delete-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>

<style>
  .btnActive{
        box-shadow: 0px 0px 9px 2px;
        border: none !important;
  }
</style>
    <script>
     
       var listUrl="/conformity/conformitylist";
 

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

        tableList("cListTable", "conformityList", conformityListColumnArray, null, listUrl, "POST", null, "conformity","","conformitySay"); //listenin çekildiği fonksiyon
          $('.conformityList').on( 'select.dt', function ( e, dt, type, indexes ) {
                 var data = dt.rows(indexes).data();
                  window.open('<?=Yii::app()->baseUrl?>/conformity/activity/'+data["0"]["id"], '_blank');
          } );

        //////// create update modal oluşturma //////
        var conformityHeader = {
            "card-header-id": "c-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Ekleme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var conformityBody = {
            "card-body-id": "c-cu-body",
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
                    "required":true,
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
                    "required":true,
                    "isurl": false,
                    "disabled":true,
                    "data":[]
                },
                {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Müşteri') ?>",
                    "id": "clientbranch_cu",
                    "required":true,
                    "isurl": false,
                    "disabled":true,
                    "data":[]
                },
                {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Bölüm') ?>",
                    "id": "department_cu",
                    "required":true,
                    "isurl": false,
                    "disabled":true,
                    "data":[]
                },
              {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Alt Bölüm') ?>",
                    "id": "subdepartment_cu",
                    "isurl": false,
                    "disabled":true,
                    "data":[]
                },
               {
                    "type": "selectbox",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Uygunsuzluk Tipi') ?>",
                    "id": "type_cu",
                    "isurl": false,
                    "disabled":true,
                    "data":[]
                },
                 {
                "type": "selectbox",
               "div-class": "col-md-6",
                "label": "<?=t('Derecesi') ?>",
                "id": "priority_cu",
                "isurl": false,
                "defaultValue":"1",
                "data": [
                  {"key": "1", "value": "1.<?= t('Derece') ?>"},
                  {"key": "2", "value": "2.<?= t('Derece') ?>"},
                  {"key": "3", "value": "3.<?= t('Derece') ?>"},
                  {"key": "4", "value": "4.<?= t('Derece') ?>"},
                ]
              },
                {
                    "type": "input-datepicker",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Tarih') ?>",
                    "id": "date_cu",
                    "required":true,
                    "isurl": false,
                    "disabled":false,
                },
               {
                    "type": "input-file",
                    "div-class": "col-md-6",
                    "label": "<?= t( 'Dosya Yükle') ?>",
                    "id": "filesf_cu",
                    "isurl": false,
                    "disabled":false,
                },
              
                 {
                    "type": "textarea",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Tanım') ?>",
                    "id": "definition_cu",
                },
                {
                    "type": "textarea",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Öneri / Önleyici Faaliyet') ?>",
                    "id": "suggestion_cu",
                },
           

            ]
        };


        var conformityFooter = {
            "card-footer-id": "c-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Ekle') ?>",
                    "icon": "icon",
                    "id": "c-create-button",
                    "url": ""
                },
            ]
        };

      
        $('#c-create-modal-button').on('click', function (e) {
            formBosalt(conformityBody);
            conformityHeader.data[0].title="<?= t( 'Uygunsuzluk Ekleme') ?>";
            conformityFooter.data[0].title="<?= t( 'Ekle') ?>";
            formOlustur(conformityHeader, conformityBody, conformityFooter);
            $('#c-cu-table').modal('show');
        });

        $("#c-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").addClass("backgroundLoading");
             datam=serviscek('/conformity/conformitycreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#c-cu-table').modal('hide');
                     tableUpdate([{"class":"conformityList","url":""}]);
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
      
      $('.conStatus').on('click', function (e) { 
       tableUpdate([{"class":"conformityList","url":listUrl+'?status='+$(this).data('id')}]);
      });
      

       //////// create update modal oluşturma //////
        var conformityDHeader = {
            "card-header-id": "c-delete-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Silme') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }

            ]
        };
        var conformityDBody = {
            "card-body-id": "c-delete-body",
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


        var conformityDFooter = {
            "card-footer-id": "c-delete-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-round btn-primary text-white float-right ml-3",
                    "title": "<?= t( 'Sil') ?>",
                    "icon": "icon",
                    "id": "c-delete-button",
                    "url": ""
                },
            ]
        };

      
      
      //////. firma listesi çekme ////
      
     $("#c-cu-body").on('change','#firm_cu',function(){
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
        selectOption("/firm/branchlist/"+value, "id", "name", "GET", "branch_cu", "",null,"selectbox","",1);
      });
      
     $("#c-cu-body").on('change','#branch_cu',function(){
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
      
     $("#c-cu-body").on('change','#clientbranch_cu',function(){
        var value = $("#clientbranch_cu").val();
        if(+value===0)
        {
          $("#department_cu").prop('disabled', true);
          $("#type_cu").prop('disabled', true);
        }
        else {
          $("#department_cu").removeAttr('disabled');
         $("#type_cu").removeAttr('disabled');
          //  $("#dep").select('destroy');
        }
       var formData=new FormData();
       formData.append('clientid',value);
       formData.append('parentid',0);
       
     //   var formData = JSON.stringify({clientid: value,parentid:0});
        selectOption("/departments/departmentlist", "id", "name", "POST", "department_cu", formData,null,"selectbox",false,1);
        selectOption("/conformitytype/conformitytypelist", "id", "name", "POST", "type_cu", formData,null,"selectbox",false,1);
    
     });
      
   $("#c-cu-body").on('change','#department_cu',function(){
        var value = $("#department_cu").val();
        if(+value===0)
        {
          $("#subdepartment_cu").prop('disabled', true);
        }
        else {
          $("#subdepartment_cu").removeAttr('disabled');
         
          //  $("#dep").select('destroy');
        }
       var formData=new FormData();
       formData.append('parentid',value);
       
     //   var formData = JSON.stringify({clientid: value,parentid:0});
        selectOption("/departments/departmentlist", "id", "name", "POST", "subdepartment_cu", formData,null,"selectbox",false,1);
   });
    
    
      
      
    </script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
