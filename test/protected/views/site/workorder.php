<?php if (Yii::app()->user->checkAccess('workorder.view')){?>	

<div class="content-body">
        <!-- Full calendar events example section start -->
        <section id="events-examples">
          <div class="row">
            <div class="col-12">
              <div class="card">
               <div class="card-header">
                  <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title"><?=t('Calender');?></h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                 
                    <div id='fc-bg-events'></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
   
        </section>
        <!-- // Full calendar events example section end -->
      </div>

<script>
$(document).ready(function(){
	$('#fc-bg-events').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay',
			},
			buttonText:{
			  today:    '<?=t('today');?>',
			  month:    '<?=t('month');?>',
			  week:     '<?=t('week');?>',
			  day:      '<?=t('day');?>',
			  list:     '<?=t('list');?>'
			},
			//titleFormat:'sdfsdf',
			dayNames:['<?=t('Sunday');?>', '<?=t('Monday');?>', '<?=t('Tuesday');?>', '<?=t('Wednesday');?>', '<?=t('Thursday');?>', '<?=t('Friday');?>', '<?=t('Saturday');?>'],
			dayNamesShort:  ['<?=t('Sun');?>', '<?=t('Mon');?>', '<?=t('Tue');?>', '<?=t('Wed');?>', '<?=t('Thu');?>', '<?=t('Fri');?>', '<?=t('Sat');?>'],
			monthNames:['<?=t('January');?>','<?=t('February');?>','<?=t('March');?>','<?=t('April');?>','<?=t('May');?>','<?=t('June');?>','<?=t('July');?>','<?=t('August');?>','<?=t('September');?>','<?=t('October');?>','<?=t('November');?>','<?=t('December');?>'],
			monthNamesShort:['<?=t('Jan');?>', '<?=t('Feb');?>', '<?=t('Mar');?>', '<?=t('Apr');?>', '<?=t('May');?>', '<?=t('Jun');?>','<?=t('Jul');?>', '<?=t('Aug');?>', '<?=t('Sep');?>', '<?=t('Oct');?>', '<?=t('Nov');?>', '<?=t('Dec');?>'],
			defaultDate: '2016-06-12',
			businessHours: true, // display business hours
			editable: true,
			eventDrop: function(event, delta, revertFunc) 
				{
					alert(event.id + " <?=t('was dropped on');?> " + event.start.format());
					if (!confirm("<?=t('Are you sure about this change?');?>")) 
					{
						revertFunc();
					}
				},
			events: [
				{
					title: 'Business Lunch',
					id:1,
					start: '2016-06-03T13:00:00',
					constraint: 'businessHours'
				},
				{
					title: 'Meeting',
					start: '2016-06-13T11:00:00',
					constraint: 'availableForMeeting', // defined below
					color: '#257e4a'
				},
				{
					title: 'Conference',
					start: '2016-06-18',
					end: '2016-06-20'
				},
				{
					title: 'Party',
					start: '2016-06-29T20:00:00'
				},

				// areas where "Meeting" must be dropped
				{
					id: 'availableForMeeting',
					start: '2016-06-11T10:00:00',
					end: '2016-06-11T16:00:00',
					rendering: 'background'
				},
				{
					id: 'availableForMeeting',
					start: '2016-06-13T10:00:00',
					end: '2016-06-13T16:00:00',
					rendering: 'background'
				},

				// red areas where no events can be dropped
				{
					start: '2016-06-24',
					end: '2016-06-28',
					overlap: false,
					rendering: 'background',
					color: '#DA4453'
				},
				{
					start: '2016-06-06',
					end: '2016-06-08',
					overlap: false,
					rendering: 'background',
					color: '#DA4453'
				}
			]
	});
});
	</script>	  
	  




<?php }?>
<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/vendors.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/extensions/moment.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/extensions/fullcalendar.min.js;';
  

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/vendors.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/calendars/fullcalendar.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/plugins/calendars/fullcalendar.css;';


?>

