<?php

class Weekly extends CI_Controller {
	private $year;
	private $mon;
	private $week;
	private $maxweek;
	private $weekflg;
	// @ 指定月度の週数
	private function getmax($mon, $year) {
		if ( $mon == 1 ) {
			$first = date('W', mktime(0,0,0, 12, 26, $year-1));
			$temp = date('W', mktime(0,0,0, 1, 2, $year));
			$first = ($temp > $first) ? -1 : 0;
			$wka = date('w', mktime(0,0,0, 12, 26, $year-1));
		}
		else {
			$first = date('W', mktime(0,0,0, $mon-1,26, $year));
			$wka = date('w', mktime(0,0,0, $mon-1, 26, $year));
		}
		$last = date('W', mktime(0,0,0, $mon, 25, $year));
		$wkb = date('w', mktime(0,0,0, $mon, 25, $year));
		if ( $this->weekflg == 0 ) {// 週の開始を日曜日とした場合
			if ( $wka == 0 ) $first --;
			if ( $wkb == 0 ) $last --;
		}
		return $last - $first + 1;
	}
	// @ 指定月の週開始日と最終日の配列を返す
	private function cnvweek2date($mon, $year) {
		$weeks[] = array();
		$cnt = 0;
		$max = $this->getmax($mon, $year);
		if ( $this->weekflg == 0 ) {
			$lastwk = 6;
		}
		else {
			$lastwk = 7;
		}
		if ( $mon == 1 ) {
			$wka = date('w', mktime(0,0,0, 12, 26, $year-1));
			$wkday2 = date('d', mktime(0,0,0, 12, 26+($lastwk-$wka), $year-1));
			$weeks[$cnt++] = array('begin' => 26, 'last' => $wkday2);
			for(  ; $cnt < $max ; ) {
				$wkday = $wkday2;
				if ( $wkday > 26 ) {
					$wkday1 = date('d', mktime(0,0,0, 12, $wkday+1, $year-1));
					$wkday2 = date('d', mktime(0,0,0, 12, $wkday+7, $year-1));
				}
				else {
					$wkday1 = date('d', mktime(0,0,0, 1, $wkday+1, $year));
					$wkday2 = date('d', mktime(0,0,0, 1, $wkday+7, $year));
					if ( $wkday2 > 25 ) $wkday2 = 25;
				}
				$weeks[$cnt++] = array('begin' => $wkday1, 'last' => $wkday2);
			} 
		}
		else {
			$wka = date('w', mktime(0,0,0, $mon-1, 26, $year));
			$wkday2 = date('d', mktime(0,0,0, $mon-1, 26+($lastwk-$wka), $year));
			$weeks[$cnt++] = array('begin' => 26, 'last' => $wkday2);
			for( ; $cnt < $max ;  ) {
				$wkday = $wkday2;
				if ( $wkday > 26 ) {
					$wkday1 = date('d', mktime(0,0,0, $mon-1, $wkday+1, $year));
					$wkday2 = date('d', mktime(0,0,0, $mon-1, $wkday+7, $year));
				}
				else {
					$wkday1 = date('d', mktime(0,0,0, $mon, $wkday+1, $year));
					$wkday2 = date('d', mktime(0,0,0, $mon, $wkday+7, $year));
					if ( $wkday2 > 25 ) $wkday2 = 25;
				}
				$weeks[$cnt++] = array('begin' => $wkday1, 'last' => $wkday2);
			} 
		}
		return $weeks;
	}
	public function __construct() {
		parent::__construct();
		$this->load->model('mydata_model');
		$this->year = idate("Y");
		$this->mon = idate("m");
		$this->week = 0;
		$this->weekflg = 1;// 週の開始0=日曜日、1=月曜日
	}
        public function index() {
		// @ データ読込
		if ( $this->input->get('year', FALSE) != NULL ) {
			$this->year = $this->input->get('year', FALSE);
		}
		if ( $this->input->get('mon', FALSE) != NULL ) {
			$this->mon = $this->input->get('mon', FALSE);
		}
		if ( $this->input->get('next', FALSE) != NULL ) {
			$next = $this->input->get('next', FALSE);
			$mon = $next + 1;
			if ( $mon > 12 ) {
				$this->year++;
				$mon = 1;
			}
			$this->mon = $mon;
			$this->week = 0;
		}
		else if ( $this->input->get('prev', FALSE) != NULL ){
			$prev = $this->input->get('prev', FALSE);
			$mon = $prev - 1;
			if ( $mon < 1 ) {
				$this->year--;
				$mon = 12;
			}
			$this->mon = $mon;
			$this->week = 0;
		}
		// @ その月の最大週数を計算
		$this->maxweek = $this->getmax($this->mon, $this->year);

		if ( $this->input->get('weeknext', FALSE) != NULL ) {
			$next = $this->input->get('weeknext', FALSE);
			$week = $next + 1;
			if ( $week >= $this->maxweek ) {
				$week = $next;
			}
			$this->week = $week;
		}
		else if ( $this->input->get('weekprev', FALSE) != NULL ) {
			$prev = $this->input->get('weekprev', FALSE);
			$week = $prev - 1;
			if ( $week < 0 ) {
				$week = 0;
			}
			$this->week = $week;
		}
		$year = $this->year;
		$mon = $this->mon;
		$week = $this->week;

		$weeksmdaarray = $this->cnvweek2date($mon, $year);
		$data['begin'] = $weeksmdaarray[$week]['begin']; 
		$data['last'] = $weeksmdaarray[$week]['last']; 

		// @ Total payment per week
		$result = $this->mydata_model->getpay_daterange($data['begin'], $data['last'], $mon, $year);
		$objects = $result->result('object');
		$totalpay = 0;
		foreach($objects as $obj) {
			$totalpay += $obj->支出;
		}
		$data['payment'] = $result->result('object');

		// @ -------- 表示 --------
		$data['title'] = "Weekly Display";
                $this->load->view('form/header', $data);

		$data['totalpay'] = $totalpay;
		$data['month'] = $this->mon;
		$data['year'] = $this->year;
		$data['week'] = $this->week;
                $this->load->view('weekly', $data);

                $this->load->view('form/rettop');
                $this->load->view('form/footer');
        }
}
