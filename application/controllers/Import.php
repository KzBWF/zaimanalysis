<?php
require 'vendor/autoload.php';
use League\Csv\Reader;

class Import extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('mydata_model');
		$this->load->helper(array('form', 'url'));
	}
        public function index() {
		// @all data read
		/* read local file
		$csv = Reader::createFromPath('./Zaim.csv');
		$csv_data = $csv->fetchAll();
		$debug = $this->mydata_model->import_all($csv_data);	
		*/

		// @ 表示
		$data['title'] = "Import Data";
                $this->load->view('form/header', $data);

                $this->load->view('import');

                $this->load->view('form/rettop');
                $this->load->view('form/footer');
        }
	public function read() {
		$config['upload_path'] = '/var/tmp/';
		$config['allowed_types'] = 'csv';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('filename') )
		{
			$error = array('error' => $this->upload->display_errors());
			$data['filename'] = $error;
			$data['title'] = "Import Failure";
		}
		else
		{
			// @ $data = array('upload_data' => $this->upload->data());
			$filename = $this->upload->data('full_path');
			$csv = Reader::createFromPath($filename);
			$csv_data = $csv->fetchAll();
			$debug = $this->mydata_model->import_all($csv_data);	
			$data['filename'] = $filename;
			$data['title'] = "Import Success";
		}

		// @ 表示
                $this->load->view('form/header', $data);

                $this->load->view('import_read', $data);

		$data['place'] = "../import";
		$data['text'] = "Return Import Data";
                $this->load->view('form/retany', $data);
                $this->load->view('form/footer');
	}
}
