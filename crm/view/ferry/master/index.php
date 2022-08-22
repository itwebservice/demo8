<div class="row mg_bt_20">
  <div class="col-md-12 text-right">
    <button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#master_save_modal" title="Add new Ferry/Cruise"><i class="fa fa-plus"></i>&nbsp;&nbsp;Ferry/Cruise</button>
  </div>
  </div>
  <div class="app_panel_content Filter-panel">
    <div class="row">
      <div class="col-md-3 col-sm-6">
          <select name="active_flag_filter" id="active_flag_filter" title="Status" data-toggle="tooltip" onchange="master_list_reflect()" style="width:100%" class='form-control'>
              <option value="">Status</option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
          </select>
      </div>
    </div>
  </div>
  <div id="div_list" class="main_block loader_parent">
  <div class="row mg_tp_20">
    <div class="table-responsive">
      <table id="tbl_list" class="table table-hover" style="margin:20px 0 !important; width:100%;">         
      </table>
    </div>
  </div>
</div>
<div id="div_edit_modal"></div>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<?php include_once('save_modal.php'); ?>
<div id="div_view_modal"></div>
<script src="js/master.js"></script>