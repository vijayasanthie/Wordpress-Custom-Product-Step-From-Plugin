<?php
global $wpdb;
$steps_results = $wpdb->get_results("select * from step where status = 1 order by steps_order");
$product_results = $wpdb->get_results("select * from product where status = 1");
$fontend_content = $wpdb->get_row("select * from fontend_content ");

$last_step_count  = '';

$pos_title = 'POS Configurator';
$welcome_text = 'WELKOM IN DE';
$welcome_content = '';
$footer_content = '';


if($fontend_content)
{
	$pos_title = $fontend_content->pos_title;
	$welcome_text = $fontend_content->welcome_text;
	$welcome_content = $fontend_content->welcome_content;
	$footer_content = $fontend_content->footer_content;
}



	/*include("./wp-content/plugins/pos/MPDF56/mpdf.php");


$html = "tttttttttttttdgdfdfgfdg";

$mpdf=new mPDF('en-x','A4','','',0,0,0,10,10,10);

$mpdf->default_lineheight_correction = 3.2;
// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
$stylesheet = '';
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->SetColumns(1,'J');

$mpdf->WriteHTML('fhfhfhfhfgh');

//$name= str_replace(' ', '_', $pname);

$mpdf->Output('./wp-content/uploads/pos/tetttt.pdf');

echo "succcccccC";*/


$option_type = 'sidebar';
$background_color = '#F0EFF3';
$sub_background_color = '#DCDCE3';
$text_color = '#ff7200';

 $select_result = $wpdb->get_row( "SELECT * FROM coloroption" );

    if($select_result)
    {
      $background_color = $select_result->background_color;
      $sub_background_color = $select_result->sub_background_color;
      $text_color = $select_result->text_color;
    }


?>

<style type="text/css">

 .cashr-app-aside {
    background: <?php echo $background_color; ?>;
}

	.version-11 .list-of-entities .item.ty_subscription_item {
    background: <?php echo $sub_background_color; ?>;
}


.stl_configurator a {
    color: <?php echo $text_color; ?>;
}

</style>
<div class="stl_configurator">
	<input type="hidden" class="sproduct_id">
	<input type="hidden" class="sproduct_name">
	<input type="hidden" class="syearly_min_fees">
	<input type="hidden" class="total_step_count" value="<?php echo sizeof($steps_results); ?>">
	<div class="row">
		<div class="col-md-12 ">
			<div class="col-md-12 stl_appheader">
				<div class="col-md-12">
					<h2 class="stl_toptitle"><?php echo $pos_title; ?></h2>
				</div> 
			</div> 
			<section class="col-md-12 col-sm-12 col-xs-12 stl_appintro">
					 
					<div class="col-md-8 col-sm-8 col-xs-8 ">
						<p class="stl_subtitle"><?php echo $welcome_text; ?></p> 
						<p class="stl_bttitle"><?php echo $pos_title; ?></p> 
						<p><?php echo $welcome_content; ?></p> 
						<button type="button" class="col-md-12 btn btn_start">Start</button>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 ">
						<img src="<?php echo site_url(); ?>/wp-content/plugins/pos/images/intro.svg" alt="Configurator Intro" class="img-responsive">
					</div>
			</section>



			<section class="col-md-12 col-sm-12 col-xs-12 stl_appmain" style="display: none;">
				<div class="row">
				<!-- left content start -->
				<div class="col-md-7  col-sm-12 col-xs-12 stl_qustdiv" >
					<!-- pos question start -->

					<div class="col-md-12 stl_cutqust qust1">
						<input type="hidden" class="step_id" value="0">
						<input type="hidden" class="step_count" value="0">
						<div class="col-md-7 stl_qusthead">
							<div class="row title">
								<span>Voor welk product wil je een prijsindicatie maken?</span> 
								<!-- <span class="stl_tooltip">
									<i aria-hidden="true" class="fa fa-info-circle"></i> 
									<span class="stl_tip stl_hint">Cashr maakt onderscheid tussen Horeca en Retail functionaliteiten. Cashr Horeca heeft bijvoorbeeld een tafelplattegrondweergave en je kunt gangen uitserveren. Retail kan een barcodescanner koppelen.</span>
								</span> -->
							</div>
						</div>
						<!-- <div class="col-md-5" style="text-align: right;">
							<ul class="list-of-categories">
								<li class="category selected">
									<a href="javascript:;">Android</a>
								</li>
								<li class="category">
									<a href="javascript:;">iOS</a>
								</li>
							</ul>
						</div> -->
						<div style="clear:both;"></div>

						<div class="col-md-12">
							<ul class="row list-of-entities">
							<?php
							if($product_results){
								$pc = 0;
								$pcount = sizeof($product_results);
								if($pcount == 1){$pclass = 'col-md-12 col-sm-12 col-xs-12';}
								else if($pcount == 2){$pclass = 'col-md-6 col-sm-6 col-xs-6';}
								else if($pcount == 3){$pclass = 'col-md-4 col-sm-6 col-xs-6';}
								else{$pclass = 'col-md-3  col-sm-3 col-xs-6';}
									foreach($product_results as $product_result)
									{
										$product_image = $product_result->product_image;
										$product_id = $product_result->product_id;
										$yearly_min_fees = $product_result->yearly_min_fees;
										$pc++;
										if($pc == '1'){$pcls = 'fa fa-check-circle';$pcls1='selected';}
										else{$pcls = 'fa fa-circle-thin';$pcls1='';}
										?>
										<li class="<?php echo $pclass.' '.$pcls1; ?> item product_items" id="pro_<?php echo $product_id; ?>">
											<input type="hidden" class="product_id" value="<?php echo $product_result->product_id; ?>">
											<input type="hidden" class="product_name" value="<?php echo $product_result->product_name; ?>">
											<input type="hidden" class="yearly_min_fees" value="<?php echo $yearly_min_fees; ?>">
											<div class="item-link">
												<div class="check">
													<span class="<?php echo $pcls; ?>"></span> 
													
												</div> 
												<div class="item-image imga">
													<?php if($product_image !='') { ?>
													<img src="<?php echo site_url().$product_image; ?>" alt=""> 
												<?php } ?>
												</div>
												<div class="item-body">
													<h3><?php echo $product_result->product_name; ?></h3>
													<p class="stl_hint"><?php echo $product_result->product_description; ?></p>
												</div>
												
											</div>
										</li>
										<?php
									}
								}
								?>
								<!-- <li class="col-md-3 item selected">
									<div class="item-link">
										<span class="tag">0</span>
										<div class="check">
											<span class="fa fa-check-circle"></span> 
										</div> 
										<div class="item-image">
											<img src="<?php echo site_url(); ?>/wp-content/plugins/pos/images/horeca.svg" alt=""> 
										</div>
										<div class="item-body">
											<h3>Product1</h3>
											<p class="stl_hint">Cafe's, bars en restaurants</p>
										</div>
										<div class="col-md-12 addtocbtn">
											<div class="row ">
												<a href="javascript:;" class="button  btn_blue">
													<span><i class="fa fa-plus-circle"></i> in winkelwagen</span>
												</a>
											</div>
										</div>
									</div>
								</li>
								<li class="col-md-3 item">
									<div class="item-link">
										<span class="tag">0</span>
										<div class="check">
											<span class="fa fa-circle-thin"></span>
										</div> 
										<div class="item-image">
											<img src="<?php echo site_url(); ?>/wp-content/plugins/pos/images/retail.svg" alt=""> 

										</div>
										<div class="item-body">
											<h3>Product2</h3>
											<p class="stl_hint">Voor winkels en webshops</p>
										</div>
										<div class="col-md-12 addtocbtn">
											<div class="row">
												<a href="javascript:;" class="button stl_dbutton"><span>Voeg toe</span></a>
											</div>
										</div>
										
									</div>
								</li>
								<li class="col-md-3 item selected">
									<div class="item-link">
										<div class="check">
											<span class="fa fa-check-circle"></span> 
										</div> 
										<div class="item-image">
											<img src="<?php echo site_url(); ?>/wp-content/plugins/pos/images/horeca.svg" alt=""> 
										</div>
										<div class="item-body">
											<h3>Product1</h3>
											<p class="stl_hint">Cafe's, bars en restaurants</p>
										</div> 
										
									</div>
								</li>
								<li class="col-md-3 item">
									<div class="item-link">
										<div class="check">
											<span class="fa fa-circle-thin"></span>
										</div> 
										<div class="item-image">
											<img src="<?php echo site_url(); ?>/wp-content/plugins/pos/images/retail.svg" alt=""> 
										</div>
										<div class="item-body">
											<h3>Product2</h3>
											<p class="stl_hint">Voor winkels en webshops</p>
										</div>
										
									</div>
								</li> -->
							</ul>
						</div>
					</div>
					<!-- pos question end --> 
					<div class="col-md-12 col-sm-12 col-xs-12 questions-control">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<a href="javascript:;" class="button is-large hollow btn_previous"><span>Vorige</span></a> 
						</div>
						<div class="col-md-6  col-sm-6 col-xs-6" style="text-align: right;">
							<a href="javascript:;" class="button is-large btn_nxt"><span>Volgende</span></a>
						</div>
					</div> 
				</div> 
				<!-- left content end -->
				<!-- pos steps sidebar start -->
				<div class="col-md-5  col-sm-12 col-xs-12">
					<div class="row cashr-app-aside">
					<div class="version-11">
						<ol class="list-of-entities steps_rside">
							<li class="item ritem_product ty_subscription_item is-active">
								<div class="col-md-12 col-sm-12 col-xs-12 item-link">
									<div class="item-label">
										<a href="javascript:;" class="btn_pproduct" title="">Product</a>
									</div> 
									<div class="selection selection_loop">
										<div>
											<span class="item-title"></span> 
										</div>
									</div>
								</div>
							</li>
							<?php
							//echo "<pre>";print_r($steps_results);echo "</pre>";
							$steps_count = 0;
							foreach($steps_results as $steps_result)
							{
								
								$step_id = $steps_result->step_id;
								$ritem_type = $steps_result->item_type;
								$step_name = $steps_result->step_name;

							?>
								<li class="item ritem_steps <?php echo 'ty_'.$ritem_type; ?>" id="stepid_<?php echo $step_id; ?>">
									<input type="hidden" class="rstep_count" value="<?php echo $steps_count; ?>">

									<input type="hidden" class="stl_ritemtype" value="<?php echo $ritem_type; ?>">
									<input type="hidden" class="stl_rstepname" value="<?php echo $step_name; ?>">

								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" class="rside_stepbtn" title=""><?php echo $step_name; ?></a>
									</div> 
									<div class="selection">
										<div class="selection_loop">
											<span class="item-title">
												<!-- <strong>4 x </strong>Vaste kassa
												<a href="javascript:;" class="remove-item">
													<i class="fa fa-close"></i>
												</a> -->
											</span> 
											<span class="price"><!-- € 30,<sup>-</sup> --></span> 
											<span class="subscription-type"><!-- p/m --></span>

											<input type="hidden" class="stl_rstepid" value="<?php echo $step_id; ?>">
											<input type="hidden" class="stl_ritemid" value="">
											<input type="hidden" class="stl_rprice" value="">
											<input type="hidden" class="stl_rqty" value="">
											<input type="hidden" class="stl_yearly_price" value="">

										</div>
									</div>
								</div>
							</li>
								<?php
								$steps_count++;
								$last_step_count = $steps_count;
							} 
							?>
							<!--<li class="item is-active">
								<div class="col-md-12 col-sm-12 col-xs-12 item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Branche</a>
									</div> 
									<div class="selection">
										<div>
											<span class="item-title">Horeca</span> 
										</div>
									</div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="col-md-12 col-sm-12 col-xs-12 item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Abonnement</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Vaste afrekenpunten</a>
									</div> 
									<div class="selection">
										<div>
											<span class="item-title">
												<strong>4 x </strong>Vaste kassa
												<a href="javascript:;" class="remove-item">
													<i class="fa fa-close"></i>
												</a>
											</span> 
											<span class="price">€ 30,<sup>-</sup></span> 
											<span class="subscription-type">p/m</span>
										</div>
									</div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Handhelds</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Pinterminals</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Tablets</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Tablethouders</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Handhelds</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Bonprinters</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Kassalades</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Pinterminals</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Barcodescanners</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class="item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Inrichtingsservice</a>
									</div> 
									<div class="selection"></div>
								</div>
							</li>
							<li class="item is-upcomming">
								<div class=" item-link">
									<div class="item-label">
										<a href="javascript:;" title="">Installatieservice</a>
									</div>
									<div class="selection"></div>
								</div>
							</li> -->
							<!-- <li class="item total">
								<div class="item-link">
									<div class="item-label">Total:</div> 
									<div class="price">€ 0,<sup>-</sup></div>
								</div>
							</li> -->
						</ol>
					</div>
				</div>
				</div>

				<!-- /pos steps sidebar end -->
				</div>
			</section>



		</div>
	</div>
</div>



<!-- Modal -->
<div id="send_pdfpopup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Please fill the below details</h4>
      </div> -->
      <div class="modal-body">
        
        <form action="" method="post">

        	<input type="hidden" name="configurator" value=""> 
			 <div class="form-group">
			 	<label for="your-name">Naam</label><br> 
			 	
			 		<input type="text" name="your-name" value="" size="40" id="your-name" aria-required="true" aria-invalid="false" placeholder="Vul uw naam in" class="form-control your_name">

			 </div> 
			 <div class="form-group">
			 	<label for="your-email">E-mail</label><br> 
			 		<input type="email" name="your-email" value="" size="40" id="your-email" aria-required="true" aria-invalid="false" placeholder="Vul uw email adres in" class="form-control your_email">
			 </div> 
			 <div class="form-group">
			 	<label for="your-phone">Telefoonnummer</label><br> 
			 		<input type="text" name="your-phone" value="" size="40" id="your-phone" aria-required="true" aria-invalid="false" placeholder="Vul uw telefoonnummer in" class=" form-control your_phoneno">
			 </div> 
			 <div class="form-group">
			 	<label for="your-message">Opmerking (optioneel)</label><br> 
			 		<textarea name="your-message" cols="40" rows="4" id="your-message" aria-invalid="false" placeholder="Vraag of opmerking" class="form-control your_message"></textarea>
			 </div> 
			 <div class="popupmsg"></div> 

		</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;">Close</button>
        <button type="submit" class="button is-large btnsend_pdf"><span>Verstuur</span></button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
	 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

	 var product_divload = '';

	 jQuery(window).load(function(){

	 	product_divload = jQuery(".stl_qustdiv").html();
	 })


	jQuery(document).on('click','.btn_start',function(){
		jQuery(".stl_appintro").hide();
		jQuery(".stl_appmain").show();
		var product_id = jQuery(".item.selected .product_id").val();
		var product_name = jQuery(".item.selected .product_name").val();
		var yearly_min_fees = jQuery(".item.selected .yearly_min_fees").val();
		//alert(product_id);
		jQuery(".sproduct_id").val(product_id);
		jQuery(".sproduct_name").val(product_name);
		jQuery(".syearly_min_fees").val(yearly_min_fees);

		jQuery(".steps_rside .ritem_product .item-title").html(product_name);
	})

	jQuery(document).on('click','.list-of-entities .product_items',function(){

		jQuery(".ritem_steps .selection_loop").remove();


		jQuery(".list-of-entities .item").removeClass('selected');
		jQuery(".list-of-entities .item .item-link .check span").removeClass();
		jQuery(".list-of-entities .item .item-link .check span").addClass('fa fa-circle-thin');
		jQuery(this).find(".item-link .check span").removeClass();
		jQuery(this).find(".item-link .check span").addClass('fa fa-check-circle');
		jQuery(this).addClass('selected');
		var product_id = jQuery(".item.selected .product_id").val();
		jQuery(".sproduct_id").val(product_id);

		var product_name = jQuery(".item.selected .product_name").val();
		var yearly_min_fees = jQuery(".item.selected .yearly_min_fees").val();
		jQuery(".sproduct_name").val(product_name);
		jQuery(".syearly_min_fees").val(yearly_min_fees);

		jQuery(".steps_rside .ritem_product .item-title").html(product_name);

		//jQuery(".list-of-entities .item").removeClass('selected');



	});

	jQuery(document).on('click','.list-of-entities .steps_item',function(evt){



		if(evt.target.className == "stlclose_blue")
          return;

       if(jQuery(evt.target).closest('.stlclose_blue').length)
          return; 

      if(evt.target.className == "stlclose")
          return;

       if(jQuery(evt.target).closest('.stlclose').length)
          return; 




		var system_type = jQuery(this).closest('.stl_cutqust').find('.system_type').val();
		var quantity_type = jQuery(this).closest('.stl_cutqust').find('.quantity_type').val();
		var item_type = jQuery(this).closest('.stl_cutqust').find('.item_type').val();

		if(quantity_type == 'radio')
		{
			jQuery(".list-of-entities .item").removeClass('selected');
			jQuery(".list-of-entities .item .item-link .check span").removeClass();
			jQuery(".list-of-entities .item .item-link .check span").addClass('fa fa-circle-thin');
			jQuery(this).find(".item-link .check span").removeClass();
		}
		jQuery(this).find(".item-link .check span").removeClass().addClass('fa fa-check-circle');
		jQuery(this).addClass('selected');

		var max_qty = jQuery(this).find('.max_qty').val();
		var tag_val = jQuery(this).find('.tag').html();
		tag_val = parseInt(tag_val)+1;

		if(max_qty >= tag_val || max_qty == '')
		{
			jQuery(this).find('.tag').html(tag_val);
		}
		//if(tag_val == 1)
		//{
			jQuery(this).find('.stlclose').show();
			jQuery(this).find('.stlclose_blue').show();
		//}

		calculate_price();
		



	});

	jQuery(document).on('click','.stlclose',function(){
		//alert('fffffffffff');
		var this_val = jQuery(this);
		setTimeout(function(){
		this_val.closest('.steps_item').find('.tag').html(0);
		this_val.hide();

		var pitem_id = this_val.closest('.steps_item').find('.pitem_id').val();
		
		jQuery("#stlit_"+pitem_id).remove();
		//calculate_price()


	}, 400);
	});


	jQuery(document).on('click','.stlclose_blue',function(){
		//alert('fffffffffff');
		var this_val = jQuery(this);
		setTimeout(function(){
		this_val.closest('.steps_item').find('.tag').html(0);
		this_val.hide();

		var pitem_id = this_val.closest('.steps_item').find('.pitem_id').val();
		
		jQuery("#stlit_"+pitem_id).remove();

		this_val.closest('.steps_item').find('.check span').removeClass().addClass('fa fa-circle-thin');
		this_val.closest('.steps_item').removeClass('selected');
		//calculate_price()


	}, 400);
	});

	jQuery(document).on('click','.stl_rremove',function(){
		//alert('fffffffffff');
		var this_val = jQuery(this);

		var item_idd = this_val.closest(".selection_loop").find(".stl_ritemid").val();
		var stl_rstepid = this_val.closest(".selection_loop").find(".stl_rstepid").val();


		this_val.closest(".selection_loop").remove();

		var current_stepid = jQuery(".stl_cutqust .step_id").val();

		if(current_stepid == stl_rstepid)
		{
			jQuery("li.itemid_"+item_idd+" .check span").removeClass().addClass('fa fa-circle-thin');
			jQuery("li.itemid_"+item_idd+" .tag").html(0);
			jQuery("li.itemid_"+item_idd).removeClass('selected');

			jQuery("li.itemid_"+item_idd+" .stlclose_blue").hide();
			jQuery("li.itemid_"+item_idd+" .stlclose").hide();

			//jQuery("li.itemid_"+item_idd+" .check span").removeClass().addClass('fa fa-circle-thin');
		}



	});



	

	jQuery(document).on('click','.btn_nxt',function(){
		var product_id = jQuery(".sproduct_id").val();
		//var pitem_id = jQuery(".selected.item .pitem").val();
		var step_id = jQuery(".stl_cutqust .step_id").val();
		var step_count = jQuery(".step_count").val();
		var total_step_count = jQuery(".total_step_count").val();

		var selected_array = rstep_selected();

		//console.log(typeof selected_array);

		var selected_arrayss = JSON.stringify(selected_array);

		//console.log(selected_arrayss);


		//var selected_array = {a:{'foo':'bar'},b:{'this':'that'}};

		if(parseInt(total_step_count) > parseInt(step_count))
		{

			jQuery.ajax({
		      url: ajaxurl,
		      data: {'action':'show_steps','product_id':product_id,'step_id' : step_id,'step_count' : step_count,'total_step_count' : total_step_count,'selected_array':selected_arrayss},
		      dataType:'json',
		      method: 'post',
		      beforeSend: function(){
		        jQuery('.preloader').addClass('show_preloader');
		      },
		      success:function(data) {
		        if(data.status == 1)
		        {
		          jQuery(".stl_qustdiv").html(data.item_content);
		          var step_id_active = data.step_id;

		          jQuery(".steps_rside .item").removeClass('is-active');
		          jQuery(".steps_rside #stepid_"+step_id_active).addClass('is-active');


		          calculate_price();
		        }
		        else
		        {
		          alert("Error in ajax");
		        }
		        jQuery('.preloader').removeClass('show_preloader');
		      },
		      error: function(errorThrown){
		        console.log(errorThrown);
		        alert("Error in ajax load");
		        jQuery('.preloader').removeClass('show_preloader');
		      }
		    });
		}
		else
		{
			//alert("ovvv");
			//alert("total_step_count = "+total_step_count+" = ss = "+step_count);

		}

	});

	jQuery(document).on('click','.btn_previous',function(){
		var product_id = jQuery(".sproduct_id").val();
		//var pitem_id = jQuery(".selected.item .pitem").val();
		var step_id = jQuery(".stl_cutqust .step_id").val();
		var step_count = jQuery(".step_count").val();
		var total_step_count = jQuery(".total_step_count").val();

		var selected_array = rstep_selected();

		//console.log(typeof selected_array);

		var selected_arrayss = JSON.stringify(selected_array);


		step_count = parseInt(step_count)-2;

		if(step_count >= 0)
		{

			jQuery.ajax({
		      url: ajaxurl,
		      data: {'action':'show_steps','product_id':product_id,'step_id' : step_id,'step_count' : step_count,'total_step_count' : total_step_count,'selected_array':selected_arrayss},
		      dataType:'json',
		      method: 'post',
		      beforeSend: function(){
		        jQuery('.preloader').addClass('show_preloader');
		      },
		      success:function(data) {
		        if(data.status == 1)
		        {
		          jQuery(".stl_qustdiv").html(data.item_content);
		          var step_id_active = data.step_id;

		          jQuery(".steps_rside .item").removeClass('is-active');
		          jQuery(".steps_rside #stepid_"+step_id_active).addClass('is-active');

		          calculate_price();
		        }
		        else
		        {
		          alert("Error in ajax");
		        }
		        jQuery('.preloader').removeClass('show_preloader');
		      },
		      error: function(errorThrown){
		        console.log(errorThrown);
		        alert("Error in ajax load");
		        jQuery('.preloader').removeClass('show_preloader');
		      }
		    });
		}

	});


	jQuery(document).on('click','.rside_stepbtn',function(){


		var product_id = jQuery(".sproduct_id").val();
		//var pitem_id = jQuery(".selected.item .pitem").val();
		var step_idtxt = jQuery(this).closest(".ritem_steps").attr('id');

		var step_id = step_idtxt.replace("stepid_", "");

		var step_count = jQuery(this).closest(".ritem_steps").find(".rstep_count").val();
		var total_step_count = jQuery(".total_step_count").val();


		var selected_array = rstep_selected();

		//console.log(typeof selected_array);

		var selected_arrayss = JSON.stringify(selected_array);
	



		jQuery.ajax({
		      url: ajaxurl,
		      data: {'action':'show_steps','product_id':product_id,'step_id' : step_id,'step_count' : step_count,'total_step_count' : total_step_count,'selected_array':selected_arrayss},
		      dataType:'json',
		      method: 'post',
		      beforeSend: function(){
		        jQuery('.preloader').addClass('show_preloader');
		      },
		      success:function(data) {
		        if(data.status == 1)
		        {
		          jQuery(".stl_qustdiv").html(data.item_content);
		          var step_id_active = data.step_id;

		          jQuery(".steps_rside .item").removeClass('is-active');
		          jQuery(".steps_rside #stepid_"+step_id_active).addClass('is-active');

		          calculate_price();


		        }
		        else
		        {
		          alert("Error in ajax");
		        }
		        jQuery('.preloader').removeClass('show_preloader');
		      },
		      error: function(errorThrown){
		        console.log(errorThrown);
		        alert("Error in ajax load");
		        jQuery('.preloader').removeClass('show_preloader');
		      }
		    });

	})


	jQuery(document).on('click','.btn_itemnxt',function(){
		var this_val = jQuery(this);
		var  item_pre = jQuery(this).closest('.itemprenxt').find('.item_pre').val();
		var  item_nxt = jQuery(this).closest('.itemprenxt').find('.item_nxt').val();
		var item_totall = jQuery(this).closest('.itemprenxt').find('.item_totall').val();


		var catcls = '';
		var cat_id = jQuery('.list-of-categories .category.selected').attr('data-catid');
		if(cat_id !== undefined && cat_id !== null)
		{
		 catcls = '.catid_'+cat_id;
		}

		//console.log("catcls = "+catcls);



		var ival = parseInt(item_nxt)+1;
		if(item_totall >= ival)
		{

			jQuery("ul .item.steps_item").removeClass("currentli");
			jQuery("ul .item.steps_item").removeClass("noncurrentli");
			jQuery("ul .item.steps_item").addClass("noncurrentli");

			item_nxt_val = parseInt(item_nxt)*4;

			for(var kk = 0; kk < 4; kk++)
			{
				var tt = item_nxt_val+kk;
				jQuery("ul "+catcls+".item.steps_item:eq(" + tt + ")").removeClass("noncurrentli");
			  	jQuery("ul "+catcls+".item.steps_item:eq(" + tt + ")").addClass("currentli");
			}
			
			this_val.closest('.itemprenxt').find('.item_nxt').val(ival);
			this_val.closest('.itemprenxt').find('.item_pre').val(item_nxt);
			this_val.closest('.itemprenxt').find(".pntxt").html(ival+"/"+item_totall);
		}
		else
		{
			//console.log("sssssssssss");
			jQuery(".btn_itempre").trigger('click');
		}
		
	});

	jQuery(document).on('click','.btn_itempre',function(){
		var this_val = jQuery(this);
		var  item_pre = jQuery(this).closest('.itemprenxt').find('.item_pre').val();
		var  item_nxt = jQuery(this).closest('.itemprenxt').find('.item_nxt').val();
		var item_totall = jQuery(this).closest('.itemprenxt').find('.item_totall').val();

		var catcls = '';
		var cat_id = jQuery('.list-of-categories .category.selected').attr('data-catid');
		if(cat_id !== undefined && cat_id !== null)
		{
		 catcls = '.catid_'+cat_id;
		}

		//console.log("catcls = "+catcls);


		var ival = item_pre;
		//console.log("ival = "+ival);
		if(ival > 0)
		{
			//console.log("sssssssssss");

			jQuery("ul .item.steps_item").removeClass("currentli");
			jQuery("ul .item.steps_item").removeClass("noncurrentli");
			jQuery("ul .item.steps_item").addClass("noncurrentli");

			item_nxt_val = parseInt(item_pre)*4;

			for(var kk = 1; kk <= 4; kk++)
			{
				var tt = item_nxt_val-kk;
				jQuery("ul "+catcls+".item.steps_item:eq(" + tt + ")").removeClass("noncurrentli");
			  	jQuery("ul "+catcls+".item.steps_item:eq(" + tt + ")").addClass("currentli");
			}
			

			this_val.closest('.itemprenxt').find('.item_nxt').val(item_pre);
			this_val.closest('.itemprenxt').find('.item_pre').val(parseInt(item_pre)-1);
			this_val.closest('.itemprenxt').find(".pntxt").html(ival+"/"+item_totall);
		}
		else
		{
			//console.log("ssaaaaaaaaaaaaaaaaaaa");
			jQuery(".btn_itemnxt").trigger('click');
		}
		
	});

	jQuery(document).on('click','.list-of-categories .category',function(){
		var cat_id = jQuery(this).attr('data-catid');
		var catcls = 'catid_'+cat_id;
		//jQuery(".item.steps_item").hide();
		var catitem_count = jQuery("."+catcls).length;
		//console.log("catitem_count = "+catitem_count);

		if(catitem_count > 4)
		{
			pcatitem_divt = catitem_count / 4;
			pcatitemsss = Math.ceil(pcatitem_divt);
			jQuery(".pntxt").html("1 / "+pcatitemsss);

			jQuery(".item.steps_item").removeClass("currentli");
			jQuery(".item.steps_item").removeClass("noncurrentli");
			jQuery(".item.steps_item").addClass("noncurrentli");
			for(var kk = 0; kk < 4; kk++)
			{
				jQuery("."+catcls+".item.steps_item:eq(" + kk + ")").removeClass("noncurrentli");
				jQuery("."+catcls+".item.steps_item:eq(" + kk + ")").addClass("currentli");
			}
			jQuery('.item_nxt').val(1);
			jQuery('.item_pre').val(0);
			jQuery(".item_totall").val(pcatitemsss);

		}
		else
		{
			//jQuery("."+catcls).show();
			jQuery(".item.steps_item").removeClass("currentli");
			jQuery(".item.steps_item").removeClass("noncurrentli");
			jQuery(".item.steps_item").addClass("noncurrentli");
			jQuery("."+catcls).removeClass("noncurrentli");
			jQuery("."+catcls).addClass("currentli");
		}


		
		jQuery('.list-of-categories .category').removeClass('selected');
		jQuery(this).addClass('selected');
	});




	jQuery(document).ajaxStart(function() {
		//alert("ssssssss");
	    jQuery(document.body).css({'cursor' : 'wait'});
	    jQuery(".button").attr("disabled", true);
	}).ajaxStop(function() {
	    jQuery(document.body).css({'cursor' : 'default'});
	    jQuery(".button").removeAttr("disabled");
	});


	function rstep_selected(){

		var selected_array = {};

		jQuery(".item.ritem_steps").each(function(){
			var s_val = jQuery(this);
			var step_txt = jQuery(this).attr('id');
			var step_id = jQuery(this).find('.stl_rstepid').val();
			var stl_ritemtype = jQuery(this).find('.stl_ritemtype').val();
			var stl_rstepname = jQuery(this).find(".stl_rstepname").val();

			var ttt = {};
		jQuery("#"+step_txt+" .selection_loop").each(function(){
			var pitem_id = jQuery(this).find('.stl_ritemid').val();
			var pitem_price = jQuery(this).find('.stl_rprice').val();
			var quantity = jQuery(this).find('.stl_rqty').val();
			var pitem_name = jQuery(this).find(".pitem_name").val();
			var stl_yearly_price = jQuery(this).find(".stl_yearly_price").val();
			var pitem_price_original = jQuery(this).find(".pitem_price_original").val();
			var stl_system_type = jQuery(this).find(".stl_system_type").val();
			var stl_max_qty = jQuery(this).find(".stl_max_qty").val() || 1;
			//var stl_ritemid = jQuery(this).find('.stl_rqty').val();

			//console.log("step_id = "+step_id+" = pitem_id = "+pitem_id+" = pitem_price = "+pitem_price+" = quantity = "+ quantity);

			

			if(pitem_id !== null && pitem_id !== undefined && pitem_id !='')
			{
				pitem_txt = "items_"+pitem_id;
				ttt[pitem_txt] = {"pitem_id": pitem_id,"pitem_price": pitem_price, "quantity":quantity,"itemtype" : stl_ritemtype, "stepname" : stl_rstepname, "pitem_name":pitem_name, "pitem_price_original" : pitem_price_original,"stl_yearly_price" :stl_yearly_price,"stl_system_type" :stl_system_type,"stl_max_qty" :stl_max_qty}; 
				//selected_array[step_txt][pitem_txt]['quantity'] = quantity;

			}

			

			//console.log("step_id = "+step_id+" = pitem_id = "+pitem_id+" = pitem_price = "+pitem_price+" = quantity = "+ quantity);
		});

		selected_array[step_txt] = ttt;


		});
		//console.log(selected_array);

		return selected_array;

	}


	function calculate_price(){

		

		var pitem_id = jQuery(".selected.item .pitem").val();
		var step_id = jQuery(".stl_cutqust .step_id").val();
		var system_type = jQuery(".stl_cutqust .system_type").val();  //pos_system, additional_item
		var quantity_type = jQuery(".stl_cutqust .quantity_type").val();  //radio, checkbox
		var item_type = jQuery(".stl_cutqust .item_type").val();  //subscription_item, normal_item
		var itm_rvoption = jQuery(".stl_cutqust .itm_rvoption").val();



		jQuery("#stepid_"+step_id+" .selection").html('');
		jQuery(".selected.item").each(function() {
			var pitem_id = jQuery(this).find(".pitem_id").val();
			var pitem_price_original = jQuery(this).find(".pitem_price").val();
			var pitem_name = jQuery(this).find(".pitem_name").val();
			var quantity = jQuery(this).find(".item-link .tag").html();
			var max_qty = jQuery(this).find('.max_qty').val();
			var max_item_price = jQuery(this).find(".max_item_price").val();
			var yearly_price = jQuery(this).find(".yearly_price").val();

			if(quantity !== undefined && quantity !== null)
			{
				qtyss = quantity
				if(system_type == 'pos_system')
				{
					qtyss = quantity - 1;
				}

				pitem_price = parseFloat(pitem_price_original) * parseInt(qtyss);

				//console.log("pitem_price = "+pitem_price+" = max_item_price = "+max_item_price+" = item_type = "+item_type);

				if(item_type == 'subscription_item' && pitem_price > parseFloat(max_item_price) && max_item_price !='' && max_item_price > 0)
				{
					//console.log("ifffffffff");
					pitem_price = parseFloat(max_item_price);
				}
				
			}
			else
			{
				quantity = 1;
				pitem_price = parseFloat(pitem_price_original);
			}
			pitem_price = pitem_price.toFixed(2);

			//console.log("pitem_id = "+pitem_id+" = step_id = "+step_id+" = quantity = "+quantity);

			var append_txt = '<div class="selection_loop" id="stlit_'+pitem_id+'"><span class="item-title"><strong>';

			if(max_qty > 1 || max_qty == '')
			{
				append_txt += quantity+' x ';
			}

			append_txt += '</strong>'+pitem_name;

			if(itm_rvoption !='no')
			{
				append_txt +='<a href="javascript:;" class="remove-item stl_rremove"><i class="fa 	fa-close"></i></a>';
			}

			var pitem_price_ss = parseFloat(pitem_price).toFixed(2);
			pitem_price_ss = pitem_price_ss.replace(".", ",");
			append_txt +='</span> <span class="price"> € '+pitem_price_ss+'</span>';

			if(item_type == 'subscription_item')
			{
				append_txt += ' <span class="subscription-type"> p/m </span>';


			}

			append_txt += '<input type="hidden" class="stl_rstepid" value="'+step_id+'"><input type="hidden" class="stl_ritemid" value="'+pitem_id+'"><input type="hidden" class="pitem_price_original" value="'+pitem_price_original+'"><input type="hidden" class="stl_rprice" value="'+pitem_price+'"><input type="hidden" class="stl_rqty" value="'+quantity+'"><input type="hidden" class="pitem_name" value="'+pitem_name+'"><input type="hidden" class="stl_max_item_price" value="'+max_item_price+'"><input type="hidden" class="stl_yearly_price" value="'+yearly_price+'"><input type="hidden" class="stl_system_type" value="'+system_type+'"><input type="hidden" class="stl_max_qty" value="'+max_qty+'"></div>';

			jQuery("#stepid_"+step_id+" .selection").append(append_txt);
		});



	}

	jQuery(document).on('click','.btn_pproduct',function(){
		//alert("product_div");

		var sproduct_id = jQuery(".sproduct_id").val();
		jQuery(".stl_qustdiv").html(product_divload);

		var id_name = "pro_"+sproduct_id;


		jQuery(".list-of-entities .item").removeClass('selected');
		jQuery(".list-of-entities .item .item-link .check span").removeClass();
		jQuery(".list-of-entities .item .item-link .check span").addClass('fa fa-circle-thin');
		jQuery("#"+id_name+" .item-link .check span").removeClass();
		jQuery("#"+id_name+" .item-link .check span").addClass('fa fa-check-circle');
		jQuery("#"+id_name).addClass('selected');
		var product_id = jQuery(".item.selected .product_id").val();
		jQuery(".sproduct_id").val(product_id);

		var product_name = jQuery(".item.selected .product_name").val();
		jQuery(".sproduct_name").val(product_name);

		var yearly_min_fees = jQuery(".item.selected .yearly_min_fees").val();
		jQuery(".syearly_min_fees").val();

		jQuery(".steps_rside .ritem_product .item-title").html(product_name);




	});
	jQuery(document).on('click','.btn_complete',function(){

		//alert("completed");

		var yearly_min_fees = jQuery(".syearly_min_fees").val() || 0;
		yearly_min_fees = parseFloat(yearly_min_fees);

		var total_year_fee = sub_price = sub_qty = other_price = other_qty = furnishing_price = installing_price = 0;

		jQuery(".ritem_steps").each(function(){
			var this_step = jQuery(this);

			var stl_ritemtype = this_step.find(".stl_ritemtype").val();
			var step_divid = this_step.attr('id');

			jQuery("#"+step_divid+" .selection .selection_loop").each(function(){
				var this_item = jQuery(this);

				var stl_rstepid = this_item.find(".stl_rstepid").val();
				var stl_rprice = this_item.find(".stl_rprice").val() || 0;
				var stl_rqty = this_item.find(".stl_rqty").val()  || 0;
				var stl_ritemid = this_item.find(".stl_ritemid").val();
				var stl_yearly_price = this_item.find(".stl_yearly_price").val() || 0;
				var stl_system_type = this_item.find(".stl_system_type").val() || '';
				var stl_max_qty = this_item.find(".stl_max_qty").val() || 0;

				//console.log("stl_yearly_price = "+stl_yearly_price);

				var qtyss = parseInt(stl_rqty)
				if(stl_system_type == 'pos_system' && stl_max_qty > 1)
				{
					qtyss = parseInt(stl_rqty) - 1;
				}

				console.log("qtyss = "+qtyss+" = stl_rqty = "+stl_rqty);

				if(stl_ritemtype == 'subscription_item')
				{
					sub_price += parseFloat(stl_rprice);
					sub_qty += parseInt(stl_rqty);

					total_year_fee +=parseInt(qtyss) * parseFloat(stl_yearly_price);
				}
				else if(stl_ritemtype == 'furnishing_service_item')
				{
					furnishing_price += parseFloat(stl_rprice);
					//sub_qty += parseInt(stl_rqty);
				}
				else if(stl_ritemtype == 'installing_service_item')
				{
					installing_price += parseFloat(stl_rprice);
					//sub_qty += parseInt(stl_rqty);
				}
				else
				{
					other_price += parseFloat(stl_rprice);
					other_qty += parseInt(stl_rqty);
				}

			})



		});

		

		console.log("total_year_fee = "+total_year_fee);
		//console.log("other_price = "+other_price);

		var last_step_count = "<?php echo $last_step_count; ?>";
		last_step_count = parseInt(last_step_count)+1;


		var sub_price_ss = parseFloat(sub_price).toFixed(2);
		sub_price_ss = sub_price_ss.replace(".", ",");

		

		var div_txt = '<div class="col-md-12 stl_completeddiv"><div class="col-md-12  stl_cutqust"> <input type="hidden" class="step_id" value="0"><input type="hidden" class="step_count" value="'+last_step_count+'"><h3 class="title">Samenvatting</h3> <ul class="price-list-summary"><li class="subdiv"><div class="item-link"><span>Maandelijks abonnement:</span> <span class="price">€ '+sub_price_ss+'</span></div></li>';

		if(total_year_fee > 0)
		{
			if(total_year_fee< yearly_min_fees)
			{
				total_year_fee = yearly_min_fees;
			}

			var total_year_fee_ss = parseFloat(total_year_fee).toFixed(2);
		total_year_fee_ss = total_year_fee_ss.replace(".", ",");

		 div_txt += ' <li><span>Jaarlijkse support kosten</span><span class="price">€ '+total_year_fee_ss+'</span></li>';
		}


		var other_price_ss = parseFloat(other_price).toFixed(2);
		other_price_ss = other_price_ss.replace(".", ",");

		var furnishing_price_ss = parseFloat(furnishing_price).toFixed(2);
		furnishing_price_ss = furnishing_price_ss.replace(".", ",");

		var installing_price_ss = parseFloat(installing_price).toFixed(2);
		installing_price_ss = installing_price_ss.replace(".", ",");

		var footer_content = "<?php echo $footer_content; ?>";

		 div_txt += ' <li><h3 class="title">Eenmalige investeringen</h3></li> <li><span>Investering hardware:</span> <span class="price">€ '+other_price_ss+'</span></li> <li><span>Inrichtingsservice</span> <span class="price">€ '+furnishing_price_ss+'</span></li> <li><span>Installatieservice</span> <span class="price">€ '+installing_price_ss+'</span></li></ul> <p class="hint" style="text-align: right;">Alle genoemde prijzen zijn exclusief BTW</p> <p>'+footer_content+'.</p> </div><div class="col-md-12 col-sm-12 col-xs-12 questions-control"><div class="col-md-6 col-sm-6 col-xs-12"><a href="javascript:;" class="button is-large hollow btn_previous"><span>Vorige</span></a></div><div class="col-md-6 col-sm-6 col-xs-12" style="text-align: right;"> <a href="javascript:;" class="button is-large btn_detailspopup"><span class="icon"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></span> <span>Ontvang prijsindicatie in PDF</span></a></div></div></div>';

		jQuery(".stl_qustdiv").html(div_txt);

	});

	jQuery(document).on('click','.btn_detailspopup',function(){

		//alert("fffffffffff");
		jQuery("#send_pdfpopup").modal('show');

	});

	jQuery(document).on('click',".btnsend_pdf",function(){
		var msg = '';
		jQuery(".popupmsg").html('');
		var your_name = jQuery(".your_name").val();
		var your_email = jQuery(".your_email").val();
		var your_phoneno = jQuery(".your_phoneno").val();
		var your_message = jQuery(".your_message").val();
		var sproduct_id = jQuery(".sproduct_id").val();
		var sproduct_name = jQuery(".sproduct_name").val();
		var yearly_min_fees = jQuery(".syearly_min_fees").val() || 0;
		if(your_name == '')
		{
			msg = "<div class='alert alert-danger'>Wat is jouw naam?</div>";
		}
		else if(your_email == '')
		{
			msg = "<div class='alert alert-danger'>Wat is jouw emailadres?</div>";
		}
		else if(your_phoneno == '')
		{
			msg = "<div class='alert alert-danger'>Wat is jouw telefoonnummer</div>";
		}
		else
		{
			var selected_array = rstep_selected();

		//console.log(typeof selected_array);

		var selected_arrayss = JSON.stringify(selected_array);

			jQuery.ajax({
		      url: ajaxurl,
		      data: {'action':'generate_pdf','your_name':your_name,'your_email' : your_email,'your_phoneno' : your_phoneno,'your_message' : your_message,'selected_array':selected_arrayss,'sproduct_name' : sproduct_name, 'sproduct_id' :sproduct_id,'yearly_min_fees' : yearly_min_fees},
		      dataType:'json',
		      method: 'post',
		      beforeSend: function(){
		        jQuery('.preloader').addClass('show_preloader');
		      },
		      success:function(data) {
		        if(data.status == 1)
		        {
		          jQuery(".popupmsg").html(data.message);
		          jQuery(".your_name").val('');
		          jQuery(".your_email").val('');
		          jQuery(".your_phoneno").val('');
		          jQuery(".your_message").val('');
		        }
		        else
		        {
		         jQuery(".popupmsg").html("<div class='alert alert-danger'>Error in Mail sending. please try again later</div>");
		        }
		        jQuery('.preloader').removeClass('show_preloader');
		      },
		      error: function(errorThrown){
		        console.log(errorThrown);
		        alert("Error in ajax load");
		        jQuery('.preloader').removeClass('show_preloader');
		      }
		    });

		}

		jQuery(".popupmsg").html(msg);
	})

	


</script>
