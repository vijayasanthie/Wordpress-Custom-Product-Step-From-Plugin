<br><br>
<?php
global $wpdb;

$step_name = '';
$step_description = '';
$step_id = '';
$steps_order = 1;
$system_type = '';
$quantity_type = '';
$item_type = '';
$tooltip_content = '';
$itm_rvoption = '';
$form_value = 'Add';
$message = '';
$status = '1';

if(isset($_POST) && isset($_POST['form_action']))
{
  if($_POST['form_action'] == 'insert')
  {
    $step_id1 = $_POST['step_id'];
    $step_name1 = $_POST['step_name'];
    $step_description1 = $_POST['step_description'];
    $steps_order1 = $_POST['steps_order'];
    $system_type1 = $_POST['system_type'];
    $quantity_type1 = $_POST['quantity_type'];
    $item_type1 = $_POST['item_type'];
    $tooltip_content1 = $_POST['tooltip_content'];
    $itm_rvoption1 = $_POST['itm_rvoption'];
    $status1 = $_POST['status'];
    if($step_id1 == '')
    {
      $insert_data = array('step_name' => $step_name1,'step_description' => $step_description1,'steps_order' => $steps_order1,'system_type' => $system_type1, 'quantity_type' => $quantity_type1,'item_type' => $item_type1,'tooltip_content' => $tooltip_content1,'itm_rvoption' => $itm_rvoption1, 'status' => $status1,'created_on' => date('Y-m-d H:i:s'));
      $insert_id =  $wpdb->insert( 'step', $insert_data );
      $message = "<div class='alert alert-success'>step inserted Successfully</div>";
    }
    else
    {
      $update_data = array('step_name' => $step_name1,'step_description' => $step_description1,'steps_order' => $steps_order1,'system_type' => $system_type1,'quantity_type' => $quantity_type1, 'item_type' => $item_type1,'tooltip_content' => $tooltip_content1,'itm_rvoption' => $itm_rvoption1 ,'status' => $status1, 'modified_on' => date('Y-m-d H:i:s'));
      $where_array = array('step_id' => $step_id1);
      $insert_id =  $wpdb->update( 'step', $update_data, $where_array );
      $message = "<div class='alert alert-success'>step Updated Successfully</div>";
      //$_GET = array();
    }
    $_POST = array(); 
   
  }
  else if($_POST['form_action'] == 'show')
  {
    $step_id = $_POST['ssstep_id'];
    $select_result = $wpdb->get_row( "SELECT * FROM step WHERE step_id = '".$step_id."'" );

    if($select_result)
    {
      $step_name = $select_result->step_name;
      $step_description = $select_result->step_description;
      $steps_order = $select_result->steps_order;
      $system_type = $select_result->system_type;
      $quantity_type = $select_result->quantity_type;
      $item_type = $select_result->item_type;
      $tooltip_content = $select_result->tooltip_content;
      $itm_rvoption = $select_result->itm_rvoption;
      $status = $select_result->status;
      $form_value = 'Update';
    }

  }
  else
  {

  }
}
?>
<div class="wrap">
  <div class="col-md-12">
    <div class="col-md-4">
      <div class="col-md-12 stltab_header">
        <div class="col-md-12 ">
          <div class="row stltab_title">
            <span><?php echo  $form_value; ?> step</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
          <div><?php echo $message; ?></div>
          <form action="" method="post" class="row form_addlocation">
            <input type="hidden" name="step_id" value="<?php echo $step_id; ?>">
            <input type="hidden" name="form_action" value="insert" />
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="step_name"><?php _e( 'Name', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="text" class="form-control" name="step_name" value="<?php echo $step_name; ?>" required>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="step_description"><?php _e( 'Description', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea class="form-control" name="step_description" required><?php echo $step_description; ?></textarea>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="step_name"><?php _e( 'System Type', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <select class="form-control system_type" name="system_type" required>
                  <option value="pos_system" <?php echo ($system_type == 'pos_system')?'selected':'' ?> >Default POS system</option>
                  <option value="additional_item" <?php echo ($system_type == 'additional_item')?'selected':'' ?> >Additional items</option>
                </select>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="step_name"><?php _e( 'Quantity Type', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <select class="form-control quantity_type" name="quantity_type" required>
                  <option value="radio" <?php echo ($quantity_type == 'radio')?'selected':'' ?>>Single(radio)</option>
                  <option value="checkbox" <?php echo ($quantity_type == 'checkbox')?'selected':'' ?>>Multiple(Checkbox)</option>
                </select>
                <span class="small">(Sigle or multiple item selection option in frontend)</span>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="step_name"><?php _e( 'Item Type', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <select class="form-control item_type" name="item_type" required>
                  <option value="normal_item" <?php echo ($item_type == 'normal_item')?'selected':'' ?> >Normal Item</option>
                  <option value="subscription_item" <?php echo ($item_type == 'subscription_item')?'selected':'' ?> >Subsciption Item</option>
                  <option value="furnishing_service_item" <?php echo ($item_type == 'furnishing_service_item')?'selected':'' ?> >Furnishing service Item</option>
                  <option value="installing_service_item" <?php echo ($item_type == 'installing_service_item')?'selected':'' ?> >Installing service Item</option>
                </select>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="steps_order"><?php _e( 'Tooltip Content', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea class="form-control" name="tooltip_content" required><?php echo $tooltip_content; ?></textarea>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="steps_order"><?php _e( 'Item remove option', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <select class="form-control" name="itm_rvoption" required>
                  <option value="yes" <?php echo ($itm_rvoption == 'yes')?'selected':''; ?>>Yes</option>
                  <option value="no" <?php echo ($itm_rvoption == 'no')?'selected': ''; ?>>No</option>
                </select>
                <span class="small text-warning">(Frontend remove button option)</span>
              </div>
            </div>


            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="steps_order"><?php _e( 'View order', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="number" class="form-control" name="steps_order" value="<?php echo $steps_order; ?>" required>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="status"><?php _e('Status','wordpress'); ?></label>
              <div class="col-md-8">
                <select class="form-control" name="status">
                  <option value="1" <?php echo ($status == '1')?'selected':''; ?>>Active</option>
                  <option value="0" <?php echo ($status == '0')?'selected':''; ?> >In-Active</option>
                </select>
              </div>
            </div>


            <div class="col-md-12">
              <center><button type="submit" name="submitstep" class="btn btn-success btn-orange btn_addstep"><?php _e(  $form_value.' step', 'wordpress' ); ?></button></center>
              </div>
          </form>
        </div>
          </div>
        </div>
      </div>


    <div class="col-md-8">
<div class="col-md-12 stltab_header">
  <div class="col-md-12 ">
    <div class="row stltab_title">
      <span>step List</span>
     
    </div>
  </div>
	<div class="col-md-12">
    	<table class="widefat steps_list">
        <thead>
          <tr>
            <th>S.no</th>
            <th>step Name</th>
            <th>step Description</th>
            <th>Order</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $steplists = $wpdb->get_results("select * from step order by steps_order");
         
          if($steplists) {
            $count = 0;
          foreach ($steplists as $steplist ) 
          {
            $count++;
            $step_idss = $steplist->step_id;
            $statuss = $steplist->status;
            $status_txt = ($statuss == '1')?'Active':'In-Active';
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $steplist->step_name; ?></td>
            <td><?php echo $steplist->step_description; ?></td>
            <td><?php echo $steplist->steps_order; ?></td>
            <td><?php echo $status_txt; ?></td>
            <td>

<form method="post" action="<?php echo admin_url(); ?>admin.php?page=steps_page" id="form1_<?php echo $step_idss; ?>">

                  <input type="hidden" name="ssstep_id" value="<?php echo $step_idss; ?>" />
                  <input type="hidden" name="form_action" value="show" />

                  

                  <a id="href" class="btn btn-sm btn-info"  onclick="document.getElementById('form1_<?php echo $step_idss; ?>').submit(); return false;">
                    <i class="fa fa-pencil" id="fa" aria-hidden="true"></i> Edit
                  </a>
                </form>

          </tr>
        <?php } } else { echo "<tr><td>No step found</td></tr>"; }?>
        </tbody>
      </table>

  	</div>
</div>
</div>

</div>
</div>

<script type="text/javascript">
  jQuery(window).load(function() {

    var table = jQuery('.steps_list').DataTable( {

          "language": {"lengthMenu": "Show _MENU_ per page"}, 
      "bFilter": true,"bDestroy": true,
} );
     




  });
</script>