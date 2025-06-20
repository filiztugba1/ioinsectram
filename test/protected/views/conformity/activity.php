
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity','Activity',$_GET['id'],'conformity');?>
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
                    <span class=""> <?=t('Öneri - Uygunsuzluk Bilgisi');?></span>
                   <a id="c-delete-modal-button" class="btn btn-sm btn-round btn-danger text-white float-right">
                        <i class="fa fa-edit cu_button"></i><?= t('Sil') ?></a>
                  
                    <a id="c-update-modal-button" class="btn btn-sm btn-round btn-warning text-white float-right">
                        <i class="fa fa-edit cu_button"></i><?= t('Güncelle') ?></a>
                   
                </div>

                <div class="card-body">
                    <div class="row" id="cdetail" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
							       
                  </div>
                   <div class="row" id="uygunsuzlukAtama">
							   </div>  
             </div>
          </div>
          
        <!------ BU KISIM CLİENTLERDE CIKACAK CLİENTLER ATAMA VEYA DEADLİNE GİRECEK --->  
            <div class="card mb-4" id="faaliyet-modal">
             
                  <div class="card-header" id="faaliyet-cu-header"></div>
                        <form id="faaliyet-cu">
                          <div class="card-body">
                        
                        <div class="row" id="faaliyet-cu-body"></div>
                        
                        </div>
                       <div class="card-footer">
                        <div class="row" id="faaliyet-cu-footer"></div>
                    </div>
                </form>
          </div>
          
      <div class="modal fade" id="assign-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="assign">
                  <div class="card-header" id="assign-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="assign-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="assign-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
          
   <div class="modal fade" id="returnassign-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="returnassign">
                  <div class="card-header" id="returnassign-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="returnassign-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="returnassign-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
          
    <div class="modal fade" id="nok-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="nok">
                  <div class="card-header" id="nok-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="nok-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="nok-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
          
   <div class="modal fade" id="ok-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="ok">
                  <div class="card-header" id="ok-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="ok-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="ok-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
          
    <div class="modal fade" id="kapanma-table" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <form id="kapanma-form">
                  <div class="card-header" id="kapanma-cu-header"></div>
                      <div class="card-body">
                        <div class="row" id="kapanma-cu-body"></div>
                        
                    </div>
                       <div class="card-footer">
                        <div class="row" id="kapanma-cu-footer"></div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
         
          
       <div class="card mb-4" id="etkinlik-table">
             
                  <div class="card-header" id="etkinlik-cu-header"></div>
                        <form id="etkinlik-cu">
                          <div class="card-body">
                          <div class="row">
                            <label class="col-md-2" for="basicSelect">Etkinlik Değerlendirmesi Gerekiyor mu ?</label>

                           <div class="row col-md-10 col-sm-10">

                              <p style="margin: 6px;">
                              <input type="radio" name="yes_no" id="close" value="0" checked=""> Hayır
                              </p>

                              <p style="margin: 6px;">
                              <input type="radio" name="yes_no" id="open" value="1"> Evet
                              </p>


                          </div>
						            </div>
                        <div class="row" id="etkinlik-cu-body"></div>
                        
                        </div>
                       <div class="card-footer">
                        <div class="row" id="etkinlik-cu-footer"></div>
                    </div>
                </form>
          </div>
          
      
     <!------ BU KISIM CLİENTLERDE CIKACAK CLİENTLER ATAMA VEYA DEADLİNE GİRECEK VE BİTİŞ--->      
          
          
          
         
          
          
         <!--   <div class="card mb-4">
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

-->
          
          
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
  .resimYok{
    background: #878787;
    text-align: center;
    padding: 50px 0 50px 0px;
    font-size: 20px;
    font-family: 'Open Sans';
    color: #e5e5e5;
  }
</style>
    <script>
        var faaliyetHeader = {
            "card-header-id": "faaliyet-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Faliyet Bitiriliş Tarihi') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }
            ]
        };
        var faaliyetBody = {
            "card-body-id": "faaliyet-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "conformityid_cu",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
              
                {
                    "type": "input-datepicker",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Termin Tarihi') ?>",
                    "id": "date_cu",
                    "url": "",
                },
               {
                    "type": "textarea",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Faaliyet Tanımı') ?>",
                    "id": "definition_cu",
                    "url": "",
                },
         
            ]
        };
        var faaliyetFooter = {
            "card-footer-id": "faaliyet-cu-footer", 
          data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-sm btn-round btn-primary text-white float-right",
                    "title": "<?= t( 'Kaydet') ?>",
                    "icon": "fa fa-floppy-o cu_button",
                    "id": "faaliyet-create-button",
                    "url": ""
                },
            ]
        };
      $("#faaliyet-modal").hide();
      
      //// atama form baaşlangıç ////
        var assignHeader = {
            "card-header-id": "assign-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Kullanıcıya uygunsuzluk atama') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                },
            ]
        };
        var assignBody = {
            "card-body-id": "assign-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "conformityid_as",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
                 {
                    "type": "selectbox",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Kullanıcılar') ?>",
                    "id": "conformityassignusers_id",
                    "isurl": true,
                   "required":true,
                    "data": {
                        "url": "/conformity/conformityassignusers/<?=$_GET['id'];?>",
                        "key": "id",
                        "value": "nameSurname",      ////eğer gelen değer list içinde list geliyorsa hangisi ekranda gösterilecek onu belirler
                        "formType": "post",
                        "checked":null
                    }
                },
         
            ]
        };
        var assignFooter = {
            "card-footer-id": "assign-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-sm btn-round btn-primary text-white float-right",
                    "title": "<?= t( 'Kaydet') ?>",
                    "icon": "fa fa-floppy-o cu_button",
                    "id": "assign-create-button",
                    "url": ""
                },
            ]
        };
      
      //// atama için form bitti /////
      
      
        //// return form baaşlangıç ////
        var returnassignHeader = {
            "card-header-id": "returnassign-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Geri Gönderme Nedeni') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                },
            ]
        };
        var returnassignBody = {
            "card-body-id": "returnassign-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "conformityid_as",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
               {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "returnassign_as",
                  "defaultValue":""
                },
                  {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "senderuser_as",
                  "defaultValue":""
                },
                 {
                    "type": "textarea",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Tanım') ?>",
                    "id": "returnaassignmessage_as",
                    "url": "",
                },
         
            ]
        };
        var returnassignFooter = {
            "card-footer-id": "returnassign-cu-footer", data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-sm btn-round btn-primary text-white float-right",
                    "title": "<?= t( 'Kaydet') ?>",
                    "icon": "fa fa-floppy-o cu_button",
                    "id": "returnassign-create-button",
                    "url": ""
                },
            ]
        };
      
      //// return için form bitti /////
      
      
      ///// nok-tamamlanmadı form başlangıç ////
         var nokHeader = {
            "card-header-id": "nok-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Kapatılmama Nedeni') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }
            ]
        };
        var nokBody = {
            "card-body-id": "nok-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "nokconformityid_cu",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
              
                {
                    "type": "input-datepicker",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Nok Tarihi') ?>",
                    "id": "nokdate_cu",
                    "defaultValue":"<?=date('Y-m-d');?>"
                },
               {
                    "type": "textarea",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Nok Tanımı') ?>",
                    "id": "nokdefinition_cu",
                    "url": "",
                },
         
            ]
        };
        var nokFooter = {
            "card-footer-id": "nok-cu-footer", 
          data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-sm btn-round btn-primary text-white float-right",
                    "title": "<?= t( 'Kaydet') ?>",
                    "icon": "fa fa-floppy-o cu_button",
                    "id": "nok-create-button",
                    "url": ""
                },
            ]
        };
      
      //// nok-tamamlanmadı form bitiş /////
      
        ///// ok-tamamlanmadı form başlangıç ////
         var okHeader = {
            "card-header-id": "ok-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t('Ok- Tarih') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }
            ]
        };
        var okBody = {
            "card-body-id": "ok-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "okconformityid_cu",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
              
                {
                    "type": "input-datepicker",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Ok Tarihi') ?>",
                    "id": "okdate_cu",
                    "defaultValue":"<?=date('Y-m-d');?>"
                },
         
            ]
        };
        var okFooter = {
            "card-footer-id": "ok-cu-footer", 
          data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-sm btn-round btn-primary text-white float-right",
                    "title": "<?= t( 'Kaydet') ?>",
                    "icon": "fa fa-floppy-o cu_button",
                    "id": "ok-create-button",
                    "url": ""
                },
            ]
        };
      
      //// ok-tamamlanmadı form bitiş /////
      
        ///// etkinlik tanımı form başlangıç ////
         var etkinlikHeader = {
            "card-header-id": "etkinlik-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Etkinlik Değerlendirmesi') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }
            ]
        };
        var etkinlikBody = {
            "card-body-id": "etkinlik-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "etkinlik_conformityid_cu",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
                {
                    "type": "textarea",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Faaliyet Tanımı') ?>",
                    "id": "etkinlik_definition_cu",
                    "url": "",
                },
              
                {
                    "type": "input-datepicker",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Kontrol Tarihi') ?>",
                    "id": "etkinlik_date_cu"
                }
             
         
            ]
        };
        var etkinlikFooter = {
            "card-footer-id": "etkinlik-cu-footer", 
          data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-sm btn-round btn-primary text-white float-right",
                    "title": "<?= t( 'Kaydet') ?>",
                    "icon": "fa fa-floppy-o cu_button",
                    "id": "etkinlik-create-button",
                    "url": ""
                },
            ]
        };
      
      //// nok-tamamlanmadı form bitiş /////
      
       ///// kapanma form başlangıç ////
         var kapanmaHeader = {
            "card-header-id": "kapanma-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-danger",
                    "title": "<?= t('Kapandı') ?>",
                    "icon": "",
                    "id": "",
                    "url": ""
                }
            ]
        };
        var kapanmaBody = {
            "card-body-id": "kapanma-cu-body",
            "required-title": "<?= t( 'Lütfen zorunlu alanı doldurunuz'); ?>",
            "data": [
                {
                    "type": "input-hidden",
                    "div-class": "col-md-12",
                    "id": "kapanmaconformityid_cu",
                  "defaultValue":"<?=$_GET['id'];?>"
                },
              
                {
                    "type": "input-datepicker",
                    "div-class": "col-md-12",
                    "label": "<?= t( 'Kapatılma Tarihi') ?>",
                    "id": "kapanmadate_cu",
                },
         
            ]
        };
        var kapanmaFooter = {
            "card-footer-id": "kapanma-cu-footer", 
          data: [
                {
                    "type": "submitbutton",
                    "class": "btn btn-sm btn-round btn-danger text-white float-right",
                    "title": "<?= t( 'Kaydet') ?>",
                    "icon": "fa fa-floppy-o cu_button",
                    "id": "ok-create-button",
                    "url": ""
                },
            ]
        };
      
      //// kapanma form bitiş /////
      
      
      
      detail();
      
      var uygunsuzlukDetail;
      function detail()
      {
          $("#faaliyet-modal").hide();
          $("#etkinlik-table").hide();
        
         var formData = new FormData(); 
             formData.append('id', <?=$id;?>);
         $("#backgroundLoading").removeClass("loadingDisplay");
            datam=serviscek('/conformity/conformitydetail',actionType='POST',formData);
            datam.then(response =>
            Promise.resolve({
              data: response,
            })
            .then(res => {
               $("#backgroundLoading").addClass("loadingDisplay");
              let donenData=JSON.parse(res.data);
              if(donenData.status==true)
                 {
                   var data=donenData['data'][0];
                   uygunsuzlukDetail=data;
                   var detail=
                       '<div class="col-md-12"><p style="    border: 1px solid #dadada; border-radius: 5px; padding: 4px 10px 4px 10px; line-height: 23px;max-width: 217px;margin-top: 5px;">'+
                           'Uygunsuzluk Numarası : '+data['cnumber']+' <br>'+
                           'Tarih : '+data['acilmaTarihi']+
                        '</p></div>';
                   if(data['filesf']=='')
                      {
                        detail=detail+
                       '<div class="col-md-3" style="width:100%">'+
                        '<h5>Dosya</h5>'+
                         '<div class="resimYok">'+
                           '<?=t('Resim Yok');?>'+ 
                        '</div>'+
									    '</div>';
                      }
                   else
                     {
                        detail=detail+
                       '<div class="col-md-3" style="width:100%">'+
                        '<h5>Dosya</h5>'+
                         '<a href="'+data['filesf']+'" download="">'+
                           '<img class="brand-logo" alt="<?=t('Uygunsuzluk Resmi');?>" style=" width: 126px;" src="'+data['filesf']+'">'+ 
                        '</a>'+
									    '</div>';
                     }
						       detail+=
                     '<div class="col-md-9">'+
						            '<div class="row">'+
							            '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Kimden ?");?></h5>'+
                            '<p style="color: #636161;">'+data['userName']+'</p>'+
							            '</div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Kime ?");?></h5>'+
                            '<p style="color: #636161;">'+data['clientName']+'</p>'+
					                '</div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Bölüm");?></h5>'+
                            '<p style="color: #636161;">'+data['departmentName']+'</p>'+
							            '</div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Alt Bölüm");?></h5>'+
                            '<p style="color: #636161;">'+data['subName']+'</p>'+
                          '</div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Uygunsuzluk Durumu");?></h5>'+
                            '<p style="color: #636161;">'+data['conStatus']+'</p>'+
                         ' </div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Uygunsuzluk Tipi");?></h5>'+
                            '<p style="color: #636161;">'+data['conType']+'</p>'+
                          '</div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Uygunsuzluk Derecesi");?></h5>'+
                           ' <p style="color: #636161;">'+data['priority']+'</p>'+
                          '</div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Tanım");?></h5>'+
                            '<p style="color: #636161;">'+data['definition']+'</p>'+
                          '</div>'+
                          '<div class="col-md-4" style="border-left: #d8d8d8 1px solid;">'+
                            '<h5><?=t("Öneri / Önleyici Faaliyet");?></h5>'+
                            '<p style="color: #636161;">'+data['suggestion']+'</p>'+
                          '</div>'+
                        '</div>'+
                      '</div>';
                   
                   $("#cdetail").html(detail);
                   
                     var uygunsuzlukAtama=
                         '<div class="card-header" style="width: 100%;" >'+
                            '<span><?=t("Uygunsuzluk Atama");?></span>'+
                          '</div>'+
                            '<div class="col-md-12">'+
                              '<table style="width: 100%;" class="table table-striped table-bordered confotmityList dataTable no-footer table-responsive">';
                              uygunsuzlukAtama+='<tr><th>Gönderen</th><th>Alıcı</th><th>Operasyon</th><th>Gönderilme Zamanı</th><th>Geri Çevirme Nedeni</th></tr>';
                              data['activity'].forEach(x=>{
                                    uygunsuzlukAtama+='<tr><td>'+x.usenderns+'</td><td>'+x.urecipientns+'</td><td>'+x.atamaDurumu+'</td><td>'+x.tarih+'</td><th>'+x.definition+'</td></tr>';
                              });
                            uygunsuzlukAtama+='</table>'+
                          '</div>';
                     if(+data['cactivityStatus']==4)
                      {
                        uygunsuzlukAtama+=
                          "<div class='col-md-12' style='padding: 14px 0 14px 0px;'>"+
                          '<a id="okTamamlandi" class="btn btn-sm btn-round btn-success text-white float-right">'+
                            '<i class="fa fa-check cu_button"></i>OK - Tamamlandı'+
                          '</a>'+
                          '<a id="nokTamamlandi" class="btn btn-sm btn-round btn-danger text-white float-right">'+
                            '<i class="fa fa-times cu_button"></i>NOK - Tamamlanamadı'+
                          '</a>'
                          +"</div>";
                        formOlustur(nokHeader, nokBody, nokFooter); 
                        formOlustur(okHeader, okBody, okFooter);
                      }
                   
                   
                   
                   var userType="<?=$userType;?>";
                   
                   var okDateDiv='<div class="col-md-12" style="background: #eaeaea;padding: 14px 23px 7px 23px;margin-top:10px">'+
                                  '<p style="font-size: 15px;font-weight: 700;">Ok-Tamamlandı Tarihi : '+data['okdate']+
                                    '<a data-id="'+data['conactivityid']+'" data-datex="'+data['okdate']+'" id="okGuncelle" class="btn btn-sm btn-round btn-success text-white float-right">'+
                                      'OK- Tarih Güncelleme'+
                                    '</a>'+				
                                  '</p>'+
                                  '</div>';
                   if(+data['cactivityStatus']==3)
                      {
                        $("#faaliyet-modal").show();
                        faaliyetHeader.data.push(
                           {
                                "type": "button",
                                "class": "btn btn-sm btn-round btn-success text-white float-right",
                                "title": "<?= t( 'Atama Yap') ?>",
                                "icon": "fa fa-users cu_button",
                                "id": "assign-btn",
                                "url": ""
                            }
                        );
                         formOlustur(faaliyetHeader, faaliyetBody, faaliyetFooter);
                        assignHeader.data[0].defaultValue=data['id'];
                        formOlustur(assignHeader, assignBody, assignFooter); 
                      }
                     else if(+data['cactivityStatus']==1)
                      {
                        $("#faaliyet-modal").show();
                          faaliyetFooter.data.push(
                           {
                                "type": "button",
                                "class": "btn btn-sm btn-round btn-danger text-white float-right",
                                "title": "<?= t( 'Uygunsuzluk tanımlamasını geri gönder') ?>",
                                "icon": "fa fa-users cu_button",
                                "id": "returnassign-btn",
                                "url": ""
                            }
                        );
                        
                         formOlustur(faaliyetHeader, faaliyetBody, faaliyetFooter);
                         returnassignHeader.data[0].defaultValue=data['id'];
                         returnassignBody.data[1].defaultValue=data['activity'][data['activity'].length-1]['id'];
                         returnassignBody.data[2].defaultValue=data['activity'][data['activity'].length-1]['senderuserid'];
                         formOlustur(returnassignHeader, returnassignBody, returnassignFooter); 
                      }
                   
                      else if(+data['cactivityStatus']==5)
                      {
                        uygunsuzlukAtama+=okDateDiv;
                        $("#etkinlik-table").show();
                          formOlustur(etkinlikHeader, etkinlikBody, etkinlikFooter);
                        $("#etkinlik-cu-body").hide();
                      }
                       else if(+data['cactivityStatus']==6)
                      {
                          uygunsuzlukAtama+=okDateDiv;
                          uygunsuzlukAtama+=
                          "<div class='col-md-12' style='padding: 14px 0 14px 0px;'>"+
                          '<a id="kapandi" class="btn btn-sm btn-round btn-danger text-white float-right">'+
                            '<i class="fa fa-check cu_button"></i>Kapandı'+
                          '</a>'
                          +"</div>";
                          kapanmaBody.data[1]['defaultValue']=data['okdate'];
                          formOlustur(kapanmaHeader, kapanmaBody, kapanmaFooter);
                      }
                   else
                     {
                           var okDateDiv='<div class="col-md-12" style="background: #eaeaea;padding: 14px 23px 7px 23px;margin-top:10px">'+
                                            '<p style="font-size: 15px;font-weight: 700;">Ok-Tamamlandı Tarihi : '+data['okdate']+
                                            '</p>'+
                                          '</div>';
                           var nokDateDiv='<div class="col-md-12" style="background: #eaeaea;padding: 14px 23px 7px 23px;margin-top:10px">'+
                                            '<p style="font-size: 15px;font-weight: 700;">Nok-Tamamlandı Tarihi : '+data['nokdate']+
                                            '</p>'+
                                          '</div>';
                           if(+data['cactivityStatus']==7 || +data['cactivityStatus']==9)
                            {
                              uygunsuzlukAtama+=nokDateDiv;
                            }
                           else
                             {
                              uygunsuzlukAtama+=okDateDiv;
                             }
                     }
                   
                    $("#uygunsuzlukAtama").html(uygunsuzlukAtama);
                  
                 }
              else
                {
                   toastr.success("<center>"+donenData.data+"</center>", "<center><?=t('Hata')?></center>", {
                     positionClass: "toast-top-right",
                     containerId: "toast-top-right"
                   });
                  
                }
            }));
      }
      
   $('#faaliyet-cu-header').on('click','#assign-btn', function (e) {
      $('#assign-table').modal('show');
   });
      
   $('#faaliyet-cu-footer').on('click','#returnassign-btn', function (e) {
      $('#returnassign-table').modal('show');
   });
      
   $('#uygunsuzlukAtama').on('click','#nokTamamlandi', function (e) {
      $('#nok-table').modal('show');
   });
   $('#uygunsuzlukAtama').on('click','#okTamamlandi', function (e) {
      $('#ok-table').modal('show');
   });
   
   $('#uygunsuzlukAtama').on('click','#kapandi', function (e) {
      $('#kapanma-table').modal('show');
   });
        //////// create update modal oluşturma //////
        var conformityHeader = {
            "card-header-id": "c-cu-header",
            "data": [
                {
                    "type": "text",
                    "class": "text-primary",
                    "title": "<?= t( 'Uygunsuzluk Güncelleme') ?>",
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
                    "data":[]
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
                    "title": "<?= t( 'Güncelle') ?>",
                    "icon": "icon",
                    "id": "c-create-button",
                    "url": ""
                },
            ]
        };

        $('#c-update-modal-button').on('click', function (e) {
            formBosalt(conformityBody);
            conformityHeader.data[0].title="<?= t( 'Uygunsuzluk Güncelleme') ?>";
            conformityFooter.data[0].title="<?= t( 'Güncelle') ?>";
            formOlustur(conformityHeader, conformityBody, conformityFooter);
          
             $("#branch_cu").removeAttr('disabled');
             $("#clientbranch_cu").removeAttr('disabled'); 
             $("#department_cu").removeAttr('disabled');
             $("#type_cu").removeAttr('disabled');
             $("#clientbranch_cu").removeAttr('disabled');
             $("#subdepartment_cu").removeAttr('disabled');
          
            selectOption("/firm/firmlist", "id", "name", "GET", "firm_cu", null,uygunsuzlukDetail['firmid'],null,"selectbox",false,1);     
            selectOption("/firm/branchlist/"+uygunsuzlukDetail['firmid'], "id", "name", "GET", "branch_cu", null,uygunsuzlukDetail['firmbranchid'],null,"selectbox",false,1);
            selectOption("/client/clientlist/"+uygunsuzlukDetail['firmbranchid'], "id", "name", "GET", "clientbranch_cu", null,uygunsuzlukDetail['clientid'],null,"selectbox",false,1);
          
             var formData=new FormData();
             formData.append('clientid',uygunsuzlukDetail['clientid']);
             formData.append('parentid',0);

            selectOption("/departments/departmentlist", "id", "name", "POST", "department_cu", formData,uygunsuzlukDetail['departmentid'],null,"selectbox",false,1);
            selectOption("/conformitytype/conformitytypelist", "id", "name", "POST", "type_cu", formData,uygunsuzlukDetail['type'],null,"selectbox",false,1);
            
          
             var formData2=new FormData();
             formData2.append('parentid',uygunsuzlukDetail['departmentid']);
             selectOption("/departments/departmentlist", "id", "name", "POST", "subdepartment_cu", formData2,uygunsuzlukDetail['subdepartmentid'],null,"selectbox",false,1);
 
          
            $('#firm_cu').val(uygunsuzlukDetail['firmid']);  
            $('#branch_cu').val(uygunsuzlukDetail['firmbranchid']);  
            $('#clientbranch_cu').val(uygunsuzlukDetail['clientid']);  
            $('#department_cu').val(uygunsuzlukDetail['departmentid']);  
            $('#subdepartment_cu').val(uygunsuzlukDetail['subdepartmentid']);  
            $('#type_cu').val(uygunsuzlukDetail['type']);  
            $('#priority_cu').val(uygunsuzlukDetail['priority']);  
            $('#date_cu').val(uygunsuzlukDetail['acilmaTarihi']);  
            $('#definition_cu').text(uygunsuzlukDetail['definition']);  
            $('#suggestion_cu').text(uygunsuzlukDetail['suggestion']); 
            $('#id_cu').val(uygunsuzlukDetail['id']); 
            $('#c-cu-table').modal('show');
        });

        $("#c-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformitycreateupdate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#c-cu-table').modal('hide');
                      detail();
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
      
       $('#c-delete-modal-button').on('click', function (e) {
            conformityDHeader.data[0].title="<?= t( 'Uygunsuzluk Silme') ?>";
            conformityDFooter.data[0].title="<?= t( 'Sil') ?>";
            formOlustur(conformityDHeader, conformityDBody, conformityDFooter);
            $('#id_delete').val(uygunsuzlukDetail['id']); 
            $('#c-delete-table').modal('show');
        });
      
        $("#c-delete").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformitydelete',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#c-delete-table').modal('hide');
                      toastr.success("<center><?=t('Silme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     window.open('/conformity/index2');
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
      
      
      
      ///////// atama ekleme başlangıç ///////
      
       $("#assign").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformityassigncreate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#assign-table').modal('hide');
                      toastr.success("<center><?=t('Atama başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     detail();
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
      ///// atama ekleme bitiş ///////
      
      ///// atama geri döndürme başlangıç ///////
      
       $("#returnassign").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformityreturnassign',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#returnassign-table').modal('hide');
                      toastr.success("<center><?=t('Atama geri çevirme başarılı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     detail();
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
      ///// atama geri döndürme bitiş ///////
      
         ///// deadline verme başlangıç ///////
      
       $("#faaliyet-cu").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/deadlinecreate',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#faaliyet-table').modal('hide');
                      toastr.success("<center><?=t('Faliyet tarihi verme başarılı bir şekilde gerçekleşmiştir.')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     detail();
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
      ///// deadline verme döndürme bitiş ///////
      
      
   ///// uygunsuzluk ok başlangıç /////// 
       $("#ok").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformityok',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#ok-table').modal('hide');
                      toastr.success("<center><?=t('Uygunsuzluk tamamlandı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     detail();
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
  ///// uygunsuzluk ok bitiş ///////
      
      ///// uygunsuzluk ok başlangıç /////// 
       $("#nok").submit(function (e) {   ////////// ekleme ve güncellemede kullanılan bölüm
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformitynok',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#nok-table').modal('hide');
                      toastr.success("<center><?=t('Uygunsuzluk tamamlanmadı')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     detail();
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
  ///// uygunsuzluk nok bitiş ///////
      
       ///// etkinlik değerlendirme gönderme başlangıç /////// 
       $("#etkinlik-cu").submit(function (e) {
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformityetkinliktanimi',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#nok-table').modal('hide');
                      toastr.success("<center><?=t('Etkin değerlendirmeniz kaydedilmiştir.')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     detail();
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
  ///// etkinlik değerlendirme gönderme bitiş ///////
      
 ///// kapanmaa başlangıç /////// 
       $("#kapanma-form").submit(function (e) {
            $("#backgroundLoading").removeClass("loadingDisplay");
          e.preventDefault();
             datam=serviscek('/conformity/conformitykapat',actionType='POST', new FormData(this));
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").addClass("loadingDisplay");
                let donenData=JSON.parse(res.data);
                if(donenData.status==true)
                   {
                      $('#kapanma-table').modal('hide');
                      toastr.success("<center><?=t('Uygunsuzluk kapatılmıştır.')?></center>", "<center><?=t('Başarılı')?></center>", {
                         positionClass: "toast-top-right",
                         containerId: "toast-top-right"
                     });
                     detail();
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
  ///// kapanmaa bitiş ///////
     
      $("#open").click(function(){
          $("#etkinlik-cu-body").show(500);
       });
       $("#close").click(function(){
            $("#etkinlik-cu-body").hide(500);
       });
      
      //// etkinlik değerlendirmesi acma kapama bitiş////://

      
      
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
