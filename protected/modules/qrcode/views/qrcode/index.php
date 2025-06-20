<?php
if($model)
{
    echo '<img src="'.$model.'" />';
}

?>
<div class="card">
    <div class="card-header">
        <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
            <div class="col-md-6">
                <h4  class="card-title">QRCODE</h4>
            </div>

        </div>
    </div>


        <div class="card-content">
            <div class="card-body">
                <form method="post">
                    <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <label for="basicSelect">Parameters (,)</label>
                        <fieldset class="form-group">
                        <input name="txt" type="text" class="form-control">
                    </fieldset>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                    <input type="submit" value="Generate" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
</div>


