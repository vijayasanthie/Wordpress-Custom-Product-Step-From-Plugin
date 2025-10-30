<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('client_model');
		$this->load->model('user_model');
		$this->load->helper('url');
	}
	public function _remap($method, $params = array())
	{
        $method = $method;
        if (method_exists($this, $method))
        {
                return call_user_func_array(array($this, $method), $params);
        }
        else
        {
        	$this->index();
        }
      }
	public function index(){
		 
		$ClientDetails = $this->user_model->getDetails(array('usertype' => 10));
			$data = array(
					'view_file'=>'show_client',
					'current_menu'=>'show_clients',
					'site_title' =>'Show Clients',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'ClientDetails' => $ClientDetails,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/bootstrap-switch/css/bootstrap-switch.min.css',
									'lib/datatables/datatables.min.css',
									'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"js" => array(
									'lib/jquery-1.11.0.min.js'
								),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/bootstrap-switch/js/bootstrap-switch.min.js',
									'lib/datatable.js',
									'lib/datatables/datatables.min.js',
									'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/bootstrap-confirmation/bootstrap-confirmation.min.js'

									),
								"priority" => 'high'
								)
				);

			$this->template->load_admin_template($data);
		}
	 
	public function add_client(){
		
		if($this->input->get('id'))
		{
			$form_name = 'Update';
			$form_action = 'updateclient_submit';
			$id = $this->input->get('id');
			$ClientDetail = $this->user_model->getDetails(array('id' => $id));
		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addclient_submit';
			$ClientDetail = '';
		}
		
		$data = array(
					'view_file'=>'add_client',
					'current_menu'=>'add_client',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'formname' => $form_name,
					'ClientDetail' => $ClientDetail,
					'form_action' => $form_action,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}
	
	public function addclient_submit(){   //insert functionality for client
		//print_r($this->input->post());exit();
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, 8 );
		$name = $this->input->post('firm_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('emailid');
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$zip_code = $this->input->post('zip_code');
		$trading_name = $this->input->post('trading_name');
		$vat_no = $this->input->post('vat_no');
		$status = $this->input->post('status');
		
		$result = $this->user_model->checkEmail($email);
		$mail=count($result);
		
		$result1 = $this->user_model->checkVatNo($vat_no);
		$vatcheck=count($result1);
		
		
		if($mail > 0)
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>EmailId Already Exists</span></div>');
			redirect(BASE_URL.'client/add_client');
	    }
		else
		{
			if($vatcheck > 0)
			{
			
				$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>VAT Number Already Exists</span></div>');
				redirect(BASE_URL.'client/add_client');
			}
				
			else
			{
				$insert_data = array(
					'name' => $name,
					'phone'=>$phone,
					'email'=>$email,
					'address1' => $address1,
					'address2' => $address2,
					'zip_code' => $zip_code,
					'trading_name' => $trading_name,
					'vat_no' => $vat_no,
					'status' => $status, 
					'password'=>$password,
					'usertype' => 10
				);
				$insert_status = $this->client_model->InsertClient($insert_data);
				if($insert_status)
				{
				$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details inserted successfully</span></div>');
				redirect(BASE_URL.'client/add_client');
				}
				else
				{
					$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
				redirect(BASE_URL.'client/add_client');
				}
			}
			
		}
	}
	public function addclient_ajax(){
		//print_r($this->input->post());exit();
		
		$name = $this->input->post('firm_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('emailid');
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$zip_code = $this->input->post('zip_code');
		$trading_name = $this->input->post('trading_name');
		$vat_no = $this->input->post('vat_no');
		$status = $this->input->post('status');
		
		//$status = $this->input->post('status');
		
		
		$insert_data = array(
		    'name' => $name,
		    'phone'=>$phone,
		    'email'=>$email,
		    'address1' => $address1,
		    'address2' => $address2,
		    'zip_code' => $zip_code,
		    'trading_name' => $trading_name,
		    'vat_no' => $vat_no,
		    'status' => $status,
		    'usertype' => 10
		);
 
		$insert_status = $this->user_model->update($insert_data);
		if($insert_status)
		{
		$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details inserted successfully</span></div>');
		}
		else
		{
		$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
		}
		$ClientDetails = $this->client_model->getClientDetails();
	     //echo json_encode($ClientDetails);
		//exit;
	}

	public function updateclient_submit(){
		
		
		$client_id = $this->input->post('client_id');
		$name = $this->input->post('firm_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('emailid');
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$zip_code = $this->input->post('zip_code');
		$trading_name = $this->input->post('trading_name');
		$vat_no = $this->input->post('vat_no');
		$status = $this->input->post('status');
		
		$ccheck_email_qur = $this->db->query("select * from usermaster where email = '".$email."' and id !='".$client_id."'");
		$check_email = $ccheck_email_qur->row();
		$check_email=count($check_email);
		if($check_email > 0)
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>EmailId Already Exists</span></div>');
			redirect(BASE_URL.'client/edit?id='.$client_id);
		}
		else
		{
			$check_vat_qur = $this->db->query("select * from usermaster where vat_no = '".$vat_no."' and id !='".$client_id."'");
			$check_vat = $check_vat_qur->row();
			$check_vat=count($check_vat);
			if($check_vat > 0)
			{
				$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>VAT Number Already Exists</span></div>');
				redirect(BASE_URL.'client/edit?id='.$client_id);
			}
			else
			{
					
			if(($_SESSION['filtered_client_name1'])!='admin')
			{
				$insert_data = array(
					'name' => $name,
					'phone'=>$phone,
					'email'=>$email,
					'address1' => $address1,
					'address2' => $address2,
					'zip_code' => $zip_code,
					'trading_name' => $trading_name,
					'vat_no' => $vat_no,
					'status' => $status, 
				);
				$where_date = array(
					'id' => $client_id
				);

				$insert_status = $this->user_model->update($insert_data,$where_date);
				//if(isset($insert_status)&&($_SESSION['usertype']== 5) )
				//{
				//$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details updated successfully</span></div>');
				//redirect(BASE_URL.'client/add_client');
				//}
				if(isset($insert_status))
				{
				$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Updated successfully</span></div>');
				redirect(BASE_URL.'reports/index');
				//~ $this->session->set_flashdata('profile', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Updated successfully</span></div>');
				//~ redirect(BASE_URL.'dashboard/profile');
				}
				else
				{
				$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
				redirect(BASE_URL.'reports/edit?id='.$client_id);
				}
			}
			else
			{
			
				$insert_data = array(
					'name' => $name,
					'phone'=>$phone,
					'email'=>$email,
					'address1' => $address1,
					'address2' => $address2,
					'zip_code' => $zip_code,
					'trading_name' => $trading_name,
					'vat_no' => $vat_no,
					'status' => $status, 
						 
				);
				$where_date = array(
					'id' => $client_id
				);

				$insert_status = $this->user_model->Update($insert_data,$where_date);
				if($insert_status)
				{
					$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details Updated successfully</span></div>');
					redirect(BASE_URL.'client/add_client');
					//redirect(BASE_URL.'file/index');
				}
				else
				{
					$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
					redirect(BASE_URL.'client/edit?id='.$client_id);
				}
			}
		}
	}
		
		 
	}
	public function get_clientnames(){

	      $ClientDetails = $this->client_model->getClientDetails();
	      echo json_encode($ClientDetails);
	}
	public function get_clientname(){
		if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      //$this->client_model->get_bird($q);
	      $option_arr = array('like'=> array('firm_name' => $q, 'directors' => $q));
	     // $option_arr = array('like' => $q);
	      $ClientDetail = $this->client_model->getClientDetails('','',$option_arr);
	      //echo $this->db->last_query();
	      if($ClientDetail)
		  {
			foreach ($ClientDetail as $value) {
				$client_id = $value->client_id;
				$firm_name = $value->firm_name;
	            $directors = $value->directors;
	            $registered_address = $value->registered_address;
	             $new_row['label']=htmlentities(stripslashes($firm_name));
        		$new_row['value']=htmlentities(stripslashes($client_id));
        		$row_set[] = $new_row; //build an array

	        }
	        echo json_encode($row_set);
	      }
	    }
	}
	public function delete_client()

	{
	$client_id = $this->input->get('client_id');
	$insert_data = array(
	'status' => 0
	);
	$where_date = array(
	'client_id' => $client_id
	);
//	$insert_status=$this->client_model->deletecontact($client_id);
//$insert_status = $this->client_model->UpdateClient($insert_data,$where_date);
$insert_status = $this->client_model->DeleteClient($insert_data,$where_date);

	//print_r($insert_status);
if($insert_status)
	{
	$this->session->set_flashdata('showclients', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Deleted Successfully</span></div>');
	redirect(BASE_URL.'client/show_clients');
	}
	else
	{
	$this->session->set_flashdata('showclients', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Delete</span></div>');
	redirect(BASE_URL.'client/show_clients');
	}
	}
	
public function updateapprove_submit()
	{
		//echo "<meta http-equiv='refresh' content='0'>";
	$client_id = $this->input->post('client_id');
	$insert_data = array(

	'status'=> 1
	);
	$where_date = array(
	'id' => $client_id
	);
	$insert_status = $this->user_model->update($insert_data,$where_date);
	
	//~ if(isset($insert_status))
	//~ {
		//for mail functions
		$admininfo = $this->user_model->getAdmin();
		$adminname = $admininfo['username'];
		$adminemail = $admininfo['email'];
		$clientinfo = $this->user_model->getclient($client_id);
		//print_r($clientinfo);exit;
		$emailid=$clientinfo['email'];
		$password=$clientinfo['password'];
			$name=$clientinfo['firm_name'];
		$to = $emailid;
		 $headers ='From:'.$adminemail;
				$subject = 'Your Account Approved';
	$txt ='Welcome' . $name ."\r\n"; 
		$txt.='Your Username:    '. $emailid ."\r\n"; 
		$txt.='Your Password:    '. $password ."\r\n";
		$txt.='Thank you for Registered.   '."\r\n";
		$txt.='Contact Us at:    '.BASE_URL."\r\n";
		mail($to,$subject,$txt,$headers);
	$this->session->set_flashdata('showclients', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client approval Updated successfully</span></div>');
	redirect(BASE_URL.'client/show_clients');
	//~ }
	//~ else
	//~ {
	//~ $this->session->set_flashdata('showclients', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
	//~ redirect(BASE_URL.'client/show_clients');
	//~ }
	
	
		
	
	}


}
