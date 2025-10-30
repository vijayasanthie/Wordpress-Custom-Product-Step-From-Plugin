<br><br>
<?php
global $wpdb;

$product_name = '';
$product_description = '';
$product_id = '';
// $base_price = '';
$product_img = '';
$form_value = 'Add';
$message = '';
$status = 1;

if(isset($_POST) && isset($_POST['form_action']))
{
  if($_POST['form_action'] == 'insert')
  {
    $product_id1 = $_POST['product_id'];
    $product_name1 = $_POST['product_name'];
    $product_description1 = $_POST['product_description'];
//$base_price1 = $_POST['base_price'];
    $product_img1 = $_POST['product_img'];
    $status1 = $_POST['status'];
    if($product_id1 == '')
    {
      $insert_data = array('product_name' => $product_name1,'product_description' => $product_description1,'product_image' => $product_img1, 'status' => $status1,'created_on' => date('Y-m-d H:i:s'));
      $insert_id =  $wpdb->insert( 'product', $insert_data );
      $message = "<div class='alert alert-success'>Inserted Successfully</div>";
    }
    else
    {
      $update_data = array('product_name' => $product_name1,'product_description' => $product_description1,'product_image' => $product_img1,'status' => $status1, 'modified_on' => date('Y-m-d H:i:s'));
      $where_array = array('product_id' => $product_id1);
      $insert_id =  $wpdb->update( 'product', $update_data, $where_array );
      $message = "<div class='alert alert-success'>Updated Successfully</div>";
      //$_GET = array();
    }
    $_POST = array(); 
   
  }
  else if($_POST['form_action'] == 'show')
  {
    $product_id = $_POST['ssproduct_id'];
    $select_result = $wpdb->get_row( "SELECT * FROM product WHERE product_id = '".$product_id."'" );

    if($select_result)
    {
      $product_name = $select_result->product_name;
      $product_description = $select_result->product_description;
      //$base_price = $select_result->base_price;
      $product_img = $select_result->product_image;
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
            <span><?php echo  $form_value; ?> product</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
          <div><?php echo $message; ?></div>
          <form action="" method="post" class="row form_addlocation">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="form_action" value="insert" />
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="product_name"><?php _e( 'Name', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>" required>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="product_description"><?php _e( 'Description', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea class="form-control" name="product_description" required><?php echo $product_description; ?></textarea>
              </div>
            </div>
           <!--  <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="base_price"><?php _e( 'Price', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea class="form-control" name="base_price" required><?php echo $base_price; ?></textarea>
              </div>
            </div> -->
             <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="base_price"><?php _e( 'Product Image', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="file" name="product_image" class="form-control product_image" >
                <input type="hidden" name="product_img" class="form-control product_img" value="<?php echo $product_img; ?>">
                <img class="preview_ptimg" src="<?php echo site_url().$product_img; ?>" width="100" alt="your image" />
              </div>
            </div>

             <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="base_price"><?php _e( 'Status', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <select name="status" class="form-control">
                  <option value="1" <?php echo ($status == '1')?'selected': ''; ?> >Active</option>
                  <option value="0" <?php echo ($status == '0')?'selected': ''; ?> >In-Active</option>
                </select>
              </div>
            </div>

            


            <div class="col-md-12">
              <center><button type="submit" name="submitproduct" class="btn btn-success btn-orange btn_addproduct"><?php _e(  $form_value.' product', 'wordpress' ); ?></button></center>
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
      <span>product List</span>
     
    </div>
  </div>
  <div class="col-md-12">
      <table class="widefat products_list">
        <thead>
          <tr>
            <th>S.no</th>
            <th>product Image</th>
            <th>product Name</th>
            <th>product Description</th>
            <th>Status</th>
            <th>Steps</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $productlists = $wpdb->get_results("select * from product");
         
          if($productlists) {
            $count = 0;
          foreach ($productlists as $productlist ) 
          {
            $count++;
            $product_idss = $productlist->product_id;
            $statuss = $productlist->status;
            $status_txt = ($statuss == '1')?'Active':'In-Active';
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><img src="<?php echo site_url().$productlist->product_image; ?>" style="width:74px;"></td>
            <td><?php echo $productlist->product_description; ?></td>
            <td><?php echo $productlist->product_description; ?></td>
            <td><?php echo $status_txt; ?></td>
            <td><a href="<?php echo admin_url(); ?>/admin.php?page=addproduct_page&product_id=<?php echo $product_idss; ?>">click here</a></td>
            <td>

<form method="post" action="<?php echo admin_url(); ?>admin.php?page=product_page" id="form1_<?php echo $product_idss; ?>">

                  <input type="hidden" name="ssproduct_id" value="<?php echo $product_idss; ?>" />
                  <input type="hidden" name="form_action" value="show" />

                  

                  <a id="href" class="btn btn-sm btn-info"  onclick="document.getElementById('form1_<?php echo $product_idss; ?>').submit(); return false;">
                    <i class="fa fa-pencil" id="fa" aria-hidden="true"></i> Edit
                  </a>
                </form>

          </tr>
        <?php } } else { echo "<tr><td>No product found</td></tr>"; }?>
        </tbody>
      </table>

    </div>
</div>
</div>

</div>
</div>

<script type="text/javascript">
  jQuery(window).load(function() {

    var table = jQuery('.products_list').DataTable( {

          "language": {"lengthMenu": "Show _MENU_ per page"}, 
      "bFilter": true,"bDestroy": true,
} );
     




  });


  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";


  function readURL(input,this_val) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      jQuery('.preview_ptimg').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

jQuery(document).on('change','.product_image',function(){

var this_val = jQuery(this);
//var product_id = jQuery(".product_id").val();
   var formData = new FormData();

 //Append files infos
 jQuery.each(jQuery(this)[0].files, function(i, file) {
     formData.append('file', file);
 });

  
  readURL(this,this_val);


             formData.append('action', 'uploadimage');
             formData.append('product_id', '');


  jQuery.ajax({
    url: ajaxurl, // Url to which the request is send
    type: "POST",             // Type of request to be send, called as method
    data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,        
    dataType:'json',
    beforeSend: function(){
        jQuery('.preloader').addClass('show_preloader');
      },
    success: function(data)   // A function to be called if request succeeds
    {
      //alert(data.status);
      if(data.status == '1')
      {
       // alert("iffff");
        jQuery('.product_img').val(data.image_name);
      }
      else
      {
        //alert("elll");
        alert(data.message);
      }
      jQuery('.preloader').removeClass('show_preloader');
    }
    });


});




</script>