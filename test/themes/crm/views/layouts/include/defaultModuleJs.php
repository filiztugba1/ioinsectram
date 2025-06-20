<style>
  .pagination{
    float:right
  }
  .dataTables_filter>label{
     float:right
  }
  .card-header {
    /* border-bottom: 1px solid; */
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);

}
  .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 0px;
    background-color: transparent;
}
  .cu_button{
    border: #fff solid 1px;
    border-radius: 50%;
    padding: 4px;
    margin-right: 5px;
  }
  .card-header>span{
    font-size: 18px;
    font-weight: 600;
  }
  td>div>a{
    margin-right:1px;
    margin-left:1px
  }
  .btn-effect2 {
    padding: 0px 9px 0 9px;
    border: 1px solid #62769a;
    margin-right: 9px;
    border-radius: 100%;
    background: #63779c;
    color: #fff;
}
    .btn-effect3 {
    padding: 0px 3px 0 3px;
    border: 1px solid #62769a;
    margin-right: 9px;
    border-radius: 100%;
    background: #63779c;
    color: #fff;
}
  .fa{
    margin:0px!important;
  }

  .nav.nav-tabs .nav-item .nav-link {
    padding: 0.3rem 0.3rem !important;
    display: inline-flex !important;
}
  .bootstrap-select.btn-group .dropdown-menu.inner {
    position: static;
    float: none;
    border: 0;
    padding: 0;
    margin: 0;
    border-radius: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
}
  .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
    color: #fff;
    text-decoration: none;
    background-color: #337ab7;
    outline: 0;
}
  .dropdown-menu>li>a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
}
  .btn:not(:disabled):not(.disabled) {
    border: #cfd9e7 solid !important;
    border-width: 1px !important;
}
</style>
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




<style>
.treex {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fbfbfb;
    border:1px solid #999;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
}
.treex li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    //position:relative
}
.treex li::before, .treex li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.treex li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.treex li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.treex li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #999;
    border-radius:5px;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none
}
.treex li.parent_li>span {
    cursor:pointer
}
.treex>ul>li::before, .treex>ul>li::after {
    border:0
}
.treex li:last-child::before {
    height:30px
}
.treex li.parent_li>span:hover, .treex li.parent_li>span:hover+ul li span {
    background:#eee;
    border:1px solid #94a0b4;
    color:#000
}
.parent_li
{clear: both;}
</style>
<script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/tables/datatable/datatables.min.js?1" type="text/javascript"></script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?1" type="text/javascript"></script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?1" type="text/javascript"></script>
 <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js" type="text/javascript"></script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
<script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/js/scripts/forms/switch.js" type="text/javascript"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />



    <script>

        var listTable = [];

        async function documents(classname, columns, pdfbaslik, columnsData,ajaxUrl,ajaxMethod,formData,pdfName, tabledata = '',sayTableDivId='') {
          var token=localStorage.getItem('token');
            let dataTable = $("." + classname).DataTable({
                "scrollX": true,
                "bDestroy" : true, //<-- add this option
                "bJQueryUI" : true,
                "autoWidth": false,
                dom: "Bfrtip",
                "search": {
                    "caseInsensitive": true
                },
               /* 'fixedColumns': {
                    leftColumns: 2,
                },
                */
                lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "<?=t("Tümünü Göster");?>"]],
                language: {
                    buttons: {
                        pageLength: {
                            _: " %d <?=t('Satır Göster');?>",
                            "-1": "<?=t('Hepsi');?>",
                            className: "d-none d-sm-none d-md-block",
                        },
                        html: true,
                        colvis: "<?=t('Sütun Görünümü');?>",


                    },
                    "sDecimal": ",",
                    "sEmptyTable": "<?=t('Veriler Tabloda Mevcut Değil');?>",
                    //"sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                    "sInfo": "<?=t('Toplam Kayıt Sayısı');?> : _TOTAL_",
                    "sInfoEmpty": "<?=t('Kayıt Bulunamadı !');?>",
                    "sInfoFiltered": "(_MAX_ '<?=t('Kayıtlar');?>')",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "<?=t('Sayfa Başı');?> _MENU_ <?=t('kayıt');?>",
                    "sLoadingRecords": "<?=t('Yükleniyor');?>...",
                    "sProcessing": "<?=t('İşlem');?>...",
                    "sSearch": "<?=t('Arama');?>:",
                    "sZeroRecords": "<?=t('Kayıt Bulunamadı');?> !",
                    "oPaginate": {
                        "sFirst": "<?=t('İlk Sayfa');?>",
                        "sLast": "<?=t('Son Sayfa');?>",
                        "sNext": "<?= t('Sonraki');?>",
                        "sPrevious": "<?= t('Önceki');?>"
                    },
                },
               select:true ,
                buttons: [
                    {
                        extend: "excelHtml5",
                        exportOptions: {
                            columns: columns
                        },
                        text: "Excel",
                        className: "d-none d-sm-none d-md-block",
                        title: "<?=t('Yoksis Asal Liste') . '-' . date("d/m/Y");?>",
                        messageTop: pdfbaslik
                    },
                    {
                        extend: "pdfHtml5",
                        exportOptions: {
                            columns: columns
                        },
                        text: "PDF",
                        title: pdfbaslik + '<?=date("d/m/Y");?>',
                        header: true,
                        orientation: "landscape",
                        pageSize: "LEGAL",
                        customize: function (doc) {
                            doc.content.splice(0, 1, {
                                text: [{
                                    text: "\n",
                                    bold: true,
                                    fontSize: 16,
                                    alignment: "center"
                                },
                                    {
                                        text: pdfbaslik + "\n",
                                        bold: true,
                                        fontSize: 12,
                                        alignment: "center"
                                    },
                                    {
                                        text: '<?=date("d/m/Y");?>',
                                        bold: true,
                                        fontSize: 11,
                                        // alignment: center
                                    }],
                                margin: [0, 0, 0, 12]

                            });
                           // doc.content[0].text = "SALES ORDER";
                            doc.pageMargins = [10, 10, 45, 20];
                            doc.defaultStyle.fontSize = 12;
                            doc.styles.tableHeader.fontSize = 14;
                            doc.styles.title.fontSize = 14;
                            doc.footer = function(page, pages) {
                                return {
                                    margin: [5, 0, 10, 0],
                                    height: 30,
                                    columns: [{
                                        alignment: "left",
                                        text: '<?= t('OASIS tarafından '.date("d/m/Y").' tarihinde üretilmiştir.');?>',
                                    },
                                        {
                                            alignment: "right",
                                            text: [
                                                { text: page.toString(), italics: true },
                                                " of ",
                                                { text: pages.toString(), italics: true }
                                            ]
                                        }

                                    ]
                                }
                            }
                        },

                    },
                    "colvis",
                    "pageLength",

                ],
                "ajax": {
                    "type" : ajaxMethod,
                    "url" : ajaxUrl,
                    "data":formData,
                    "dataType": 'json',
                     headers: {
                  'Authorization': 'Bearer '+token
               },
                    "dataSrc": function ( json ) {
                        //Make your callback here.
                        $("#backgroundLoading").removeClass("backgroundLoading");
                        if(json.status==true)
                        {
                           // setTimeout(function(){ listTablePush(classname,dataTable)}, 100);
                            if(json.data.length==0)
                            {
//                                 swal({
//                                     title: "<?= t('Uyarı')?>",
//                                     text:pdfbaslik+" <?= t('İçin Sonuç Bulunamadı.')?>",
//                                     type: "warning",
//                                     confirmButtonText: "<?= t('Tamam')?>"
//                                 })
                            }
                         // console.log(sayTableDivId);
                          $('#'+sayTableDivId).html(json.data.length);

                            return json.data;
                        }
                        else
                        {
                            swal({
                                title: "<?= t('Hata')?>",
                                text:" <?= t('Liste oluşturulma sırasında hata oluştu.')?>",
                                type: "error",
                                confirmButtonText: "<?= t('Tamam')?>"
                            })
                            return [];
                        }
                    }
                },
                "columns": columnsData,
              // "data": data,
              /*  "rowCallback": function (row, data) {
                    if (data.color != "" && data.color != undefined && data.color != null) {
                        $(row).css("backgroundColor", data.color);
                    }
                },
                */
              "fnDrawCallback": function() {
                  $('.switch').bootstrapToggle({
                     on: 'Aktif',
                     off: 'Pasif',
                     onstyle: "success",
                     offstyle:"danger" ,
                     size:"mini"
                 });
              },
              "rowCallback": function (row, data) {
                console.log("burada");
                console.log(data);
                $(row).addClass("trUrl");
                if (data.color != "" && data.color != undefined && data.color != null) { 
                  $(row).css("backgroundColor", data.color);

                } },
              /*  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if(aData.tdColor != "" && aData.tdColor != undefined && aData.tdColor != null)
                    {
                        let tdColor=aData.tdColor;
                        for(let i=0;i<columnsData.length;i++)
                        {
                            datam=aData[columnsData[i].data];
                            let varmi=tdColor.find(x=>x==columnsData[i].data);
                            if(varmi!=undefined)
                            {
                                $(nRow).find('td:eq('+i+')').css('color', 'red');

                                //$('td', nRow).css('background-color', 'Red');
                            }
                        }
                    }
                }
              */
            });
            let result = await dataTable; // wait until the promise resolves (*)
            listTablePush(classname,result);

  <?php        $ax= User::model()->userobjecty('');
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
var table = result;
table.page.len( <?=$pageLength;?> ).draw();
var table = result; //note that you probably already have this call
var info = table.page.info();
var lengthMenuSetting = info.length; //The value you want

        }
        $(".dataTables_wrapper").css("width","100%"); //tüm datatable width ları ekranda 100% olarak ekran kaplaması için

        function listTablePush(classname,dataTable)
        {
           isDataTableIndex = listTable.findIndex(x => x.class == classname);
            if (isDataTableIndex != undefined && isDataTableIndex != null && isDataTableIndex!=-1) {
                listTable.splice(isDataTableIndex, 1);
            }
            listTable.push({"class": classname, "value": dataTable});
        }

        function logTableList(listId, tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata = '')
        {
            var tableHtml='<div class="row">' +
                '<div class="col-md">' +
                '<div class="card mb-4">' +
                '<div class="card-header with-elements"><span class="card-header-title mr-2">'+pdfName+'</span>'+
                '</div>' +
                '<div class="card-body"><div id="'+listId+'"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            $("#logTableListDiv").html(tableHtml);
            tableList(listId, tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata)
        }

        function tableList(listId, tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata = '',sayTableDivId='') {

             tableHtml =
                '<table class="table table-striped table-bordered ' + tableClass + '">' +
                '<thead>';

            if (columnArray[0][0] != undefined && columnArray[0][0] != null) {
                for (let i = 0; i < columnArray.length; i++) {
                    tableHtml = tableHtml + '<tr>';
                    if (i == columnArray.length - 1 && listButtonArray != null && listButtonArray != undefined && listButtonArray != '' && listButtonArray.length > 0) {
                        tableHtml = tableHtml + '<th><?= t('İşlem');?></th>';
                    }

                    for (let j = 0;j < columnArray[i].length;j++)
                    {
                        var colspan=columnArray[i][j]["colspan"];
                        colspan1=colspan!=null && colspan!=undefined&& colspan!=""?"colspan='"+colspan+"'":"";
                        var rowspan=columnArray[i][j]["rowspan"];
                        rowspan1=rowspan!=null && rowspan!=undefined&& rowspan!=""?"rowspan='"+rowspan+"'":"";
                        tableHtml = tableHtml + '<th '+rowspan1+' '+colspan1+'>' + columnArray[i][j]['value'] + '</th>';
                    }
                    tableHtml = tableHtml + '</tr>';
                }
            } else {
                tableHtml = tableHtml + '<tr>';
                if (listButtonArray != null && listButtonArray != undefined && listButtonArray != '' && listButtonArray.length > 0) {
                    tableHtml = tableHtml + '<th><?= t('İşlem');?></th>';
                }

                for (var i = 0; i < columnArray.length; i++) {
                    tableHtml = tableHtml + '<th><a class="column_sort" id="' + columnArray[i]['key'] + '" >' + columnArray[i]['value'] + '</a></th>';
                }
                tableHtml = tableHtml + '</tr>';
            }

            tableHtml = tableHtml +
                '</thead>' +
                '</table>';

            $('#' + listId).html(tableHtml);
            ApiListeFunc(tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata,sayTableDivId);
        }


        function ApiListeFunc(tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata = '',sayTableDivId) {
            // var namesurname = $(this).data("namesurname");
            $("#backgroundLoading").addClass("backgroundLoading");
            var columnsData = [];
            var pdfArray = [];
            var defaultContent = '';
            if (listButtonArray != '' && listButtonArray != null && listButtonArray.length != 0 && listButtonArray != undefined) {

                 /* columnsData.push({
                        "data": null,
                        className: "center",
                        // defaultContent: defaultContent,
                        "render": function (data) {
                            return '<div class="m-4"><input type="checkbox" class="pendingChk" value="' + data['stu_id'] + '">';

                        }
                    });
                    */

                    columnsData.push({
                        "data": null,
                        className: "center",
                        // defaultContent: defaultContent,
                        "render": function (data) {
                            defaultContent='';
                            defaultContent += '<div class="col-6">';
                            for (let i = 0; i < listButtonArray.length; i++) {
                                let datam='';
                                for(let j=0;j<listButtonArray[i]['data'].length;j++)
                                {
                                    datam=datam+' data-'+listButtonArray[i]['data'][j]+'="'+data[listButtonArray[i]['data'][j]]+'"';
                                }

                                   defaultContent += '<a '+datam+' class="'+listButtonArray[i]['class']+'"  data-buttontype="'+listButtonArray[i]['class']+'" data-toggle="tooltip" data-placement="top" title="'+listButtonArray[i]['title']+'">' +
                                    '<i class="'+listButtonArray[i]["iconClass"]+'"></i></a>' ;

                            }
                                   defaultContent +=  '</div>';
                         //   console.log(defaultContent);
                            return defaultContent;
                        }
                    });

            }


            if (columnArray[0][0] != undefined && columnArray[0][0] != null) {
                columnArray=columnArray[columnArray.length-1];
            }

            for (let i = 0; i < columnArray.length; i++) {

                if(columnArray[i]['data']!=undefined && columnArray[i]['data'] != null)
                {
                    columnsData.push({
                        "data": null,
                        className: "center",
                        "render": function (data) {
                            defaultContent='';
                                let datam='';
                                for(let j=0;j<columnArray[i]['data'].length;j++)
                                {
                                    datam=datam+' data-'+columnArray[i]['data'][j]+'="'+data[columnArray[i]['data'][j]]+'"';
                                }
                            if(columnArray[i]['button-text']!=undefined && columnArray[i]['button-text'] != null && columnArray[i]['button-text']!='' )
                            {
                                defaultContent += '<div class="col-12">' +
                                    '<a  style="color:#000;cursor: pointer;background:#d6d2d2"'+datam+' class="btn btn-sm tablerow '+columnArray[i]['key']+'"  data-buttontype="'+columnArray[i]['key']+'" data-toggle="tooltip" data-placement="top" title="'+columnArray[i]['value']+'">' +
                                    columnArray[i]['button-text']
                                    '</div>';
                            }
                            else
                            {
                                if(columnArray[i]['type']==='url')
                                {
                                    defaultContent += '<div class="col-12">' +
                                        '<a target="_blank" href="'+columnArray[i]['url']+'/'+data['id']+'" style="color:red;cursor: pointer;"'+datam+' class="tablerow '+columnArray[i]['key']+'"  data-buttontype="'+columnArray[i]['key']+'" data-toggle="tooltip" data-placement="top" title="'+columnArray[i]['value']+'">' +
                                        data['name']+
                                        '</div>';
                                }
                               else if(columnArray[i]['type']==='checbox')
                                {

                                  defaultContent += '<input  class="switch" type="checkbox" onchange="isactive(this)" data-toggle="toggle" data-on="Ready" data-off="Not Ready" data-onstyle="success" data-offstyle="danger" '+datam+' '+(data[columnArray[i]['key']]==1?"checked":"")+' />';

                                }
                                else
                                {
                                    defaultContent += '<div class="col-12">' +
                                        '<a style="color:red;cursor: pointer;"'+datam+' class="tablerow '+columnArray[i]['key']+'"  data-buttontype="'+columnArray[i]['key']+'" data-toggle="tooltip" data-placement="top" title="'+columnArray[i]['value']+'">' +
                                        data[columnArray[i]['key']]+
                                        '</div>';
                                }

                            }


                            //   console.log(defaultContent);
                            return defaultContent;
                        }
                    });
                }
                else
                {
                    columnsData.push({"data": columnArray[i]['key']});
                }
                pdfArray.push(i);
            }
            console.log(columnsData);
            documents(tableClass, pdfArray, pdfName, columnsData, ajaxUrl,ajaxMethod,formData, pdfName, tabledata,sayTableDivId);

        }

        function tableUpdate(data)
        {

            for(let i=0;i<data.length;i++)
            {
                isDataTableIndex = listTable.findIndex(x => x.class == data[i]["class"]);
                if(isDataTableIndex!=undefined && isDataTableIndex!=null && isDataTableIndex!=-1)
                {
                    let table=listTable[isDataTableIndex].value;
                    if(data[i]["url"]==undefined || data[i]["url"]==null || data[i]["url"]=="")
                    {
                        table.ajax.reload();
                    }
                    else
                    {
                        table.ajax.url(data[i]["url"]).load();
                    }
                }
            }
        }

        ///form oluşturuluyor
        function formOlustur(header, body, footer) {  //1 ise bir kere submit edilmiş
            if (header != "" && header != undefined && header != null) {
                let headerHtml = '';
                for (let i = 0; i < header['data'].length; i++) {  //header oluşturuluyor
                    url = header['data'][i]['url'] != undefined && header['data'][i]['url'] != null && header['data'][i]['url'] != '' ? "url=" + header['data'][i]['url'] : "";
                    iconn = header['data'][i]['icon'] != undefined && header['data'][i]['icon'] != null && header['data'][i]['icon'] != '' ? "<i class= 'feather " + header['data'][i]['icon'] + "' ></i>" : "";
                    if (header['data'][i]['type'] == 'text') {
                        headerHtml = headerHtml +
                            '<span class="' + header['data'][i]['class'] + '">' + header['data'][i]['title'] + '</span>';
                    }
                    if (header['data'][i]['type'] == 'button') {

                        headerHtml = headerHtml +
                            '<a  style="float: right;"' + url + ' id="' + header['data'][i]['id'] + '" class="' + header['data'][i]['class'] + '">' + iconn + header['data'][i]['title'] + '</a>';
                    }
                    if (header['data'][i]['type'] == 'closebutton') {

                        headerHtml = headerHtml +
                            '<button type="button" class="close" data-dismiss="modal">' +
                            '<span aria-hidden="true">&times;</span> ' +
                            '</button>';
                    }
                }
                $('#' + header['card-header-id']).html(headerHtml);
            }
            if (body != "" && body != undefined && body != null) {
                requiredHtml(body, 0);
            }
            if (footer != "" && footer != undefined && footer != null) {
                let footerHtml = '';
                footerHtml = footerHtml + "<div class='col-lg-12 float-right'>";
                for (let i = 0; i < footer['data'].length; i++) {  //header oluşturuluyor
                    url = footer['data'][i]['url'] != undefined && footer['data'][i]['url'] != null && footer['data'][i]['url'] != '' ? "url=" + footer['data'][i]['url'] : "";
                    iconn = footer['data'][i]['icon'] != undefined && footer['data'][i]['icon'] != null && footer['data'][i]['icon'] != '' ? "<i class= 'feather " + footer['data'][i]['icon'] + "' ></i> " : "";
                    if (footer['data'][i]['type'] == 'button') {
                        footerHtml = footerHtml +
                            '<a ' + url + 'id="' + footer['data'][i]['id'] + '" class="' + footer['data'][i]['class'] + '">' + iconn + footer['data'][i]['title'] + '</a>';
                    }
                    if (footer['data'][i]['type'] == 'submitbutton') {
                        footerHtml = footerHtml +
                            '<button type="submit" ' + url + 'id="' + footer['data'][i]['id'] + '" class="' + footer['data'][i]['class'] + '">' + iconn + footer['data'][i]['title'] + '</button>';
                    }
                    if (footer['data'][i]['type'] == 'closebutton') {
                        footerHtml = footerHtml +
                            '<a ' + url + 'id="' + footer['data'][i]['id'] + '" class="' + footer['data'][i]['class'] + '" data-dismiss="modal">' + iconn + footer['data'][i]['title'] + ' </a>';
                    }

                }
                footerHtml = footerHtml + "</div>";
                $('#' + footer['card-footer-id']).html(footerHtml);
            }
        }

        function requiredHtml(body, isclick) {
            let bodyHtml = '';
            for (let i = 0; i < body['data'].length; i++) {  //body oluşturuluyor
                url = body['data'][i]['url'] != undefined && body['data'][i]['url'] != null && body['data'][i]['url'] != '' ? "url=" + body['data'][i]['url'] : "";
                iconn = body['data'][i]['icon'] != undefined && body['data'][i]['icon'] != null && body['data'][i]['icon'] != '' ? "<i class= 'feather icon-user' ></i>" : "";
                divClass = body['data'][i]['div-class'] != undefined && body['data'][i]['div-class'] != null && body['data'][i]['div-class'] != '' ? body['data'][i]['div-class'] : "";
                invalid = "oninvalid='" + body['required-title'] + "'";
                oninvalidx = body['data'][i]['required'] != undefined && body['data'][i]['required'] != null && body['data'][i]['required'] != '' ? invalid : "";
                required = body['data'][i]['required'] != undefined && body['data'][i]['required'] != null && body['data'][i]['required'] != '' && body['data'][i]['required'] != false ? "required" : "";
                rLabel = required != '' ? body['data'][i]['label'] + ' *' : body['data'][i]['label'];
                label =body['data'][i]['type']!="input-checkbox"&& body['data'][i]['label'] != undefined && body['data'][i]['label'] != null && body['data'][i]['label'] != '' ? "<label class='form-label' id='"+body['data'][i]['id']+"-label'>" + rLabel + "</label>" : "";
                disabled = body['data'][i]['disabled'] != undefined && body['data'][i]['disabled'] != null && body['data'][i]['disabled'] != '' && body['data'][i]['disabled'] != false ? "disabled" : "";

                if (body['data'][i]['type'] != 'input-hidden' && body['data'][i]['type'] != 'button') {
                    bodyHtml = bodyHtml + '<div class="' + divClass + '">' + label+'<fieldset class="form-group">';
                }


                if (body['data'][i]['type'] == 'text') {

                    bodyHtml = bodyHtml + ' <p class="form-control mb-0" id="' + body['data'][i]['id'] + '">'+body['data'][i]['defaultValue']+'</p>';
                }
                if (body['data'][i]['type'] == 'input-number') {

                    bodyHtml = bodyHtml + ' <input type="number" class="form-control" ' + oninvalidx + ' ' + required + ' ' + disabled + ' name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">';
                }
                if (body['data'][i]['type'] == 'input-hidden') {

                    bodyHtml = bodyHtml + ' <input type="hidden" class="form-control" ' + oninvalidx + ' ' + required + ' ' + disabled + ' name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">';
                }
                if (body['data'][i]['type'] == 'input-text') {

                    bodyHtml = bodyHtml + ' <input type="text" class="form-control" ' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">';
                }
               if (body['data'][i]['type'] == 'input-password') {

                    bodyHtml = bodyHtml + ' <input type="password" autocomplete="new-password"  class="form-control" ' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">';
                }
                if (body['data'][i]['type'] == 'input-file') {

                    bodyHtml = bodyHtml + ' <input type="file" class="form-control" ' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">';
                }
                if (body['data'][i]['type'] == 'input-color') {

                    bodyHtml = bodyHtml + ' <input type="color" class="form-control"' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">';
                }

                if (body['data'][i]['type'] == 'input-datepicker') {

                    bodyHtml = bodyHtml + ' <input type="date" class="form-control datepicker" ' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">';
                }
                if (body['data'][i]['type'] == 'selectbox') {

                    bodyHtml = bodyHtml + ' <select type="text" class="custom-select block" ' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '"></select>';
                }
                if (body['data'][i]['type'] == 'search-selectbox') {

                    bodyHtml = bodyHtml + ' <select class="form-control selectpicker" data-live-search="true"  ' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '"></select>';
                }
                if (body['data'][i]['type'] == 'multi-selectbox') {

                    bodyHtml = bodyHtml + ' <select type="text" class="form-control multi-selectox" multiple ' + oninvalidx + ' ' + required + ' ' + disabled + '  name="' + body['data'][i]['id'] + '[]" id="' + body['data'][i]['id'] + '"></select>';
                }
                if (body['data'][i]['type'] == 'textarea') {
                    bodyHtml = bodyHtml + ' <textarea ' + oninvalidx + ' ' + required + ' ' + disabled + '   class="form-control ' + body['data'][i]['class'] + '" name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '" size="80" style="margin: 0px; width: 100%; height: 66px;"></textarea>';
                }
                if (body['data'][i]['type'] == 'input-checkbox') {
                     bodyHtml = bodyHtml + '<div class="col-sm-10">' +
                        '<label class="custom-control custom-checkbox m-0" id="'+body['data'][i]['id']+'-label">' +
                        '<input '+ oninvalidx + ' ' + required + ' ' + disabled +' type="checkbox" class="custom-control-input"  name="' + body['data'][i]['id'] + '" id="' + body['data'][i]['id'] + '">' +
                        '<span class="custom-control-label">'+rLabel+'</span>' +
                        '</label>' +
                        ' </div>';
                }
                if (body['data'][i]['type'] != 'input-hidden') {
                    bodyHtml = bodyHtml + '<span class="requiredSpan" id="' + body['data'][i]['id'] + '-span"></span></fieldset></div>';
                }

            }
            $('#' + body['card-body-id']).html(bodyHtml);



            apiSend = body['data'].filter(x => x.type === 'selectbox' || x.type === 'multi-selectbox'  || x.type === 'search-selectbox');

            for (let i = 0; i < apiSend.length; i++) {
                if (apiSend[i]['isurl'] == true) {
                    if (apiSend[i]['data']['url'] != undefined && apiSend[i]['data']['url'] != null && apiSend[i]['data']['url'] != "") {
                        selectOption(apiSend[i]['data']['url'], apiSend[i]['data']['key'], apiSend[i]['data']['value'], apiSend[i]['data']['formType'], apiSend[i]['id'], null, apiSend[i]['defaultValue'],"selectbox",apiSend[i]['group'],apiSend[i]['selectAllorselect'])
                    }
                } else {
                    $("#" + apiSend[i]['id']).empty();
                    let selected='';
                    if(apiSend[i]['type']=='multi-selectbox')
                    {
                        selected='selected';
                    }
                    for (let j = 0; j < apiSend[i]['data'].length; j++) {
                        console.log("sdfsdf", apiSend[i]['data']);
                        $("#" + apiSend[i]['id']).append("<option "+selected+" value='" + apiSend[i]['data'][j]['key'] + "'>" + apiSend[i]['data'][j]['value'] + "</option>");
                    }
                    if(apiSend[i]['type']=='multi-selectbox')
                    {
                        miltiSelectbox(apiSend[i]['id']);
                    }
                }
            }
            body['data'].forEach(x => {if(x.defaultValue!==undefined && x.defaultValue!==null && x.defaultValue!==''){
                 $("#"+x.id).val(x.defaultValue);
            }});
        }

        function isRequired(body) {
           // console.log(body);
            let is_required = true;
            for (let i = 0; i < body['data'].length; i++) {
                let required = body['data'][i]["required"];

                let value = $('#' + body['data'][i]["id"]).val();
                if (required != '' && required != null && required != undefined) {
                    if (value == "" || value == undefined || value == null) {
                        $('#' + body['data'][i]["id"] + "-span").html(body['required-title']);
                        is_required = false;
                    } else {
                        $('#' + body['data'][i]["id"] + "-span").html("");
                    }
                }
                else
                {
                    $('#' + body['data'][i]["id"] + "-span").html("");
                }
            }
            return is_required;
        }

        function formBosalt(body) {
            for (let i = 0; i < body['data'].length; i++) {
                $('#' + body['data'][i]["id"]).val(null);
                $('#' + body['data'][i]["id"] + "-span").html("");
            }
        }

        function selectOption(url, dataKey, dataValue, formType, selectId, fomDatam, defaultValue,type,group,selectAllorselect) {  //selectbox için apiden veri çekiliyor
          var token=localStorage.getItem('token');
            $.ajax({
                url: url,
                type: formType,
                cache: false,
                processData: false,
                 contentType: false,
               // contentType: "application/json",
              //  dataType: "json",
                data: fomDatam,
             //   body:fomDatam,
               enctype: 'multipart/form-data',
                headers: {
                  'Authorization': 'Bearer '+token
               },
                success: function (datam) {
                  var data=JSON.parse(datam);
                    $("#" + selectId).empty();
                    let selected='';
                    if(type=='multi-selectbox')
                    {
                        selected='selected';
                    }
                  if(selectAllorselect==1)
                     {
                      $("#" + selectId).append("<option value='0'><?=t("Seçiniz");?></option>");
                     }
                   else if(selectAllorselect==2)
                     {
                      $("#" + selectId).append("<option value='0'><?=t("Hepsi");?></option>");
                     }
                  if(group===true)
                     {
                       var anaparent=data.filter(x=>x.parentid==0);
                        for (let i = 0; i < anaparent.length; i++) {
                          $("#" + selectId).append("<optgroup label='" + anaparent[i][dataValue] + "'></option>");
                         var parent=data.filter(x=>x.parentid==anaparent[i][dataKey]);
                          for (let j = 0; j < parent.length; j++) {

                          $("#" + selectId).append("<option "+selected+" value='" + parent[j][dataKey] + "'>" + parent[j][dataValue] + "</option>");
                          }
                            $("#" + selectId).append("</option>");
                        }
                     }
                  else
                    {
                       for (let i = 0; i < data.length; i++) {
                        $("#" + selectId).append("<option "+selected+" value='" + data[i][dataKey] + "'>" + data[i][dataValue] + "</option>");
                     }
                    }

                    if (defaultValue != null && defaultValue != undefined && defaultValue != "") {
                        $("#" + selectId).val(defaultValue);
                    }

                    if(type=='multi-selectbox')
                    {
                        miltiSelectbox(selectId);
                    }
                  else
                    {
                       $('.selectpicker').selectpicker();
                    }


                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal({
                        title: xhr.status,
                        text:thrownError+" </br>id="+selectId+" </br> url="+url,
                        type: "warning",
                        confirmButtonText: "<?= t('Tamam')?>"
                    })
                }
            });
        }

        function miltiSelectbox(id)
        {
            $('#'+id).multiselect({
                enableClickableOptGroups: true,
                enableCollapsibleOptGroups: true,
                enableFiltering: false,
                buttonWidth: '100%',
                maxHeight: 400,
                dropUp: true,
                templates: {
                    filter: '<li class="multiselect-item filter"><div class="input-group input-group-sm"><span class="input-group-prepend"><span class="input-group-text"><i class="ion ion-ios-search"></i></span></span><input class="form-control multiselect-search" type="text"></div></li>',
                    filterClearBtn: '<span class="input-group-append"><button class="btn btn-default multiselect-clear-filter" type="button"><i class="ion ion-md-close"></i></button></span>',
                },
                buttonContainer: '<div class="btn-group" />',
                selectAllText: "<?= t('Tümünü Seç') ?>",
                enableCaseInsensitiveFiltering:false,
                filterPlaceholder: "<?= t('Ara') ?>",
                filterBehavior: "text",
                nonSelectedText: "<?= t('Seçim Yok') ?>",
                nSelectedText: "<?= t('seçildi') ?>",
                allSelectedText: "<?= t('Tümü') ?>",
                includeSelectAllOption: true,
            });

            $('.multiselect').removeClass('btn btn-default');
            $('.multiselect').addClass('form-control');

        }

//         $('.datepicker').datepicker({
//            //language: "<?php //Yii::$app->formatter->locale == "tr" ? "tr-TR" : "en-US";?>",
//           language: "tr-TR",
//             format: "dd/mm/yyyy",
//         });





        $(function() {
            $('.select2-demo').each(function() {
                $(this)
                    .wrap('<div class="position-relative"></div>')
                    .select2({
                        placeholder: 'Select value',
                        dropdownParent: $(this).parent()
                    });
            })
        });

   async function serviscek(actionUrl='',actionType='POST',formData='',guncellenecekTabloUrl='',guncellenecekTabloClass='')
      {
        $("#backgroundLoading").addClass("backgroundLoading");
               var token=localStorage.getItem('token');
         let datamm=await $.ajax({
                url:actionUrl,
                data: formData,
                cache: false,
                type:actionType, // For jQuery < 1.9
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                headers: {
                  'Authorization': 'Bearer '+token
               },
             /*   success: function (data) {
                     $("#backgroundLoading").addClass("loadingDisplay");
                  if(guncellenecekTablo!=undefined && guncellenecekTablo!='')
                     {
                       var list=[];
                       list.push({"url":guncellenecekTabloUrl,"class":guncellenecekTabloClass});
                        tableUpdate(list);
                     }
                }
                , error: function (xhr, ajaxOptions, thrownError) {
                    $( "#backgroundLoading" ).addClass( "loadingDisplay" );
                    swal({
                        title: "<?= t( 'Hata oluştu')?>",
                        text: xhr.status + " "+thrownError+" <?= t( 'Lütfen sorunu bildirin!')?>",
                        type: "error",
                        confirmButtonText: "<?= t( 'Tamam')?>"
                    })
                }
                */

                });
        return datamm;
      }
      function userCartList(divid,firm,branch,client,clientbranch,userSay){

               var token=localStorage.getItem('token');
            var formData = new FormData();
            formData.append('firmid', firm);
            formData.append('branchid', branch);
            formData.append('clientid', client);
            formData.append('clientbranchid', clientbranch);
            $.ajax({
                url: "/user/userlist",
                data: formData,
                cache: false,
                type: 'POST', // For jQuery < 1.9
                contentType: false,
                processData: false,
              enctype: 'multipart/form-data',
                headers: {
                  'Authorization': 'Bearer '+token
               },
                success: function (data) {
                    $("#backgroundLoading").removeClass("backgroundLoading");
                    var jsonData = JSON.parse(data)
                    if (jsonData['status']) {
                          $('#'+userSay).html(jsonData['data'].length);
                          var userData=jsonData['data'];
                      var datam='';
                          userData.forEach(x=>{
                                           datam+=
                                           '<div class="col-xl-3 col-md-6 col-12">'+
                                               '<div class="card" style="border: solid 1px #e3ebf3;border-radius: 5px;">'+
                                                 '<div class="text-center">'+
                                                     '<a class="btn btn-'+(x['active']==1?"success":"danger")+' btn-sm" style="float:right;color:#fff">'+(x['active']==1?"<?=t('Active');?>":"<?=t('Passive');?>")+' </a>'+
                                                     '<div class="card-body">'+
                                                        '<img src="/themes/crm/app-assets/images/staff-logo-'+(x['gender']==0?"mr":"mrs")+'.png" class="rounded-circle  height-150" alt="Chris South">'+
                                                     '</div>'+
                                                     '<div class="card-body">'+
                                                        '<div class="card-title" style="background:#'+x['color']+';height:5px"></div>'+
                                                        '<h4 class="card-title">'+x['name']+' '+x['surname']+'</h4>'+
                                                        '<h5 class="card-subtitle">'+x['typename']+'</h5>'+
                                                        '<h6 class="card-subtitle" style="margin-top: 14px;">'+x['primaryphone']+'</h6>'+
                                                        '<div class="text-center" style="margin-bottom:10px">'+
                                                            ' <a class="btn btn-warning btn-sm userUpdate" data-id="'+x['id']+'"><i style="color:#fff;" class="fa fa-edit"></i></a>'+
                                                            '	<a href="/userinfo/update/'+x['userid']+'" class="btn btn-info btn-sm"><i style="color:#fff;" class="fa fa-info"></i></a>'+
                                                            '	<a class="btn btn-danger btn-sm userDelete" data-id="'+x['id']+'" data-userid="'+x['userid']+'"><i style="color:#fff;" class="fa fa-trash"></i></a>'+
                                                        '</div>'+
                                                     '</div>'+
                                                 '</div>'+
                                               '</div>'+
                                           '</div>';
                                           });
                              $('#'+divid).html(datam);
                    } else {
                        alert();

                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    $( "#backgroundLoading" ).removeClass( "backgroundLoading" );
                    swal({
                        title: "<?= t( 'Duyuru ekleme sırasında bir hata oluştu')?>",
                        text: xhr.status + " "+thrownError+" <?= t( 'Lütfen YBS ye bildirin!')?>",
                        type: "error",
                        confirmButtonText: "<?= t( 'Tamam')?>"
                    })
                }
            });
            return false;
        }

        


    </script>
