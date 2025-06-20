<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$departments=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
							   ));




						?>


<?
//monitor benzerliği
/*
$mbarkod=Monitoring::model()->findAll(array(
							 'condition'=>'id>9999 && id<16000'));
foreach ($mbarkod as $monitorx) {
	$mbarkodvarmi=Monitoring::model()->findAll(array(
								 'condition'=>'barcodeno="'.$monitorx->barcodeno.'"',
							 ));
	if($mbarkodvarmi && count($mbarkodvarmi)>1)
	{
		echo count($mbarkodvarmi).'-'.$monitorx->id.'<br>';
		$model=Monitoring::model()->find(array('condition'=>'id='.$monitorx->id));
		$model->barcodeno=Monitoring::model()->barkodeControl($model->barcodeno);
		$model->save();
	}
}
*/
?>

<?php
$where='';

if(isset($_GET['hid']) && is_numeric($_GET['hid']) )
{

}else{
  echo 'bad data';
  exit;
}

$map=Maps::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'id='.$_GET['hid'].$where,
							   ));


$monitoring=Monitoring::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'clientid='.$_GET['id'].$where,
							   ));


$clientbtitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_GET['id'])));
$clienttitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientbtitle->parentid)));
$branchtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clienttitle->firmid)));
$firmtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$branchtitle->parentid)));






?>
<style>
    body{
        margin: 0;
    }
    .draw-box {
        position: relative;
        width: 100%;
        max-width: 100%;
        display: grid;
        grid-template-columns: auto 300px;
        gap: 5px;
        overflow: auto;
    }
    .drawArea{
        overflow: auto;
    }
    canvas {
        border: 1px solid red;
        width: 2000px;
        height: 1000px;
        position: relative;
        top: 0;
        left: 0;
        z-index: 9;
    }
    .logs{
        position: relative;
        top: 0;
        right: 0;
        border: 1px solid #ccc;
    }
    .top-buttons{
        position: absolute;
        text-align: right;
        top: 10px;
        right: 10px;
    }
    ul.log-list {
        top:20px;
        list-style: none;
        margin: 20px;
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding-left: 0;
    }
    ul.log-list li {
        text-align: center;
        position: relative;
        display: grid;
        grid-template-columns: 15px auto 100px;
    }
</style>

<?php if (Yii::app()->user->checkAccess('client.branch.maps.view') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
<?=User::model()->geturl('Client','Maps',$_GET['id'],'maps');?>
Map Çizme Ekranı
			<div class="card">
		<div class="card-header" style="">
							<ul class="nav nav-tabs">
					<?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
						  <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
							<?$say=User::model()->findAll(array('condition'=>'clientbranchid='.$_GET['id']));
									echo count($say);?>

							</span><?=t('Staff');?>

							</a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>

						  <li class="nav-item">
							<a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/departments/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $departments);?></span><?=t('Departments');?></a>
						  </li>
					   <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
							<li class="nav-item">
							<a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

					      <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/reports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>
						   <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a>
						  </li>

					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

					        <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files2/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a>
						  </li>
						<?php }?>

								<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a></a>
                      </li>
					 <?//}?>
	<?php if (Yii::app()->user->checkAccess('client.maps.view') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
					        <li class="nav-item">
                        <a class="nav-link active"  href="/client/maps?id=<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-map" style="font-size: 15px;"></i></span><?=t('Haritalar');?> </a></a>
                      </li>
					 <?php }?>


                    </ul>
				</div>

</div>




<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						</div>

			


				



                </div>





  <?php if (Yii::app()->user->checkAccess('client.map.create') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>


	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">

			   <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Map Update');?></h4>
									</div>

						</div>
					 </div>

					<!-- <form id="departments-form" action="/monitoring/create" method="post">	-->

				<form id="monitoring-form" method="POST" >
				<div class="card-content collapse show">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="mapid"  name="Maps[id]" value="<?=$_GET['hid'];?>">
					  <input type="hidden" class="form-control" id="client_id"  name="Maps[client_id]" value="<?=$_GET['id'];?>">
            <input type="hidden" class="form-control" id="is_active"  name="Maps[is_active]" value="1">
            <input type="hidden" class="form-control" id="points"  name="Maps[points]" value="<?=$map->points?>">


            <div class="draw-box">
              <div class="drawArea" id="drawArea">
                  <canvas id="canvas" width="2000" height="1000"></canvas>
              </div>
              <div class="logs">
                  <div class="top-buttons">
                                          <button type="button" class="btn btn-sm btn-warning" id="plus">+</button>
                                          <button type="button" class="btn btn-sm btn-warning" id="zoom_default">Zoom</button>
                                          <button type="button" class="btn btn-sm btn-warning" id="minus">-</button>
                                          
                      <button type="button" class="save-button btn btn-sm btn-success">Save</button>
                    
<!--                      <button type="button" id="download_map">Download</button>-->
                  </div>
                  <ul class="log-list">
                  </ul>
              </div>
          </div>
          <image id="theimage"></image>
          <script src="https://hongru.github.io/proj/canvas2image/canvas2image.js"></script>
            
          <script>
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");
    var canvasOffset = $("#canvas").offset();
    var offsetX = canvasOffset.left;
    var offsetY = parseInt(window.pageYOffset) + parseInt(canvasOffset.top)
		
    var storedLines =  JSON.parse('<?=$map->points ?? "[]" ?>');
    var drawedLines =JSON.parse('<?=$map->points ?? "[]" ?>');
					
      var scale = 100;
      var scaleMultiplier = 5;
            
             var startX = 0;
    var startY = 0;
    var isDown;
    var stopDraw=true;


            
   
            
    window.onscroll = function() {checkScrollMoving()};

    function checkScrollMoving() {
        offsetY = parseInt(canvasOffset.top) - parseInt(window.pageYOffset)// + parseInt(canvasOffset.top)
    }

    ctx.strokeStyle = "black";
    ctx.lineWidth = 1;

    if(drawedLines.length>0){
        redrawStoredLines();
    }

    function UUID() { // Public Domain/MIT
        var d = new Date().getTime();//Timestamp
        var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now()*1000)) || 0;//Time in microseconds since page-load or 0 if unsupported
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16;//random number between 0 and 16
            if(d > 0){//Use timestamp until depleted
                r = (d + r)%16 | 0;
                d = Math.floor(d/16);
            } else {//Use microseconds since page-load if supported
                r = (d2 + r)%16 | 0;
                d2 = Math.floor(d2/16);
            }
            return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
    }

    $(document).on("click","#stop_draw",function () {
        stopDraw=!stopDraw
        if(stopDraw)
            $(this).text("Stop Draw");
        else
            $(this).text("Let's Draw")

    })

    $("#canvas").mousedown(function(e) {
        if(!stopDraw)
            return;
        handleMouseDown(e);
    });
    $("#canvas").mousemove(function(e) {
        if(!stopDraw)
            return;
        handleMouseMove(e);
    });
    $("#canvas").mouseup(function(e) {
        if(!stopDraw)
            return;
        handleMouseUp(e);
    });
    $("#clear").click(function() {
        drawedLines.length = 0;
        redrawStoredLines();
    });

    function maxCntNum() {
        let max=0;
        $.each(drawedLines,function (kk,ss) {
            if(ss.cnt>max)
                max=ss.cnt;
        })

        return ++max;
    }

    function handleMouseDown(e) {

        let x= e.clientX + document.getElementById("drawArea").scrollLeft;
        let y= e.clientY + document.body.scrollTop;
        var mouseX = parseInt(x - offsetX);
        var mouseY = parseInt(y - offsetY);
        isDown = true;
        startX = mouseX;
        startY = mouseY;

    }

    function handleMouseMove(e) {
        if (!isDown) {
            return;
        }
        redrawStoredLines();
        let x= e.clientX + document.getElementById("drawArea").scrollLeft;
        let y= e.clientY + document.body.scrollTop;
        var mouseX = parseInt(x - offsetX);
        var mouseY = parseInt(y - offsetY);
        // draw the current line
        ctx.beginPath();
        //ctx.setLineDash([3, 3])
        ctx.fillText( "right-aligned 270 deg", 0, 0 );

        ctx.moveTo(startX, startY);
        ctx.lineTo(mouseX, mouseY);
        ctx.stroke();
    }


    function handleMouseUp(e) {
        isDown = false;
        var mouseX = parseInt(e.clientX + document.getElementById("drawArea").scrollLeft - offsetX);
        var mouseY = parseInt(e.clientY + document.body.scrollTop - offsetY);
        let data = {
            id: UUID(),
            positionInfo: "",
            cnt: maxCntNum(),
            x1: startX,
            y1: startY,
            x2: mouseX,
            y2: mouseY,
        }

        if(startX==mouseX && startY==mouseY){
            return false;
        }
        drawedLines.push(data);
        redrawStoredLines();
        //let cnt = $(".log-list").find("li").count();
        //$(".log-list").append('<li><div>'+cnt+'</div><a href="javascript:;">x</a></li>')
    }


    function redrawStoredLines() {
        $(".log-list").html("");
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        if (drawedLines.length == 0) {
            return;
        }
        $.each(drawedLines,function (k,s) {
            $(".log-list").append('<li>' +
                '<div>'+ s.cnt + ')</div>' +
                '<div>'+ s.positionInfo + '</div>' +
                '<div>' +
                '<a class="btn btn-sm btn-info action-button" data-type="edit" data-id="'+s.id+'">Edit</a>' +
                '<a class="btn btn-sm btn-danger action-button" data-type="delete" data-id="'+s.id+'">Delete</a>' +
                '</div>' +
                '</li>')

            ctx.beginPath();
            ctx.moveTo(s.x1, s.y1);
            ctx.lineTo(s.x2, s.y2);
            ctx.stroke();


            ctx.font = "20px Arial";
            ctx.fillText((s.positionInfo!="" ? s.positionInfo : s.cnt), ((s.x1+s.x2)/2)-5, ((s.y1+s.y2)/2)+8);

        })
        // redraw each stored line
    }

    $(document).on("click",".log-list li",function () {
    //    storedLines[$(this).index()].animationName

    })

    $(document).on("click",".log-list li a",function () {
  /*      storedLines.splice($(this).parent().index(),1)
        redrawStoredLines();
        $(this).parent().remove()
*/
    })

    $(document).on("click",".save-button",function () {
			//alert('ok');return true;
      localStorage.setItem("drawedLines",JSON.stringify(drawedLines));
			    document.getElementById("points").value =JSON.stringify(drawedLines);
			  event.preventDefault();
				var form = $('#monitoring-form');
				var actionUrl = form.attr('action');

				$.ajax({
						type: "POST",
						url: actionUrl,
						data: form.serialize(), // serializes the form's elements.
						success: function(data)
						{
							alert(data); // show response from the php script.
						}
				});
			
			return false;

        //TODO: ajax ile JSON data olan drawedLines db'ye kaydedilecek. 
    })
    Number.prototype.between = function(a, b) {
        var min = Math.min(a, b),
            max = Math.max(a, b);

        return this >= min && this <= max;
    };
/*
    function printMousePos(event) {
        let xTrue = yTrue = false;
        let eventX = event.clientX + document.getElementById("drawArea").scrollLeft;
        let eventY = event.clientY + document.body.scrollTop;
        console.log(eventX,eventY);
        $.each(JSON.parse(localStorage.getItem("drawedLines")),function (k,v) {
            xTrue = eventX.between(v.x1,v.x2) || (eventX-3).between(v.x1,v.x2) || (eventX+3).between(v.x1,v.x2);
            yTrue = eventY.between(v.y1,v.y2) || (eventY-3).between(v.y1,v.y2) || (eventY+3).between(v.y1,v.y2);

            console.log(xTrue,yTrue);
            if(xTrue && yTrue){
                if(confirm("Seçtiğiniz çizgi silinecektir Onaylıyor musunuz?"+ "( "+eventX+" "+eventY+")")){
                    storedLines.splice(k,1)
                    redrawStoredLines();
                    var ulElem = document.getElementsByClassName('log-list');
                    ulElem.removeChild(ulElem.childNodes[k])
                }
            }
            console.log(k,v)
        })
        localStorage.setItem("storedLines",JSON.stringify(storedLines))

    }
*/


    function to_image(){
        var canvas = document.getElementById("canvas");
        document.getElementById("theimage").src = canvas.toDataURL();
        Canvas2Image.saveAsPNG(canvas);
    }
            /*
    document.getElementById('download_map').addEventListener("click", function(e) {
        to_image();
    });*/
    function setMonitorData(id,setMonitorData){
        $.each(drawedLines,function (k,s) {
            if(s.id == id){
                drawedLines[k].positionInfo = setMonitorData;
            }
        })
    }

    function findDrawedData(id){
        $.each(drawedLines,function (s) {
            if(s.id == id){
                return s;
            }

            return null;
        })
    }

    function monitorEdit(id){
        let positionInfoMessage=null
        let data = findDrawedData(id);
        if(data!=null){
            positionInfoMessage = data.positionInfo;
        }

        positionInfoMessage = prompt("Lütfen pozisyonunu tanımlayın:"+id, positionInfoMessage==null ? "Ör: Ana giriş kapısı " : positionInfoMessage);

        setMonitorData(id,positionInfoMessage);
        redrawStoredLines();
    }
    function monitorDelete(id){
        $.each(drawedLines,function (k,s) {
            if(s.id == id){
                drawedLines.splice(k,1);
                redrawStoredLines();
            }
        })


    }

    $(document).on("click",".action-button",function () {
      
        let type = $(this).data("type");
        let id = $(this).data("id");

        switch (type) {
            case "edit":
                monitorEdit(id)
                break;
            case "delete":
                monitorDelete(id)
                break;
        }
    })
            
            
                // add button event listeners
      document.getElementById("plus").addEventListener("click", function() {
        scale += scaleMultiplier;
//        draw(scale, translatePos);
        $("#canvas").css("zoom",scale+"%")

        stopDraw=false;

      }, false);
            
                  document.getElementById("zoom_default").addEventListener("click", function() {
//        draw(scale, translatePos);
        $("#canvas").css("zoom","100%")
                    scale=100;

        stopDraw=true;

      }, false);
            

      document.getElementById("minus").addEventListener("click", function() {
        scale -= scaleMultiplier;
//        draw(scale, translatePos);
        $("#canvas").css("zoom",scale+"%")
                stopDraw=false;
      }, false);
            
</script>
            
					</div>

					</div>
				</form>
			</div>

	</div><!-- form -->
	

<?php }?>

                
  




<?php if (Yii::app()->user->checkAccess('client.maps.update')|| ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Monitoring Points Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
							<form id="departments-form" action="/client/mapupdate" method="post">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control"  name="Maps[client_id]" value="<?=$_GET['id'];?>">
					   <input type="hidden" class="form-control" id="modalmapsid"  name="Maps[id]" value="">


					<div class="row">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Map Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalmapsname" placeholder="<?=t('Map Name');?>" name="Maps[name]">
                        </fieldset>
                    </div>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Is Active');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="modalmapsactive" name="Maps[active]" >

						  <option value="1"><?=t('Active');?></option>
						  <option value="0"><?=t('Passive');?></option>

                           </select>
                        </fieldset>
						
						</div>
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page" type="submit"><?=t('Update');?></button>
								</div>
                        </fieldset>
                    </div>
						

					</div>
				</div>
				

									<!--form biti�-->
                    </div>
					</form>
                </div>
            </div>
        </div>
    </div>

	<?php }?>
	<!-- G�NCELLEME B�T��-->
	<!--S�L BA�LANGI�-->
	<?php if (Yii::app()->user->checkAccess('client.maps.delete')|| ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Map Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="departments-form" action="/client/mapdelete/0" method="post">
						<input type="hidden" class="form-control" id="basicInput"  name="Maps[client_id]" value="<?=$_GET['id'];?>">


						<input type="hidden" class="form-control" id="modalmapid2" name="Maps[id]" value="0">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- S�L B�T�� -->

	<!--delelete all start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Map Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslang��-->
						<form action="/client/mapdeleteall" method="post">

						<input type="hidden" class="form-control" id="modalid3" name="Maps[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput"  name="Maps[client_id]" value="<?=$_GET['id'];?>">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Are you sure you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- delete all finish -->

<?php }
}?>
<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

.table tr {
    cursor: pointer;
}
.hiddenRow {
    padding: 0 4px !important;
    background-color: #eeeeee;
    font-size: 13px;
}

</style>

<script>


$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
});



 //delete all start
$(document).ready(function(){
	$("#barcodesearch").hide();
	$("#openbarcode").on('click',function(){
		$("#barcodesearch").show("slow");
	})


    $('#select_all').on('click',function(){
        if(this.checked){
            $('.sec').each(function(){
                this.checked = true;
            });
        }else{
             $('.sec').each(function(){
                this.checked = false;
            });
        }
    });

    $('.sec').on('click',function(){
        if($('.sec:checked').length == $('.sec').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});

 function deleteall()
 {
	var ids = [];
	$('.sec:checked').each(function(i, e) {
		ids.push($(this).val());
	});
	$('#modalid3').val(ids);
	if(ids=='')
	 {
		alert("<?=t('You must select at least one of the checboxes!');?>");
	}
	else
	 {
		$('#deleteall').modal('show');
	 }

 }
 // delete all finish


//ekle b�l�m� baslang�c

function myFunction() {
	yy=document.getElementById("typeselect").value;
		 $.post( "/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient').html(data);
			$("#subdepartmentclient" ).prop( "disabled", false );

		 });
}


function myFunction5() {
	yy=document.getElementById("typeselect5").value;
		 $.post( "/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient5').html(data);
			$("#subdepartmentclient5" ).prop( "disabled", false );

		 });
}
//ekle b�l�m� biti�


//G�ncelle b�l�m� baslang�c




function myFunction2() {
	yy=document.getElementById("typeselect2").value;
		 $.post( "/client/subdepartments2?id="+yy).done(function( data ) {
			$('#subdepartmentclient2').html(data);

		 });
}


//G�ncelle b�l�m� biti�



function authchange(data,permission,obj)
{
$.post( "?id=<?=$_GET['id'];?>;", { id: data, active: permission })
  .done(function( returns ) {
	  toastr.success("<?=t('Update Successful');?>");
});
};

$(document).ready(function(){
	$(".switchery").on('change', function() {

	  if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this));
	  } else {
		  authchange($(this).data("id"),0,$(this));
	  }

	  $('#checkbox-value').text($('#checkbox1').val());
});
});


</script>


<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });
 $("#cancelb").click(function(){
        $("#barcodesearch").hide(500);
 });
 $(document).ready(function(){




 });



   $(document).ready(function() {
      $('.block-page').on('click', function() {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 20000, //unblock after 20 seconds
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


	$('#modalmapsid').val($(obj).data('id'));
	$('#modalmapsactive').val($(obj).data('is_active'));
	$('#modalmapsname').val($(obj).data('name'));


	$('#duzenle').modal('show');

}



function openmodalsil(obj)
{
	$('#modalmapid2').val($(obj).data('id'));
	$('#sil').modal('show');

}

$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[5,10,50,100, -1], [5,10,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },
			colvis: "<?=t('Columns Visibility');?>",

        },
				     "sDecimal": ",",
                     "sEmptyTable": "<?=t('Data is not available in the table');?>",
                     //"sInfo": "_TOTAL_ kay�ttan _START_ - _END_ aras�ndaki kay�tlar g�steriliyor",
                     "sInfo": "<?=t('Total number of records');?> : _TOTAL_",
                     "sInfoEmpty": "<?=t('No records found');?> ! ",
                     "sInfoFiltered": "(_MAX_ <?=t('records');?>)",
                     "sInfoPostFix": "",
                     "sInfoThousands": ".",
                     "sLengthMenu": "<?=t('Top of page');?> _MENU_ <?=t('record');?>",
                     "sLoadingRecords": "<?=t('Loading');?>...",
                     "sProcessing": "<?=t('Processing');?>...",
                     "sSearch": "<?=t('Search');?>:",
                     "sZeroRecords": "<?=t('No records found');?> !",
                     "oPaginate": {
                         "sFirst": "<?=t('First page');?>",
                         "sLast": "<?=t('Last page');?>",
                         "sNext": "<?=t('Next');?>",
                         "sPrevious": "<?=t('Previous');?>"
                     },
    },
	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0,1,2,3,4,5 ]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0,1,2,3,4,5 ]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
        },
     		 {
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2,3,4,5 ]
            },
			text:'<?=mb_strtoupper(t('Pdf'));?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Client Branch \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=User::model()->table('clientbranch',$_GET['id']);?> \n',
					bold: true,
					fontSize: 12,
						alignment: 'center'
				  },

						{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 11,
					alignment: 'center'
				  }],
				  margin: [0, 0, 0, 12]

				});
			  }

        },





        'colvis',
		'pageLength'
    ]
} );
<?
$ax= User::model()->userobjecty('');
$pageUrl=explode('?',$_SERVER['REQUEST_URI'])[0];
$pageLength=5;
$table=Usertablecontrol::model()->find(array(
							 'condition'=>'userid=:userid and sayfaname=:sayfaname',
							 'params'=>array(
								 'userid'=>$ax->id,
								 'sayfaname'=>$pageUrl)
						 ));
if($table){
	$pageLength=$table->value;
}
?>
var table = $('.dataex-html5-export').DataTable();
table.page.len( <?=$pageLength;?> ).draw();
var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
var info = table.page.info();
//var lengthMenuSetting = info.length; //The value you want
// alert(table.page.info().length);
} );
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



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
