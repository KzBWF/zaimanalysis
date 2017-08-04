<?php

class Monthly extends CI_Controller {
	private $year;
	private $mon;
	public function __construct() {
		parent::__construct();
		$this->load->model('mydata_model');
		$this->year = idate("Y");
		$this->mon = idate("m");
	}
        public function index() {
		// @ データ読込
		if ( $this->input->get('year', FALSE) != NULL ) {
			$this->year = $this->input->get('year', FALSE);
		}
		if ( $this->input->get('next', FALSE) != NULL ) {
			$next = $this->input->get('next', FALSE);
			$mon = $next + 1;
			if ( $mon > 12 ) {
				$this->year++;
				$mon = 1;
			}
			$this->mon = $mon;
		}
		else if ( $this->input->get('prev', FALSE) != NULL ){
			$prev = $this->input->get('prev', FALSE);
			$mon = $prev - 1;
			if ( $mon < 1 ) {
				$this->year--;
				$mon = 12;
			}
			$this->mon = $mon;
		}
		$year = $this->year;
		$mon = $this->mon;

		// @ Total payment per month
		$result = $this->mydata_model->getpay_mon($mon, $year);
		$objects = $result->result('object');
		$totalpay = 0;
		foreach($objects as $obj) {
			$totalpay += $obj->支出;


		}
		$data['payment'] = $result->result('object');

		// @ Total income per month
		$result = $this->mydata_model->getinc_mon($mon, $year);
		$objects = $result->result('object');
		$totalinc = 0;
		foreach($objects as $obj) {
			$totalinc += $obj->収入;
		}
		$data['income'] = $result->result('object');

		// @ Balance of payments per month
		$balance = $totalinc - $totalpay;

		// @ 表示
		$data['title'] = "Monthly Display";
                $this->load->view('form/header', $data);

		$data['balance'] = $balance;
		$data['totalinc'] = $totalinc;
		$data['totalpay'] = $totalpay;
		$data['month'] = $this->mon;
		$data['year'] = $this->year;
                $this->load->view('monthly', $data);

                $this->load->view('form/rettop');
                $this->load->view('form/footer');
        }
}
