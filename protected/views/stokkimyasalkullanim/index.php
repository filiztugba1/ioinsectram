<?php

User::model()->login();
$ax= User::model()->userobjecty('');
if (Yii::app()->user->checkAccess('staff.view')){

echo User::model()->geturl('Stok Kimyasal Kullanımı','',0,'stokkimyasalkullanim');//sayfada neredeyiz banneri
$where='';
if($ax->firmid>0)
{
	if($ax->branchid>0)
	{
		$where='branchid='.$ax->branchid;
	}
	else
	{
		$where='firmid='.$ax->firmid;
	}
}
else
{
	$where='';
}
$stokkimyasal=Stokkimyasalkullanim::model()->findAll(array("condition"=>$where));?>
<?php if (Yii::app()->user->checkAccess('staff.create')){ ?>
	<div class="row" id="createpage" >
		<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="card">
			    	<div class="card-header">
						 	<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 	<div class="col-md-6">
								  <h4  class="card-title">Stok Kimyasal Ekleme</h4>
								</div>
								<div class="col-md-6">
									<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
							</div>
					 	</div>
						<form id="ekleForm">
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
											<label for="basicSelect">Kimyasal Adı</label>
												<fieldset class="form-group">
													<input type="text" class="form-control" id="kimyasal_adi"  placeholder="Kimyasal Adı" name="Stokkimyasalkullanim[kimyasaladi]" required>
                        </fieldset>
                    </div>


										<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											<label for="basicSelect">Ruhsat Tarih</label>
												<fieldset class="form-group">
													<input type="date" class="form-control" id="ruhsat_tarih" placeholder="Ruhsat Tarihi" name="Stokkimyasalkullanim[ruhsattarih]" required>
												</fieldset>
										</div>

										<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											<label for="basicSelect">Ruhsat No</label>
												<fieldset class="form-group">
													<input type="number" class="form-control" id="ruhsat_no"  placeholder="Ruhsat No" name="Stokkimyasalkullanim[ruhsatno]" required>
												</fieldset>
										</div>

										<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
											<fieldset class="form-group">
												<label for="basicSelect">Aktif Madde Tanımı</label>
													<textarea  class="form-control" id="aktif_madde_tanimi"  placeholder="Aktif Madde Tanımı" name="Stokkimyasalkullanim[aktifmaddetanimi]"></textarea>
											</fieldset>
									</div>

									<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
										<fieldset class="form-group">
											<label for="basicSelect">Yöntem</label>
												<textarea  class="form-control" id="yontem"  placeholder="Yöntem" name="Stokkimyasalkullanim[yontem]"></textarea>
										</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<fieldset class="form-group">
										<div class="input-group-append"  style="float:right">
											<button class="btn btn-primary block-page" id="ekleButton"><?=t('Create');?></button>
										</div>
									</fieldset>
								</div>



					  		</div>
							</div>
						</div>
					</form>
				</div>
			</div><!-- form -->
	</div>
<?php }?>

<section id="html5">
	<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-7 col-lg-7 col-md-7 col-xs-12 mb-1">
						 	<h4 class="card-title">Stok Kimyasal Listesi</h4>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-xs-12 mb-1" >
						<?php if (Yii::app()->user->checkAccess('staff.create')){ ?>

									<button style='float:right' class="btn btn-info" id="createbutton" type="submit">Kimyasal Ekle <i class="fa fa-plus"></i></button>

						<?php }?>
						</div>
					</div>
					<a href='?type=branch&&id=2&&status=2' class="btn btn-danger btn-sm" style='float:right' type="submit"><?=t('Passive');?> </a>
					<a href='?type=branch&&id=2&&status=1' class="btn btn-success btn-sm" style='float:right' type="submit"><?=t('Active');?> </a>
					<a href='?type=branch&&id=2&&status=0' class="btn btn-warning btn-sm" style='float:right'  type="submit"><?=t('All');?> </a>
        </div>
  			<div class="card-content collapse show">
            <div class="card-body card-dashboard">
							<div class='row'>
									<div class="col-xl-2 col-lg-2 col-md-2">
										<label for="basicSelect" class='show2'>Adet Kolon</label>
										 <fieldset class="form-group showformGrup">
												<select class="custom-select block showselect" id="kolonadet" onchange="show(this.value)">
													<option value="10">10</option>
													<option value="20">20</option>
													<option value="30">30</option>
													<option value="40">40</option>
													<option value="50">50</option>
													<option value="100">100</option>
													<option value="">Hepsi</option>
												</select>
										</fieldset>
									</div>
									<div class="col-xl-10 col-lg-10 col-md-10">
													<fieldset class="form-group searchformGrup">
														<input type="email" class="form-control searchinput" id="search" onkeyup="searchinput()">
													</fieldset>
													<label for="basicSelect" class='show2'>Ara</label>
									</div>
							</div>
							<div class="loader-wrapper d-flex justify-content-center align-items-center">
																		 <div class="loader">
																				 <div class="ball-spin-fade-loader">
																						 <div></div>
																						 <div></div>
																						 <div></div>
																						 <div></div>
																						 <div></div>
																						 <div></div>
																						 <div></div>
																						 <div></div>
																				 </div>
																		 </div>
									</div>
				<div class="row" id="tableBody">

				</div>

				<div class='row'>

				<div class="col-xl-2 col-lg-2 col-md-2">
	<label for="basicSelect" class='show' id='total'>Toplam Kayıt:<?=count($stokkimyasal);?></label>
				</div>

				<div class="col-xl-10 col-lg-10 col-md-10">

								 <nav style='float: right;' class="" aria-label="Page navigation example">
								<ul class="pagination pagination-sm" id='sayfasayisi'>

								</ul>
						</nav>
				</div>
		</div>


      </div>
    </div>
  </div>
</div>
</div>
</section>

<?php if (Yii::app()->user->checkAccess('staff.update')){ ?>
<!-- GÜNCELLEME BAŞLANGIÇ-->
<div class="col-lg-4 col-md-6 col-sm-12">
  <div class="form-group">
    <div class="modal fade text-left" id="duzenle2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning white">
            <h4 class="modal-title" id="myModalLabel8">Stok Kimyasal Güncelleme</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
                </button>
          </div>
					<!--form baslangıç-->
					<form id="user-form1" action="/stokkimyasalkullanim/create" method="post">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="col-xl-3 col-lg-3 col-md-3 mb-1" >
										<label for="basicSelect">Kimyasal Adı</label>
											<fieldset class="form-group">
												<input type="text" class="form-control" id="kimyasal_adi" onkeyup="javascript:kontrol()" placeholder="Kimyasal Adı" name="Stokkimyasalkullanim[kimyasaladi]" required>
											</fieldset>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
										<label for="basicSelect">Aktif Madde Tanımı</label>
											<fieldset class="form-group">
												<input type="text" class="form-control" id="aktif_maddetanimi" onkeyup="javascript:kontrol()" placeholder="Aktif Madde Tanımı" name="Stokkimyasalkullanim[aktifmaddetanimi]" required>
											</fieldset>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
										<label for="basicSelect">Ruhsat Tarih</label>
											<fieldset class="form-group">
												<input type="date" class="form-control" id="ruhsat_tarih" onkeyup="javascript:kontrol()" placeholder="Ruhsat Tarihi" name="Stokkimyasalkullanim[ruhsattarih]" required>
											</fieldset>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
										<label for="basicSelect">Ruhsat No</label>
											<fieldset class="form-group">
												<input type="number" class="form-control" id="ruhsat_no" onkeyup="javascript:kontrol()" placeholder="Ruhsat No" name="Stokkimyasalkullanim[ruhsatno]" required>
											</fieldset>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
										<label for="basicSelect"><?=t('Active');?></label>
										 <fieldset class="form-group">
												<select class="custom-select block" id="customSelect8" name="User[isactive]">
													<option value="1" selected><?=t('Active');?></option>
													<option value="0"><?=t('Passive');?></option>
												</select>
											</fieldset>
									</div>
							</div>
						</div>
					</div>
				</form>
  		</div>
    </div>
  </div>
</div>
</div>


	<!-- GÜNCELLEME BİTİŞ-->
<?php }?>
<?php if (Yii::app()->user->checkAccess('staff.delete')){ ?>
	<!--SİL BAŞLANGIÇ-->
<div class="col-lg-4 col-md-6 col-sm-12">
  <div class="form-group">
		<div class="modal fade text-left" id="sil2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger white">
            <h4 class="modal-title" id="myModalLabel8">Stok Kimyasal Kullanim Silme</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
              </button>
          </div>
					<form id="user-form" action="/user/delete/0" method="post">
						<input type="hidden" class="form-control" id="modaluserid2" name="User[id]" value="0">
						<div class="modal-body">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Active');?></label>
								 <fieldset class="form-group">
										<select class="custom-select block" id="customSelect8" name="User[isactive]">
											<option value="1" selected><?=t('Active');?></option>
											<option value="0"><?=t('Passive');?></option>
										</select>
									</fieldset>
							</div>
						</div>
            <div class="modal-footer">
              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
            	<button class="btn btn-danger block-page-delete" type="submit"><?=t('Delete');?></button>
            </div>
					</form>
				</div>
      </div>
    </div>
  </div>
</div>






 <div id="snackbar">Ekleme Başarılı</div>

<?php }?>
<?php }?>


<div class="modal fade text-left" id="hedefzararli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
											aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger white">
				<h4 class="modal-title" id="myModalLabel8">Stok Kimyasal Kullanim Silme</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<form id="hedefzararliformu">
				<input type="hidden" class="form-control" id="stokkimyasalid" name="Stokkimyasalkullanimid[id]" value="0">

				<div class="modal-body">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect">Hedef Canlı</label>
						 <fieldset class="form-group">
								<select class="custom-select block" id="hedeflenencanli" name="Stokkimyasalkullanimid[petsid]">
									<?$pets=Pets::model()->findAll();
									foreach($pets as $pet)
									{?>
											<option value="<?=$pet->id;?>"><?=$pet->name?></option>
								<?	}?>


								</select>
							</fieldset>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect">Dozaj</label>
						 <fieldset class="form-group">
							 <input type="text" class="form-control" id="dozaj" name="Stokkimyasalkullanimid[dozaj]" value="0">

							</fieldset>
					</div>

<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<fieldset class="form-group">
						<label for="basicSelect">Birim</label>
						 <select class="custom-select block" id="olcubirimi" name="Stokkimyasalkullanimid[olcubirimi]">
							 <option value="Litre">Litre</option>
							 <option value="Kilogram">Kilogram</option>
							 <option value="Gram">Gram</option>
						 </select>
					 </fieldset>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
					<button class="btn btn-danger block-page-delete" type="submit">Ekle</button>
				</div>
			</form>
		</div>
	</div>
</div>
<form id="listform">
			<input type="hidden" class="form-control" id="eklepackage" name="package" >
				<input type="hidden" class="form-control" id="eklekolon" name="kolon" >
				<input type="hidden" class="form-control" id="eklesearch" name="search" >
</form>

<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

.show{
    font-size: 10px;
    float: left;
    line-height: 22px;
    margin-right: 2px;
}
.show2{
    font-size: 10px;
    float: right;
    line-height: 22px;
    margin-right: 2px;
}
.showformGrup{
    width: 64px;
    float: left;
    height: 22px;
    padding-bottom: 0px;
    margin-bottom: 0px;
}
.showselect{
    width: 60px;
    height: 23px;
    padding: 0px 0px 0px 8px;
}
.searchinput
{
    width: 100px;
    height: 23px;
    padding: 0px 0px 0px 8px;
}

.searchformGrup{
    width: 100px;
    float: right;
    height: 22px;
    padding-bottom: 0px;
    margin-bottom: 0px;
}

.pagination li a {
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #404e67;
    background-color: #fff;
    border: 1px solid #dee2e6;
}
.loader-wrapper {
    width: 100%;
    height: 338px;
    margin-top: 43px;
    /* float: left !important; */
    position: absolute;
    /* background: #000; */
    /* opacity: 0.1; */
}
.backgroundloading{
    background: #fff;
    opacity: 0.3;
}
.displayblock{
    display:block!important;
}
.loader{
    display:none;
}


/*snackbar barrrrrrrrr*/
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: green;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  right:0px;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
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


 var kolonadet=$('#kolonadet').val();
 var search=$('#search').val();
 var page=1;

 $('#tableBody').addClass('backgroundloading');
 $('.loader').addClass('displayblock');
 $('#eklepackage').val(page);
 $('#eklekolon').val(kolonadet);
 $('#eklesearch').val(search);
	var Listform = $("#listform").serialize();
	console.log(Listform);
$.ajax({
			 url:'/stokkimyasalkullanim/list', // serileştirilen değerleri ajax.php dosyasına
			 type:'POST', // post metodu ile
			 data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
			 success:function(k){
			 $('#tableBody').removeClass('backgroundloading');
			 $('.loader').removeClass('displayblock');
			 $('#tableBody').html(k);
			 $.ajax({
								url:'/stokkimyasalkullanim/pagination', // serileştirilen değerleri ajax.php dosyasına
								type:'POST', // post metodu ile
								data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
								success:function(page){
								$('#tableBody').removeClass('backgroundloading');
								$('.loader').removeClass('displayblock');
								$('#sayfasayisi').html(page);
						}
					//$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
		});
						 //$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
			 }
		 });

 $("#ekleButton").on("click", function(){ // buton idli elemana tıklandığında


 		$('#tableBody').addClass('backgroundloading');
 		$('.loader').addClass('displayblock');

 		 kolonadet=$('#kolonadet').val();
 		 search=$('#search').val();
 		 page=page;

 		$('#eklepackage').val(page);
 		$('#eklekolon').val(kolonadet);
 		$('#search').val(search);

 		event.preventDefault();
 		var gonderilenform = $("#ekleForm").serialize();// idsi gonderilenform olan formun içindeki tüm elemanları serileştirdi ve gonderilenform adlı değişken oluşturarak içine attı
		$.ajax({
 		url:'/stokkimyasalkullanim/create', // serileştirilen değerleri ajax.php dosyasına
 		type:'POST', // post metodu ile
 		data:gonderilenform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
 		success:function(e){
 		// var x = document.getElementById("snackbar");
 		// 	x.className = "show";
 		// 	setTimeout(function(){ $('#snackbar').removeClass('show');}, 3000);
 		 // alert(e);// gonderme işlemi başarılı ise e değişkeni ile gelen değerleri aldı
 			var x=JSON.parse(e);
 			$('#total').html('Toplam Kayıt:'+x.total);
 			var Listform = $("#listform").serialize();
 			$.ajax({
 					url:'/stokkimyasalkullanim/list', // serileştirilen değerleri ajax.php dosyasına
 					type:'POST', // post metodu ile
 					data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
 					success:function(k){
 					 $('#tableBody').removeClass('backgroundloading');
 					 $('.loader').removeClass('displayblock');
 					$('#tableBody').html(k);
						 $.ajax({
											url:'/stokkimyasalkullanim/pagination', // serileştirilen değerleri ajax.php dosyasına
											type:'POST', // post metodu ile
											data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
											success:function(page){
											$('#tableBody').removeClass('backgroundloading');
											$('.loader').removeClass('displayblock');
											$('#sayfasayisi').html(page);
									}
								//$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
					});
 						//$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
 					}
 				});

 		//$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
 		}
 });

 return false;

 });

 function zararlieklemodal(obj)
 {

	 $('#stokkimyasalid').val($(obj).data('stokkimyasal'));

	 $('#hedefzararli').modal('show');
 }

 function show(id)
 {
		$('#tableBody').addClass('backgroundloading');
		$('.loader').addClass('displayblock');
		$('#eklekolon').val(id);
		var Listform = $("#listform").serialize();
	 $.ajax({
					url:'/stokkimyasalkullanim/list', // serileştirilen değerleri ajax.php dosyasına
					type:'POST', // post metodu ile
					data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
					success:function(k){
					$('#tableBody').html(k);
						 $.ajax({
											url:'/stokkimyasalkullanim/pagination', // serileştirilen değerleri ajax.php dosyasına
											type:'POST', // post metodu ile
											data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
											success:function(page){
											$('#tableBody').removeClass('backgroundloading');
											$('.loader').removeClass('displayblock');
											$('#sayfasayisi').html(page);
									}
								//$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
					});


					}
		});
 }



 function pagex(obj)
 {
		$('#tableBody').addClass('backgroundloading');
		$('.loader').addClass('displayblock');
		$('#eklepackage').val($(obj).data('id'));
		var Listform = $("#listform").serialize();
	 $.ajax({
					url:'/stokkimyasalkullanim/list', // serileştirilen değerleri ajax.php dosyasına
					type:'POST', // post metodu ile
					data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
					success:function(k){
					$('#tableBody').removeClass('backgroundloading');
					$('.loader').removeClass('displayblock');
					$('#tableBody').html(k);
								//$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
					}
		});
 }

 function searchinput()
 {
 	 $('#tableBody').addClass('backgroundloading');
 	 $('.loader').addClass('displayblock');
 	 $('#eklesearch').val($('#search').val());
 	 var Listform = $("#listform").serialize();
 	$.ajax({
 				 url:'/stokkimyasalkullanim/list', // serileştirilen değerleri ajax.php dosyasına
 				 type:'POST', // post metodu ile
 				 data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
 				 success:function(k){
 				 $('#tableBody').html(k);
 						$.ajax({
 										 url:'/stokkimyasalkullanim/pagination', // serileştirilen değerleri ajax.php dosyasına
 										 type:'POST', // post metodu ile
 										 data:Listform, // yukarıda serileştirdiğimiz gonderilenform değişkeni
 										 success:function(page){
 										 $('#tableBody').removeClass('backgroundloading');
 										 $('.loader').removeClass('displayblock');
 										 $('#sayfasayisi').html(page);
 								 }
 							 //$("div").html("").html(e); // div elemanını her gönderme işleminde boşalttı ve gelen verileri içine attı
 				 });
 				 }
 	 });
 }







   $(document).ready(function() {
      $('.block-page-update').on('click', function() {
		if(document.getElementById("modaluserusername").value!='' && document.getElementById("modaluseruseremail").value!='' && document.getElementById("modaluseruserlgid").value!='')
		  {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 5000, //unblock after 20 seconds
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
		  }
    });

});


   $(document).ready(function() {
      $('.block-page-create').on('click', function() {
		if(document.getElementById("email").value!='' && document.getElementById("username").value!='' && document.getElementById("userlgid").value!='')
		  {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 5000, //unblock after 20 seconds
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
		  }
    });

});


   $(document).ready(function() {
      $('.block-page-delete').on('click', function() {

        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 5000, //unblock after 20 seconds
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
	$('#modaluserid').val($(obj).data('id'));
	$('#modaluserusername').val($(obj).data('username'));
	$('#modaluseremail').val($(obj).data('email'));
	$('#modalusername').val($(obj).data('name'));
	$('#modalusersurname').val($(obj).data('surname'));
	$('#modalusertype').val($(obj).data('type'));
	$('#modaluseruserlgid').val($(obj).data('userlgid'));
	$('#modaluseractive').val($(obj).data('active'));
	$('#color2').val($(obj).data('color'));
	$('#modalconformityemail').val($(obj).data('conformityemail'));
	$('#duzenle2').modal('show');

}

function openmodalsil(obj)
{
	$('#modaluserid2').val($(obj).data('id'));
	$('#sil2').modal('show');

}












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



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/js/jscolor.js;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';
