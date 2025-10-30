<br><br>
<style>
.show_preloader{
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background:url("<?php echo site_url(); ?>/wp-content/plugins/pos/images/preloader.gif") no-repeat center center rgba(0,0,0,0.25)
}
</style>
<?php
global $wpdb;

  $product_table = 'product';
  $steps_table = 'product_steps';
  $cat_table = 'product_category';
  $item_table = 'product_items';
 // $qty_table = 'product_quantity';


$form_value = 'Add';
$message = '';
$steps_array = array();
$steps_json = '';

$items_result = $wpdb->get_results( "SELECT * FROM item" );
$steps_result = $wpdb->get_results( "SELECT * FROM step WHERE status = '1' order by steps_order asc" );
$category_result = $wpdb->get_results( "SELECT * FROM category where status='1'" );

if(isset($_GET['product_id'])) {

$product_id = $_GET['product_id'];

 $select_result = $wpdb->get_row( "SELECT * FROM product WHERE product_id = '".$product_id."'" );

    if($select_result)
    {
      $product_name = $select_result->product_name;
      $yearly_min_fees = $select_result->yearly_min_fees;
      $product_description = $select_result->product_description;
      //$base_price = $select_result->base_price;
      //$steps_json = $select_result->steps_json;
      //$steps_array=unserialize($steps_json);
      $form_value = 'Update';
    }

//echo "<pre>";print_r($steps_array);echo "</pre>";

?>
<div class="preloader"></div>
<div class="wrap">
  <div class="col-md-12">

      <div class="col-md-12 stltab_header">
        <div class="col-md-12 ">
          <div class="row stltab_title">
            <span>Product Items</span>
            <button type="button" class="btn btn-success btn_save">Save</button>
          </div>
        </div>
        <div class="col-md-12">
          
          <div class="message"></div>
          <form action="" method="post" id="stepsform" class="row form_addlocation" enctype="multipart/form-data">
           
            <input type="hidden" class="product_id" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="form_action" value="insert" />
            
            <div class="col-md-4 form-group">
              <label class="control-label col-md-3" for="product_name"><?php _e( 'Name', 'wordpress' ); ?></label>
              <div class="col-md-9"> 
                <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>" required>
              </div>
            </div>
            <div class="col-md-4 form-group">
              <label class="control-label col-md-8" for="product_name"><?php _e( 'Yearly Minimum Fees', 'wordpress' ); ?></label>
              <div class="col-md-4"> 
                <input type="text" class="form-control" name="yearly_min_fees" value="<?php echo $yearly_min_fees; ?>" required>
              </div>
            </div>
            <!-- <div class="col-md-4 form-group">
              <label class="control-label col-md-3" for="base_price"><?php _e( 'Price', 'wordpress' ); ?></label>
              <div class="col-md-9"> 
                <input type="text" class="form-control" name="base_price" value="<?php echo $base_price; ?>" required>
              </div>
            </div> -->
            <div class="col-md-4 form-group">
              <label class="control-label col-md-3" for="product_description"><?php _e( 'Description', 'wordpress' ); ?></label>
              <div class="col-md-9"> 
                <textarea class="form-control" name="product_description" required><?php echo $product_description; ?></textarea>
              </div>
            </div>
            
              <!-- <div class="col-md-12">

                <div class="col-md-2 form-group">
                    <select class="form-control select_step_id">
                      <?php
                      if($steps_result)
                      {
                        foreach($steps_result as $step)
                        {
                          echo "<option value='".$step->step_id."'>".$step->step_name."</option>";
                        }
                      }
                      ?>
                    </select>
                </div>

                 <div class="col-md-2 form-group">

                    <select class="form-control pos_type">
                      <option value="pos_system">Default POS system</option>
                      <option value="additional_item">Additional items</option>
                    </select>
                </div>

                <div class="col-md-2 form-group">

                    <select class="form-control view_type">
                      <option value="radio">Single(radio)</option>
                      <option value="checkbox">Multiple(Checkbox)</option>
                    </select>
                    <span class="small">(Sigle or multiple item selection option in frontend)</span>
                </div>

                <div class="col-md-2 form-group">

                    <select class="form-control quantity_type">
                      <option value="normal_item">Normal Item</option>
                      <option value="subscription_item">Subsciption Item</option>
                    </select>
                    
                </div> 

                <div class="col-md-2 form-group">
                    <select class="form-control select_category" multiple="">
                      <?php
                      if($category_result)
                      {
                        foreach($category_result as $category)
                        {
                          echo "<option value='".$category->category_id."'>".$category->category_name."</option>";
                        }
                      }
                      ?>
                    </select>
                </div>

                <div class="col-md-2">
                  <button type="button" class="btn btn-info btn-orange btn_addsteps"><?php _e(  'Add Steps', 'wordpress' ); ?></button>
                </div>
                
              </div> -->

            

            <div class="additional_steps">
           


<?php
  if($product_id !=''){
    $steps_count = 0;
    $stepsdiv = '';
    //$steps_result  = $wpdb->get_results( "SELECT * FROM step WHERE status = '1' order by steps_order asc" );
    //echo $wpdb->last_query;
      if($steps_result)
      {
        ?>

        <input type="hidden" name="steps_count" class="steps_count" value="<?php echo sizeof($steps_result); ?>">
        <?php
        foreach($steps_result as $ppsteps_data)
          {
            $step_id = $ppsteps_data->step_id;

            $steps_name = $ppsteps_data->step_name;
            $item_type = $ppsteps_data->item_type;


            $steps_data = $wpdb->get_row( "SELECT * FROM ".$steps_table." WHERE product_id = '".$product_id."' and step_id = '".$step_id."'" );

            //echo $wpdb->last_query;
           // echo "<pre>";print_r($steps_data);echo "</pre>";
            if($steps_data)
            {
              $pstep_id = $steps_data->pstep_id;
              $pquantity_type = $steps_data->quantity_type;
            }
            else
            {
              $pstep_id = '';
              $pquantity_type = 'radio';
            }

           $radio_select = ($pquantity_type == 'radio')?'selected':'';
           $checkbox_select = ($pquantity_type == 'checkbox')?'selected':'';
           // $step_id = $steps_data->step_id;
            //$pos_type = $steps_data->pos_type;
            //$view_type = $steps_data->view_type;
            //$quantity_type = $steps_data->quantity_type;
            //$steps_namess = $wpdb->get_row( "SELECT * FROM step where step_id = '".$step_id."'" );
            //$steps_name = $steps_namess->step_name;
            //$item_type = $steps_namess->item_type;

            $category_datas = $wpdb->get_results( "SELECT * FROM ".$cat_table." WHERE pstep_id = '".$pstep_id."'" );

            $total_cat_count = sizeof($category_datas);

$stepsdiv .= "<div class='col-md-12 steps_div'>

  <div class='col-md-12 steps_title'>
    <div class='col-md-3'>
    <button class='btn btn-sm btn-outline-danger btn_remove btn_removestep' style='display:none;'> <i class='fa fa-times'></i></button>
    <span style='text-decorat'><b>Step: </b>".$steps_name."</span>
    </div>
    <div class='col-md-5'>

                    <select class='form-control view_type' name='steps_details[".$steps_count."][quantity_type]' style='display:inline-block;width:auto;margin-top:0px;'>
                      <option value='radio' ".$radio_select.">Single(radio)</option>
                      <option value='checkbox' ".$checkbox_select.">Multiple(Checkbox)</option>
                    </select>
                    <span class='small' style='font-size:12px;'>(Sigle or multiple item selection option in frontend)</span>
                </div>

    <div class='col-md-4' style='text-align:right;'>
    
      <select class='form-control category_list' >";
      if($category_result)
      {
        foreach($category_result as $cat)
        {
          $stepsdiv .= "<option value='".$cat->category_id."'>".$cat->category_name."</option>";
        }
      }
      $stepsdiv .= "</select>
    <button type='button' class='btn btn-sm btn-outline-success  btn_addcategory'> <i class='fa fa-plus'></i> Add category</button>
    </div>
  </div>";
  $stepsdiv .= '<input type="hidden" name="steps_details['.$steps_count.'][stl_step_id]" class="stl_step_id" value="'.$step_id.'">



      <input type="hidden" name="category_count" class="category_count" value="'.$total_cat_count.'">
      <input type="hidden" name="this_steps_count" class="this_steps_count" value="'.$steps_count.'">

      <div class="col-md-12 categorys_div">';


            if(!empty($category_datas))
            {
              $category_count = 0;
              foreach($category_datas as $category_data)
              {
                $category_name = '';
                $pcategory_id = $category_data->pcategory_id;
                $category_id = $category_data->category_id;
                $category_namess = $wpdb->get_row( "SELECT * FROM category where category_id = '".$category_id."'" );
               // echo "<pre>";print_r($category_namess);echo "</pre>";
                if(!empty($category_namess)){$category_name = $category_namess->category_name;}
                $item_datas = $wpdb->get_results( "SELECT * FROM ".$item_table." WHERE pcategory_id = '".$pcategory_id."'" );

                $total_item_count = sizeof($item_datas);
                $stepsdiv .='<div class="col-md-12 category_div">
              
              <input type="hidden" name="this_category_count" class="this_category_count" value="'.$category_count.'">

              <input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][stl_category_id]" class="stl_category_id" value="'.$category_id.'">
              <input type="hidden" class="item_count" value="'.$total_item_count.'">
                 
                <div class="col-md-12 category_title">
                  <button class="btn btn-sm btn-outline-danger btn_remove btn_removecategory"> <i class="fa fa-times"></i></button>  
                  <span><b>Category: </b> '.$category_name.'</span>
                  <button type="button" class="btn btn-outline-info btn-sm btn_additem"><i class="fa fa-plus-circle btn_additem"></i> Add Item</button>

                </div>';


                if(!empty($item_datas))
                {
                  $item_count = 0;
                  foreach($item_datas as $item_data)
                  {
                    $pitem_id = $item_data->pitem_id;
                    $item_name = $item_data->item_name;
                    $item_description = $item_data->item_description;
                    $max_qty = $item_data->max_qty;
                    $item_price = $item_data->item_price;
                    $max_item_price = $item_data->max_item_price;
                    $yearly_price = $item_data->yearly_price;
                    $default_selected = $item_data->default_selected;
                    $item_img = $item_data->item_img;
                    if($item_img =='')
                    {
                      $item_img = '/wp-content/plugins/pos/images/noimage.png';
                    }

                    $noselected = ($default_selected == 'no')?'selected':'';
                    $yesselected = ($default_selected == 'yes')?'selected':'';


                    $stepsdiv .= '  
      
      <div class="col-md-12 items_div">
        
          <div class="col-md-1 btn_removeitemdiv">
          <button class="btn btn-sm btn-outline-danger btn_remove btn_removeitem"> <i class="fa fa-times"></i></button>
          </div>
          <div class="col-md-2">
            <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_name]" class="form-control" placeholder="item name" value="'.$item_name.'">
          </div>
          <div class="col-md-2">
            <input type="file" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_image]" class="form-control item_image" >
            <input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_img]" class="form-control item_img" value="'.$item_img.'">
            <img class="preview_itemimg" src="'.site_url().$item_img.'" width="100" alt="your image" />
          </div>
          <div class="col-md-2">
            <textarea name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_description]" class="form-control" placeholder="item desciption">'.$item_description.'</textarea>
          </div>
          ';
         
          if($item_type == 'normal_item') { 
            $stepsdiv .= ' <div class="col-md-4 quantity_div">
            <div class="col-md-6">
            <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_qty]" class="form-control" placeholder="Max Quantity" value="'.$max_qty.'">
            <span class="small text-warning">(Leave blank if product quantity is unlimited)</span>
            </div>
            <div class="col-md-6">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_price]" class="form-control" placeholder="Item fees" value="'.$item_price.'">
              </div>
              <input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_item_price]" class="form-control" Placeholder="Max Subscription Fees" value="0">
              <input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][yearly_price]" class="form-control"  value="0">

            </div>';
           } else { 
           $stepsdiv .= '
            <div class="col-md-4 quantity_div">
              <div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_qty]" class="form-control" placeholder="Max Quantity" value="'.$max_qty.'">
              <span class="small text-warning">(Leave blank if product quantity is unlimited)</span>
              </div>
              <div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_price]" class="form-control" Placeholder="Subscription Fees" value="'.$item_price.'">
              </div>
              <div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_item_price]" class="form-control" Placeholder="Max Subscription Fees" value="'.$max_item_price.'">
              </div>
              <div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][yearly_price]" class="form-control" Placeholder="Yearly Fees" value="'.$yearly_price.'">
              </div>
            </div>';
           } 
        $stepsdiv .= '
        <div class="col-md-1">
          <select name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][default_selected]" class="form-control">
            <option value="no" '.$noselected.'>No</option>
            <option value="yes" '.$yesselected .'>Yes</option>
          </select>
          <span class="small text-warning">(Frontend default item selected)</span>
        </div>
     </div>
    ';


    $item_count++;
                  }
                }

                $stepsdiv .= '</div><div style="clear:both"></div><hr>';

                $category_count++;
              }
            }
            $stepsdiv .='</div></div>';
            $steps_count++;
          }

      }
      else
      {
        ?>
         <input type="hidden" name="steps_count" class="steps_count" value="0">
         <?php

      }

      echo  $stepsdiv;
  }
  else
  {
?>
 <input type="hidden" name="steps_count" class="steps_count" value="0">
 <?php } ?>
            </div>

            <div style="clear:both"></div> <hr>


            <!-- <div class="col-md-12">
              <center><button type="button" name="submitproduct" class="btn btn-success btn-orange btn_addproduct"><?php _e(  'Save', 'wordpress' ); ?></button></center>
            </div> -->
          </form>
        
          </div>
        </div>




</div>
</div>

<div class="appendadditional_steps" style="">
  
    
<?php
//$quantity_type = 'single_qtyd' ; ?>




  
</div>

<script type="text/javascript">
  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";







  jQuery(document).on('click','.btn_addsteps',function(){




    var steps_count = jQuery(".steps_count").val() || 0;

    var select_step_id = jQuery(".select_step_id").val();
    var select_category = jQuery(".select_category").val();
    //var view_type = jQuery(".view_type").val();
   // var pos_type = jQuery(".pos_type").val();
    //var quantity_type = jQuery(".quantity_type").val();

    var select_step_txt = jQuery(".select_step_id option:selected").text();


    //var append_txt = jQuery(".appendadditional_steps").html();
    //console.log(append_txt);

    //jQuery(".additional_steps").append('<div class="col-md-12"><input type="text" class="selected_step" value="'+select_step+'">'+ append_txt+"</div>");


    jQuery.ajax({
      url: ajaxurl,
      data: {'action':'add_stepsdiv','select_step_id':select_step_id,'select_step_txt' : select_step_txt, 'select_category' : select_category,'steps_count' : steps_count },
      dataType:'json',
      beforeSend: function(){
        jQuery('.preloader').addClass('show_preloader');
      },
      success:function(data) {
        if(data.status == 1)
        {
          jQuery(".additional_steps").append(data.message);
          steps_count++;
          jQuery(".steps_count").val(steps_count);
        }
        else
        {
          alert("Error in add additional steps");
        }
        jQuery('.preloader').removeClass('show_preloader');
      },
      error: function(errorThrown){
        console.log(errorThrown);
        alert("Error in ajax load");
        jQuery('.preloader').removeClass('show_preloader');
      }
    });



  });

  

    jQuery(document).on('click','.btn_addcategory',function(){

    //  console.log('dddddddddddddddddddddddddddddddd');

    var this_val = jQuery(this);
    var steps_count = jQuery(".steps_count").val();
    var select_step_id = jQuery(this).closest('.steps_div').find(".stl_step_id").val();
   // var select_category = jQuery(this).closest('.steps_div').find(".stl_select_category").val();
   // var view_type = jQuery(this).closest('.steps_div').find(".stl_view_type").val();
   // var pos_type = jQuery(this).closest('.steps_div').find(".stl_pos_type").val();
   // var quantity_type = jQuery(this).closest('.steps_div').find(".stl_quantity_type").val();

    var category_id = jQuery(this).closest('.steps_div').find(".category_list").val();

    var category_count = jQuery(this).closest('.steps_div').find(".category_count").val();
    var this_steps_count = jQuery(this).closest('.steps_div').find(".this_steps_count").val();



    jQuery.ajax({
      url: ajaxurl,
      data: {'action':'add_categorydiv','select_step_id':select_step_id,'category_id' : category_id,'category_count' : category_count,'steps_count' : this_steps_count },
      dataType:'json',
      beforeSend: function(){
        jQuery('.preloader').addClass('show_preloader');
      },
      success:function(data) {
        if(data.status == 1)
        {
          this_val.closest('.steps_div').find('.categorys_div').append(data.message);
          category_count = parseInt(category_count)+1;
          this_val.closest('.steps_div').find(".category_count").val(category_count);
          

        }
        else
        {
          alert("Error in add additional category");
        }
        jQuery('.preloader').removeClass('show_preloader');
      },
      error: function(errorThrown){
        console.log(errorThrown);
        alert("error in ajax load");
        jQuery('.preloader').removeClass('show_preloader');
      }
    });


  });
  jQuery(document).on('click','.btn_additem',function(){

    var this_val = jQuery(this);
    var select_step_id = jQuery(this).closest('.steps_div').find(".stl_step_id").val();
   // var select_category = jQuery(this).closest('.steps_div').find(".stl_select_category").val();
   // var view_type = jQuery(this).closest('.steps_div').find(".stl_view_type").val();
   // var pos_type = jQuery(this).closest('.steps_div').find(".stl_pos_type").val();
   // var quantity_type = jQuery(this).closest('.steps_div').find(".stl_quantity_type").val();

    var category_id = jQuery(this).closest('.category_div').find(".stl_category_id").val();

    var category_count = jQuery(this).closest('.category_div').find(".this_category_count").val();
    var this_steps_count = jQuery(this).closest('.steps_div').find(".this_steps_count").val();
    var item_count = jQuery(this).closest('.category_div').find(".item_count").val();



    jQuery.ajax({
      url: ajaxurl,
      data: {'action':'add_itemsdiv','select_step_id':select_step_id,'category_id' : category_id,'category_count' : category_count,'steps_count' : this_steps_count,'item_count' : item_count },
      dataType:'json',
      beforeSend: function(){
        jQuery('.preloader').addClass('show_preloader');
      },
      success:function(data) {
        if(data.status == 1)
        {
          this_val.closest('.category_div').append(data.message);
          item_count++;
         // alert(item_count);
          this_val.closest('.category_div').find(".item_count").val(item_count);
          
        }
        else{
          alert("Error in add additional item");
        }
        jQuery('.preloader').removeClass('show_preloader');
      },
      error: function(errorThrown){
        console.log(errorThrown);
        alert("Error in ajax load");
        jQuery('.preloader').removeClass('show_preloader');
      }
    });


  });

  /*jQuery(document).on('click','.btn_addqty',function(){

    var quantity_count = jQuery(this).closest('.items_div').find('.quantity_count').val();

    var steps_count =  jQuery(this).closest('.steps_div').find('.this_steps_count').val(); 

    var category_count =  jQuery(this).closest('.category_div').find('.this_category_count').val(); 

    var item_count =  jQuery(this).closest('.category_div').find('.item_count').val(); 

    var this_val = jQuery(this);

   //console.log("cllllllllllllll");
   var qty_div = '<div class="col-md-3"><input type="text" class="form-control btn_addqty" name="steps_details['+steps_count+'][category_details]['+category_count+'][item_details]['+item_count+'][quantity_details]['+quantity_count+'][qty_condition]" placeholder="Quantity Condition"></div><div class="col-md-3"><input type="text" class="form-control" name="steps_details['+steps_count+'][category_details]['+category_count+'][item_details]['+item_count+'][quantity_details]['+quantity_count+'][item_price]"  Placeholder="Price"></div>';

   this_val.closest('.items_div').find('.quantity_div').append(qty_div);

   quantity_count++;
   this_val.closest('.items_div').find('.quantity_count').val(quantity_count);
   

  });*/


  jQuery(document).on('click','.btn_removestep',function(){
    if (confirm("Are you sure want to delete this step?")) {
      jQuery(this).closest('.steps_div').remove();
    }
    else
    {
      return false;
    }
  });
  jQuery(document).on('click','.btn_removecategory',function(){
    if (confirm("Are you sure want to delete this category?")) {
      jQuery(this).closest('.category_div').remove();
    }
    else
    {
      return false;
    }
  });

  jQuery(document).on('click','.btn_removeitem',function(){
    if (confirm("Are you sure want to delete this item?")) {
      jQuery(this).closest('.items_div').remove();
    }
    else
    {
      return false;
    }
  });

  jQuery(document).on('click','.btn_save',function(){

jQuery(".message").html('');
   // alert("fffffffffffffff");

    var formData=new FormData(document.getElementById('stepsform')); 

        formData.append("action", "savestepform");  
        console.log(formData);
    
    jQuery.ajax({
      url: ajaxurl,
    type: 'POST',
            data: formData, 
            cache: false,
            processData: false, 
            contentType: false, 
            dataType:'json', 
      beforeSend: function(){
        jQuery('.preloader').addClass('show_preloader');
      },
      success:function(data) {

        if(data.status == 1)
        {
          location.reload();
          jQuery(".message").html('<div class="alert alert-success">Product saveed successfully</div.')
        }
        else
        {
          alert("Error in product item save");
        }
        jQuery('.preloader').removeClass('show_preloader');
      },
      error: function(errorThrown){
        console.log(errorThrown);
        alert("Error in ajax product save");
        jQuery('.preloader').removeClass('show_preloader');
      }
    });
  });



  function readURL(input,this_val) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      this_val.closest('.items_div').find('.preview_itemimg').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

jQuery(document).on('change','.item_image',function(){

var this_val = jQuery(this);
var product_id = jQuery(".product_id").val();
   var formData = new FormData();

 //Append files infos
 jQuery.each(jQuery(this)[0].files, function(i, file) {
     formData.append('file', file);
 });

  
  readURL(this,this_val);


             formData.append('action', 'uploadimage');
             formData.append('product_id', product_id);


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
        this_val.closest('.items_div').find('.item_img').val(data.image_name);
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

<?php } ?>