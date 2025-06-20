<?php

$clientid=$_GET['cbid'];
$mapid=$_GET['mapid'];
$shapes=Maps::model()->findByPk($mapid);
$datas=json_decode($shapes->points);
$canvasSize=json_decode($shapes->canvasSize);
if ($canvasSize==''){
  $canvasSize='{"width":1024,"height":768}';
}
$mapBackgroundImage=json_decode($shapes->mapBackgroundImage);
$imageSize=json_decode($shapes->imageSize);

$clientbtitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_GET['cbid'])));
$clienttitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientbtitle->parentid)));
$branchtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clienttitle->firmid)));
$firmtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$branchtitle->parentid)));

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harita Çizimi</title>
    <link rel="stylesheet" href="/hmap/css/shared.css">
    <link rel="stylesheet" href="/hmap/css/map-drawing.css?101">
</head>
<body>
    <style>
  .toolbar {
    float: none;
    }
      .nav{
        background: none;
            box-shadow: none;
    margin-bottom: 0;
      }
      .nav-link:hover{
          background-color: transparent !important;
      }
      
  </style>
  <script>
  
  
            localStorage.setItem('mapShapes', <?=$shapes->points?>);
            localStorage.setItem('canvasSize', '<?=$canvasSize?>');
            localStorage.setItem('mapBackgroundImage', '<?=$mapBackgroundImage?>');
            localStorage.setItem('imageSize', '<?=$imageSize?>');
  
  </script>
    <nav class="nav">
          <div class="container"><center><span style="font-size:15px;"><?=$clientbtitle->name?></span></center><br>
            <div class="nav-content">
                <a href="/map/?cbid=<?=$clientid?>&mapid=<?=$mapid?>" class="nav-link active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7l5-5 5 5M3 17l5-5 5 5M13 7h8M13 17h8"/></svg>
                    <span><?=t('Map Drawing')?></span>
                </a>
                <a href="/map/monitors?cbid=<?=$clientid?>&mapid=<?=$mapid?>" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span><?=t('Monitoring Points')?></span>
                </a>
               <!-- <a href="/map/heatmap?cbid=<?=$clientid?>&mapid=<?=$mapid?>" class="nav-link ">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>
                    <span><?=t('Heat Map')?></span>
                </a>-->
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="toolbar">
            <div class="toolbar-content">
                <button class="tool-button" data-shape="move" title="<?=t('Move Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 9l-3 3 3 3M9 5l3-3 3 3M15 19l-3 3-3-3M19 9l3 3-3 3M2 12h20M12 2v20"/></svg>
                </button>
                <button class="tool-button" data-shape="text" title="<?=t('Text Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 22h-1a4 4 0 0 1-4-4V6a4 4 0 0 1 4-4h1M7 22h1a4 4 0 0 0 4-4V6a4 4 0 0 0-4-4H7M7 22v-4M17 22v-4M7 2v4M17 2v4"/></svg>
                </button>
                <button class="tool-button" data-shape="line" title="<?=t('Straight Line Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                </button>
                <button class="tool-button" data-shape="dashed-line" title="<?=t('Dotted Line Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="4 4"><path d="M5 12h14"/></svg>
                </button>
                <button class="tool-button" data-shape="arrow-right" title="<?=t('Arrow Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
                <button class="tool-button" data-shape="dashed-arrow-right" title="<?=t('Dotted Arrow Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="4 4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
                <button class="tool-button" data-shape="rectangle" title="<?=t('Rectangle Tool')?>">
                    <div style="width: 20px; height: 14px; border: 2px solid currentColor;"></div>
                </button>
                <button class="tool-button" data-shape="filled-rectangle" title="<?=t('Filled Rectangle Tool')?>">
                    <div style="width: 20px; height: 14px; background-color: currentColor;"></div>
                </button>
                <button class="tool-button" data-shape="triangle" title="<?=t('Triangle Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h18L12 4z"/></svg>
                </button>
                <button class="tool-button" data-shape="filled-triangle" title="<?=t('Filled Triangle Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h18L12 4z"/></svg>
                </button>
                <button class="tool-button" data-shape="circle" title="<?=t('Circle Tool')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>
                </button>
                <button class="tool-button" data-shape="filled-circle" title="Filled Circle Tool">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>
                </button>
                <div class="color-picker">
                    <label for="colorPicker" class="text-sm text-gray-600"> <?=t('Colour')?>:</label>
                    <input type="color" id="colorPicker" value="#000000">
                </div>
                <button class="tool-button" id="clearButton" title="<?=t('Erase everything on the canvas')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
                </button>
                <label class="tool-button" title="<?=t('Add Image')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <input type="file" id="imageInput" accept="image/*" class="hidden">
                </label>
                <button class="tool-button hidden" id="removeImageButton" title="<?=t('Remove Image')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8M9 9l6 6M15 9l-6 6"/></svg>
                </button>
                <button class="tool-button" id="sizeButton" title="<?=t('Canvas Size')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M14 10l6.1-6.1M9 21H3v-6M10 14l-6.1 6.1"/></svg>
                </button>
                <button class="tool-button hidden" id="imageScaleButton" title="<?=t('Image Scale')?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 21H3M21 16V3M16 3h5M12 21V3M8 21v-4M4 21v-8"/></svg>
                </button>
                <button class="btn btn-primary" id="saveButton">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    <span> <?=t('Save')?></span>
                </button>
            </div>
        </div>

        <div class="canvas-container">
            <canvas id="canvas" width="1024" height="768"></canvas>
        </div>
    </div>

    <div id="imageScaleModal" class="modal">
        <div class="modal-content">
            <h2> <?=t('Image Size')?></h2>
            <div class="size-inputs">
                <div class="size-input">
                    <label> <?=t('Scale')?>:</label>
                    <input type="range" id="imageScaleSlider" min="10" max="200" step="1">
                    <span id="imageScaleValue">100%</span>
                </div>
            </div>
            <div class="modal-buttons">
                <button class="btn btn-cancel" id="cancelImageScaleButton"> <?=t('Cancel')?></button>
                <button class="btn btn-primary" id="applyImageScaleButton"> <?=t('Save')?></button>
            </div>
        </div>
    </div>

    <div id="textModal" class="modal">
        <div class="modal-content">
            <h2> <?=t('Add Text')?></h2>
            <textarea id="textInput" placeholder="<?=t('Please write text...')?>" rows="4"></textarea>
            <div class="modal-buttons">
                <button class="btn btn-cancel" id="cancelText"> <?=t('Cancel')?></button>
                <button class="btn btn-primary" id="addText"> <?=t('Add')?></button>
            </div>
        </div>
    </div>

    <div id="sizeModal" class="modal">
        <div class="modal-content">
            <h2> <?=t('Canvas Size')?></h2>
            <div class="size-inputs">
                <div class="size-input">
                    <label> <?=t('Width')?>:</label>
                    <input type="number" id="modalCanvasWidth" min="100" max="2000">
                    <span>px</span>
                </div>
                <div class="size-input">
                    <label> <?=t('Height')?>:</label>
                    <input type="number" id="modalCanvasHeight" min="100" max="2000">
                    <span>px</span>
                </div>
            </div>
            <div class="modal-buttons">
                <button class="btn btn-cancel" id="cancelSizeButton"> <?=t('Cancel')?></button>
                <button class="btn btn-primary" id="applySizeButton"> <?=t('Save')?></button>
            </div>
        </div>
    </div>

    <div id="contextMenu" class="context-menu">
        <button class="context-menu-item" id="sendToBack">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20M2 12h20M2 4h20"/></svg>
            <span> <?=t('Send to Back')?></span>
        </button>
        <button class="context-menu-item danger" id="deleteShape">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/></svg>
            <span> <?=t('Delete')?></span>
        </button>
    </div>

    <div id="saveMessage" class="save-message">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        <span> <?=t('Saved')?>!</span>
    </div>

    <script src="/hmap/js/utils.js"></script>
  <script>
  
  class MapDrawing {
    constructor() {
        this.canvas = document.getElementById('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.shapes = [];
        this.selectedShape = 'move';
        this.selectedColor = '#000000';
        this.isDrawing = false;
        this.startPoint = null;
        this.backgroundImage = null;
        this.canvasSize = { width: 1024, height: 768 };
        this.imageSize = { width: 0, height: 0, scale: 1 };
        this.isDragging = false;
        this.dragOffset = null;
        this.selectedShapeIndex = -1;
        this.textModal = document.getElementById('textModal');
        this.sizeModal = document.getElementById('sizeModal');
        this.imageScaleModal = document.getElementById('imageScaleModal');
        this.contextMenu = document.getElementById('contextMenu');
        this.saveMessage = document.getElementById('saveMessage');
        this.tempImageScale = 100;

        this.loadSavedData();
        this.setupEventListeners();
        this.draw();
    }

    loadSavedData() {
        const savedShapes = localStorage.getItem('mapShapes');
        const savedImageData = localStorage.getItem('mapBackgroundImage');
        const savedCanvasSize = localStorage.getItem('canvasSize');
        const savedImageSize = localStorage.getItem('imageSize');
        
        if (savedShapes) {
            this.shapes = JSON.parse(savedShapes);
        }

        if (savedCanvasSize) {
            const size = JSON.parse(savedCanvasSize);
            this.canvas.width = size.width;
            this.canvas.height = size.height;
            this.canvasSize = size;
        }

        if (savedImageSize) {
            this.imageSize = JSON.parse(savedImageSize);
        }
        
        if (savedImageData) {
            const img = new Image();
            img.src = savedImageData;
            img.onload = () => {
                this.backgroundImage = img;
                if (!savedImageSize) {
                    const scale = Math.min(
                        this.canvas.width / img.width,
                        this.canvas.height / img.height
                    );
                    this.imageSize = {
                        width: img.width,
                        height: img.height,
                        scale: scale,
                        originalScale: scale
                    };
                }
                this.draw();
                document.getElementById('removeImageButton').classList.remove('hidden');
                document.getElementById('imageScaleButton').classList.remove('hidden');
            };
        }
    }

    setupEventListeners() {
        // Canvas events
        this.canvas.addEventListener('mousedown', this.handleMouseDown.bind(this));
        this.canvas.addEventListener('mousemove', this.handleMouseMove.bind(this));
        this.canvas.addEventListener('mouseup', this.handleMouseUp.bind(this));
        this.canvas.addEventListener('mouseleave', () => {
            this.isDrawing = false;
            this.isDragging = false;
        });
        this.canvas.addEventListener('contextmenu', this.handleContextMenu.bind(this));

        // Tool buttons
        document.querySelectorAll('.tool-button[data-shape]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tool-button').forEach(b => b.classList.remove('active'));
                button.classList.add('active');
                this.selectedShape = button.dataset.shape;
            });
        });

        // Color picker
        document.getElementById('colorPicker').addEventListener('input', (e) => {
            this.selectedColor = e.target.value;
        });

        // Clear button
        document.getElementById('clearButton').addEventListener('click', () => {
            if (confirm('<?=t('Do you want to delete all shapes?')?>')) {
                this.shapes = [];
                this.selectedShapeIndex = -1;
                localStorage.setItem('mapShapes', JSON.stringify([]));
                this.draw();
            }
        });

        // Image upload
        document.getElementById('imageInput').addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = () => {
                        this.backgroundImage = img;
                        const scale = Math.min(
                            this.canvas.width / img.width,
                            this.canvas.height / img.height
                        );
                        this.imageSize = {
                            width: img.width,
                            height: img.height,
                            scale: scale,
                            originalScale: scale
                        };
                        localStorage.setItem('mapBackgroundImage', img.src);
                        localStorage.setItem('imageSize', JSON.stringify(this.imageSize));
                        document.getElementById('removeImageButton').classList.remove('hidden');
                        document.getElementById('imageScaleButton').classList.remove('hidden');
                        this.draw();
                    };
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove image
        document.getElementById('removeImageButton').addEventListener('click', () => {
            this.backgroundImage = null;
            localStorage.removeItem('mapBackgroundImage');
            localStorage.removeItem('imageSize');
            document.getElementById('imageScaleButton').classList.add('hidden');
            document.getElementById('removeImageButton').classList.add('hidden');
            this.draw();
        });

        // Image scale button
        document.getElementById('imageScaleButton').addEventListener('click', () => {
            const currentScale = Math.round((this.imageSize.scale / this.imageSize.originalScale) * 100);
            this.tempImageScale = currentScale;
            document.getElementById('imageScaleSlider').value = currentScale;
            document.getElementById('imageScaleValue').textContent = currentScale + '%';
            this.imageScaleModal.style.display = 'flex';
        });

        // Image scale slider
        document.getElementById('imageScaleSlider').addEventListener('input', (e) => {
            this.tempImageScale = parseInt(e.target.value);
            document.getElementById('imageScaleValue').textContent = this.tempImageScale + '%';
            // Update image scale live while dragging
            if (this.backgroundImage && this.imageSize.originalScale) {
                const newScale = (this.tempImageScale / 100) * this.imageSize.originalScale;
                this.imageSize.scale = newScale;
                this.draw();
            }
        });

        // Image scale modal buttons
        document.getElementById('cancelImageScaleButton').addEventListener('click', () => {
            // Restore original scale if cancelled
            if (this.backgroundImage && this.imageSize.originalScale) {
                const currentScale = Math.round((this.imageSize.scale / this.imageSize.originalScale) * 100);
                this.imageSize.scale = (currentScale / 100) * this.imageSize.originalScale;
                this.draw();
            }
            this.imageScaleModal.style.display = 'none';
        });

        document.getElementById('applyImageScaleButton').addEventListener('click', () => {
            const newScale = (this.tempImageScale / 100) * this.imageSize.originalScale;
            this.imageSize.scale = newScale;
            localStorage.setItem('imageSize', JSON.stringify(this.imageSize));
            this.imageScaleModal.style.display = 'none';
            this.draw();
        });

        // Size button
        document.getElementById('sizeButton').addEventListener('click', () => {
            document.getElementById('modalCanvasWidth').value = this.canvasSize.width;
            document.getElementById('modalCanvasHeight').value = this.canvasSize.height;
            this.sizeModal.style.display = 'flex';
        });

        // Size modal buttons
        document.getElementById('cancelSizeButton').addEventListener('click', () => {
            this.sizeModal.style.display = 'none';
        });

        document.getElementById('applySizeButton').addEventListener('click', () => {
            const width = Number(document.getElementById('modalCanvasWidth').value);
            const height = Number(document.getElementById('modalCanvasHeight').value);
            
            if (width >= 100 && width <= 2000 && height >= 100 && height <= 2000) {
                this.canvas.width = width;
                this.canvas.height = height;
                this.canvasSize = { width, height };
                
                if (this.backgroundImage) {
                    const scale = Math.min(
                        width / this.backgroundImage.width,
                        height / this.backgroundImage.height
                    );
                    this.imageSize.scale = scale;
                    localStorage.setItem('imageSize', JSON.stringify(this.imageSize));
                }
                
                localStorage.setItem('canvasSize', JSON.stringify(this.canvasSize));
                this.draw();
            }
            
            this.sizeModal.style.display = 'none';
        });

        // Text modal
        document.getElementById('addText').addEventListener('click', () => {
            const text = document.getElementById('textInput').value.trim();
            if (text && this.startPoint) {
                this.shapes.push({
                    id: Date.now().toString(),
                    type: 'text',
                    text: text,
                    x: this.startPoint.x,
                    y: this.startPoint.y,
                    width: 0,
                    height: 0,
                    color: this.selectedColor
                });
                document.getElementById('textInput').value = '';
                this.textModal.style.display = 'none';
                this.draw();
            }
        });

        document.getElementById('cancelText').addEventListener('click', () => {
            document.getElementById('textInput').value = '';
            this.textModal.style.display = 'none';
        });

        // Context menu
        document.getElementById('sendToBack').addEventListener('click', () => {
            if (this.selectedShapeIndex !== -1) {
                const shape = this.shapes[this.selectedShapeIndex];
                this.shapes.splice(this.selectedShapeIndex, 1);
                this.shapes.unshift(shape);
                this.selectedShapeIndex = 0;
                this.contextMenu.style.display = 'none';
                this.draw();
            }
        });

        document.getElementById('deleteShape').addEventListener('click', () => {
            if (this.selectedShapeIndex !== -1) {
                this.shapes.splice(this.selectedShapeIndex, 1);
                this.selectedShapeIndex = -1;
                this.contextMenu.style.display = 'none';
                this.draw();
            }
        });

        // Save button
        document.getElementById('saveButton').addEventListener('click', () => {
            localStorage.setItem('mapShapes', JSON.stringify(this.shapes));
          
          
          
  
            //localStorage.setItem('mapShapes', <?=$shapes->points?>);
            //localStorage.setItem('canvasSize', '<?=$canvasSize?>');
          //  localStorage.setItem('mapBackgroundImage', '<?=$mapBackgroundImage?>');
         //   localStorage.setItem('imageSize', '<?=$imageSize?>');
          
         
           $.ajax({
        url: "/client/mapupdatenew",
        type: "POST",    
        data: {
            "map_id": <?=$mapid?> ,
            "client_id": <?=$clientid?> ,
              "shapes" : JSON.stringify(this.shapes),
              "canvasSize" :  localStorage.getItem('canvasSize'),
              "mapBackgroundImage" :  localStorage.getItem('mapBackgroundImage'),
              "imageSize" :  localStorage.getItem('imageSize'),
        },
        success: function(response) {
            // document.getElementById("total_items").value = response;
         alert("saved");
        },
        error: function() {
            alert("error");
        }    
    });    
          
            this.saveMessage.style.display = 'flex';
      
        });

        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === this.textModal) {
                this.textModal.style.display = 'none';
            }
            if (e.target === this.imageScaleModal) {
                this.imageScaleModal.style.display = 'none';
            }
            if (e.target === this.sizeModal) {
                this.sizeModal.style.display = 'none';
            }
            if (!e.target.closest('.context-menu') && !e.target.closest('canvas')) {
                this.contextMenu.style.display = 'none';
            }
        });

        // Handle keyboard events
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Delete' && this.selectedShapeIndex !== -1) {
                this.shapes.splice(this.selectedShapeIndex, 1);
                this.selectedShapeIndex = -1;
                this.draw();
            }
            if (e.key === 'Escape') {
                this.textModal.style.display = 'none';
                this.sizeModal.style.display = 'none';
                this.imageScaleModal.style.display = 'none';
                this.contextMenu.style.display = 'none';
            }
        });
    }

    handleMouseDown(e) {
        const rect = this.canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (this.selectedShape === 'move') {
            const clickedShapeIndex = this.shapes.findLastIndex(shape => 
                this.isPointInShape(x, y, shape)
            );

            this.selectedShapeIndex = clickedShapeIndex;
            if (clickedShapeIndex !== -1) {
                this.isDragging = true;
                this.dragOffset = {
                    x: x - this.shapes[clickedShapeIndex].x,
                    y: y - this.shapes[clickedShapeIndex].y
                };
            }
        } else if (this.selectedShape === 'text') {
            this.startPoint = { x, y };
            document.getElementById('textInput').value = '';
            this.textModal.style.display = 'flex';
        } else {
            this.isDrawing = true;
            this.startPoint = { x, y };
            this.selectedShapeIndex = -1;
        }

        this.draw();
    }

    handleMouseMove(e) {
        const rect = this.canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (this.isDragging && this.selectedShapeIndex !== -1) {
            this.shapes[this.selectedShapeIndex].x = x - this.dragOffset.x;
            this.shapes[this.selectedShapeIndex].y = y - this.dragOffset.y;
            this.draw();
            return;
        }

        if (!this.isDrawing || !this.startPoint) return;

        this.draw();
        this.drawCurrentShape(x, y);
    }

    handleMouseUp(e) {
        if (this.isDragging) {
            this.isDragging = false;
            this.dragOffset = null;
            localStorage.setItem('mapShapes', JSON.stringify(this.shapes));
            return;
        }

        if (!this.isDrawing || !this.startPoint || 
            this.selectedShape === 'move' || 
            this.selectedShape === 'text') return;

        const rect = this.canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        this.shapes.push({
            id: Date.now().toString(),
            type: this.selectedShape,
            x: this.startPoint.x,
            y: this.startPoint.y,
            width: x - this.startPoint.x,
            height: y - this.startPoint.y,
            color: this.selectedColor,
            isDashed: this.selectedShape.includes('dashed')
        });

        this.isDrawing = false;
        this.startPoint = null;
        this.selectedShapeIndex = -1;
        this.draw();
    }

    handleContextMenu(e) {
        e.preventDefault();
        const rect = this.canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const clickedShapeIndex = this.shapes.findLastIndex(shape => 
            this.isPointInShape(x, y, shape)
        );

        if (clickedShapeIndex !== -1) {
            this.selectedShapeIndex = clickedShapeIndex;
            this.contextMenu.style.display = 'block';
            this.contextMenu.style.left = e.clientX + 'px';
            this.contextMenu.style.top = e.clientY + 'px';
            this.draw();
        } else {
            this.contextMenu.style.display = 'none';
        }
    }

    isPointInShape(x, y, shape) {
        if (shape.type === 'text') {
            const padding = 5;
            const ctx = this.ctx;
            ctx.font = '16px Arial';
            const metrics = ctx.measureText(shape.text || '');
            return x >= shape.x - padding && 
                   x <= shape.x + metrics.width + padding &&
                   y >= shape.y - padding && 
                   y <= shape.y + 20 + padding;
        }

        if (shape.type.includes('arrow') || shape.type.includes('line')) {
            const lineWidth = 10;
            const dx = shape.x + shape.width - shape.x;
            const dy = shape.y + shape.height - shape.y;
            const length = Math.sqrt(dx * dx + dy * dy);
            
            if (length === 0) return false;

            const t = ((x - shape.x) * dx + (y - shape.y) * dy) / (length * length);
            if (t < 0 || t > 1) return false;

            const nearestX = shape.x + t * dx;
            const nearestY = shape.y + t * dy;
            const distance = Math.sqrt(
                (x - nearestX) * (x - nearestX) + (y - nearestY) * (y - nearestY)
            );

            return distance <= lineWidth;
        }

        if (shape.type.includes('circle')) {
            const centerX = shape.x + shape.width / 2;
            const centerY = shape.y + shape.height / 2;
            const radius = Math.min(Math.abs(shape.width), Math.abs(shape.height)) / 2;
            const distance = Math.sqrt(
                (x - centerX) * (x - centerX) + (y - centerY) * (y - centerY)
            );
            return distance <= radius;
        }

        if (shape.type.includes('triangle')) {
            const x1 = shape.x + shape.width / 2;
            const y1 = shape.y;
            const x2 = shape.x;
            const y2 = shape.y + shape.height;
            const x3 = shape.x + shape.width;
            const y3 = shape.y + shape.height;

            const area = Math.abs((x1 * (y2 - y3) + x2 * (y3 - y1) + x3 * (y1 - y2)) / 2);
            const area1 = Math.abs((x * (y2 - y3) + x2 * (y3 - y) + x3 * (y - y2)) / 2);
            const area2 = Math.abs((x1 * (y - y3) + x * (y3 - y1) + x3 * (y1 - y)) / 2);
            const area3 = Math.abs((x1 * (y2 - y) + x2 * (y - y1) + x * (y1 - y2)) / 2);

            return Math.abs(area - (area1 + area2 + area3)) < 0.1;
        }

        const minX = Math.min(shape.x, shape.x + shape.width);
        const maxX = Math.max(shape.x, shape.x + shape.width);
        const minY = Math.min(shape.y, shape.y + shape.height);
        const maxY = Math.max(shape.y, shape.y + shape.height);

        return x >= minX && x <= maxX && y >= minY && y <= maxY;
    }

    draw() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        if (this.backgroundImage) {
            const scaledWidth = this.backgroundImage.width * this.imageSize.scale;
            const scaledHeight = this.backgroundImage.height * this.imageSize.scale;
            const x = (this.canvas.width - scaledWidth) / 2;
            const y = (this.canvas.height - scaledHeight) / 2;
            this.ctx.drawImage(this.backgroundImage, x, y, scaledWidth, scaledHeight);
        }

        this.shapes.forEach((shape, index) => {
            this.ctx.beginPath();
            this.ctx.strokeStyle = shape.color;
            this.ctx.fillStyle = shape.color;
            this.ctx.lineWidth = 2;

            if (shape.isDashed) {
                this.ctx.setLineDash([5, 5]);
            } else {
                this.ctx.setLineDash([]);
            }

            if (index === this.selectedShapeIndex) {
                this.drawSelectionBox(shape);
            }

            if (shape.type === 'text') {
                this.ctx.font = '16px Arial';
                this.ctx.textBaseline = 'top';
                const text = shape.text || '';
                this.ctx.fillText(text, shape.x, shape.y);
            } else if (shape.type.includes('arrow')) {
                this.drawArrow(shape);
            } else if (shape.type === 'line' || shape.type === 'dashed-line') {
                this.ctx.moveTo(shape.x, shape.y);
                this.ctx.lineTo(shape.x + shape.width, shape.y + shape.height);
                this.ctx.stroke();
            } else if (shape.type.includes('rectangle')) {
                this.ctx.rect(shape.x, shape.y, shape.width, shape.height);
                if (shape.type.includes('filled')) {
                    this.ctx.fill();
                }
                this.ctx.stroke();
            } else if (shape.type.includes('triangle')) {
                this.ctx.moveTo(shape.x + shape.width / 2, shape.y);
                this.ctx.lineTo(shape.x, shape.y + shape.height);
                this.ctx.lineTo(shape.x + shape.width, shape.y + shape.height);
                this.ctx.closePath();
                if (shape.type.includes('filled')) {
                    this.ctx.fill();
                }
                this.ctx.stroke();
            } else if (shape.type.includes('circle')) {
                const radius = Math.min(Math.abs(shape.width), Math.abs(shape.height)) / 2;
                this.ctx.arc(
                    shape.x + shape.width / 2,
                    shape.y + shape.height / 2,
                    radius,
                    0,
                    2 * Math.PI
                );
                if (shape.type.includes('filled')) {
                    this.ctx.fill();
                }
                this.ctx.stroke();
            }
        });
    }

    drawSelectionBox(shape) {
        this.ctx.save();
        this.ctx.strokeStyle = '#3B82F6';
        this.ctx.lineWidth = 1;
        this.ctx.setLineDash([5, 5]);

        if (shape.type === 'text') {
            const metrics = this.ctx.measureText(shape.text || '');
            this.ctx.strokeRect(
                shape.x - 5,
                shape.y - 5,
                metrics.width + 10,
                25
            );
        } else if (shape.type.includes('arrow') || shape.type.includes('line')) {
            const padding = 10;
            const minX = Math.min(shape.x, shape.x + shape.width) - padding;
            const minY = Math.min(shape.y, shape.y + shape.height) - padding;
            const maxX = Math.max(shape.x, shape.x + shape.width) + padding;
            const maxY = Math.max(shape.y, shape.y + shape.height) + padding;
            this.ctx.strokeRect(minX, minY, maxX - minX, maxY - minY);
        } else {
            this.ctx.strokeRect(
                shape.x - 5,
                shape.y - 5,
                shape.width + 10,
                shape.height + 10
            );
        }

        this.ctx.restore();
    }

    drawArrow(shape) {
        const headLength = 15;
        const angle = Math.atan2(shape.height, shape.width);
        
        this.ctx.beginPath();
        this.ctx.moveTo(shape.x, shape.y);
        this.ctx.lineTo(shape.x + shape.width, shape.y + shape.height);
        this.ctx.stroke();

        this.ctx.beginPath();
        this.ctx.moveTo(shape.x + shape.width, shape.y + shape.height);
        this.ctx.lineTo(
            shape.x + shape.width - headLength * Math.cos(angle - Math.PI / 6),
            shape.y + shape.height - headLength * Math.sin(angle - Math.PI / 6)
        );
        this.ctx.moveTo(shape.x + shape.width, shape.y + shape.height);
        this.ctx.lineTo(
            shape.x + shape.width - headLength * Math.cos(angle + Math.PI / 6),
            shape.y + shape.height - headLength * Math.sin(angle + Math.PI / 6)
        );
        this.ctx.stroke();
    }

    drawCurrentShape(x, y) {
        this.ctx.beginPath();
        this.ctx.strokeStyle = this.selectedColor;
        this.ctx.fillStyle = this.selectedColor;
        this.ctx.lineWidth = 2;

        if (this.selectedShape.includes('dashed')) {
            this.ctx.setLineDash([5, 5]);
        } else {
            this.ctx.setLineDash([]);
        }

        if (this.selectedShape.includes('arrow')) {
            this.drawArrow({
                x: this.startPoint.x,
                y: this.startPoint.y,
                width: x - this.startPoint.x,
                height: y - this.startPoint.y
            });
        } else if (this.selectedShape === 'line' || this.selectedShape === 'dashed-line') {
            this.ctx.moveTo(this.startPoint.x, this.startPoint.y);
            this.ctx.lineTo(x, y);
            this.ctx.stroke();
        } else if (this.selectedShape.includes('rectangle')) {
            this.ctx.rect(this.startPoint.x, this.startPoint.y, x - this.startPoint.x, y - this.startPoint.y);
            if (this.selectedShape.includes('filled')) {
                this.ctx.fill();
            }
            this.ctx.stroke();
        } else if (this.selectedShape.includes('triangle')) {
            const width = x - this.startPoint.x;
            const height = y - this.startPoint.y;
            this.ctx.moveTo(this.startPoint.x + width / 2, this.startPoint.y);
            this.ctx.lineTo(this.startPoint.x, this.startPoint.y + height);
            this.ctx.lineTo(this.startPoint.x + width, this.startPoint.y + height);
            this.ctx.closePath();
            if (this.selectedShape.includes('filled')) {
                this.ctx.fill();
            }
            this.ctx.stroke();
        } else if (this.selectedShape.includes('circle')) {
            const width = x - this.startPoint.x;
            const height = y - this.startPoint.y;
            const radius = Math.min(Math.abs(width), Math.abs(height)) / 2;
            this.ctx.arc(
                this.startPoint.x + width / 2,
                this.startPoint.y + height / 2,
                radius,
                0,
                2 * Math.PI
            );
            if (this.selectedShape.includes('filled')) {
                this.ctx.fill();
            }
            this.ctx.stroke();
        }
    }
}

// Initialize the map drawing
document.addEventListener('DOMContentLoaded', () => {
    new MapDrawing();
});
  
  </script>
  <!--  <script src="/hmap/js/map-drawing.js?101"></script> -->

</body>
</html>