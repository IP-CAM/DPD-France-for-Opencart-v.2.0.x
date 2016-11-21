<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-dpdfrrelais" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-dpdfrrelais" class="form-horizontal">
          <div class="row">
            <div class="col-sm-2">
              <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <li><a href="#tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>" data-toggle="tab"><?php echo $geo_zone['name']; ?></a></li>
                <?php } ?>
              </ul>
            </div>
            <div class="col-sm-10">
              <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                        <select name="dpdfrpredict_status" class="form-control">
                            <?php if ($dpdfrpredict_status) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                        </select> <?php echo $text_activate; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_agence; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="dpdfrpredict_agence" class="form-control" value="<?php echo $dpdfrpredict_agence; ?>" size="3" /> <?php echo $text_agence; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_cargo; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="dpdfrpredict_cargo" class="form-control" value="<?php echo $dpdfrpredict_cargo; ?>" size="3" /> <?php echo $text_cargo; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_advalorem; ?></label>
                    <div class="col-sm-10">
                        <select name="dpdfrpredict_advalorem" class="form-control">
                            <?php if ($dpdfrpredict_advalorem) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                        </select> <?php echo $text_advalorem; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_retour; ?></label>
                    <div class="col-sm-10">
                        <select name="dpdfrpredict_retour" class="form-control">
                            <option value="0" <?php echo ($dpdfrpredict_retour == 0 ? 'selected="selected"' : ''); ?>><?php echo $text_retour_off; ?></option>
                            <option value="3" <?php echo ($dpdfrpredict_retour == 3 ? 'selected="selected"' : ''); ?>><?php echo $text_retour_ondemand; ?></option>
                            <option value="4" <?php echo ($dpdfrpredict_retour == 4 ? 'selected="selected"' : ''); ?>><?php echo $text_retour_prepared; ?></option>
                        </select> <?php echo $text_retour; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_suppiles; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="dpdfrpredict_suppiles" class="form-control" value="<?php echo $dpdfrpredict_suppiles; ?>" size="5" /> <?php echo $text_suppiles; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_suppmontagne; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="dpdfrpredict_suppmontagne" class="form-control" value="<?php echo $dpdfrpredict_suppmontagne; ?>" size="5" /> <?php echo $text_suppmontagne; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_sort_order; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="dpdfrpredict_sort_order" class="form-control" value="<?php echo $dpdfrpredict_sort_order; ?>" size="3" /> <?php echo $text_sort_order; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
                    <div class="col-sm-10">
                      <select name="dpdfrpredict_tax_class_id" id="input-tax-class" class="form-control">
                        <option value="0"><?php echo $text_none; ?></option>
                        <?php foreach ($tax_classes as $tax_class) { ?>
                        <?php if ($tax_class['tax_class_id'] == $dpdfrpredict_tax_class_id) { ?>
                        <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                </div>

            </div>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <div class="tab-pane" id="tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $entry_delivery; ?></label>
                    <div class="col-sm-10">
                      <select name="dpdfrpredict_<?php echo $geo_zone['geo_zone_id']; ?>_status" id="input-status<?php echo $geo_zone['geo_zone_id']; ?>" class="form-control">
                        <?php if (${'dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_status'}) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select><?php echo $text_delivery; ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-rate<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $entry_rate; ?></label>
                    <div class="col-sm-10">
                      <textarea name="dpdfrpredict_<?php echo $geo_zone['geo_zone_id']; ?>_rate" rows="5" id="input-rate<?php echo $geo_zone['geo_zone_id']; ?>" class="form-control"><?php echo ${'dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_rate'}; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-rate<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $entry_franco; ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="dpdfrpredict_<?php echo $geo_zone['geo_zone_id']; ?>_franco" size="5" value="<?php echo ${'dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_franco'}; ?>"</input> € <?php echo $text_franco; ?>
                    </div>
                </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 