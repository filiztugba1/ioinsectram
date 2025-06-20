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
$points=json_decode($shapes->monitor);



$monitoring=Monitoring::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'clientid='.$clientid.' and active=1',
							   ));

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
    <title>Gözlem Noktaları</title>
    <link rel="stylesheet" href="/hmap/css/shared.css">
    <link rel="stylesheet" href="/hmap/css/observation-points.css">
  </head>

  <body>
  <script>
  
  
            localStorage.setItem('mapShapes', <?=$shapes->points?>);
            localStorage.setItem('canvasSize', '<?=$canvasSize?>');
            localStorage.setItem('mapBackgroundImage', '<?=$mapBackgroundImage?>');
            localStorage.setItem('imageSize', '<?=$imageSize?>');
            localStorage.setItem('observationPoints', '<?=$points?>');
  
  </script>
    <style>
      .toolbar {
        float: none;
      }

      .nav {
        background: none;
        box-shadow: none;
        margin-bottom: 0;
      }

      .nav-link:hover {
        background-color: transparent !important;
      }

      .fixed-navbar {
        padding-top: 0px !important;
      }

      .header-navbar {
        min-height: 60px !important;
        height: 60px !important;
      }
    </style>
    <nav class="nav">
           <div class="container">
            <div class="nav-content">
                <a href="/map/?cbid=<?=$clientid?>&mapid=<?=$mapid?>" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7l5-5 5 5M3 17l5-5 5 5M13 7h8M13 17h8"/></svg>
                    <span><?=t('Map Drawing')?></span>
                </a>
                <a href="/map/monitors/?cbid=<?=$clientid?>&mapid=<?=$mapid?>" class="nav-link active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span><?=t('Monitoring Points')?></span>
                </a>
              <!--  <a href="/map/heatmap?cbid=<?=$clientid?>&mapid=<?=$mapid?>" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>
                    <span><?=t('Heat Map')?></span>
                </a> -->
            </div>
        </div>
    </nav>

    <div class="container">
      <div class="toolbar">
        <div class="flex space-x-4">
          <div class="flex-1 px-4 py-2 text-gray-600">
           <center><span style="font-size:15px;"><?=$clientbtitle->name?> - <?=t('You can add an observation point by right clicking on the map')?></span></center>
          </div>
          <button id="deletePointButton" class="btn btn-danger hidden">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/></svg>
                    <span>
           <?=t('Delete')?></span>
                </button>
        </div>
      </div>

      <!-- Compact Monitors Button -->
      <div style="margin-bottom: 15px; text-align: center;">
        <button id="showMonitorsButton" class="btn btn-info" style="padding: 8px 16px; font-size: 14px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <?=t('View Added Monitors')?> (<span id="monitorCount">0</span>)
        </button>
      </div>

      <div class="canvas-container">
        <canvas id="canvas" width="1024" height="768"></canvas>
      </div>

      <div id="contextMenu" class="context-menu">
        <div class="search-container">
          <input type="text" id="pointSearch" placeholder="
           <?=t('Search')?>..." class="search-input">
        </div>
        <div class="context-menu-grid">
          <!-- Points will be dynamically added here -->
        </div>
      </div>

      <!-- Monitors List Modal -->
      <div id="monitorsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 8px; padding: 20px; max-width: 500px; width: 90%; max-height: 60%; overflow-y: auto;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 10px;">
            <h5 style="margin: 0; color: #495057; font-size: 18px;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              <?=t('Added Monitors on Map')?>
            </h5>
            <button id="closeModalButton" style="background: none; border: none; font-size: 24px; color: #6c757d; cursor: pointer; padding: 0;">×</button>
          </div>
          <div id="monitorsContainer" style="display: flex; flex-wrap: wrap; gap: 8px;">
            <span id="noMonitorsText" style="color: #6c757d; font-style: italic;"><?=t('No monitors added yet')?></span>
          </div>
        </div>
      </div>
    </div>

    <script src="/hmap/js/utils.js"></script>
    <script>
      class ObservationPoints {
        constructor() {
          this.canvas = document.getElementById('canvas');
          this.ctx = this.canvas.getContext('2d');
          this.points = [];
          this.shapes = [];
          this.selectedPoint = null;
          this.backgroundImage = null;
          this.canvasSize = {
            width: 1024,
            height: 768
          };
          this.imageSize = {
            width: 0,
            height: 0,
            scale: 1
          };
          this.contextMenu = document.getElementById('contextMenu');
          this.availablePoints = this.generateAvailablePoints();
          this.unusedPoints = [];
          this.searchTerm = localStorage.getItem('pointSearchTerm') || '';
          this.rightClickPosition = { x: 0, y: 0 }; // Sağ tık pozisyonunu saklamak için

          this.loadSavedData();
          this.setupEventListeners();
          this.updateMonitorsList();
          this.draw();
        }

        generateAvailablePoints() {
          const points = [];
          <?php
      
      foreach ($monitoring as $monitor){
        
							  $monitoringtype=Monitoringtype::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'id='.$monitor['mtypeid'],
							   ));

      
      ?>
          points.push("<?=t($monitoringtype->short_code).'('.$monitor->mno.')' ;?>");
          <?php

      }

  ?>
          return points;
        }

        loadSavedData() {
          const savedPoints = localStorage.getItem('observationPoints');
          const savedShapes = localStorage.getItem('mapShapes');
          const savedImageData = localStorage.getItem('mapBackgroundImage');
          const savedCanvasSize = localStorage.getItem('canvasSize');
          const savedImageSize = localStorage.getItem('imageSize');

          if (savedPoints) {
            this.points = JSON.parse(savedPoints);
            this.updateUnusedPoints();
          } else {
            this.unusedPoints = this.availablePoints;
          }

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
                  scale: scale
                };
              }
              this.draw();
            };
          }
        }

        updateUnusedPoints() {
          const usedLabels = new Set(this.points.map(p => p.label));
          this.unusedPoints = this.availablePoints.filter(label => !usedLabels.has(label));
        }

        updateMonitorsList() {
          const monitorCount = document.getElementById('monitorCount');
          const monitorsContainer = document.getElementById('monitorsContainer');
          const noMonitorsText = document.getElementById('noMonitorsText');
          
          monitorCount.textContent = this.points.length;
          
          if (this.points.length === 0) {
            monitorsContainer.innerHTML = '<span id="noMonitorsText" style="color: #6c757d; font-style: italic;"><?=t('No monitors added yet')?></span>';
          } else {
            monitorsContainer.innerHTML = '';
            
            this.points.forEach(point => {
              const monitorItem = document.createElement('div');
              monitorItem.className = 'monitor-item';
              monitorItem.style.cssText = `
                display: inline-flex;
                align-items: center;
                background: #fff;
                border: 1px solid #dee2e6;
                border-radius: 20px;
                padding: 5px 10px;
                font-size: 12px;
                color: #495057;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
              `;
              
              monitorItem.innerHTML = `
                <span style="margin-right: 8px; color: #FFBF00;">●</span>
                <span style="margin-right: 8px;">${point.label}</span>
                <button onclick="observationPoints.deletePointFromList('${point.id}')" 
                        style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 0; margin-left: 5px; font-size: 14px;"
                        title="<?=t('Delete')?>">
                  ×
                </button>
              `;
              
              monitorsContainer.appendChild(monitorItem);
            });
          }
        }

        setupEventListeners() {
          this.canvas.addEventListener('click', this.handlePointClick.bind(this));
          this.canvas.addEventListener('contextmenu', this.handleContextMenu.bind(this));
          document.addEventListener('click', this.handleClickOutside.bind(this));

          const deleteButton = document.getElementById('deletePointButton');
          deleteButton.addEventListener('click', () => {
            if (this.selectedPoint) {
              this.deletePoint(this.selectedPoint.id);
            }
          });

          const searchInput = document.getElementById('pointSearch');
          searchInput.value = this.searchTerm;
          searchInput.addEventListener('input', (e) => {
            this.searchTerm = e.target.value.toLowerCase();
            localStorage.setItem('pointSearchTerm', this.searchTerm);
            this.updatePointsList();
          });

          // Modal event listeners
          const showMonitorsButton = document.getElementById('showMonitorsButton');
          const monitorsModal = document.getElementById('monitorsModal');
          const closeModalButton = document.getElementById('closeModalButton');

          showMonitorsButton.addEventListener('click', () => {
            monitorsModal.style.display = 'block';
          });

          closeModalButton.addEventListener('click', () => {
            monitorsModal.style.display = 'none';
          });

          // Modal dışına tıklandığında kapatma
          monitorsModal.addEventListener('click', (e) => {
            if (e.target === monitorsModal) {
              monitorsModal.style.display = 'none';
            }
          });
        }

        updatePointsList() {
          const grid = this.contextMenu.querySelector('.context-menu-grid');
          grid.innerHTML = '';

          const filteredPoints = this.unusedPoints.filter(label =>
            label.toLowerCase().includes(this.searchTerm)
          );

          filteredPoints.forEach(label => {
            const button = document.createElement('button');
            button.className = 'context-menu-item';
            button.textContent = label;
            button.addEventListener('click', () => {
              // Saklanan sağ tık pozisyonunu kullan
              this.addPoint(this.rightClickPosition.x, this.rightClickPosition.y, label);
            });
            grid.appendChild(button);
          });
        }

        handlePointClick(e) {
          if (this.contextMenu.style.display === 'block') {
            this.contextMenu.style.display = 'none';
            return;
          }

          const rect = this.canvas.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;

          const clickedPoint = this.points.find(point => {
            const distance = Math.sqrt(Math.pow(point.x - x, 2) + Math.pow(point.y - y, 2));
            return distance < 10;
          });

          this.selectedPoint = clickedPoint || null;
          document.getElementById('deletePointButton').classList.toggle('hidden', !clickedPoint);
          this.draw();
        }

        handleContextMenu(e) {
          e.preventDefault();
          const rect = this.canvas.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;

          // Sağ tık pozisyonunu sakla
          this.rightClickPosition = { x: x, y: y };

          this.contextMenu.style.display = 'block';
          //  this.contextMenu.style.left = (e.clientX -240) + 'px';
          //  this.contextMenu.style.top = (e.clientY -60 ) + 'px';
          this.contextMenu.style.left = (e.clientX - 240 + 10) + 'px';
          this.contextMenu.style.top = (e.clientY - 60 + 10) + 'px';

          const searchInput = document.getElementById('pointSearch');
          searchInput.value = this.searchTerm;
          this.updatePointsList();
        }

        handleClickOutside(e) {
          if (!this.contextMenu.contains(e.target) && e.target !== this.canvas) {
            this.contextMenu.style.display = 'none';
          }
        }

        addPoint(x, y, label) {
          const newPoint = {
            id: Date.now().toString(),
            x,
            y,
            label
          };

          this.points.push(newPoint);
          this.updateUnusedPoints();
          this.updateMonitorsList();
          localStorage.setItem('observationPoints', JSON.stringify(this.points));
          this.savedata();
          this.contextMenu.style.display = 'none';
          this.draw();
        }

        deletePoint(id) {
          this.points = this.points.filter(point => point.id !== id);
          this.selectedPoint = null;
          this.updateUnusedPoints();
          this.updateMonitorsList();
          localStorage.setItem('observationPoints', JSON.stringify(this.points));
          this.savedata();
          document.getElementById('deletePointButton').classList.add('hidden');
          this.draw();
        }

        deletePointFromList(id) {
          if (confirm('<?=t('Are you sure you want to delete this monitor?')?>')) {
            this.deletePoint(id);
          }
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

          // Draw shapes
          this.shapes.forEach(shape => {
            this.ctx.beginPath();
            this.ctx.strokeStyle = shape.color;
            this.ctx.fillStyle = shape.color;
            this.ctx.lineWidth = 2;

            if (shape.isDashed) {
              this.ctx.setLineDash([5, 5]);
            } else {
              this.ctx.setLineDash([]);
            }

            if (shape.type === 'text') {
              this.ctx.font = '16px Arial';
              this.ctx.textBaseline = 'top';
              const text = shape.text || '';
              this.ctx.fillText(text, shape.x, shape.y);
            } else if (shape.type.includes('arrow')) {
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

          // Draw points
          this.points.forEach(point => {
            this.ctx.beginPath();
            this.ctx.fillStyle = this.selectedPoint?.id === point.id ? '#3B82F6' : '#FFBF00';

            this.ctx.arc(point.x, point.y, 6, 0, 2 * Math.PI);
            this.ctx.fill();

            this.ctx.font = '9px Arial';
           // this.ctx.fontStyle = 'italic';
            this.ctx.fillStyle = '#000';
            this.ctx.fillText(point.label, point.x + -25, point.y - 10);
          });
        }

        savedata() {
          $.ajax({
            url: "/client/mapupdatenewpoints",
            type: "POST",
            data: {
              "map_id": <?=$mapid?>,
              "client_id": <?=$clientid?>,
              "points": JSON.stringify(this.points),
            },
            success: function(response) {
              // document.getElementById("total_items").value = response;
              //  alert("saved");
            },
            error: function() {
              alert("error");
            }
          });

        }


      }




      // Initialize the observation points
      let observationPoints;
      document.addEventListener('DOMContentLoaded', () => {
        observationPoints = new ObservationPoints();
      });
    </script>
  </body>

  </html>