<?php
/**
 * Plugin Name: POS System Price Calculation
 * Plugin URI: http://stallioni.com
 * Description: This plugin used to calculate the price based on POS products.
 * Version: 1.0.0
 * Author: Vijayasanthi E
 * Author URI: http://stallioni.com
 * License: Test
 */
session_start();
define( 'POSSYSTEM_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, 'myplugin_activate' ); // For activation
function myplugin_activate() {


 	global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

  	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS `category` (
	 `category_id` int(11) NOT NULL AUTO_INCREMENT,
	 `category_name` varchar(100) DEFAULT NULL,
	 `category_description` varchar(500) DEFAULT NULL,
	 `status` int(11) DEFAULT NULL,
	 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`category_id`)
	) $charset_collate;";


  	dbDelta( $sql );


    $sql1 = "CREATE TABLE IF NOT EXISTS `coloroption` (
	 `id` int(11) NOT NULL AUTO_INCREMENT,
	 `option_type` varchar(100) DEFAULT NULL,
	 `background_color` varchar(50) DEFAULT NULL,
	 `sub_background_color` varchar(50) DEFAULT NULL,
	 `text_color` varchar(50) DEFAULT NULL,
	 `status` int(11) DEFAULT NULL,
	 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`id`)
	) $charset_collate;";


  	dbDelta( $sql1 );

    $sql2 = "CREATE TABLE IF NOT EXISTS `customer_mail` (
	 `id` int(11) NOT NULL AUTO_INCREMENT,
	 `pdf_name` varchar(500) DEFAULT NULL,
	 `customer_name` varchar(100) DEFAULT NULL,
	 `emailid` varchar(100) DEFAULT NULL,
	 `phoneno` varchar(50) DEFAULT NULL,
	 `message` varchar(500) DEFAULT NULL,
	 `client_ip` varchar(100) DEFAULT NULL,
	 `mail_content` longtext,
	 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 PRIMARY KEY (`id`)
	) $charset_collate;";


  	dbDelta( $sql2 );


    $sql3 = "CREATE TABLE IF NOT EXISTS `fontend_content` (
	 `pos_id` int(11) NOT NULL AUTO_INCREMENT,
	 `pos_title` varchar(250) DEFAULT NULL,
	 `welcome_text` varchar(250) DEFAULT NULL,
	 `welcome_content` text,
	 `footer_content` longtext,
	 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`pos_id`)
	) $charset_collate;";


  	dbDelta( $sql3 );



	// $sql4 = "CREATE TABLE `item` (
	//  `item_id` int(11) NOT NULL AUTO_INCREMENT,
	//  `item_name` varchar(100) DEFAULT NULL,
	//  `item_description` varchar(500) DEFAULT NULL,
	//  `step_id` varchar(50) DEFAULT NULL,
	//  `category_id` varchar(50) DEFAULT NULL,
	//  `base_price` varchar(50) DEFAULT NULL,
	//  `status` int(11) DEFAULT NULL,
	//  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	//  `modified_on` datetime DEFAULT NULL,
	//  PRIMARY KEY (`item_id`)
	// ) $charset_collate;";


	//   dbDelta( $sql4 );


    $sql5 = "CREATE TABLE IF NOT EXISTS `product` (
	 `product_id` int(11) NOT NULL AUTO_INCREMENT,
	 `product_name` varchar(100) DEFAULT NULL,
	 `product_description` varchar(500) DEFAULT NULL,
	 `yearly_min_fees` varchar(100) DEFAULT NULL,
	 `base_price` varchar(50) DEFAULT NULL,
	 `product_image` varchar(500) DEFAULT NULL,
	 `steps_json` longtext,
	 `status` int(11) DEFAULT NULL,
	 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`product_id`)
	) $charset_collate;";


  	dbDelta( $sql5 );


    $sql6 = "CREATE TABLE IF NOT EXISTS `product_category` (
	 `pcategory_id` int(11) NOT NULL AUTO_INCREMENT,
	 `product_id` int(11) DEFAULT NULL,
	 `pstep_id` int(11) DEFAULT NULL,
	 `category_id` int(11) DEFAULT NULL,
	 `status` int(11) DEFAULT NULL,
	 `created_on` datetime DEFAULT NULL,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`pcategory_id`)
	) $charset_collate;";


  	dbDelta( $sql6 );

    $sql7 = "CREATE TABLE IF NOT EXISTS `product_items` (
	 `pitem_id` int(11) NOT NULL AUTO_INCREMENT,
	 `product_id` int(11) DEFAULT NULL,
	 `pcategory_id` int(11) DEFAULT NULL,
	 `item_name` varchar(250) DEFAULT NULL,
	 `item_description` varchar(250) DEFAULT NULL,
	 `max_qty` varchar(50) DEFAULT NULL,
	 `item_price` varchar(100) DEFAULT NULL,
	 `max_item_price` varchar(100) DEFAULT NULL,
	 `yearly_price` varchar(50) DEFAULT NULL,
	 `item_img` varchar(500) DEFAULT NULL,
	 `default_selected` varchar(50) DEFAULT NULL,
	 `status` int(11) DEFAULT NULL,
	 `created_on` datetime DEFAULT NULL,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`pitem_id`)
	) $charset_collate;";


  	dbDelta( $sql7 );

	//         $sql8 = "CREATE TABLE `product_quantity` (
	//  `pquantity_id` int(11) NOT NULL AUTO_INCREMENT,
	//  `product_id` int(11) DEFAULT NULL,
	//  `pitem_id` int(11) DEFAULT NULL,
	//  `quantity` varchar(100) DEFAULT NULL,
	//  `quantity_price` varchar(100) DEFAULT NULL,
	//  `status` int(11) DEFAULT NULL,
	//  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	//  `modified_on` datetime DEFAULT NULL,
	//  PRIMARY KEY (`pquantity_id`)
	// ) $charset_collate;";


	//   dbDelta( $sql8 );

    $sql9 = "CREATE TABLE IF NOT EXISTS `product_steps` (
	 `pstep_id` int(11) NOT NULL AUTO_INCREMENT,
	 `product_id` int(11) DEFAULT NULL,
	 `step_id` int(11) DEFAULT NULL,
	 `quantity_type` varchar(100) DEFAULT NULL,
	 `status` int(11) DEFAULT NULL,
	 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`pstep_id`)
	) $charset_collate;";


  	dbDelta( $sql9 );

    $sql10 = "CREATE TABLE IF NOT EXISTS `step` (
	 `step_id` int(11) NOT NULL AUTO_INCREMENT,
	 `step_name` varchar(100) DEFAULT NULL,
	 `step_description` varchar(500) DEFAULT NULL,
	 `steps_order` int(11) DEFAULT NULL,
	 `system_type` varchar(50) DEFAULT NULL,
	 `quantity_type` varchar(50) DEFAULT NULL,
	 `item_type` varchar(50) DEFAULT NULL,
	 `tooltip_content` varchar(500) DEFAULT NULL,
	 `itm_rvoption` varchar(50) DEFAULT NULL,
	 `status` int(11) DEFAULT NULL,
	 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 `modified_on` datetime DEFAULT NULL,
	 PRIMARY KEY (`step_id`)
	) $charset_collate;";


  	dbDelta( $sql10 );


$uploads_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'pos';
wp_mkdir_p( $uploads_dir );



}

register_deactivation_hook( __FILE__, 'myplugin_deactivate' );
function myplugin_deactivate() {


}


add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );
function wpdocs_register_my_custom_menu_page() {

	add_menu_page('POS System', 'POS System', 'manage_options', 'pos_page', 'pos_page','dashicons-networking',200);


	//add_menu_page( string $page_title, string $menu_title, string $capability,string $menu_slug, callable $function = '', string $icon_url = '',int $position = null )
 
 	// Admin main menu
	add_submenu_page('pos_page', 'Steps', 'Steps', 'manage_options', 'steps_page', 'steps_page'); 

	add_submenu_page('pos_page', 'Category', 'Category', 'manage_options', 'category_page', 'category_page'); 

	// add_submenu_page('pos_page', 'Items', 'Items', 'manage_options', 'item_page', 'item_page'); 
	add_submenu_page('pos_page', 'Products', 'Products', 'manage_options', 'product_page', 'product_page'); 

	add_submenu_page(null,'POS System' , 'POS System', 'manage_options', 'addproduct_page', 'addproduct_page');


	add_submenu_page('pos_page', 'POS Mail List', 'POS Mail List', 'manage_options', 'mail_list', 'mail_list'); 
	add_submenu_page('pos_page', 'Settings', 'Settings', 'manage_options', 'settings', 'settings'); 

	//add_submenu_page( string $parent_slug, string $page_title, string $menu_title,string $capability, string $menu_slug, callable $function = '' )
	 
	// Add sub menu
	 //add_submenu_page(null,'POS System' , 'POS System', 'manage_options', 'additem_page', 'additem_page'); // Add page without adding main menu


	remove_submenu_page( 'pos_page', 'pos_page' ); // remove sub menu


}

add_action( 'init', 'pos_includefiles' );

function pos_includefiles() {


	wp_register_style ( 'bootstrap_css', plugins_url ( 'bootstrap/css/bootstrap.css', __FILE__ ) );
	wp_register_script ( 'bootstrap_js', plugins_url ( 'bootstrap/js/bootstrap.js', __FILE__ ) );
	wp_register_style ( 'font_awesome', plugins_url ( 'font-awesome/css/font-awesome.css', __FILE__ ) );
	wp_register_style ( 'admin_style', plugins_url ( 'css/admin_style.css', __FILE__ ) );

	wp_register_style ( 'frontend_style', plugins_url ( 'css/style.css', __FILE__ ) );

	wp_register_script('datatable_js', plugins_url ( 'datatable/jquery.dataTables.min.js', __FILE__ ));

}


if ( ! function_exists( 'steps_page' ) ) {
	function steps_page()
	{
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_style('admin_style');
		wp_enqueue_script('datatable_js');
		if(file_exists(POSSYSTEM_DIR.'steps.php')){

			include_once(POSSYSTEM_DIR.'steps.php');

		}
	}
}
if ( ! function_exists( 'category_page' ) ) {
	function category_page()
	{
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_style('admin_style');
		wp_enqueue_script('datatable_js');
		if(file_exists(POSSYSTEM_DIR.'category.php')){

			include_once(POSSYSTEM_DIR.'category.php');

		}
	}
}
if ( ! function_exists( 'item_page' ) ) {
	function item_page()
	{
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_style('admin_style');
		wp_enqueue_script('datatable_js');
		if(file_exists(POSSYSTEM_DIR.'item.php')){

			include_once(POSSYSTEM_DIR.'item.php');

		}
	}
}
if ( ! function_exists( 'product_page' ) ) {
	function product_page()
	{
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_style('admin_style');
		wp_enqueue_script('datatable_js');
		if(file_exists(POSSYSTEM_DIR.'product.php')){

			include_once(POSSYSTEM_DIR.'product.php');

		}
	}
}
if ( ! function_exists( 'addproduct_page' ) ) {
	function addproduct_page()
	{
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_style('admin_style');
		wp_enqueue_script('datatable_js');
		if(file_exists(POSSYSTEM_DIR.'addproduct.php')){

			include_once(POSSYSTEM_DIR.'addproduct.php');

		}
	}
}

if ( ! function_exists( 'mail_list' ) ) {
	function mail_list()
	{
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_style('admin_style');
		//wp_enqueue_script('datatable_js');
		if(file_exists(POSSYSTEM_DIR.'mail_list.php')){

			include_once(POSSYSTEM_DIR.'mail_list.php');

		}
	}
}

if ( ! function_exists( 'settings' ) ) {
	function settings()
	{
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('bootstrap_css');
		wp_enqueue_style('admin_style');
		wp_enqueue_script('datatable_js');
		if(file_exists(POSSYSTEM_DIR.'settings.php')){

			include_once(POSSYSTEM_DIR.'settings.php');

		}
	}
}


function add_stepsdiv(){
    global $wpdb;
    $response = array();
     $select_result = $wpdb->get_results( "SELECT * FROM category" );
	$select_step_id = $_REQUEST['select_step_id'];
	$select_category = $_REQUEST['select_category'];
	//$view_type = $_REQUEST['view_type'];
	//$pos_type = $_REQUEST['pos_type'];
	//$quantity_type = $_REQUEST['quantity_type'];
	$select_step_txt = $_REQUEST['select_step_txt'];
	$steps_count = $_REQUEST['steps_count'];
	$category_count = 0;
	//$item_count = 0;

	$stepres = $wpdb->get_row( "SELECT * FROM step where step_id ='".$select_step_id."'" );

	if($stepres)
	{
		$item_type = $stepres->item_type;
	}
	else
	{
		$item_type = 'normal_item';
	}

	$total_cat_count = sizeof($select_category);

	//echo "<pre>";print_r($select_category);echo "</pre>";
	$stepsdiv = "<div class='col-md-12 steps_div'>

	<div class='col-md-12 steps_title'>
		<div class='col-md-6'>
		<button class='btn btn-sm btn-outline-danger btn_remove btn_removestep'> <i class='fa fa-times'></i></button>
		<span style='text-decorat'><b>Step: </b>".$select_step_txt."</span>
		</div>
		<div class='col-md-6' style='text-align:right;'>
		
			<select class='form-control category_list' >";
			if($select_result)
			{
				foreach($select_result as $cat)
				{
					$stepsdiv .= "<option value='".$cat->category_id."'>".$cat->category_name."</option>";
				}
			}
			$stepsdiv .= "</select>
		<button type='button' class='btn btn-sm btn-outline-success  btn_addcategory'> <i class='fa fa-plus'></i> Add category</button>
		</div>
	</div>";
	$stepsdiv .= '<input type="hidden" name="steps_details['.$steps_count.'][stl_step_id]" class="stl_step_id" value="'.$select_step_id.'">



      <input type="hidden" name="category_count" class="category_count" value="'.$total_cat_count.'">
      <input type="hidden" name="this_steps_count" class="this_steps_count" value="'.$steps_count.'">

      <div class="col-md-12 categorys_div">';

	if($select_step_id !='' && $select_category !='')
	{
		//$select_categorys = explode(',', $select_category);
		//echo "<pre>";print_r($select_categorys);echo "</pre>";
		foreach($select_category as $category_id)
		{
			//$nxt_cat_count = $category_count+1;
			$category_name = '';
			$category_result = $wpdb->get_row( "SELECT * FROM category where category_id = '".$category_id."'" );
			if($category_result)
			{
				$category_name = $category_result->category_name;
			}

			$stepsdiv .='<div class="col-md-12 category_div">
							
							<input type="hidden" name="this_category_count" class="this_category_count" value="'.$category_count.'">

							<input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][stl_category_id]" class="stl_category_id" value="'.$category_id.'">
							<input type="hidden" class="item_count" value="1">
					       
					      <div class="col-md-12 category_title">
					        <button class="btn btn-sm btn-outline-danger btn_remove btn_removecategory"> <i class="fa fa-times"></i></button>  
					        <span><b>Category: </b> '.$category_name.'</span>
					        <button type="button" class="btn btn-outline-info btn-sm btn_additem"><i class="fa fa-plus-circle btn_additem"></i> Add Item</button>

					      </div>';
			$stepsdiv .= single_itemdiv($category_id,$item_type,$steps_count,$category_count,0);
			$stepsdiv .= '</div><div style="clear:both"></div><hr>';
			$category_count++;
		}

		//$stepsdiv = 'dd';
	$response_status = 1;	
	}
	else
	{
		$response_status = 0;	
	}
	$stepsdiv .='</div></div>';
	$response = array('status' => $response_status,'message' => $stepsdiv);
	echo json_encode($response);
	exit();
}
add_action( 'wp_ajax_add_stepsdiv', 'add_stepsdiv' );
add_action( 'wp_ajax_nopriv_add_stepsdiv', 'add_stepsdiv' );


function add_categorydiv(){
    global $wpdb;
    $response = array();
    $stepsdiv = '';
	$select_step_id = $_REQUEST['select_step_id'];
	$category_id = $_REQUEST['category_id'];
	//$view_type = $_REQUEST['view_type'];
	//$pos_type = $_REQUEST['pos_type'];
	//$quantity_type = $_REQUEST['quantity_type'];
	$category_count = $_REQUEST['category_count'];
	$steps_count  = $_REQUEST['steps_count'];
	//$item_count = $_REQUEST['item_count'];

	$stepres = $wpdb->get_row( "SELECT * FROM step where step_id ='".$select_step_id."'" );

	if($stepres){$item_type = $stepres->item_type;}
	else{$item_type = 'normal_item';}



	if($category_id !='')
	{

		$category_name = '';
			$category_result = $wpdb->get_row( "SELECT * FROM category where category_id = '".$category_id."'" );
			if($category_result)
			{
				$category_name = $category_result->category_name;
			}

			$stepsdiv .='<div class="col-md-12 category_div">

			<input type="hidden" name="this_category_count" class="this_category_count" value="'.$category_count.'">

							<input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][stl_category_id]" class="stl_category_id" value="'.$category_id.'">

							<input type="hidden" class="item_count" value="1">
					       
					      <div class="col-md-12 category_title">
					        <button class="btn btn-sm btn-outline-danger btn_remove btn_removecategory"> <i class="fa fa-times"></i></button>  
					        <span><b>Category: </b> '.$category_name.'</span>
					        <button type="button" class="btn btn-outline-info btn-sm btn_additem"><i class="fa fa-plus-circle btn_additem"></i> Add Item</button>

					      </div>';

		$stepsdiv .= single_itemdiv($category_id,$item_type,$steps_count,$category_count,0);

		$stepsdiv .= '</div><div style="clear:both"></div><hr>';

		$response_status = 1;	
	}
	else
	{
		$response_status = 0;	
	}
	$response = array('status' => $response_status,'message' => $stepsdiv);
	echo json_encode($response);
	exit();


}
add_action( 'wp_ajax_add_categorydiv', 'add_categorydiv' );
add_action( 'wp_ajax_nopriv_add_categorydiv', 'add_categorydiv' );



function add_itemsdiv(){
    global $wpdb;
    $response = array();
    $stepsdiv = '';
	$select_step_id = $_REQUEST['select_step_id'];
	$category_id = $_REQUEST['category_id'];
	//$view_type = $_REQUEST['view_type'];
	//$pos_type = $_REQUEST['pos_type'];
	//$quantity_type = $_REQUEST['quantity_type'];
	$category_count = $_REQUEST['category_count'];
	$steps_count  = $_REQUEST['steps_count'];
	$item_count  = $_REQUEST['item_count'];


	$stepres = $wpdb->get_row( "SELECT * FROM step where step_id ='".$select_step_id."'" );

	if($stepres){$item_type = $stepres->item_type;}
	else{$item_type = 'normal_item';}



	if($category_id !='' && $item_type !='')
	{
		$stepsdiv .= single_itemdiv($category_id,$item_type,$steps_count,$category_count,$item_count);
		$response_status = 1;	
	}
	else
	{
		$response_status = 0;	
	}
	$response = array('status' => $response_status,'message' => $stepsdiv);
	echo json_encode($response);
	exit();
}
add_action( 'wp_ajax_add_itemsdiv', 'add_itemsdiv' );
add_action( 'wp_ajax_nopriv_add_itemsdiv', 'add_itemsdiv' );




function single_itemdiv($category_id = '',$quantity_type = 'normal_item',$steps_count = 0,$category_count = 0,$item_count = 0){

$stepsdiv = '';
	$stepsdiv .= '  
      
      <div class="col-md-12 items_div">
        
        	<div class="col-md-1 btn_removeitemdiv">
        	<button class="btn btn-sm btn-outline-danger btn_remove btn_removeitem"> <i class="fa fa-times"></i></button>
        	</div>
          <div class="col-md-2">
            <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_name]" class="form-control" placeholder="item name">
          </div>
          <div class="col-md-2">
            <input type="file" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_image]" class="form-control item_image" >
            <input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_img]" class="form-control item_img" value="/wp-content/plugins/pos/images/noimage.png">

            <img class="preview_itemimg" src="'.site_url().'/wp-content/plugins/pos/images/noimage.png" width="100" alt="your image" />
          </div>
          <div class="col-md-2">
            <textarea name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_description]" class="form-control" placeholder="item desciption"></textarea>
          </div>
          ';
         
          if($quantity_type == 'normal_item') { 
          	$stepsdiv .= ' <div class="col-md-4 quantity_div">
          	<div class="col-md-6">
          	<input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_qty]" class="form-control" placeholder="Max Quantity" value="">
          	<span class="small text-warning">(Leave blank if product quantity is unlimited)</span>
          	</div>
          	<div class="col-md-6">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_price]" class="form-control" placeholder="Item fees">
              </div>
              <input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_item_price]" class="form-control" Placeholder="Max Subscription Fees" value="0">
              <input type="hidden" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][yearly_price]" class="form-control"  value="0">

              

            </div>';
           } else { 
           $stepsdiv .= '
            <div class="col-md-4 quantity_div">
           		<div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_qty]" class="form-control" placeholder="Max Quantity" value="">
              <span class="small text-warning">(Leave blank if product quantity is unlimited)</span>
              </div>
              <div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][item_price]" class="form-control" Placeholder="Subscription Fees">
              </div>
              <div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][max_item_price]" class="form-control" Placeholder="Max Subscription Fees">
           	  </div>
           	 <div class="col-md-3">
              <input type="text" name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][yearly_price]" class="form-control" Placeholder="Yearly Fees" >
              </div>
            </div>';
           } 
        $stepsdiv .= '
        <div class="col-md-1">
        	<select name="steps_details['.$steps_count.'][category_details]['.$category_count.'][item_details]['.$item_count.'][default_selected]" class="form-control">
        		<option value="no">No</option>
        		<option value="yes">Yes</option>
        	</select>
        	<span class="small text-warning">(Frontend default item selected)</span>
        </div>
     </div>
    ';

    return $stepsdiv;


}

function savestepform(){
	//echo "<pre>";print_r($_POST);echo "</pre>";
	//echo "<pre>";print_r($_FILES);echo "</pre>";
	//exit;
	global $wpdb;
	$product_table = 'product';
	$steps_table = 'product_steps';
	$cat_table = 'product_category';
	$item_table = 'product_items';
	//$qty_table = 'product_quantity';

	$product_id = $_POST['product_id'];
	$form_action = $_POST['form_action'];
	$steps_count = $_POST['steps_count'];
	$product_name = $_POST['product_name'];
	$yearly_min_fees = $_POST['yearly_min_fees'];
	//$base_price = $_POST['base_price'];
	$product_description = $_POST['product_description'];
	$steps_details = $_POST['steps_details'];

	$steps_json=serialize($steps_details);

	$product_data = array('product_name' => $product_name, 'product_description' => $product_description,'yearly_min_fees' => $yearly_min_fees,'steps_json' => $steps_json,'status' => 1);
	if($product_id == '')
	{
		$product_data['created_on'] = date('Y-m-d H:i:s');
		$wpdb->insert( $product_table, $product_data); 
		$product_id = $wpdb->insert_id;
	}
	else
	{
		$product_data['modified_on'] = date('Y-m-d H:i:s');
		$product_where = array('product_id' => $product_id);
		$wpdb->update( $product_table, $product_data, $product_where);
	}


	if(!empty($steps_details)){
		
		$delete_where = array('product_id' => $product_id);
		$wpdb->delete( $steps_table, $delete_where);
		$wpdb->delete( $cat_table, $delete_where);
		$wpdb->delete( $item_table, $delete_where);
		//$wpdb->delete( $qty_table, $delete_where);

		foreach ($steps_details as $steps_detail) {
			$stl_step_id = $steps_detail['stl_step_id'];
			$quantity_type = $steps_detail['quantity_type'];
			//$stl_view_type = $steps_detail['stl_view_type'];
			//$stl_item_types = $steps_detail['stl_item_types'];
			//$stl_quantity_type = $steps_detail['stl_quantity_type'];
			$category_details = $steps_detail['category_details'];

			if($stl_step_id !=''){
				$steps_data = array('product_id' => $product_id, 'step_id' => $stl_step_id,'quantity_type' => $quantity_type,'status' => 1,'created_on' => date('Y-m-d H:i:s') );
				$wpdb->insert( $steps_table, $steps_data);
				$pstep_id = $wpdb->insert_id;
	 

				if(!empty($category_details)){
					foreach($category_details as $category_detail)
					{
						$stl_category_id = $category_detail['stl_category_id'];
						$item_details = $category_detail['item_details'];

						if($stl_category_id !=''){
							$category_data = array('product_id' => $product_id,'pstep_id' => $pstep_id, 'category_id' => $stl_category_id,'status' => 1, 'created_on' => date('Y-m-d H:i:s'));
							$wpdb->insert( $cat_table, $category_data);
							$pcategory_id = $wpdb->insert_id;

							if(!empty($item_details)){
								foreach($item_details as $item_detail)
								{
									$item_name = $item_detail['item_name'];
									$item_description = $item_detail['item_description'];
									//$quantity_details = $item_detail['quantity_details'];
									$max_qty = $item_detail['max_qty'];
									$item_price = $item_detail['item_price'];
									$max_item_price = $item_detail['max_item_price'];
									$yearly_price = $item_detail['yearly_price'];
									$item_img = $item_detail['item_img'];
									$default_selected = $item_detail['default_selected'];
									
									if($item_name !='') {
										$item_data = array('product_id' => $product_id,'pcategory_id' => $pcategory_id, 'item_name' => $item_name, 'item_description' => $item_description,'max_qty' => $max_qty,'item_price' => $item_price,'max_item_price' => $max_item_price,'yearly_price' => $yearly_price, 'item_img' => $item_img, 'default_selected' => $default_selected, 'status' => 1, 'created_on' => date('Y-m-d H:i:s') );
										$wpdb->insert( $item_table, $item_data);
										$pitem_id = $wpdb->insert_id;
									}
								}
							}
						}
					}
				}
			}
		}
		$response_status = 1;
		$message = 'Product save successfully';
	}
	else
	{
		$response_status = 0;
		$message = 'No steps are added';
	}
	$response = array('status' => $response_status,'message' => $message);
	echo json_encode($response);
	exit();

}
add_action( 'wp_ajax_savestepform', 'savestepform' );
add_action( 'wp_ajax_nopriv_savestepform', 'savestepform' );

function uploadimage(){
	$save_name = '';
$status = 0;
$filetype = array('jpeg','jpg','png','gif','PNG','JPEG','JPG');
//echo "<pre>";print_r($_FILES);echo "</pre>";
$projID = $_POST['product_id'];


if($projID =='')
{
$projID = 'product';
}
	$folderPath = "/wp-content/uploads/pos/{$projID}";


mkdir(ABSPATH.$folderPath, 0755, true);

$milliseconds = round(microtime(true) * 1000);

$filename = basename($_FILES['file']['name']);
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if(in_array(strtolower($ext), $filetype))
          {
          	if($_FILES['file']['name']<1000000)
            {


$upload_name = $milliseconds.'.'.$ext;
$filetype = $_FILES['file']['type'];
$datei = "files/standard/{$projID}/{$upload_name}";
$target_path = ABSPATH.$folderPath . "/" . $upload_name;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
$save_name = $folderPath . "/" . $upload_name;
$status = 1;
$message = "Success";
}
else
{
	$status = 0;
	$message = "Error in file move";
}
}
else
{
	$status = 0;
	$message = "Error in file size";
}
}
else
{
	$status = 0;
	$message = "File type not allowed";
}

echo json_encode(array('status' => $status,'message' => $message, 'image_name' => $save_name));
exit;
}



add_action( 'wp_ajax_uploadimage', 'uploadimage' );
add_action( 'wp_ajax_nopriv_uploadimage', 'uploadimage' );


function pos_product_frontview() {
   	wp_enqueue_style('font_awesome');
	wp_enqueue_style('bootstrap_css');
	wp_enqueue_style('frontend_style');
	wp_enqueue_script('bootstrap_js');

	if(file_exists(POSSYSTEM_DIR.'productview.php')){

		include_once(POSSYSTEM_DIR.'productview.php');

	}



}
add_shortcode('POS_PRODUCTS', 'pos_product_frontview');


function show_steps(){
	global $wpdb;
	$item_div = '';
	$step_id = 0;
	$item_div .= '<div class="col-md-12 stl_cutqust qust1">';
	$product_id = $_POST['product_id'];
	$step_count = $_POST['step_count'];
	$total_step_count = $_POST['total_step_count'];

	//$selected_array = $_POST['selected_array'];

	//echo $selected_array;


	$selected_sarr = json_decode(stripslashes($_POST['selected_array']),true);
	//echo "<pre>";print_r($selected_sarr);echo "</pre>";


	$last_stepres = $wpdb->get_row("SELECT * FROM `step` where status='1' order by steps_order desc limit 1");

	$last_step_id = $last_stepres->step_id;

	$first_stepres = $wpdb->get_row("SELECT * FROM `step` where status='1' order by steps_order asc limit 1");

	$first_step_id = $first_stepres->step_id;


	$steps_results = $wpdb->get_row("select * from step where status='1' order by steps_order asc limit ".$step_count.",1");
	//echo $wpdb->last_query;
	$step_count = $step_count+1;
	if($steps_results)
	{
		
		$step_id = $steps_results->step_id;
		$step_description = $steps_results->step_description;
		$system_type = $steps_results->system_type;
		$quantity_type = $steps_results->quantity_type;
		$item_type = $steps_results->item_type;
		$tooltip_content = $steps_results->tooltip_content;

		$itm_rvoption = $steps_results->itm_rvoption;





		$arr_key = 'stepid_'.$step_id;
		$selected_step = $selected_sarr[$arr_key];
		//echo "<pre>";print_r($selected_step);echo "</pre>";
		//echo "==================================";

		$item_div .= '
		<input type="hidden" class="step_id" value="'.$step_id.'">
		<input type="hidden" class="step_count" value="'.$step_count.'">
		<input type="hidden" class="system_type" value="'.$system_type.'">
		
		<input type="hidden" class="item_type" value="'.$item_type.'">
		<input type="hidden" class="itm_rvoption" value="'.$itm_rvoption.'">

		<div class="col-md-7 stl_qusthead">
						<div class="row title">
							<span>'.$step_description.'</span>
							<span class="stl_tooltip">
								<i aria-hidden="true" class="fa fa-info-circle"></i> 
								<span class="stl_tip stl_hint">
								'.$tooltip_content.'
								</span>
							</span>
						</div>
					</div>';	
		$psteps_result = $wpdb->get_row("select * from product_steps where step_id = '".$step_id."' and product_id = '".$product_id ."'");

		if($psteps_result)
		{
			$quantity_type = $psteps_result->quantity_type;


			$item_div .= '<input type="hidden" class="quantity_type" value="'.$quantity_type.'">';
			$pstep_id = $psteps_result->pstep_id;
			$pcat_results = $wpdb->get_results("select * from product_category where pstep_id = '".$pstep_id."'");

			//echo "<pre>";print_r($pcat_results);echo "</pre>";
			$pcatitem_count = 0;
			$pc_inicount = 0;
			if($pcat_results)
			{
				$pcat_count = sizeof($pcat_results);
				if($pcat_count > 1) {
					$item_div .= '<div class="col-md-5" style="text-align: right;">
							<ul class="list-of-categories">';
							$ppcat = 0;
					foreach($pcat_results as $pcat_result)
					{
						$ppcat++;
						//if($ppcat == 1){$selected='selected';}else{$selected='';}
						$category_id = $pcat_result->category_id;
						$cat_results = $wpdb->get_row("select * from category where category_id = '".$category_id."'");
						$category_name = $cat_results->category_name;

						//$catcls = 'catid_'.$category_id;
						
								$item_div .='<li class="category " data-catid="'.$category_id.'">
									<a href="javascript:;">'.$category_name.'</a>
								</li>';
							
					}
					$item_div .='</ul>
						</div>';
				}

				$item_div .= '<div style="clear:both;"></div><div class="col-md-12">
							<ul class="row list-of-entities">';
				foreach($pcat_results as $pcat_result)
				{
					$category_id = $pcat_result->category_id;
					$pcategory_id = $pcat_result->pcategory_id;
					$pitem_results = $wpdb->get_results("select * from product_items where pcategory_id = '".$pcategory_id."'");
					//echo $wpdb->last_query;
					//echo "<pre>";print_r($pitem_results);echo "</pre>";
					if($pitem_results)
					{
						$pc = 0;

						$pcount = sizeof($pitem_results);

						$pcatitem_count = $pcatitem_count+$pcount;

						if($pcount == 1 && $pcat_count < 2){$pclass = 'col-md-4  col-sm-10 col-xs-10'; $item_div .='<div class="col-md-4  col-sm-1 col-xs-1"></div>'; }
						else if($pcount == 2  && $pcat_count < 2){$pclass = 'col-md-4 col-sm-6 col-xs-6'; $item_div .='<div class="col-md-2 col-sm-12 col-xs-12"></div>'; }
						else if($pcount == 3  && $pcat_count < 2){$pclass = 'col-md-4';}
						else{$pclass = 'col-md-3  col-sm-3 col-xs-6';}

						foreach($pitem_results as $pitem_result)
						{
							$pc++;
							$pc_inicount++;
							
							$pitem_id = $pitem_result->pitem_id;
							$item_name = $pitem_result->item_name;
							$item_description = $pitem_result->item_description;
							$max_qty = $pitem_result->max_qty;
							$item_price = $pitem_result->item_price;
							$max_item_price	= $pitem_result->max_item_price;
							$yearly_price = $pitem_result->yearly_price;
							$item_img = $pitem_result->item_img;
							$default_selected = $pitem_result->default_selected;

							$selected_quantity = 0;

							$show_closebtn = "display:none;";

							//echo "<pre>";print_r($selected_step);echo "</pre>";
							if(!empty($selected_step))
							{
								//echo "ifffffffff";
								$selected_items = $selected_step['items_'.$pitem_id];
								if($selected_items !='')
								{
									$selected_pitem_id = $selected_items['pitem_id'];
									$selected_pitem_price = $selected_items['pitem_price'];
									$selected_quantity = $selected_items['quantity'];

									$pcls = 'fa fa-check-circle';
									$pcls1='selected';

									if($itm_rvoption != 'no'){
										$show_closebtn = "display:inline;";
									}
									

								}
								// else if($pc == '1' && $step_count == '1' && $item_type == 'subscription_item'){$pcls = 'fa fa-check-circle';$pcls1='selected';}
								 else{$pcls = 'fa fa-circle-thin';$pcls1='';}
							}

							else if($default_selected == 'yes'){$pcls = 'fa fa-check-circle';$pcls1='selected';}
							else{$pcls = 'fa fa-circle-thin';$pcls1='';}






							if($pc_inicount <= 4) {
									$li_class = 'currentli';
								}
								else
								{
									$li_class =  'noncurrentli';
								}

								$catcls = 'catid_'.$category_id;

							$item_div .='<li class="'.$pclass.' '.$pcls1.' '.$li_class. ' '.$catcls.' item steps_item itemid_'.$pitem_id.'">
							<input type="hidden" class="pitem_id" value="'.$pitem_id.'">
							<input type="hidden" class="pitem_price" value="'.$item_price.'">
							<input type="hidden" class="pitem_name" value="'.$item_name.'">
							<input type="hidden" class="max_qty" value="'.$max_qty.'">
							<input type="hidden" class="max_item_price" value="'.$max_item_price.'">
							<input type="hidden" class="yearly_price" value="'.$yearly_price.'">

								<div class="item-link">';
								if($max_qty == '' || $max_qty > 1){
									$item_div .='<span class="tag">'.$selected_quantity.'</span>';
								}

								
									$item_div .='<div class="check">
										<span class="'.$pcls.'"></span>';
										if($quantity_type =='checkbox') {
										$item_div .='<a href="javascript:;" class="remove-item stlclose_blue" style="'.$show_closebtn.'"><i class="fa fa-close"></i></a> ';	
										}	
									$item_div .='</div>
									';
								
									if($item_img !='' && $item_img !='/wp-content/plugins/pos/images/noimage.png')
									{

										$item_div .='<div class="item-image imga"><img src="'.site_url().$item_img.'" alt=""></div><div class="item-body">
										<h3><?php echo $product_result->'.$item_name.'</h3>
										<p class="stl_hint">'.$item_description.'</p>
											</div>';
									}
									else
									{
										$item_div .='<div class="item-image"><h3><?php echo $product_result->'.$item_name.'</h3></div><div class="item-body">
										
										<p class="stl_hint">'.$item_description.'</p>
											</div>';
									}
									if($item_type == 'normal_item') {
										//echo "iffffff";
										
										// else
										// {
											$item_div .= '<div class="col-md-12 addtocbtn">
													<div class="row ">
														<a href="javascript:;" class="button  btn_blue">
															<span><i class="fa fa-plus-circle"></i> voeg toe</span>
														</a>

													</div>
												</div>';
										// }
									}
									else
									{
										if($max_qty > 1)
										{
											$item_div .= '<div class="col-md-12 addtocbtn">
												<div class="row">
													<a href="javascript:;" class="button stl_dbutton"><span>Voeg toe</span></a>
													<a href="javascript:;" class="button stlclose stlclose" style="'.$show_closebtn.'"><span class="fa fa-close"></span></a>
												</div>
											</div>';
										}
									}

									$item_div .= '
									
												
								</div>
							</li>
							';
						}
					}
				}
				$item_div .= '</ul>
						</div>';
						if($pcatitem_count > 4) {
							$pcatitem_divt = $pcatitem_count / 4;
							$pcatitemsss = ceil($pcatitem_divt);
						$item_div .= '<div class="col-md-12 itemprenxt" style=margin-bottom:15px;">
						<input type="hidden" class="item_pre" value="0">
						<input type="hidden" class="item_nxt" value="1">
						<input type="hidden" class="item_totall" value="'.$pcatitemsss.'">
						<button class="button btn_itempre paging"><span class="icon"><i class="fa fa-angle-left"></i></span></button>
										<span class="pntxt">1 / '.$pcatitemsss.'</span>
										<button class="button btn_itemnxt paging"><span class="icon"><i class="fa fa-angle-right"></i></span></button></div>
										';
									}
			}
		}
		else
		{
			$item_div .= "no product found";
		}
	}
	else
	{

	}

	if($last_step_id == $step_id)
	{
		$button_class="btn_complete";
	}
	else
	{
		$button_class="btn_nxt";
	}

	if($first_step_id == $step_id)
	{
		$pbtn_cls = "btn_pproduct";
	}
	else
	{
		$pbtn_cls = 'btn_previous';
	}
	$item_div .='</div><div class="col-md-12  col-sm-12 col-xs-12 questions-control">
						<div class="col-md-6  col-sm-6 col-xs-6">
							<button type="button" class="button is-large hollow '.$pbtn_cls.'"><span>Vorige</span></button> 
						</div>
						<div class="col-md-6  col-sm-6 col-xs-6" style="text-align: right;">
							<button type="button" class="button is-large '.$button_class.'"><span>Volgende</span>
							</button>
						</div>
					</div>';

	//echo $item_div;
	echo json_encode(array('item_content' => $item_div,'step_id' => $step_id,'status' => '1'));
	exit;
}
add_action( 'wp_ajax_show_steps', 'show_steps' );
add_action( 'wp_ajax_nopriv_show_steps', 'show_steps' );


function generate_pdf(){
	//echo "<pre>";print_r($_POST);echo "</pre>";
global $wpdb;

error_reporting(E_ALL); 
ini_set("display_errors", 1);




	$your_name = $_POST['your_name'];
	$your_email = $_POST['your_email'];
	$your_phoneno = $_POST['your_phoneno'];
	$your_message = $_POST['your_message'];
	$selected_array = $_POST['selected_array'];
	$sproduct_id = $_POST['sproduct_id'];
	$sproduct_name = $_POST['sproduct_name'];
	$yearly_min_fees = $_POST['yearly_min_fees'];



	$selected_sarr = json_decode(stripslashes($_POST['selected_array']),true);

	$sub_total = $total_year_fee = 0;
	$other_total = 0;
	$sub_tr = '';
	$other_tr = '';


	//echo "<pre>";print_r($selected_sarr);echo "</pre>";

	foreach($selected_sarr as $step_key => $step_val)
	{
		if(!empty($step_val))
		{
			foreach ($step_val as $item_key => $item_val) {
				$pitem_id = $item_val['pitem_id'];
				$pitem_price = $item_val['pitem_price'];
				$pitem_price_original = $item_val['pitem_price_original'];
				$quantity = $item_val['quantity'];
				$itemtype = $item_val['itemtype'];
				$stepname = $item_val['stepname'];
				$pitem_name = $item_val['pitem_name'];
				$stl_yearly_price = $item_val['stl_yearly_price'];
				$stl_system_type = $item_val['stl_system_type'];
				$stl_max_qty = $item_val['stl_max_qty'];

				$pitem_price = (float)$pitem_price;
				$pitem_price_original = (float)$pitem_price_original;

				$pitem_price_original_ss = number_format($pitem_price_original,2,",","");
				$pitem_price_ss = number_format($pitem_price,2,",","");


				$qtyss = (int)$quantity;
				if($stl_system_type == 'pos_system' && $stl_max_qty > 1)
				{
					$qtyss = (int)$quantity - 1;
				}


				if($itemtype == 'subscription_item')
				{
					$sub_tr .= '<tr><td style="text-align:left;">'.$pitem_name.'</td><td>'.$quantity.'</td><td>€ '.$pitem_price_original_ss.'</td><td>€ '.$pitem_price_ss.'</td></tr>';

					$sub_total += (float)$pitem_price;
					//$ssquantity = (int)$quantity;

					$total_year_fee += (int)$qtyss * (float)$stl_yearly_price;
				}

				else
				{
					if($itemtype == 'furnishing_service_item'){$pitem_name = 'Inrichtingsservice ('.$pitem_name.')';}
					else if($itemtype == 'installing_service_item'){$pitem_name = 'Installatieservice ('.$pitem_name.')'; }
					else {$pitem_name = $pitem_name; }
						

					$other_tr .= '<tr><td style="text-align:left;">'.$pitem_name.'</td><td>'.$quantity.'</td><td>€ '.$pitem_price_original_ss.'</td><td>€ '.$pitem_price_ss.'</td></tr>';

					$other_total += (float)$pitem_price;
				}

			}
		}
	}

if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
//check ip from share internet
$client_ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
//to check ip is pass from proxy
$client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
$client_ip = $_SERVER['REMOTE_ADDR'];
}

$wpdb->insert( 
	'customer_mail', 
	array( 
		'customer_name' => $your_name, 
		'emailid' => $your_email,
		'phoneno' => $your_phoneno,
		'message' => $your_message,
		'mail_content' => $selected_array,
		'client_ip' =>$client_ip,
		'created_on' => date('Y-m-d H:i:s')
	)
);

$invoice_id = $wpdb->insert_id;


$six_digit_random_number = sprintf("%06d", $invoice_id);;

$invoice_pdf = 'InnSane-prijsindicatie-'.$six_digit_random_number.'.pdf';



$wpdb->update( 
	'customer_mail', 
	array( 
		'pdf_name' =>$invoice_pdf,
		//'modified_on' => date('Y-m-d H:i:s')
	),
	array('id' => $invoice_id)
);




$other_total_ss = number_format($other_total,2,",","");
$sub_total_ss = number_format($sub_total,2,",","");



	//exit;


	$plugin_dir_path  = plugin_dir_path(__FILE__);
	include($plugin_dir_path."/MPDF56/mpdf.php");

//include_once("./wp-content/plugins/pos/MPDF56/mpdf.php");


header('Content-Type: application/pdf'); 
header('Content-Description: inline; filename.pdf'); 


$html_header = '<img src="'.site_url().'/wp-content/plugins/pos/images/header.png" style="margin-top:10px;width:100%;">
				<div style="width:100%;padding:15px; 25px; ">
					<div style="width:50%;display:inline:block;float:left;">
						<p style="margin:0px;padding:0px;padding-left:10px;">'.$your_name.'</p>
						<p style="margin:0px;padding:0px;padding-left:10px;">'.$your_email.'</p>
						<p style="margin:0px;padding:0px;padding-left:10px;">'.$your_phoneno.'</p>
						<p style="margin:0px;padding:5px 0px 0px;padding-left:10px;">Datum: '.date("d-m-Y").'</p>
						<p style="margin:0px;padding:5px 0px 0px;padding-left:10px;">Product: '.$sproduct_name.'</p>
					</div>
					<div style="width:49%;display:inline-block;text-align:right;float:right;">
						<p style="margin:0px;padding:0px;padding-right:10px;">Pagina: {PAGENO} / {nb}</p>
					</div>
				</div>
				<div style="border-bottom:1px solid #A9CD4E;"></div>
				';
// $html_footer = '<img src="'.site_url().'/wp-content/plugins/pos/images/header.png">
// 				<div style="width:100%;padding:15px; 25px;">
// 					<div style="width:70%;display:inline-block;float:left">
// 						<p>Aan deze prijsindicatie kunnen geen rechten worden ontleend. U kunt altijd contact opnemen per telefoon of e-mail. We staan u graag te woord.</p>
// 					</div>
// 					<div style="width:30%;display:inline-block;float:right;text-align:right;">
// 						<p>Contact</p>
// 						<p>POS</p>
// 						<p>De Corridor 5A</p>
// 						<p>3621 ZA Breukelen</p>
// 						<p>T: 0346-258085</p>
// 						<p>E: sales@pos.nl</p>
// 					</div>
// 				</div>';

$html_footer = '<img src="'.site_url().'/wp-content/plugins/pos/images/footer.png">';

$html_body ='<style>
body{font-size:12px;}
table th,table td{border-bottom:1px solid #A9CD4E;text-align:right;padding:10px 3px;font-size:12px;}
table thead th{background-color: #A9CD4E;color:#ffffff;}
table{width:100%;border-collapse: collapse;}

</style>
<div style="clear:both"></div><div class="html_body" style="padding: 0px 25px;">
				<p>Onderstaande tabel is een overzicht van de maandelijkse kosten voor het gebruik van '.$sproduct_name.' in de configuratie die je zelf  hebt samengesteld.</p>
			<table style="">
				<thead>
					<tr>
						<th style="width:70%;text-align:left;">Abonnement per maand </th>
						<th>Aantal</th>
						<th>Prijs</th>
						<th>Totaal</th>
					</tr>
				</thead>
				<tbody>
					'.$sub_tr.'
					<tr style="background-color:#e4e393;">
						<td colspan="3" style="text-align:left;">Totaal abonnement per maand</td>
						<td>€ '.$sub_total_ss.'</td>
					</tr>';

if($total_year_fee > 0)
		{

			$yearly_min_fees = (float)$yearly_min_fees;

			if($total_year_fee< $yearly_min_fees)
			{
				$total_year_fee = $yearly_min_fees;
			}
			$total_year_fee_ss = number_format($total_year_fee,2,",","");

				$html_body .=	'<tr >
						<td colspan="3" style="text-align:left;">Jaarlijkse support kosten</td>
						<td>€ '.$total_year_fee_ss.'</td>
					</tr>';
				}



			$html_body .=	'</tbody>
			</table>
			<p>Daarnaast zijn er voor het gebruik van de kassaoplossing eenmalige kosten voor aanschaf van de hardware en eventuele configuratie en installatie. Welke producten je hebt geselecteerd vind je in anderstaande tabel.</p>

			<table style="">
				<thead>
					<tr>
						<th style="width:70%;text-align:left;">Eenmalige aanschaf</th>
						<th>Aantal</th>
						<th>Prijs</th>
						<th>Totaal</th>
					</tr>
				</thead>
				<tbody>
					'.$other_tr.'
					<tr style="background-color:#e4e393;">
						<td colspan="3" style="text-align:left;">Totaal eenmalige aanschaf</td>
						<td>€ '.$other_total_ss.'</td>
					</tr>
				</tbody>
			</table>
			<p>Wil je korting op deze prijzen? Overweeg dan om ook andere horeca applicaties bij InnSane onder te brengen. Ontvang kortingen tot 30% als je ook bijvoorbeeld de website, personeelsplanning en/of boekhoudpakket bij InnSane onderbrengt.

			</div>';


//$mpdf = new mPDF('', 'A4', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer); 

//$mpdf=new mPDF('en-x','A4','','',0,0,0,10,10,10);

$mpdf=new mPDF('en-x','A4','','',0,0,74,40,0,0);

$mpdf->SetHTMLHeader($html_header,'O');

$mpdf->SetHTMLFooter($html_footer,'O');

$mpdf->setAutoBottomMargin = 'stretch';



//$mpdf->default_lineheight_correction = 3.2;
// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
//$stylesheet = '';
//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text





//$mpdf->SetColumns(1,'J');




$mpdf->WriteHTML($html_body);



//$invoice_pdf = 'testttt.pdf';

//$name= str_replace(' ', '_', $pname);
$uploads = wp_upload_dir();
$mpdf->Output($uploads['basedir'].'/pos/'.$invoice_pdf);

//echo "succcccccC";



$mail_message = "<p>Beste <b>".$your_name."</b>,</p>

<p>Hartelijk dank voor het configureren van je oplossing en de PDF prijsindicatie aanvraag.</p> 

<p>Zie bijgevoegd jouw configuratie inclusief prijzen per onderdeel. Als je een andere configuratie wilt kan je dit aanpassen door nogmaals de tool in te vullen op de website.</p>

<p>Als je vragen hebt kan je ons bereiken met onderstaande gegevens.</p>

<p>Met vriendelijke groet,</p>

<p>Evan van Wolfswinkel</p>

<p>Telefoon: +31 85 0020110<br>Mobiel: +31 6 51368747<br>Adres: Ternate 42, 3772EW Barneveld<br>
Website: www.innsane.nl</p>";








//$filename = 'Inv00002_1518002203.pdf';
$filename = $invoice_pdf;
$file = site_url().'/wp-content/uploads/pos/'.$invoice_pdf;
$content = file_get_contents( $file);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$name = basename($file);

// header
$header = "From: Stallioni<vijayasanthi@stallioni.com>\r\n";
//$header .= "Reply-To: vijayasanthi@stallioni.com\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed;boundary=\"".$uid."\"\r\n\r\n";


// message & attachment
$nmessage = "--".$uid."\r\n";
$nmessage .= "Content-type:text/html; charset=UTF-8\r\n";
$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
//$nmessage .= 'tettttttt'."\r\n\r\n";
$nmessage .= $mail_message."\r\n\r\n";
$nmessage .= "--".$uid."\r\n";
$nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
$nmessage .= "Content-Transfer-Encoding: base64\r\n";
$nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$nmessage .= $content."\r\n\r\n";
$nmessage .= "--".$uid."--";


$status = 1;

if(mail($your_email, 'InnSane prijsindicatie', $nmessage, $header))
{
	$status = 1;
}
else
{
	$status = 0;
}


	echo json_encode(array('message' => '<div class="alert alert-success">Email verzonden</div>' ,'status' => '1'));
	exit;


}
add_action( 'wp_ajax_generate_pdf', 'generate_pdf' );
add_action( 'wp_ajax_nopriv_generate_pdf', 'generate_pdf' );


