<?=User::model()->geturl('Documents','',0,'documents');?>
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #f3f5f9;">
        <h4 class="card-title"><?=mb_strtoupper(t('Documents'));?></h4>
    </div>
	  <div class="card-content">
        <div class="card-body" id="mainCategory">
		    </div>
    </div>
</div>

<div class="row tablelist" >
    <div class="col-lg-4 col-md-4 col-sm-12" id="documents"></div>
     
  <div class="col-lg-8 col-md-8 col-sm-12" id="documentlist">	
    </div>
</div>


  
  <style>
                 .active
                 {
                  background-color: #7777778a;
                 }
              </style>
              <script>
              function aktif(id)
              {
              $('a').removeClass('active');
              $('#'+id+'').addClass('active');
              };
            </script>
<style>
  .nav-item{
    padding: 0 5px 0 5px;
  }
</style>
<script>
  let donenData='';
  $("#backgroundLoading").addClass("backgroundLoading");
  var formData=new FormData;
  formData.append('parentid',0);
  datam=serviscek('/documents/categorylist',actionType='POST',formData);
             datam.then(response =>
              Promise.resolve({
                data: response,
              })
              .then(res => {
                 $("#backgroundLoading").removeClass("backgroundLoading");
                donenData=JSON.parse(res.data).data;
                let mainCategory='<ul class="nav nav-tabs" style="background: #f3f5f9;">';
               let activeClass;
               for(let i=0;i<donenData.length;i++)
               {
                 if(i==0)
                    {
                    doc(donenData[i].id);
                      activeClass=donenData[i].id;
                    }
                  mainCategory+='<li class="nav-item ">';
                  mainCategory+='<a class="nav-link category" id="'+donenData[i].id+'" data-toggle="tab" onclick="tabs(this)" data-id="'+donenData[i].id+'" data-name="'+donenData[i].name+'" aria-controls="tab'+donenData[i].id+'" href="#tab'+donenData[i].id+'" aria-expanded="true">'+donenData[i].name;
                  let say=donenData[i].say;
                 let subMenu=donenData[i];
                 
                 for(let j=0;i<subMenu.length;i++)
                 {
                   say=say+subMenu[j].say;
                 }
                 if(say>0)
                 {
                    mainCategory+='<span class="badge badge badge-primary badge-pill float-right mr-2">'+say+'</span>';
                 }
                 mainCategory+='</a></li>';
               }
               
                 mainCategory+='</ul>';
                 $('#mainCategory').html(mainCategory);
                 $('#'+activeClass).addClass('active');
              })
          );
  
  
  function tabs(obj)
  {
    
    let kategori=$(obj).data('id');
    doc(kategori);
  }
  
  function doc(kategori)
  {
     for(let i=0;i<donenData.length;i++)
    {
      if(+kategori===+donenData[i].id)
         {
           var subCategory="";
           subCategory='<div class="card">';
			     subCategory+='<div class="card-content collapse show">';
				   subCategory+='<div class="card-body card-dashboard">';
					 subCategory+='<h4 id="documentsh4" class="card-title">Kurumsal KATEGORY LISTESI</h4>';
				   subCategory+='<div class="treex well">';
				   subCategory+='<div class="horizontal-scroll scroll-example height-300">';
           subCategory+='<div class="horz-scroll-content">';
					 subCategory+='<ul><div id="main-class">';
                      
           for(let k=0;k<donenData[i].subKategori.length;k++)
            {
              	 subCategory+='<li><a class="btn btn-default category" id="'+donenData[i].subKategori[k].id+'" data-id="'+donenData[i].subKategori[k].id+'" onclick="category(this)"  data-name="'+donenData[i].subKategori[k].name+'">'+donenData[i].subKategori[k].name+'</a></li>';             
            }
            subCategory+='</div></ul>	';	 
                       subCategory+=' </div>';	 
                     subCategory+=' </div>';	 
                    subCategory+='</div>';	 
                  subCategory+='</div>';	 
                  subCategory+='  </div>';	 
               subCategory+=' </div>';	 
           
           $('#documents').html(subCategory);
           
           
           var subDocList="";
           subDocList+='<div class="card">';
           subDocList+='<div class="card-header">';
            subDocList+='<div class="row">';
            subDocList+='<div class="col-xl-9 col-lg-9 col-md-9 mb-1">';
              subDocList+='<h4 id="documentlisth4" class="card-title">Eğitim Dökümanları</h4>';
            subDocList+='</div>';
            subDocList+='<div class="col-xl-3 col-lg-3 col-md-3 mb-1">';
            subDocList+='<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">';
            subDocList+='<button class="btn btn-info" id="createbutton" type="submit">Dosya ekle <i class="fa fa-plus"></i></button>';
            subDocList+='</div>';
            subDocList+='</div>';
            subDocList+='</div>';
            subDocList+='</div>';
            subDocList+='<div class="card-content collapse show">';
            subDocList+=' <div class="card-body">';
             subDocList+=' <div id="cListTable">';
                  subDocList+='  </div>';
           subDocList+='</div>';
        subDocList+='</div>';
           console.log(subDocList);
           
           $('#documentlist').html(subDocList);
           
            var listUrlClient="/conformity/conformitylist?cid=<?=$_GET['id'];?>&pid=<?=$detay["parentid"];?>";
            ////liste çekme başlangıç
            var listColumnArray = [
                {"key": "name", "value": "<?= t('Adı') ?>"},
                {"key": "document_type", "value": "<?= t('Döküman Tipi') ?>"},
                {"key": "kime", "value": "<?= t('Kime') ?>"},
                {"key": "islem", "value": "<?= t('İşlem') ?>"},
            ];
            tableList("cListTable", "docList", listColumnArray, null, listUrlClient, "POST", null, "document","","documentSay"); //listenin çekildiği fonksiyon
           
         }
    }
  }
</script>