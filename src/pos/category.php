<br><br>
<?php
global $wpdb;

$category_name = '';
$category_description = '';
$category_id = '';
$form_value = 'Add';
$message = '';
$status = '1';

if(isset($_POST) && isset($_POST['form_action']))
{
  if($_POST['form_action'] == 'insert')
  {
    $category_id1 = $_POST['category_id'];
    $category_name1 = $_POST['category_name'];
    $category_description1 = $_POST['category_description'];
    $status1 = $_POST['status'];
    if($category_id1 == '')
    {
      $insert_data = array('category_name' => $category_name1,'category_description' => $category_description1,'status' => $status1,'created_on' => date('Y-m-d H:i:s'));
      $insert_id =  $wpdb->insert( 'category', $insert_data );
      $message = "<div class='alert alert-success'>Item Category inserted Successfully</div>";
    }
    else
    {
      $update_data = array('category_name' => $category_name1,'category_description' => $category_description1,'status' => $status1, 'modified_on' => date('Y-m-d H:i:s'));
      $where_array = array('category_id' => $category_id1);
      $insert_id =  $wpdb->update( 'category', $update_data, $where_array );
      $message = "<div class='alert alert-success'>Item Category Updated Successfully</div>";
      //$_GET = array();
    }
    $_POST = array(); 
   
  }
  else if($_POST['form_action'] == 'show')
  {
    $category_id = $_POST['sscategory_id'];
    $select_result = $wpdb->get_row( "SELECT * FROM category WHERE category_id = '".$category_id."'" );

    if($select_result)
    {
      $category_name = $select_result->category_name;
      $category_description = $select_result->category_description;
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
            <span><?php echo  $form_value; ?> Item Category</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
          <div><?php echo $message; ?></div>
          <form action="" method="post" class="row form_addlocation">
            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
            <input type="hidden" name="form_action" value="insert" />
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="category_name"><?php _e( 'Name', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="text" class="form-control" name="category_name" value="<?php echo $category_name; ?>" required>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="category_description"><?php _e( 'Description', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea class="form-control" name="category_description" required><?php echo $category_description; ?></textarea>
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
              <center><button type="submit" name="submitcategory" class="btn btn-success btn-orange btn_addcategory"><?php _e(  $form_value.' Item Category', 'wordpress' ); ?></button></center>
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
      <span>Item Category</span>
     
    </div>
  </div>
	<div class="col-md-12">
    	<table class="widefat steps_list">
        <thead>
          <tr>
            <th>S.no</th>
            <th>Category Name</th>
            <th>Category Description</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $categorylists = $wpdb->get_results("select * from category");
         
          if($categorylists) {
            $count = 0;
          foreach ($categorylists as $categorylist ) 
          {
            $count++;
            $category_idss = $categorylist->category_id;
            $statuss = $categorylist->status;
            $status_txt = ($statuss == '1')?'Active':'In-Active';
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $categorylist->category_name; ?></td>
            <td><?php echo $categorylist->category_description; ?></td>
            <td><?php echo $status_txt; ?></td>
            <td>

<form method="post" action="<?php echo admin_url(); ?>admin.php?page=category_page" id="form1_<?php echo $category_idss; ?>">

                  <input type="hidden" name="sscategory_id" value="<?php echo $category_idss; ?>" />
                  <input type="hidden" name="form_action" value="show" />

                  

                  <a id="href" class="btn btn-sm btn-info"  onclick="document.getElementById('form1_<?php echo $category_idss; ?>').submit(); return false;">
                    <i class="fa fa-pencil" id="fa" aria-hidden="true"></i> Edit
                  </a>
                </form>

          </tr>
        <?php } } else { echo "<tr><td>No category found</td></tr>"; }?>
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