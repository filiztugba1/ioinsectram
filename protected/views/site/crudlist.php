   <section id="headers">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Complex headers</h4>
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
                  <div class="card-body card-dashboard">
                    <p class="card-text"></p>
                    <table class="table table-striped table-bordered scroll-horizontal complex-headers">
                      <thead>
                        <tr>
                          <th rowspan="2">Permissions</th>
                          <th colspan="2">Default Roles</th>
                          <th colspan="5">Your Roles</th>
                        </tr>
                        <tr>
                          <th>Admin</th>
                          <th>Moderator</th>
                          <th>Maneger</th>
                          <th>Accounting</th>
                          <th>Staff</th>
                          <th>Franchising</th>
                          <th>Customer</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Tiger Nixon</td>
                          <td>System Architect</td>
                          <td>$320,800</td>
                          <td>Edinburgh</td>
                          <td>5421</td>
                          <td>5421</td>
                          <td>t.nixon@datatables.net</td>
                          <td>
							<fieldset>
							  <div class="float-left">
								<input type="checkbox" class="switch" id="checkbox1" data-off-label="false" data-on-label="false" data-icon-cls="fa"  data-on-icon-cls="fa-check-square" data-off-icon-cls="fa-window-close-o"  checked/>

							  </div>
							</fieldset>
							<div id="checkbox-value"></div>
						</td>
                        </tr>

                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Admin</th>
                          <th>Moderator</th>
                          <th>Maneger</th>
                          <th>Accounting</th>
                          <th>Staff</th>
                          <th>Franchising</th>
                          <th>Customer</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<script>
$(document).ready(function() {
	
	$('#checkbox-value').text($('#checkbox1').val());

$("#checkbox1").on('change', function() {
  if ($(this).is(':checked')) {
    $(this).attr('value', 'true');
  } else {
    $(this).attr('value', 'false');
  }
  
  $('#checkbox-value').text($('#checkbox1').val());
});

$('.complex-headers').DataTable();

});

</script>

<?php
Yii::app()->params['scripts'].='//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js;';
Yii::app()->params['css'].='alper.css;test.css;';
?>