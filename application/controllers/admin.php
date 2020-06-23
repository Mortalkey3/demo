<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');

		$this->load->library('form_validation');
		$this->load->model('account_model','account');
	}

	public function index()
	{
		if($this->session->userdata('log_in')){

			redirect('Admin/home_so');
		}
		else{
			$data['style'] = $this->load->view('include/style',NULL,TRUE);
			$data['script'] = $this->load->view('include/script',NULL,TRUE);

			$this->load->view('page/index_admin',$data);
		}
	}

	/*public function home()
	{
		if($this->session->userdata('log_in')){
			$data['css'] = $this->load->view('include/css',NULL,TRUE);
			$data['js'] = $this->load->view('include/js',NULL,TRUE);
			$data['navbar'] = $this->load->view('template/navbar',NULL,TRUE);
			$this->load->view('page/home_admin',$data);
		}
		else{
			redirect(base_url('Admin'));
		}
	}*/

	public function login()
	{

		if(isset($_POST['signin'])){
			if(isset($_POST['username']) && isset($_POST['password'])){
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if(strcmp($username, "admin")!=0 && strcmp($password,"AFHR12345")!=0)
			{
				$error = "Your username or password are incorrect !";
				$this->session->set_flashdata('error',$error);

				redirect(base_url(Admin));
			}
			else
			{


				$sess_arr = array(
					'username' => $username
				);

				$this->session->set_userdata('log_in',$sess_arr);
				redirect('Admin/home_so');
			}

			}
		}

	}

	public function logout()
	{
		if($this->session->has_userdata('log_in'))
		{
			$this->session->unset_userdata('log_in');
			$this->session->sess_destroy();
			redirect(base_url(Admin));
		}
	}

	public function formAdmin()
	{
		if($this->session->userdata('log_in')){
			$data['css'] = $this->load->view('include/css',NULL,TRUE);
			$data['js'] = $this->load->view('include/js',NULL,TRUE);
			$data['navbar'] = $this->load->view('template/navbar',NULL,TRUE);
			$query = $this->account->select_all_account(1);
			$data['query'] = $query->result();
			$query1 = $this->db->query('select hca.ACCOUNT_NUMBER cust_id,hop.ORGANIZATION_NAME cust_name
			from HZ_ORGANIZATION_PROFILES hop join HZ_CUST_ACCOUNTS hca on hca.party_id = hop.party_id order by cust_name');
			$data['cust'] = $query1->result();

			$this->load->view('page/table_acc_admin',$data);
		}
		else{
			redirect(base_url('Admin'));
		}
	}

	public function formManager()
	{
		if($this->session->userdata('log_in')){
			$data['css'] = $this->load->view('include/css',NULL,TRUE);
			$data['js'] = $this->load->view('include/js',NULL,TRUE);
			$data['navbar'] = $this->load->view('template/navbar',NULL,TRUE);
			$query = $this->account->select_all_account(2);
			$data['query'] = $query->result();
			$query1 = $this->db->query('select hca.ACCOUNT_NUMBER cust_id,hop.ORGANIZATION_NAME cust_name
			from HZ_ORGANIZATION_PROFILES hop join HZ_CUST_ACCOUNTS hca on hca.party_id = hop.party_id order by cust_name');
			$data['cust'] = $query1->result();

			$this->load->view('page/table_acc_mgr',$data);
		}
		else{
			redirect(base_url('Admin'));
		}
	}

	public function ajax_select()
	{

			$data = $this->account->select_customer();
		  echo json_encode($data->result());
	}

	public function ajax_select_account()
	{

			$data = $this->account->select_all_account(1);
		  echo json_encode($data->result());
	}

	public function ajax_select_account_mgr()
	{

			$data = $this->account->select_all_account(2);
		  echo json_encode($data->result());
	}

	public function ajax_edit($id)
	{
		$data = $this->account->select_account($id);
		echo json_encode($data->row());
	}

	public function ajax_add($auth)
	{

			$username = $this->input->post('username');
			$pass = $this->input->post('password');
			$dat = array("res_status" => FALSE,'result'=> FALSE);
			if(!empty($username) && !empty($pass))
			{
				$data = array(
	                'USERNAME' => $this->input->post('username'),
	                'PASS' => $this->input->post('password'),
	                'CUSTOMER_ID' => $this->input->post('customer'),
	                'AUTH' => $auth
	            );
	      $result = $this->account->add_account($data);

				$this->output->set_content_type('application/json');
				$dat = array("res_status" => TRUE,'result'=>$result);
			}
				echo json_encode($dat);


	}

	public function ajax_update($auth)
	{
				$username = $this->input->post('username');
				$pass = $this->input->post('password');
				$dat = array("res_status" => FALSE,'result'=> FALSE);
				if(!empty($username) && !empty($pass))
				{$data = array(
                'USERNAME' => $this->input->post('username'),
                'PASS' => $this->input->post('password'),
								'CUSTOMER_ID' => $this->input->post('customer')
            );
						$id = $this->input->post('acc_id');
						$result = $this->account->edit_account($data,$id);
						$dat = array("res_status" => TRUE,'result'=>$result);
				}
 			 echo json_encode($dat);
	}

	public function ajax_delete($id)
	{

			 $this->db->where('ID', $id);
			 $this->db->delete('PN_EORDER_LOGIN');
			 $dat[] = array("res_status" => TRUE);

			 echo json_encode($dat);
	}

	  public function _validate()
    {
			if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
		}


		public function home_so()
		{
			if($this->session->userdata('log_in')){
					$session = $this->session->logged_in['id'];

					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar',NULL,TRUE);

						$this->load->view('page/home_so',$data);

			}
			else{
				redirect('Admin');
			}
		}
		public function home_retur()
		{
			if($this->session->userdata('log_in')){
					$session = $this->session->logged_in['id'];

					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar',NULL,TRUE);

						$this->load->view('page/home_retur',$data);

			}
			else{
				redirect('Admin');
			}
		}

		public function ajax_select_so()
		{

				$id = $this->session->logged_in['id'];
				$data = $this->account->select_so();

			echo json_encode($data);
		}

		public function ajax_select_detail($po_no,$ide,$cust_id)
		{

				$id = $this->session->logged_in['id'];
				$data = $this->account->select_so_detail($po_no,$ide,$cust_id);


			  echo json_encode($data->result());
		}

		public function ajax_select_retur()
		{

				$id = $this->session->logged_in['id'];
				$data = $this->account->select_retur();
					echo json_encode($data);
		}

		public function ajax_retur_detail($po_no,$ide,$cust_id)
		{

				$data = $this->account->select_retur_detail($po_no,$ide,$cust_id);

			  echo json_encode($data->result());
		}
}
