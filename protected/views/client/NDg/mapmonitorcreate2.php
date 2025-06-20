<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$departments=Departments::model()->findAll(array(
    #'select'=>'',
    #'limit'=>'5',
    'order'=>'name ASC',
    'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
));

$mapsImage = MapsImages::model()->findAll(array('order'=>'id DESC','condition'=>'maps_id = :id','params'=>array('id'=>$_GET['hid'])));



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


<?php if (Yii::app()->user->checkAccess('client.branch.maps.view') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
    <?=User::model()->geturl('Client','Maps',$_GET['id'],'maps');?>
    Monitor Create Screen
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
                            <h4  class="card-title"><?=t('Monitor Update');?></h4>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <style>
                        .drawed-circle {
                            width: 35px;
                            height: 20px;
                            -webkit-border-radius: 10px;
                            -moz-border-radius: 25px;
                            border-radius: 10px;
                            background: white;
                            border-color: black;
                            border: 2px solid;
                        }
                        .monitor-centeral span {
                            position: relative;
                            display: block;
                            top: -19px;
                            font-weight: bold;
                        }
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
                        .logs {
                            position: fixed;
                            top: 50px;
                            right: 0;
                            min-width: 250px;
                            background: white;
                            z-index: 11;
                            border: 1px solid;
                            height: 100vh;
                        }
                        .top-buttons{
                            position: absolute;
                            text-align: right;
                            top: 10px;
                            right: 10px;
                        }
                        ul.log-list {
                            top: 20px;
                            list-style: none;
                            margin: 20px;
                            position: relative;
                            display: flex;
                            flex-direction: column;
                            gap: 5px;
                            padding-left: 0;
                        }
                        ul.log-list li {
                            text-align: left;
                            position: relative;
                            display: flex;
                            flex-direction: row;
                            gap: 10px;
                        }
                        .z-999{
                            z-index: 999;
                        }
                        img.item.draggable.ui-draggable.ui-draggable-handle {
                            position: absolute;
                            z-index: 999;
                        }
                        img.item.ui-draggable-handle.z-999 {
                            position: absolute;
                        }
                        .monitor-centeral{
                            position: absolute;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            z-index:15
                        }
                        .monitor-centeral.TEXT img{
                            display:none;
                        }
                        #canvas{
                        <?php
                        if(isset($mapsImage[0]) && !is_null($mapsImage[0]->img ?? null)){
                        ?>
                            background: url('<?=$mapsImage[0]->img ?? "" ?>');
                            background-size: cover;
                            background-position: top left;

                        <?php
                        }
                        ?>
                        }
                        div#customContextMenu{
                            z-index:999
                        }
                    </style>
                    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
                    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
                    <form id="monitoring-form" method="POST" >


                        <input type="hidden" class="form-control" id="mapid"  name="Maps[id]" value="<?=$_GET['hid'];?>">
                        <input type="hidden" class="form-control" id="client_id"  name="Maps[client_id]" value="<?=$_GET['id'];?>">
                        <input type="hidden" class="form-control" id="is_active"  name="Maps[is_active]" value="1">
                        <input type="hidden" class="form-control" id="points"  name="Maps[monitor]" value="<?=$map->monitor?>">

                    </form>
                    <div class="draw-box">
                        <div class="draw-box-monitor">
                            <div class="drawArea" id="drawArea">
                                <div id="heatmapContainer" style="width: 2000px; height: 1000px; position: absolute; z-index: 8; opacity: 0.7;"></div>
                                <canvas id="canvas" width="2000" height="1000" style="position: relative; z-index: 9;"></canvas>
                            </div>
                        </div>
                        <div class="logs">
                            <div class="top-buttons">
                                <button type="button" class="save-button">Save</button>
                                <button type="button" id="download_map" style="display: none">Download</button>
                                <button type="button" id="stop_draw" style="display: none">Let's Draw</button>
                            </div>
                            <ul class="log-list">
                            </ul>
                        </div>


                    </div>
                    <image id="theimage"></image>
                    <script src="https://hongru.github.io/proj/canvas2image/canvas2image.js"></script>


                    <script>
                        // TODO: monitor dataları burada localStorage'e basılacak.
                        // localStorage.setItem("drawedLines",JSON.parse('$map[points]'))




                        var monitorTypes = [
                            {
                                url: "/images/monitors/RM.png",
                                type: "RM"
                            },{
                                url: "/images/monitors/LT.png",
                                type: "LT"
                            },{
                                url: "/images/monitors/LFT.png",
                                type: "LFT"
                            },{
                                url: "/images/monitors/CI.png",
                                type: "CI"
                            },{
                                url: "/images/monitors/MT.png",
                                type: "MT"
                            },{
                                url: "/images/monitors/BS.png",
                                type: "BS"
                            },{
                                url: "/images/monitors/BN.png",
                                type: "BN"
                            },{
                                url: "/images/monitors/text.png",
                                type: "TEXT"
                            }
                        ];
                        let leftSpace = 20;
                        /*$.each(monitorTypes,function (k,v) {
                            $(".draw-box-monitor").prepend('<img class="item draggable" src="'+v.url+'" data-type="'+v.type+'" width="20" style="left:'+((k*20)+(leftSpace+=5))+'px">');
                        })*/
                        var canvas = document.getElementById("canvas");
                        var ctx = canvas.getContext("2d");
                        var canvasOffset = $("#canvas").offset();
                        var offsetX = canvasOffset.left;
                        var offsetY = canvasOffset.top;

                        <?php
                        if (strlen($map->points)>1)
                        {
                        ?>

                        var drawedLines =JSON.parse('<?=$map->points?>');
                        localStorage.setItem("drawedLines",drawedLines)

                        <?php
                        }else{
                        ?>
                        var drawedLines = localStorage.getItem("drawedLines") == null ? [] : JSON.parse(localStorage.getItem("drawedLines"));
                        <?php
                        }
                        ?>



                        <?php
                        if (strlen($map->monitor)>1)
                        {
                        ?>


                        var monitors = JSON.parse('<?=$map->monitor?>');

                        <?php
                        }else{
                        ?>
                        var monitors = localStorage.getItem("monitors_<?=$_GET["hid"]?>") == null ? [] : JSON.parse(localStorage.getItem("monitors_<?=$_GET["hid"]?>"));

                        <?php
                        }
                        ?>


                        //var drawedLines = localStorage.getItem("drawedLines") == null ? [] : JSON.parse(localStorage.getItem("drawedLines"));
                        var startX = 0;
                        var startY = 0;
                        var isDown;
                        var stopDraw=false;
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
                        }


                        function redrawStoredLines() {
                            $(".log-list").html("");
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            if (drawedLines.length == 0) {
                                return;
                            }
                            // redraw each stored line
                            for (var i = 0; i < drawedLines.length; i++) {
                                //$(".log-list").append('<li><div>'+i+'</div><a href="javascript:;">x</a></li>')
                                ctx.beginPath();
                                ctx.moveTo(drawedLines[i].x1, drawedLines[i].y1);
                                ctx.lineTo(drawedLines[i].x2, drawedLines[i].y2);
                                ctx.stroke();

                                //ctx.font = "20px Arial";
                                // ctx.fillText(i, ((drawedLines[i].x1+drawedLines[i].x2)/2)-5, ((drawedLines[i].y1+drawedLines[i].y2)/2)+8);


                            }
                        }
                        /*
                            $(document).on("click",".log-list li",function () {
                                drawedLines[$(this).index()].animationName
                            })

                            $(document).on("click",".log-list li a",function () {
                                drawedLines.splice($(this).parent().index(),1)
                                redrawStoredLines();
                                $(this).parent().remove()

                            })
                        */
                        $(document).on("click",".save-button",function () {

                            //TODO: ajax ile kayıt işlemini yapacağız. takipte paylaşılan monitors dataları kaydedilecek.
                            // var monitors = localStorage.getItem("monitors") ;

                            document.getElementById("points").value =JSON.stringify(monitors);
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

                        })
                        Number.prototype.between = function(a, b) {
                            var min = Math.min(a, b),
                                max = Math.max(a, b);

                            return this >= min && this <= max;
                        };

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
                                        drawedLines.splice(k,1)
                                        redrawStoredLines();
                                        var ulElem = document.getElementsByClassName('log-list');
                                        ulElem.removeChild(ulElem.childNodes[k])
                                    }
                                }
                                console.log(k,v)
                            })
                            localStorage.setItem("drawedLines",JSON.stringify(drawedLines))

                        }

                        function findMonitorData(id){
                            $.each(monitors,function (s) {
                                if(s.id == id){
                                    return s;
                                }

                                return null;
                            })
                        }

                        function setMonitorData(id,setMonitorData){
                            $.each(monitors,function (k,s) {
                                if(s.id == id){
                                    monitors[k].positionInfo = setMonitorData;
                                }
                            })
                        }

                        function findMonitorByType(type) {
                            let src=null;
                            $.each(monitorTypes,function (k,v) {
                                console.log(v.type,type)
                                if(v.type==type){
                                    src= v.url
                                }
                            })
                            return src;
                        }
                        function monitorList(){
                            let positionInfoMessage = null;
                            let monitor = "";
                            $(".log-list").html("");
                            let cnt = 1;

                            $.each(monitors,function (k,s) {
                                $("body").find("#row_monitor_"+s.positionInfo).fadeOut("fast");
                                $(".log-list").append('<li>' +
                                    '<div>'+ (cnt++) + ')</div>' +
                                    '<div>' + s.positionInfo +'</div>' +
                                    '<div>('+s.type+')</div>' +
                                    '<div>' +
                                    '<button class="btn btn-sm btn-warning action-button" data-type="rotate" data-id="'+s.id+'" data-position="">Rotate</button>' +
                                    '<button class="btn btn-sm btn-info action-button" data-type="edit" data-id="'+s.id+'" data-position="">Edit</button>' +
                                    '<button class="btn btn-sm btn-danger action-button" data-type="delete" data-id="'+s.id+'" data-position="'+s.positionInfo+'">Delete</button>' +
                                    '</div>' +
                                    '</li>')

                                monitor+= '<div class="monitor-centeral '+s.type+' monitor_container_'+s.id+'" style="inset: '+s.top+'px auto auto '+s.left+'px; transform:rotate('+(typeof s.rotate == 'undefined' ? 0 : s.rotate)+'deg)" data-rotate="'+(typeof s.rotate == 'undefined' ? 0 : s.rotate)+'">' + '<div class="drawed-circle" style="background:'+s.mbgc+'; border-color:'+s.mbc+'"></div>' + '<span style="">'+s.positionInfo+'</span></div>';

                                $('.drawArea .draggable')
                                    .addClass('item-' + s.id)
                                    .addClass("z-999")
                                    .attr("id",'item_' + s.id)
                                    .attr("data-id",s.id)


                                $('.drawArea .item-' + s.id).removeClass('draggable ui-draggable ui-draggable-dragging');

                                $("body").find('.drawArea .item-' + s.id).dblclick(function() {
                                    let id = $(this).data("id");
                                    if(positionInfoMessage!==null){
                                        let data = findMonitorData(id);
                                        if(data!=null){
                                            positionInfoMessage = data.positionInfo;
                                        }
                                    }
                                    positionInfoMessage = prompt("Lütfen monitör pozisyonunu tanımlayın:"+id, positionInfoMessage==null ? "Ör: Ana giriş kapı yanı" : positionInfoMessage);

                                    setMonitorData(id,positionInfoMessage);
                                    //monitorList();
                                    //$(this).remove();
                                });



                                //make_draggable($('.dropzone .item-' + s.id));
                            })
                            $.each($("#drawArea").find(".monitor-centeral"),function(){
                                $(this).remove()
                            })
                            $("#drawArea").append(monitor)
                            localStorage.setItem("monitors_<?=$_GET["hid"]?>",JSON.stringify(monitors))
                        }


                        document.getElementById('download_map').addEventListener("click", function(e) {
                            to_image();
                        });



                        $(function(){
                            var zIndex = 0,
                                counts = [monitors.length];

                            function make_draggable(elements) {
                                elements.draggable({
                                    containment: 'parent',
                                    start: function(e,ui) {
                                        ui.helper.css('z-index', ++zIndex);
                                    },
                                    stop:function(e, ui) {
                                    }
                                });
                            }

                            $('.draggable').draggable({
                                helper: 'clone',
                                start: function() {
                                    counts[0]++;
                                }
                            });

                            $('.drawArea').droppable({
                                drop: function(e, ui){
                                    if (ui.draggable.hasClass('draggable')) {

                                        let positionInfoMessage = null;
                                        //$(this).append($(ui.helper).clone());



                                        var monitorData = {
                                            id: UUID(),
                                            left: ui.position.left,
                                            top: ui.position.top,
                                            type: $(ui.helper).data("type"),
                                            positionInfo: positionInfoMessage
                                        }


                                        monitors.push(monitorData)
                                        monitorList();

                                    }
                                },
                                out: function(e,ui){
                                    var offset = $(this).offset();

                                    let eventX = offset.left + document.getElementById("drawArea").scrollLeft;
                                    let eventY = offset.top + document.body.scrollTop;

                                    var xPos = offset.left;
                                    var yPos = offset.top;
                                }
                            });
                        });

                        function monitorEdit(id){
                            let positionInfoMessage=null
                            let data = findMonitorData(id);
                            if(data!=null){
                                positionInfoMessage = data.positionInfo;
                            }

                            positionInfoMessage = prompt("Lütfen monitör pozisyonunu tanımlayın:"+id, positionInfoMessage==null ? "Ör: Ana giriş kapı yanı" : positionInfoMessage);

                            setMonitorData(id,positionInfoMessage);
                            monitorList();
                        }


                        function monitorDelete(id){
                            $.each(monitors,function (k,s) {
                                if(s.id == id){
                                    monitors.splice(k,1);
                                    $("body").find(".item_"+id).remove()
                                    monitorList();
                                }
                            })
                        }

                        function monitorRotate(id){
                            let rotate = parseInt($("body").find(".monitor_container_"+id).data("rotate"))+90;
                            $("body").find(".monitor_container_"+id).data("rotate",(rotate))
                            $("body").find(".monitor_container_"+id).css({'transform':'rotate('+$("body").find(".monitor_container_"+id).data("rotate")+'deg)'});

                            $.each(monitors,function (k,s) {
                                if(s.id == id){
                                    monitors[k].rotate = rotate;
                                }
                            })
                            localStorage.setItem("monitors_<?=$_GET["hid"]?>",JSON.stringify(monitors))
                        }

                        $(document).on("click",".action-button",function () {
                            let type = $(this).data("type");
                            let id = $(this).data("id");
                            let position = $(this).data("position");

                            switch (type) {
                                case "edit":
                                    monitorEdit(id)
                                    break;
                                case "delete":
                                    $("body").find("#row_monitor_"+position).fadeIn("fast");
                                    monitorDelete(id)
                                    break;
                                case "rotate":
                                    monitorRotate(id)
                                    break;
                            }
                        })
                        monitorList();
                    </script>

                </div>




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
            var lengthMenuSetting = info.length; //The value you want
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

    <!---   Right Click Start    --->


    <!-- Özel bağlam menüsü -->

    <style>
        #customContextMenu{
            position:absolute;
            display:none;
            z-index: 999;
            border: 1px solid #ccc;
            padding: 15px;
            background: white;
        }
    </style>

    <!-- Buradan itibaren başlıuor--->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/heatmap.js/2.0.0/heatmap.min.js"></script>
    <script>
        // Initialize heatmap instance with more aggressive settings
        const heatmapInstance = h337.create({
            container: document.getElementById('heatmapContainer'),
            radius: 70,
            maxOpacity: 0.8,
            minOpacity: 0, // Changed to 0 for full transparency at minimum
            blur: 0.9,
            gradient: {
                '0.1': 'green', // Transparent for lowest values
                '0.4': 'yellow',
                '0.6': 'orange',
                '0.8': 'red',
                '1.0': 'darkred'
            }
        });

        // Update the existing monitorList function
        function monitorList() {
            let positionInfoMessage = null;
            let monitor = "";
            $(".log-list").html("");
            let cnt = 1;

            $.each(monitors,function (k,s) {
                $("body").find("#row_monitor_"+s.positionInfo).fadeOut("fast");
                $(".log-list").append('<li>' +
                    '<div>'+ (cnt++) + ')</div>' +
                    '<div>' + s.positionInfo +'</div>' +
                    '<div>('+s.type+')</div>' +
                    '<div>' +
                    '<button class="btn btn-sm btn-warning action-button" data-type="rotate" data-id="'+s.id+'" data-position="">Rotate</button>' +
                    '<button class="btn btn-sm btn-info action-button" data-type="edit" data-id="'+s.id+'" data-position="">Edit</button>' +
                    '<button class="btn btn-sm btn-danger action-button" data-type="delete" data-id="'+s.id+'" data-position="'+s.positionInfo+'">Delete</button>' +
                    '</div>' +
                    '</li>')

                monitor+= '<div class="monitor-centeral '+s.type+' monitor_container_'+s.id+'" style="inset: '+s.top+'px auto auto '+s.left+'px; transform:rotate('+(typeof s.rotate == 'undefined' ? 0 : s.rotate)+'deg)" data-rotate="'+(typeof s.rotate == 'undefined' ? 0 : s.rotate)+'">' + '<div class="drawed-circle" style="background:'+s.mbgc+'; border-color:'+s.mbc+'"></div>' + '<span style="">'+s.positionInfo+'</span></div>';

                $('.drawArea .draggable')
                    .addClass('item-' + s.id)
                    .addClass("z-999")
                    .attr("id",'item_' + s.id)
                    .attr("data-id",s.id)


                $('.drawArea .item-' + s.id).removeClass('draggable ui-draggable ui-draggable-dragging');

                $("body").find('.drawArea .item-' + s.id).dblclick(function() {
                    let id = $(this).data("id");
                    if(positionInfoMessage!==null){
                        let data = findMonitorData(id);
                        if(data!=null){
                            positionInfoMessage = data.positionInfo;
                        }
                    }
                    positionInfoMessage = prompt("Lütfen monitör pozisyonunu tanımlayın:"+id, positionInfoMessage==null ? "Ör: Ana giriş kapı yanı" : positionInfoMessage);

                    setMonitorData(id,positionInfoMessage);
                    //monitorList();
                    //$(this).remove();
                });



                //make_draggable($('.dropzone .item-' + s.id));
            })
            $.each($("#drawArea").find(".monitor-centeral"),function(){
                $(this).remove()
            })
            $("#drawArea").append(monitor)
            localStorage.setItem("monitors_<?=$_GET["hid"]?>",JSON.stringify(monitors))
        }

        function updateHeatmap() {
            try {
                // Find max count for normalization
                let maxCount = Math.max(...monitors.map(m => m.count || 0));
                maxCount = 500;
                // Convert monitors data to heatmap.js format
                const points = monitors.map(monitor => ({
                    x: Math.round(monitor.left),
                    y: Math.round(monitor.top),
                    value: monitor.count || Math.floor(Math.random() * (1000 - 1 + 1) + 1) // Default to 1 if count is not set
                }));

                console.log('Heatmap points:', points); // Debug log

                // Set heatmap data
                heatmapInstance.setData({
                    max: maxCount || 100, // Default max if no counts exist
                    min: 0,
                    data: points
                });
            } catch (error) {
                console.error('Heatmap update error:', error);
            }
        }

        // Add test data if needed
        function addTestData() {
            const testData = {
                max: 100,
                data: [
                    {x: 100, y: 100, value: 100},
                    {x: 200, y: 200, value: 80},
                    {x: 300, y: 300, value: 60}
                ]
            };
            heatmapInstance.setData(testData);
        }

        // Call updateHeatmap initially
        document.addEventListener('DOMContentLoaded', () => {
            updateHeatmap();
            // Uncomment to test with sample data
            // addTestData();
        });

        // Add styles for the heatmap container
        const style = document.createElement('style');
        style.textContent = `
    #heatmapContainer {
        mix-blend-mode: multiply;
        pointer-events: none;
    }
    #heatmapContainer canvas {
        opacity: 0.7 !important;
    }
`;
        document.head.appendChild(style);
    </script>

    <script>
        var contextMenu = null;
        var positionX=0;
        var positionY=0;
        var x=0;
        var y=0;
        document.addEventListener("DOMContentLoaded", function() {
            contextMenu = document.getElementById("customContextMenu");

            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");

            // Canvas üzerinde sağ tıklama olayını dinle
            canvas.addEventListener("contextmenu", function(event) {
                // Sağ tıklanan noktanın x ve y koordinatlarını al
                x = event.clientX - canvas.getBoundingClientRect().left;
                y = event.clientY - canvas.getBoundingClientRect().top;

                // Koordinatları konsola yazdır
                console.log("Right-Click - X: " + x + ", Y: " + y);

                /*
                $("#customContextMenu").css({
                    top: x + "px",
                    left: y + "px"
                });*/

                // İsteğe bağlı olarak sağ tıklanan noktaya bir işlem ekleyebilirsiniz

                // Sağ tıklamanın varsayılan davranışını engelle
            });



            document.addEventListener("contextmenu", function(event) {
                event.preventDefault(); // Tarayıcı tarafından sağ tıklama menüsünü engelle
//      showContextMenu(event.clientX, event.clientY);
                showContextMenu(x, y);
            });

            function showContextMenu(_x, _y) {
                positionX=x;
                positionY=y;
                console.log(_x,_y)
                if(_x<1000){
                    _x=50;
                }else{
                    _x -=1000;
                }
                if(_y<440){
                    _y=50;
                }else{
                    _y-=440;
                }

                contextMenu.style.display = "block";
                contextMenu.style.left =  _x+"px";
                contextMenu.style.top =  _y+"px";



                document.getElementById("close_monitor_selection").addEventListener("click", function() {
                    contextMenu.style.display = "none";
                });

            }

        });

        $(document).on("click",".addMonitorToPosition",function(){
            console.log("monitor to position")
            console.log($(this).data("id")+" "+$(this).data("mno")+" "+$(this).data("mtypeid")+" "+$(this).data("mtypename"))
            contextMenu.style.display = "none";

            var monitorData = {
                id: UUID(),
                left: positionX,
                top: positionY,
                type: $(this).data("mtypename"),
                monitorId: $(this).data("mtypeid"),
                positionInfo: $(this).data("mno"),
                mbc: $(this).data("mbc"),
                mbgc: $(this).data("mbgc")
            }

            monitors.push(monitorData)
            monitorList();

            console.log(monitors);
        })



    </script>

    <!---   Right Click End    --->

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