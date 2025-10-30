<br><br>
<?php
global $wpdb;

$item_name = '';
$item_description = '';
$item_id = '';
$base_price = '';
$step_id = '';
$category_id = '';
$form_value = 'Add';
$message = '';

$step_lists = $wpdb->get_results( "SELECT * FROM step" );
$category_lists = $wpdb->get_results( "SELECT * FROM category" );

if(isset($_POST) && isset($_POST['form_action']))
{
  if($_POST['form_action'] == 'insert')
  {
    $item_id1 = $_POST['item_id'];
    $item_name1 = $_POST['item_name'];
    $item_description1 = $_POST['item_description'];
    $base_price1 = $_POST['base_price'];
    $step_id1 = $_POST['step_id'];
    $category_id1 = $_POST['category_id'];
    if($item_id1 == '')
    {
      $insert_data = array('item_name' => $item_name1,'item_description' => $item_description1,'base_price' => $base_price1,'step_id' => $step_id1,'category_id' => $category_id1,'status' => 1,'created_on' => date('Y-m-d H:i:s'));
      $insert_id =  $wpdb->insert( 'item', $insert_data );
      $message = "<div class='alert alert-success'>Item step inserted Successfully</div>";
    }
    else
    {
      $update_data = array('item_name' => $item_name1,'item_description' => $item_description1,'base_price' => $base_price1,'step_id' => $step_id1,'category_id' => $category_id1,'modified_on' => date('Y-m-d H:i:s'));
      $where_array = array('item_id' => $item_id1);
      $insert_id =  $wpdb->update( 'item', $update_data, $where_array );
      $message = "<div class='alert alert-success'>Item step Updated Successfully</div>";
      //$_GET = array();
    }
    $_POST = array(); 
   
  }
  else if($_POST['form_action'] == 'show')
  {
    $item_id = $_POST['ssitem_id'];
    $select_result = $wpdb->get_row( "SELECT * FROM item WHERE item_id = '".$item_id."'" );

    if($select_result)
    {
      $item_name = $select_result->item_name;
      $item_description = $select_result->item_description;
      $base_price = $select_result->base_price;
      $step_id = $select_result->step_id;
      $category_id = $select_result->category_id;
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
            <span><?php echo  $form_value; ?> Item</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
          <div><?php echo $message; ?></div>
          <form action="" method="post" class="row form_addlocation">
            <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
            <input type="hidden" name="form_action" value="insert" />
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="item_name"><?php _e( 'Name', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="text" class="form-control" name="item_name" value="<?php echo $item_name; ?>" required>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="item_description"><?php _e( 'Description', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea class="form-control" name="item_description" required><?php echo $item_description; ?></textarea>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="step_id"><?php _e( 'step', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <select class="form-control" name="step_id" required>
                  <option value=''>Select step</option>
                  <?php 
                  if($step_lists){
                    foreach($step_lists as $step_list)
                    {
                      ($step_list->step_id == $step_id)?$selected='selected':$selected='';
                      echo "<option value='".$step_list->step_id."' ".$selected.">".$step_list->step_name."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="category_id"><?php _e( 'Category', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <select class="form-control" name="category_id" required>
                  <option value=''>Select Category</option>
                  <?php 
                  if($category_lists){
                    foreach($category_lists as $category_list)
                    {
                      ($category_list->category_id == $category_id)?$selected='selected':$selected='';
                      echo "<option value='".$category_list->category_id."' ".$selected.">".$category_list->category_name."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="base_price"><?php _e( 'Base Price', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="text" class="form-control" name="base_price" value="<?php echo $base_price; ?>" required>
              </div>
            </div>

            <div class="col-md-12">
              <center><button type="submit" name="submititem" class="btn btn-success btn-orange btn_additem"><?php _e(  $form_value.' Item step', 'wordpress' ); ?></button></center>
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
      <span>Items</span>
     
    </div>
  </div>
	<div class="col-md-12">
    	<table class="widefat steps_list">
        <thead>
          <tr>
            <th>S.no</th>
            <th>Name</th>
            <th>Description</th>
            <th>step</th>
            <th>category</th>
            <th>Price</th>
            <!-- <th>Item Count</th> -->
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $itemlists = $wpdb->get_results("select * from item");
         
          if($itemlists) {
            $count = 0;
          foreach ($itemlists as $itemlist ) 
          {
            $count++;
            $step_name = '';
            $category_name = '';
            $item_idss = $itemlist->item_id;
            $step_idss = $itemlist->step_id;
            $category_idss = $itemlist->category_id;
            if($step_idss !='')
            {
                          
              $step_lists1 = $wpdb->get_row( "SELECT * FROM step where step_id = '".$step_idss."'" );
              if($step_lists1)
              {
                $step_name = $step_lists1->step_name;
              }
            }
            if($category_idss !='')
            {
                          
              $category_lists1 = $wpdb->get_row( "SELECT * FROM category where category_id = '".$category_idss."'" );
              if($category_lists1)
              {
                $category_name = $category_lists1->category_name;
              }
            }

          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $itemlist->item_name; ?></td>
            <td><?php echo $itemlist->item_description; ?></td>
            <td><?php echo $step_name; ?></td>
            <td><?php echo $category_name; ?></td>
            <td><?php echo $itemlist->base_price; ?></td>
            <!-- <td>0</td> -->
            <td>

<form method="post" action="<?php echo admin_url(); ?>admin.php?page=item_page" id="form1_<?php echo $item_idss; ?>">

                  <input type="hidden" name="ssitem_id" value="<?php echo $item_idss; ?>" />
                  <input type="hidden" name="form_action" value="show" />

                  

                  <a id="href" class="btn btn-sm btn-info"  onclick="document.getElementById('form1_<?php echo $item_idss; ?>').submit(); return false;">
                    <i class="fa fa-pencil" id="fa" aria-hidden="true"></i> Edit
                  </a>
                </form>

          </tr>
        <?php } } else { echo "<tr><td>No item found</td></tr>"; }?>
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