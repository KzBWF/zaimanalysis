<?php

class Yearly extends CI_Controller {
	private $year;
	public function __construct() {
		parent::__construct();
		$this->load->model('mydata_model');
		$this->year = idate("Y");
	}
        public function index() {
		// @ データ読込
		if ( $this->input->get('next', FALSE) != NULL ) {
			$next = $this->input->get('next', FALSE);
			$year = $next + 1;
			$this->year = $year;
		}
		else if ( $this->input->get('prev', FALSE) != NULL ){
			$prev = $this->input->get('prev', FALSE);
			$year = $prev - 1;
			$this->year = $year;
		}
		$year = $this->year;

		// @ Total payment per month
		$result = $this->mydata_model->getpay_year($year);
		$objects = $result->result('object');
		$totalpay = 0;
		foreach($objects as $obj) {
			$totalpay += $obj->支出;
		}
		$data['payment'] = $result->result('object');

		// @ Total income per month
		$result = $this->mydata_model->getinc_year($year);
		$objects = $result->result('object');
		$totalinc = 0;
		foreach($objects as $obj) {
			$totalinc += $obj->収入;
		}
		$data['income'] = $result->result('object');

		// @ Balance of payments per month
		$balance = $totalinc - $totalpay;

		// @ 表示
		$data['title'] = "Yearly Display";
                $this->load->view('form/header', $data);

		$data['balance'] = $balance;
		$data['totalinc'] = $totalinc;
		$data['totalpay'] = $totalpay;
		$data['year'] = $this->year;
                $this->load->view('yearly', $data);

                $this->load->view('form/rettop');
                $this->load->view('form/footer');
        }
}
