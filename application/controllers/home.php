<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');

		$this->load->library('form_validation');

		$this->load->model('customer_model','customer');
		$this->load->library('excel');
	}

	public function index()
	{

		if($this->session->userdata('logged_in')){
			$session = $this->session->logged_in['id'];
			$auth = $this->customer->select_auth($session);
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$cust_name = $this->customer->select_cust_name($id);
			$data['cust'] = $cust_name;
			if($auth==1){
				$data['css'] = $this->load->view('include/css',NULL,TRUE);
				$data['js'] = $this->load->view('include/js',NULL,TRUE);
				$data['navbar'] = $this->load->view('template/navbar_adm',$data,TRUE);
				$this->load->view('pageCust/home_so',$data);
			}
			elseif($auth==2){
				$data['css'] = $this->load->view('include/css',NULL,TRUE);
				$data['js'] = $this->load->view('include/js',NULL,TRUE);
				$data['navbar'] = $this->load->view('template/navbar_mgr',$data,TRUE);

				$data['footer'] = $this->load->view('template/footer',NULL,TRUE);

				$this->load->view('pageCust/home_so_mgr',$data);
			}
			else{
				$data['style'] = $this->load->view('include/style',NULL,TRUE);
				$data['script'] = $this->load->view('include/script',NULL,TRUE);

				$this->load->view('pageCust/index',$data);
			}
		}
		else{
			$data['style'] = $this->load->view('include/style',NULL,TRUE);
			$data['script'] = $this->load->view('include/script',NULL,TRUE);

			$this->load->view('pageCust/index',$data);
		}
	}


	public function login()
	{

		if(isset($_POST['signin'])){
			if(isset($_POST['username']) && isset($_POST['password'])){
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$count = $this->customer->count_login($username,$password);
				if($count ==0)
				{
					$error = "Your username or password are incorrect !";
					$this->session->set_flashdata('error',$error);

					redirect(base_url(Home));
				}
				else
				{
					$id = $this->customer->select_id($username,$password);
					$auth = $this->customer->select_auth($id);
					$sess_arr = array(
						'username' => $username,
						'id' => $id
					);

					var_dump($id,$auth);
					$this->session->set_userdata('logged_in',$sess_arr);

						redirect('Home/home_so');

				}
			}
		}
	}

	public function home_so()
	{
		if($this->session->userdata('logged_in')){
				$session = $this->session->logged_in['id'];
				$auth = $this->customer->select_auth($session);
				$id = $this->session->logged_in['id'];
				$cust_id = $this->customer->select_customer_id($id);
				$cust_name = $this->customer->select_cust_name($id);
				$data['cust'] = $cust_name;
				if($auth==1){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_adm',$data,TRUE);

					$this->load->view('pageCust/home_so',$data);
				}
				elseif($auth==2){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_mgr',$data,TRUE);

					$this->load->view('pageCust/home_so_mgr',$data);

				}
				else{
						redirect('Home');
				}
		}
		else{
			redirect('Home');
		}
	}

	public function home_price()
	{
		if($this->session->userdata('logged_in')){
				$session = $this->session->logged_in['id'];
				$auth = $this->customer->select_auth($session);
				$id = $this->session->logged_in['id'];
				$cust_id = $this->customer->select_customer_id($id);
				$cust_name = $this->customer->select_cust_name($id);
				$data['cust'] = $cust_name;
				if($auth==1){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_adm',$data,TRUE);

					$this->load->view('pageCust/home_price',$data);
				}
				elseif($auth==2){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_mgr',$data,TRUE);

					$this->load->view('pageCust/home_price',$data);

				}
				else{
						redirect('Home');
				}
		}
		else{
			redirect('Home');
		}
	}


	public function home_acc()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$cust_name = $this->customer->select_cust_name($id);
			$data['cust'] = $cust_name;
			$data['css'] = $this->load->view('include/css',NULL,TRUE);
			$data['js'] = $this->load->view('include/js',NULL,TRUE);
			$data['navbar'] = $this->load->view('template/navbar_mgr',$data,TRUE);

			$data['footer'] = $this->load->view('template/footer',NULL,TRUE);


			$this->load->view('pageCust/table_acc',$data);
		}
		else{
			redirect(base_url('Home'));
		}
	}

	public function home_import()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$cust_name = $this->customer->select_cust_name($id);
			$data['cust'] = $cust_name;
			$data['css'] = $this->load->view('include/css',NULL,TRUE);
			$data['js'] = $this->load->view('include/js',NULL,TRUE);
			$data['navbar'] = $this->load->view('template/navbar_adm',$data,TRUE);

			$data['footer'] = $this->load->view('template/footer',NULL,TRUE);


			$this->load->view('pageCust/table_import',$data);
		}
		else{
			redirect(base_url('Home'));
		}
	}

	public function home_import_retur()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$cust_name = $this->customer->select_cust_name($id);
			$data['cust'] = $cust_name;
			$data['css'] = $this->load->view('include/css',NULL,TRUE);
			$data['js'] = $this->load->view('include/js',NULL,TRUE);
			$data['navbar'] = $this->load->view('template/navbar_adm',$data,TRUE);

			$data['footer'] = $this->load->view('template/footer',NULL,TRUE);


			$this->load->view('pageCust/table_import_retur',$data);
		}
		else{
			redirect(base_url('Home'));
		}
	}

	public function logout()
	{
		if($this->session->has_userdata('logged_in'))
		{
			$this->session->unset_userdata('logged_in');
			$this->session->sess_destroy();
			redirect(base_url(Home));
		}
	}


	public function ajax_select()
	{

			$data = $this->customer->select_customer();
		  echo json_encode($data->result());
	}

	public function ajax_select_account()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_all_account(1,$cust_id);
		}
		  echo json_encode($data->result());

	}


	public function ajax_edit($id)
	{
		$data = $this->customer->select_account($id);
		echo json_encode($data->row());
	}

	public function ajax_add($auth)
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$username = $this->input->post('username');
			$pass = $this->input->post('password');
			$dat = array("res_status" => FALSE,'result'=> FALSE);
			if(!empty($username) && !empty($pass))
			{

				$data = array(
	                'USERNAME' => $this->input->post('username'),
	                'PASS' => $this->input->post('password'),
	                'CUSTOMER_ID' => $cust_id,
	                'AUTH' => $auth
	            );
	      $result = $this->customer->add_account($data);

				$this->output->set_content_type('application/json');
				$dat = array("res_status" => TRUE,'result'=>$result);
			}
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
						$result = $this->customer->edit_account($data,$id);
						$dat = array("res_status" => TRUE,'result'=>$result);
				}
 			 echo json_encode($dat);
	}


	public function ajax_delete_so()
	{
				$info = $this->input->post('info');
				$dat = array("res_status" => FALSE,'result'=> FALSE);

					$id = $this->session->logged_in['id'];
					$cust_id = $this->customer->select_customer_id($id);
				if(!empty($info))
				{
						foreach ($info as $value) {
							$result = $this->customer->delete_so($value[0],$value[1],$cust_id);
						}
						$dat = array("res_status" => TRUE,'result'=>$result);
				}
 			 echo json_encode($dat);
	}

	public function ajax_accept_so_all()
	{
				$info = $this->input->post('info');
				$dat = array("res_status" => FALSE,'result'=> FALSE);
				$id = $this->session->logged_in['id'];
				$cust_id = $this->customer->select_customer_id($id);

				if(!empty($info))
				{
						foreach ($info as $value) {
							$result = $this->customer->accept_so($value[0],$value[1],$cust_id);
						}
						$dat = array("res_status" => TRUE,'result'=>$result);
				}
 			 echo json_encode($dat);
	}

	public function ajax_cancel_so_all()
	{
				$info = $this->input->post('info');
				$dat = array("res_status" => FALSE,'result'=> FALSE);
				$id = $this->session->logged_in['id'];
				$cust_id = $this->customer->select_customer_id($id);

				if(!empty($info))
				{
						foreach ($info as $value) {
							$result = $this->customer->cancel_so($value[0],$value[1],$cust_id);
						}
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

	public function action(){
		  //$this->load->library("excel");
			$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
			$rendererLibrary = 'tcPDF.php';
			$rendererLibraryPath = 'C:\xampp\htdocs\application\libraries\dompdf';

			$object = new PHPExcel();

		  $object->setActiveSheetIndex(0);

		  $table_columns = array("NAMA CUSTOMER", "<=0", "1 s/d 30", "31 s/d 60", ">60","JUMLAH");

		  $column = 0;
			$style_col_no = array(
      	'font' => array('bold' => true), // Set font nya jadi bold
      	'alignment' => array(
        	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
        	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      	)
    	);
			$style_col = array(
      	'font' => array('bold' => true), // Set font nya jadi bold
      	'alignment' => array(
        	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      	),
      	'borders' => array(
        	'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        	'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        	'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        	'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      	)
    	);
			$style_row = array(
      	'font' => array('bold' => false), // Set font nya jadi bold
      	'alignment' => array(
        	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
        	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      	),
      	'borders' => array(
        	'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        	'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        	'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        	'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      	)
    	);
			$style_row_right = array(
      	'font' => array('bold' => true), // Set font nya jadi bold
      	'alignment' => array(
        	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
        	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      	),
      	'borders' => array(
        	'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        	'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        	'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        	'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      	)
    	);
			$style_row_left = array(
				'font' => array('bold' => false), // Set font nya jadi bold
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);
			$date = date('d F Y');
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'PT PRATAPA NIRMALA');
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'LAPORAN REKAP ANALISA FAKTUR');
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'Per ' . $date);
			$object->getActiveSheet()->getStyle('A'. 1)->applyFromArray( $style_col_no);
			$object->getActiveSheet()->getStyle('A'. 2)->applyFromArray( $style_col_no);
			$object->getActiveSheet()->getStyle('A'. 3)->applyFromArray( $style_col_no);

		  foreach($table_columns as $field)
		  {
		   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 4, $field);
			 //$object->getActiveSheet()->getStyle($column. '1')->applyFromArray( $style_col);
		   $column++;
		  }

			$object->getActiveSheet()->getStyle('A'. 4)->applyFromArray( $style_col);
			$object->getActiveSheet()->getStyle('B'. 4)->applyFromArray( $style_col);
			$object->getActiveSheet()->getStyle('C'. 4)->applyFromArray( $style_col);
			$object->getActiveSheet()->getStyle('D'. 4)->applyFromArray( $style_col);
			$object->getActiveSheet()->getStyle('E'. 4)->applyFromArray( $style_col);
			$object->getActiveSheet()->getStyle('F'. 4)->applyFromArray( $style_col);

		  $faktur_data = $this->customer->select_rekapFaktur();

		  $excel_row = 5;
			$sum_cat1 = 0;
			$sum_cat2 = 0;
			$sum_cat3 = 0;
			$sum_cat4 = 0;
			$sum = 0;
		  foreach($faktur_data as $row)
		  {
		   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->NAME);
		   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, number_format($row->CAT1,2). " ");
		   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, number_format($row->CAT2,2). " ");
		   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, number_format($row->CAT3,2). " ");
		   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, number_format($row->CAT4,2). " ");
			 $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($row->TOTAL,2). " ");

			 $object->getActiveSheet()->getStyle('A'. $excel_row)->applyFromArray($style_row_left );
			 $object->getActiveSheet()->getStyle('B'. $excel_row)->applyFromArray( $style_row);
			 $object->getActiveSheet()->getStyle('C'. $excel_row)->applyFromArray( $style_row);
			 $object->getActiveSheet()->getStyle('D'. $excel_row)->applyFromArray( $style_row);
			 $object->getActiveSheet()->getStyle('E'. $excel_row)->applyFromArray( $style_row);
			 $object->getActiveSheet()->getStyle('F'. $excel_row)->applyFromArray( $style_row);
			 $object->getActiveSheet()->getStyle('A'. $excel_row)->getAlignment()->setIndent(1);
			 $object->getActiveSheet()->getStyle('B'. $excel_row)->getAlignment()->setIndent(1);
			 $object->getActiveSheet()->getStyle('C'. $excel_row)->getAlignment()->setIndent(1);
			 $object->getActiveSheet()->getStyle('D'. $excel_row)->getAlignment()->setIndent(1);
			 $object->getActiveSheet()->getStyle('E'. $excel_row)->getAlignment()->setIndent(1);
			 $object->getActiveSheet()->getStyle('F'. $excel_row)->getAlignment()->setIndent(1);
			 $sum_cat1 = $sum_cat1 + $row->CAT1;
			 $sum_cat2 = $sum_cat2 + $row->CAT2;
			 $sum_cat3 = $sum_cat3 + $row->CAT3;
			 $sum_cat4 = $sum_cat4 + $row->CAT4;
			 $excel_row++;
		 }
		 $sum = $sum_cat1 + $sum_cat2 + $sum_cat3 + $sum_cat4;
		 $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'TOTAL');
		 $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, number_format($sum_cat1,2) . " " );
		 $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, number_format($sum_cat2,2). " ");
		 $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, number_format($sum_cat3,2). " ");
		 $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, number_format($sum_cat4,2). " ");
		 $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($sum,2). " ");
		$object->getActiveSheet()->getStyle('A'. $excel_row)->applyFromArray( $style_col);
		 $object->getActiveSheet()->getStyle('B'. $excel_row)->applyFromArray( $style_row_right);
		 $object->getActiveSheet()->getStyle('C'. $excel_row)->applyFromArray( $style_row_right);
		 $object->getActiveSheet()->getStyle('D'. $excel_row)->applyFromArray( $style_row_right);
		 $object->getActiveSheet()->getStyle('E'. $excel_row)->applyFromArray( $style_row_right);
		 $object->getActiveSheet()->getStyle('F'. $excel_row)->applyFromArray( $style_row_right);
		 $object->getActiveSheet()->getStyle('A'. $excel_row)->getAlignment()->setIndent(1);
		 $object->getActiveSheet()->getStyle('B'. $excel_row)->getAlignment()->setIndent(1);
		 $object->getActiveSheet()->getStyle('C'. $excel_row)->getAlignment()->setIndent(1);
		 $object->getActiveSheet()->getStyle('D'. $excel_row)->getAlignment()->setIndent(1);
		 $object->getActiveSheet()->getStyle('E'. $excel_row)->getAlignment()->setIndent(1);
		 $object->getActiveSheet()->getStyle('F'. $excel_row)->getAlignment()->setIndent(1);
		 $excel_row++;

		 $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,' ');
		 $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, ' ');
		 $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, ' ');
		 $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, ' ');


		$object->getActiveSheet()->setShowGridlines(false);
		if (!PHPExcel_Settings::setPdfRenderer(
		$rendererName,
		$rendererLibraryPath
	)) {
	die(
		'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
		'<br />' .
		'at the top of this script as appropriate for your directory structure'
	);
}
			for($col = 'A'; $col !== 'G'; $col++) {
    		$object->getActiveSheet()
        	->getColumnDimension($col)
        	->setAutoSize(true);
			}
			$object->getActiveSheet()
    			->getPageMargins()->setTop(0.75);
			$object->getActiveSheet()
			    ->getPageMargins()->setRight(0);
			$object->getActiveSheet()
			    ->getPageMargins()->setLeft(0.1);
			$object->getActiveSheet()
			    ->getPageMargins()->setBottom(3);
			$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A3);

			$pdfRendererClassFile = PHPExcel_Settings::getPdfRendererPath() . '/dompdf/dompdf_config.inc.php';
			$object_writer = new PHPExcel_Writer_PDF($object);
			$object_writer->setSheetIndex(0);
			$object_writer->save('C:\xampp\htdocs\assets\upload\PN - Laporan Rekap Analisa Faktur ' . $date.'.pdf');




			 $filename = 'PN - Laporan Rekap Analisa Faktur ' . $date.'.pdf';
			 $path = 'C:\xampp\htdocs\assets\upload';
			 $file = $path . "/" . $filename;

			 $mailto = "peter@fahrenheit.co.id";
			 $subject = 'Update Piutang Customer Per ' . $date;
			 $message = "
Dengan Hormat,



All


Berikut update piutang customer per tanggal ". $date ."
Terima kasih.




Regards,


Monica

";

			 $content = file_get_contents($file);
			 $content = chunk_split(base64_encode($content));

			 // a random hash will be necessary to send mixed content
			 $separator = md5(time());

			 // carriage return type (RFC)
			 $eol = "\r\n";

			 // main header (multipart mandatory)
			 $headers = "From: pnpiutang@gmail.com " . $eol;
			 $headers .= "CC: daniel_effendy@yahoo.com;juhnti@fahrenheit.co.id;heitax88@yahoo.com;ingrid@fahrenheit.co.id;monica.maria@fahrenheit.co.id;yustinus_vernanda@fahrenheit.co.id" . $eol;
			 $headers .= "MIME-Version: 1.0" . $eol;
			 $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
			 $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
			 $headers .= "This is a MIME encoded message." . $eol;

			 // message
			 $body = "--" . $separator . $eol;
			 $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
			 $body .= "Content-Transfer-Encoding: 8bit" . $eol;
			 $body .= $message . $eol .$eol;

			 // attachment
			 $body .= "--" . $separator . $eol;
			 $body .= "Content-Type: application/vnd.ms-excel; name=\"" . $filename . "\"" . $eol;
			 $body .= "Content-Disposition: attachment;size= " .filesize($file) ." ;filename=\"" . $filename . "\"" .$eol;
			 $body .= "Content-Transfer-Encoding: base64" . $eol. $eol;
			 $body .= $content . $eol;
			 $body .= "--" . $separator . "--";

			 //SEND Mail
			 if (mail($mailto, $subject, $body, $headers)) {
					 echo "mail send ... OK"; // or use booleans here
			 } else {
					 echo "mail send ... ERROR!";
					 print_r( error_get_last() );
			 }

	}

	public function import()
	{
				if(isset($_FILES["file"]["name"])){
					$id = $this->session->logged_in['id'];
					$cust_id = $this->customer->select_customer_id($id);
					$path = $_FILES["file"]["tmp_name"];

					$inputFileType = PHPExcel_IOFactory::identify($path);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$object = $objReader->load($path);
					foreach($object->getWorksheetIterator() as $worksheet)
					{
						$highestRow = $worksheet->getHighestRow();
						$highestColumn = $worksheet->getHighestColumn();
						for($row=1; $row<=$highestRow; $row++)
						{
							$noPO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							if($noPO==NULL){
									break;
							}
							else{
							$tanggal = ($worksheet->getCellByColumnAndRow(1, $row)->getValue());
							$branch = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							if($cust_id == 1001 || $cust_id == 1301){
								$branch = $this->customer->select_city($branch,$cust_id);

							}
							$product = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
							if($cust_id != 1301)
							{
								$pricelist = $this->customer->select_price_item_id($cust_id,'D'.$product);
								$uom = $this->customer->select_uom('D'.$product,$cust_id);
							}
							else{
								$pricelist = $this->customer->select_price_item_id($cust_id,$product);
								$uom = $this->customer->select_uom($product,$cust_id);
							}
							$qty = $worksheet->getCellByColumnAndRow(4, $row)->getValue();


							$order_type = $this->customer->select_order_type_id($cust_id,$pricelist);
							if(!empty($noPO))
								{
									$value[] = array(
										'noPO'		=>	$noPO,
										'tanggal'	=>	date('Y/m/d', PHPExcel_Shared_Date::ExcelToPHP($tanggal)),
										'branch'	=>	$branch,
										'product' =>$product,
										'qty' => $qty,
										'uom' => $uom,
										'orderType' => $order_type,
										'pricelist' => $pricelist
									);
									if($cust_id != 1301){
										$product = 'D'.$product;
									}
									$check = $this->customer->check_import($product,$order_type,$pricelist,$cust_id,$noPO);
									if($check==1){
										$status[] = array('status'=>'BENAR');}
									else{
										$status[] = array('status'=>'');
									}

								}
							}
						}
					}
					$result = $this->customer->select_orderType($cust_id);
					$result_price = $this->customer->select_pricelist($cust_id);

					$result1 = $this->customer->select_tujuan();
					$res_status = TRUE;
				}
				else{
					$res_status = FALSE;
				}
			$data = array('res_status'=>$res_status,'value'=>$value,'orderType'=>$result,'pricelist'=>$result_price,'status'=>$status,'tujuan'=>$result1);
		  echo json_encode($data);
	}

	public function import_form()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$ide = $this->customer->count_so() + 1;
				$arr = $_POST['noPO'];
				$no_po = array();
				for($x=0;$x<count($arr);$x++){
					$product = $_POST['product'][$x];
					if($cust_id != 1301)
					{
						$product = 'D'.$product;
					}
					$order_type = strtoupper($_POST['orderType'][$x]);
					$pricelist = ($_POST['pricelist'][$x]);
					$check = $this->customer->check_import2($product,$order_type,$pricelist,$cust_id);
					$name_product = $this->customer->select_name_product($product);
					$data = array(
									'PO_NO' => $_POST['noPO'][$x],
									'DATE_ORDER' => date("d-M-Y", strtotime($_POST['tanggal'][$x])),
									'BRANCH' => ucwords(strtolower($_POST['branch'][$x])),
									'PRODUCT' => $product,
									'NAME_PRODUCT' => $name_product,
									'QUANTITY' => $_POST['qty'][$x],
									'ORDER_TYPE' => $_POST['orderType'][$x],
									'USERNM' => $id,
									'FLAG' => 0,
									'CUSTOMER_ID' => $cust_id,
									'CATEGORY_ORDER' => 'order',
									'CREATED_BY' => 1,
									'PRICELIST' => $_POST['pricelist'][$x],
									'SHIP_FROM_ID' => $this->customer->select_ship($_POST['orderType'][$x],$_POST['pricelist'][$x],$cust_id),
									'IDENTIFICATION' => $ide,
									'UOM' => $_POST['uom'][$x]
							);

						$result = $this->customer->insert_import($data);
					if($this->customer->check_line($cust_id,$_POST['noPO'][$x],$ide)==0){
						 $check = 0;
					}
					if($check==1){
					}
					else{
							$no_po[] = $_POST['noPO'][$x];
					}

				}
				for($a=0;$a<count($no_po);$a++)
				{
					$result = $this->customer->error_so($no_po[$a],$ide,$cust_id);
				}
			}
		redirect(base_url('Home'));
	}

	public function ajax_check($id)
	{
		$dat;
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$product = $_POST['product'];
			if($cust_id != 1301)
			{
				$product = 'D'.$product;
			}
			$noPO = $_POST['noPO'];
			/*$order_type = strtoupper($order_type);
			$pricelist = strtoupper($pricelist);*/


			$pricelist = $this->customer->select_price_item_id($cust_id,$product);
			$order_type = $this->customer->select_order_type_id($cust_id,$pricelist);
				$check = $this->customer->check_import($product,$order_type,$pricelist,$cust_id,$noPO);
				$uom = $this->customer->select_uom($product,$cust_id);
				if($check==1){
					$status = array('BENAR');}
				else{
					$status = array('');
				}
			 $dat = array("res_status" => $status,"uom"=>$uom,"pricelist"=>$pricelist,"order_type"=>$order_type,"noPO"=>$noPO);
			 echo json_encode($dat);
		 }
		  //$dat = array("res_status" => 'sfsad');

	}


	public function ajax_select_so()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_so_admin($id);
		}
		echo json_encode($data);
	}

	public function ajax_select_price()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_price_item($cust_id);
		}
		echo json_encode($data);
	}

	public function ajax_select_detail($po_no,$ide)
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_so_detail($po_no,$ide,$cust_id);
		}
		//var_dump($create_date);
		  echo json_encode($data->result());
	}

	public function ajax_retur_detail($po_no,$ide)
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_retur_detail($po_no,$ide,$cust_id);
		}
		//var_dump($create_date);
		  echo json_encode($data->result());
	}

	public function ajax_select_so_mgr()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_so_mgr($cust_id);
		}
		echo json_encode($data);
	}


	public function ajax_accept($po_no,$ide)
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->accept_so($po_no,$ide,$cust_id);
		}
		echo json_encode($data);
	}

	public function ajax_cancel($po_no,$ide)
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->cancel_so($po_no,$ide,$cust_id);
		}
		echo json_encode($data);
	}


	public function ajax_accept_retur($po_no,$ide)
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			if($cust_id == 1301)
			$data = $this->customer->accept_retur($po_no,$ide,$cust_id);
			else $data = $this->customer->accept_so($po_no,$ide,$cust_id);
		}
		echo json_encode($data);
	}

	public function ajax_cancel_retur($po_no,$ide)
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			if($cust_id == 1301)
			$data = $this->customer->cancel_retur($po_no,$ide,$cust_id);
			else $data = $this->customer->cancel_so($po_no,$ide,$cust_id);
		}
		echo json_encode($data);
	}


	public function import_retur()
	{
					if(isset($_FILES["file"]["name"])){

					$id = $this->session->logged_in['id'];
					$cust_id = $this->customer->select_customer_id($id);
					$path = $_FILES["file"]["tmp_name"];
					$file_name = $_FILES["file"]["name"];
					$inputFileType = PHPExcel_IOFactory::identify($path);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$object = $objReader->load($path);

					$config['upload_path']          = $_SERVER['DOCUMENT_ROOT'] .'/assets/upload/';
    			$config['allowed_types']        = 'xls|xlsx';
    			$config['file_name']            = $file_name;
    			$config['overwrite']						= true;
    			$config['max_size']             = 20480000; // 1MB
    			// $config['max_width']            = 1024;
    			// $config['max_height']           = 768;

    			$this->load->library('upload', $config);

    			if ($this->upload->do_upload('file')) {
        		$file = $this->upload->data();
						$file_name = $file['file_name'];
    			}


					foreach($object->getWorksheetIterator() as $worksheet)
					{
						$highestRow = $worksheet->getHighestRow();
						$highestColumn = $worksheet->getHighestColumn();
						$start = 1;
						if($cust_id == 1301)
						{
							$start = 7;
						}
						for($row=$start; $row<=$highestRow; $row++)
						{

							if($cust_id != 1301)
							{
								$noPO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
								if($noPO==NULL){
										break;
								}
								$tanggal = ($worksheet->getCellByColumnAndRow(1, $row)->getValue());
								$branch = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
								if($cust_id == 1001){
									$branch = $this->customer->select_city($branch,$cust_id);
								}
								$ba = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
								$skb = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
								$product = ($worksheet->getCellByColumnAndRow(5, $row)->getValue());
								$qty = ($worksheet->getCellByColumnAndRow(6, $row)->getValue());
								$batch = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
								$exp = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
								$ket = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
								$outlet = ($worksheet->getCellByColumnAndRow(10, $row)->getValue());
								$cn = ($worksheet->getCellByColumnAndRow(11, $row)->getValue());
								$tipe = strtoupper($worksheet->getCellByColumnAndRow(12, $row)->getValue());

								$uom = $this->customer->select_uom('D'.$product,$cust_id);
								$branch = ucwords(strtolower($branch));
							}
							else{
								$noPO = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
								if($noPO==NULL){
										break;
								}
								$tanggal = ($worksheet->getCellByColumnAndRow(1, $row)->getValue());
								$branch = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
								$ba = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
								$skb = '';
								$product = ($worksheet->getCellByColumnAndRow(4, $row)->getValue());
								$qty = ($worksheet->getCellByColumnAndRow(7, $row)->getValue());
								$batch = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
								$exp = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
								$ket = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
								$outlet = ($worksheet->getCellByColumnAndRow(11, $row)->getValue());
								$cn = '';
								$tipe = strtoupper($worksheet->getCellByColumnAndRow(13, $row)->getValue());

								$uom = $this->customer->select_uom($product,$cust_id);
								$batch = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i',' ',$batch);
							}

							if($tipe == 'RPC'){
								$tipe = 'RETUR REPACK';
							}
							else if($tipe == 'REG')
							{
								$tipe = 'RETUR REGULAR';
							}
							if(!empty($noPO))
								{
									$value[] = array(
										'noPO'		=>	$noPO,
										'tanggal'	=>	date('Y/m/d', PHPExcel_Shared_Date::ExcelToPHP($tanggal)),
										'branch'	=>	$branch,
										'ba' =>$ba,
										'skb' => $skb,
										'product' => $product,
										'qty' => $qty,
										'uom' => $uom,
										'batch' =>$batch,
										'exp' => date('Y/m/d', PHPExcel_Shared_Date::ExcelToPHP($exp)),
										'ket' => strtoupper($ket),
										'outlet' => $outlet,
										'cn' => $cn,
										'tipe' => strtoupper($tipe)
									);


								}
						}
					}
					$result = $this->customer->select_TypeRetur();
					$result1 = $this->customer->select_tujuan();
					$result2 = $this->customer->select_keterangan();
					$res_status = TRUE;
				}
				else{
					$res_status = FALSE;
				}
			$data = array('res_status'=>$res_status,
				'value'=>$value,'orderType'=>$result,'tujuan'=>$result1,
				'ket'=>$result2,'cust_id'=>$cust_id,'file_name'=>$file_name);
			echo json_encode($data);
	}

	public function import_form_retur()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$ide = $this->customer->count_retur() + 1;
				$arr = $_POST['noPO'];
				$no_po = array();
				$error = 0;
				for($x=0;$x<count($arr);$x++){
					$product = $_POST['product'][$x];
					$branch = $_POST['branch'][$x];
					if($cust_id != 1301)
					{
						$product = 'D'.$product;
						$branch = ucwords(strtolower($branch));
					}
					$price = $this->customer->select_price($product,$_POST['batch'][$x]);
					$name_product = $this->customer->select_name_product($product);
					$data = array(
									'PO_NO' => $_POST['noPO'][$x],
									'DATE_ORDER' => date("d-M-Y", strtotime($_POST['tanggal'][$x])),
									'BRANCH' => $branch,
									'BA' => $_POST['ba'][$x],
									'SKB' => $_POST['skb'][$x],
									'PRODUCT' => $product,
									'NAME_PRODUCT' => $name_product,
									'QUANTITY' => $_POST['qty'][$x],
									'ORDER_TYPE' => strtoupper($_POST['orderType'][$x]),
									'BATCH_NO' => $_POST['batch'][$x],
									'EXPIRED' => date("d-M-Y", strtotime($_POST['exp'][$x])),
									'REASON' => $_POST['ket'][$x],
									'OUTLET' => $_POST['outlet'][$x],
									'NO_CN' => $_POST['cn'][$x],
									'USERNM' => $id,
									'FLAG' => 0,
									'CUSTOMER_ID' => $cust_id,
									'CATEGORY_ORDER' => 'return',
									'CREATED_BY' => 1,
									'PRICELIST' => $price,
									'SHIP_FROM_ID' => $this->customer->select_ship_retur($product),
									'IDENTIFICATION' => $ide,
									'UOM' => $_POST['uom'][$x],
									'FILE_NAME' => $_POST['file_name'][$x]
							);
						$result = $this->customer->insert_import($data);


						if(is_null($price))
						{
								$no_po[] = $_POST['noPO'][$x];
								$error = 1;
						}
						else if($this->customer->check_line($cust_id,$_POST['noPO'][$x],$ide)==0){
							$no_po[] = $_POST['noPO'][$x];
							$error = 1;
						}
					}

						for($a=0;$a<count($no_po);$a++)
						{
							$result = $this->customer->error_retur($no_po[$a],$ide,$cust_id);
						}

			}


		redirect(base_url('Home/home_retur'));
	}

	public function home_retur()
	{
		if($this->session->userdata('logged_in')){
				$session = $this->session->logged_in['id'];
				$auth = $this->customer->select_auth($session);
				$id = $this->session->logged_in['id'];
				$cust_id = $this->customer->select_customer_id($id);
				$cust_name = $this->customer->select_cust_name($id);
				$data['cust'] = $cust_name;
				if($auth==1){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_adm',$data,TRUE);

					$this->load->view('pageCust/home_retur',$data);
				}
				elseif($auth==2){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_mgr',$data,TRUE);

					$this->load->view('pageCust/home_retur_mgr',$data);

				}
				else{
						redirect('Home');
				}
		}
		else{
			redirect('Home');
		}
	}

	public function ajax_select_retur()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_retur_admin($id);
		}
		echo json_encode($data);
	}

	public function ajax_select_retur_mgr()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_retur_mgr($cust_id);
		}
		echo json_encode($data);
	}

	public function ajax_select_invoice()
	{
		if($this->session->userdata('logged_in')){
			$id = $this->session->logged_in['id'];
			$cust_id = $this->customer->select_customer_id($id);
			$data = $this->customer->select_invoice($cust_id);
		}
		echo json_encode($data);
	}

	public function home_invoice()
	{
		if($this->session->userdata('logged_in')){
				$session = $this->session->logged_in['id'];
				$auth = $this->customer->select_auth($session);
				$id = $this->session->logged_in['id'];
				$cust_id = $this->customer->select_customer_id($id);
				$cust_name = $this->customer->select_cust_name($id);
				$data['cust'] = $cust_name;
				if($auth==1){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_adm',$data,TRUE);

					$this->load->view('pageCust/home_invoice',$data);
				}
				elseif($auth==2){
					$data['css'] = $this->load->view('include/css',NULL,TRUE);
					$data['js'] = $this->load->view('include/js',NULL,TRUE);
					$data['navbar'] = $this->load->view('template/navbar_mgr',$data,TRUE);

					$this->load->view('pageCust/home_invoice_mgr',$data);

				}
				else{
						redirect('Home');
				}
		}
		else{
			redirect('Home');
		}
	}

}
