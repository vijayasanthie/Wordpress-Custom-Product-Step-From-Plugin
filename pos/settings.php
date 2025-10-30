<br><br>
<?php
global $wpdb;

$option_type = 'sidebar';
$background_color = '#F0EFF3';
$sub_background_color = '#DCDCE3';
$id = '';
$form_value = 'Add';
$message = '';
$status = '1';
$text_color = '#ff7200';

$pos_id = '';
$pos_title = $welcome_text = $footer_content = $welcome_content = $message1 = '';

if(isset($_POST) && isset($_POST['form_action']))
{

 // echo "aaaaaaaaaaaaa";
  if($_POST['form_action'] == 'insert')
  {
    $id1 = $_POST['id'];
    $option_type1 = $_POST['option_type'];
    $background_color1 = $_POST['background_color'];
    $sub_background_color1 = $_POST['sub_background_color'];
    $text_color1 = $_POST['text_color'];
    $status1 = 1;
    if($id1 == '')
    {
      $insert_data = array('option_type' => $option_type1,'background_color' => $background_color1, 'sub_background_color' => $sub_background_color1,'text_color' => $text_color1,'status' => $status1,'created_on' => date('Y-m-d H:i:s'));
      $insert_id =  $wpdb->insert( 'coloroption', $insert_data );
     // echo $wpdb->last_query;
      $message = "<div class='alert alert-success'>Settings saved successfully</div>";
    }
    else
    {
      $update_data = array('option_type' => $option_type1,'background_color' => $background_color1, 'sub_background_color' => $sub_background_color1,'text_color' => $text_color1, 'status' => $status1, 'modified_on' => date('Y-m-d H:i:s'));
      $where_array = array('id' => $id1);
      $insert_id =  $wpdb->update( 'coloroption', $update_data, $where_array );
      // echo $wpdb->last_query;
      $message = "<div class='alert alert-success'>Settings saved successfully</div>";
      //$_GET = array();
    }
    $_POST = array(); 
   
  }

  if($_POST['form_action'] == 'frontend_insert')
  {
    //echo "dddddddddddddddddddddddd";
    $pos_id1 = $_POST['pos_id'];
    $pos_title1 = $_POST['pos_title'];
    $welcome_text1 = $_POST['welcome_text'];
    $welcome_content1 = $_POST['welcome_content'];
    $footer_content1 = $_POST['footer_content'];
   // $text_color1 = $_POST['text_color'];
    $status1 = 1;
    if($pos_id1 == '')
    {
      $insert_data = array('pos_title' => $pos_title1,'welcome_text' => $welcome_text1, 'welcome_content' => $welcome_content1,'footer_content' => $footer_content1,'created_on' => date('Y-m-d H:i:s'));
      $insert_id =  $wpdb->insert( 'fontend_content', $insert_data );
      //echo $wpdb->last_query;
      $message1 = "<div class='alert alert-success'>Settings saved successfully</div>";
    }
    else
    {
      $update_data = array('pos_title' => $pos_title1,'welcome_text' => $welcome_text1, 'welcome_content' => $welcome_content1,'footer_content' => $footer_content1, 'modified_on' => date('Y-m-d H:i:s'));
      $where_array = array('pos_id' => $pos_id1);
      $insert_id =  $wpdb->update( 'fontend_content', $update_data, $where_array );
      // echo $wpdb->last_query;
      $message1 = "<div class='alert alert-success'>Settings saved successfully</div>";
      //$_GET = array();
    }
    $_POST = array(); 
   
  }
  else
  {

  }
}






 $select_result = $wpdb->get_row( "SELECT * FROM coloroption" );

    if($select_result)
    {
      $option_type = $select_result->option_type;
      $background_color = $select_result->background_color;
      $sub_background_color = $select_result->sub_background_color;
      $status = $select_result->status;
      $text_color = $select_result->text_color;
      $id = $select_result->id;
      //$form_value = 'Update';
    }

     $select_result1 = $wpdb->get_row( "SELECT * FROM fontend_content" );

    if($select_result1)
    {
      $pos_title = $select_result1->pos_title;
      $welcome_text = $select_result1->welcome_text;
      $welcome_content = $select_result1->welcome_content;
      $pos_id = $select_result1->pos_id;
      $footer_content = $select_result1->footer_content;
      //$form_value = 'Update';
    }

?>
<div class="wrap">
  <div class="col-md-12">
    <!-- <div class="col-md-2"></div> -->
    <div class="col-md-6">
      <div class="col-md-12 stltab_header">
        <div class="col-md-12 ">
          <div class="row stltab_title">
            <span>Content Settings</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
          <div><?php echo $message1; ?></div>
          <form action="" method="post" class="row form_addlocation">
            <input type="hidden" name="pos_id" value="<?php echo $pos_id; ?>">
            <input type="hidden" name="form_action" value="frontend_insert" />
             <!-- <input type="hidden" class="form-control" name="option_type" value="<?php echo $option_type; ?>" required> -->

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="background_color"><?php _e( 'POS Title', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="text" name="pos_title" class="form-control" value="<?php echo $pos_title; ?>">
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="sub_background_color"><?php _e( 'Welcome Title', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="text" name="welcome_text" class="form-control" value="<?php echo $welcome_text; ?>">
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="text_color"><?php _e( 'Welcome Content', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea type="text" name="welcome_content" class="form-control"><?php echo $welcome_content; ?></textarea>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="text_color"><?php _e( 'Last Step Footer Content', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <textarea type="text" name="footer_content" class="form-control"><?php echo $footer_content; ?></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <center><button type="submit" name="submitcategory" class="btn btn-success btn-orange btn_addcategory"><?php _e(  'Save Settings', 'wordpress' ); ?></button></center>
              </div>
          </form>
        </div>
          </div>
        </div>
      </div>





      <div class="col-md-6">
      <div class="col-md-12 stltab_header">
        <div class="col-md-12 ">
          <div class="row stltab_title">
            <span>Color Settings</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
          <div><?php echo $message; ?></div>
          <form action="" method="post" class="row form_addlocation">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="form_action" value="insert" />
             <input type="hidden" class="form-control" name="option_type" value="<?php echo $option_type; ?>" required>

            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="background_color"><?php _e( 'Background Color', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="color" name="background_color" class="form-control" value="<?php echo $background_color; ?>">
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="sub_background_color"><?php _e( 'Subscription Background Color', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="color" name="sub_background_color" class="form-control" value="<?php echo $sub_background_color; ?>">
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label class="control-label col-md-4" for="text_color"><?php _e( 'Text Color', 'wordpress' ); ?></label>
              <div class="col-md-8"> 
                <input type="color" name="text_color" class="form-control" value="<?php echo $text_color; ?>">
              </div>
            </div>

            <div class="col-md-12">
              <center><button type="submit" name="submitcategory" class="btn btn-success btn-orange btn_addcategory"><?php _e(  'Save Settings', 'wordpress' ); ?></button></center>
              </div>
          </form>
        </div>
          </div>
        </div>
      </div>

</div>
</div>
