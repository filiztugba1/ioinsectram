<?php include "header.php"; ?>
<div class="views">

      <div class="view view-main">
<div class="pages">
  <div data-page="form" class="page">
    <div class="page-content">
    
		<div class="navbar navbar--fixed navbar--fixed-top navbar--bg">
			<div class="navbar__col navbar__col--title">
				<a href="index.php">Insectram</a>
			</div>
			<div class="navbar__col navbar__col--icon navbar__col--icon-right">
				<a href="#" data-panel="right" class="open-panel"><img src="images/icons/white/user.png" alt="" title="" /></a>
			</div>
			<div class="navbar__col navbar__col--icon navbar__col--icon-right">
				<a href="#" data-panel="left" class="open-panel"><img src="images/icons/white/menu.png" alt="" title="" /></a>
			</div>
                </div>
	
     <div id="pages_maincontent">
     
              <h2 class="page_title">CUSTOM FORM</h2> 
     
     <div class="page_single layout_fullwidth_padding">

                <div class="contactform">
                <form class="" id="CustomForm" method="post" action="#">
				
				<div class="form_row">
				<input type="file" accept="image/*" capture="capture">
                </div>
				
                <div class="form_row">
			<div class="selector_overlay">
				<select name="musteri" class="required">
					<option value="" disabled selected>Müşteri Seç</option>
					<option value="1">select one</option>
					<option value="2">select two</option>
					<option value="3">select three</option>
					<option value="4">select four</option>
					<option value="5">select five</option>
				</select>
			</div>
                </div>
				<div class="form_row">
			<div class="selector_overlay">
				<select name="bolum" class="required">
					<option value="" disabled selected>Bölüm Seç</option>
					<option value="1">select one</option>
					<option value="2">select two</option>
					<option value="3">select three</option>
					<option value="4">select four</option>
					<option value="5">select five</option>
				</select>
			</div>
                </div>
				<div class="form_row">
			<div class="selector_overlay">
				<select name="altbolum" class="required">
					<option value="" disabled selected>Alt Bölüm Seç</option>
					<option value="1">select one</option>
					<option value="2">select two</option>
					<option value="3">select three</option>
					<option value="4">select four</option>
					<option value="5">select five</option>
				</select>
			</div>
                </div>
				<div class="form_row">
			<div class="selector_overlay">
				<select name="altbolum" class="required">
					<option value="" disabled selected>Detay Seç</option>
					<option value="1">Kırık Çatlak vb.</option>
					<option value="2">Çevresel Risk</option>
					<option value="3">Ekipman Çalışmıyor</option>
					<option value="4">Ekipman Eksik</option>
					<option value="5">Temizlik</option>
				</select>
			</div>
                </div>
				
				<div class="form_row">
                <input type="text" name="aciklama" value="" placeholder="Açıklama" class="form_input" />
                </div>
				
				<div class="form_row">
                <input type="text" name="oneri" value="" placeholder="Öneri/Önlem" class="form_input" />
                </div>
				
				<div class="form_row">
			<div class="selector_overlay">
				<select name="altbolum" class="required">
					<option value="1">1.Derece</option>
					<option value="2">2.Derece</option>
					<option value="3">3.Derece</option>
					<option value="4">4.Derece</option>
				</select>
			</div>
                </div>

                
                
                <input type="submit" name="submit" class="form_submit" id="submit" value="Send" />
                </form>
                </div>

              
              
              </div>
      
      </div>
      
      
    </div>
  </div>
</div>

         </div>
    </div>
<?php include "footer.php";?>