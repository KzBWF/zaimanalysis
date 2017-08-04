<?php

class Mydata_model extends CI_Model {
        public function __construct() {
                $this->load->database();
        }
	public function import_all($csv_data) {
		$err = array();
                $colum = array();
                $cnt=0;
                foreach($csv_data as $row_val) {
                        if($cnt == 0) {
				$i=0;
                                foreach($row_val as $val) {
                                        $colum[$i++] = mb_convert_encoding($val,"UTF8","SJIS");
                                }
                        }
                        else {
				$indata = array();
				$i=0;
				$sql = 'select * from mydata where';
                                foreach($row_val as $val) {
                                        $indata += array($colum[$i] => mb_convert_encoding($val,"UTF8","SJIS"));
					if ($i != 0) {
						$sql .= ' AND';
					}
					$valtmp = str_replace("'", "\'", mb_convert_encoding($val, "UTF8", "SJIS"));
					$sql .= ' '.$colum[$i].' = \''.$valtmp.'\'';
					$i++;
                                }
				/* check same data
				$result = $this->db->query($sql);
				if ($result->num_rows() == 0) {
					$err[$cnt] = $this->db->insert('mydata', $indata);
				}
				else {
					$err[$cnt] = $sql;
				}
				*/
				$err[$cnt] = $this->db->insert('mydata', $indata);
				$indata = NULL;
                        }
                        $cnt++;
                }
		return $err;
	}
	public function getpay_daterange($begin, $last, $mon, $year) {
		if ( $begin >= 26 ) {
			if ( $mon == 1 ) {
				$start = date("Y-m-d H:i:s", mktime(0,0,0, 12, $begin, $year-1));
			}
			else {
				$start = date("Y-m-d H:i:s", mktime(0,0,0, $mon-1, $begin, $year));
			}
		}
		else {
			$start = date("Y-m-d H:i:s", mktime(0,0,0, $mon, $begin, $year));
		}
		if ( $last >= 26 ) {
			if ( $mon == 1 ) {
				$end = date("Y-m-d H:i:s", mktime(23,59,59, 12, $last, $year-1));
			}
			else {
				$end = date("Y-m-d H:i:s", mktime(23,59,59, $mon-1, $last, $year));
			}
		}
		else {
			$end = date("Y-m-d H:i:s", mktime(23,59,59, $mon, $last, $year));
		}
		$sql = "select 日付,カテゴリ,ジャンル,商品,メモ,場所,支出 from mydata where 方法='payment' and ";
		$sql .= "'".$start."' <= 日付 and 日付 <= '".$end."'";
		return $this->db->query($sql);
	}
	public function getpay_mon($mon, $year) {
		// **/26～**/25
		if ( $mon == 1 ) {
			$start = date("Y-m-d H:i:s", mktime(0,0,0, 12, 26, $year-1));
		}
		else {
			$start = date("Y-m-d H:i:s", mktime(0,0,0, $mon-1, 26, $year));
		}
		$end = date("Y-m-d H:i:s", mktime(23,59,59, $mon, 25, $year));
		$sql = "select 日付,カテゴリ,ジャンル,商品,メモ,場所,支出 from mydata where 方法='payment' and ";
		$sql .= "'".$start."' <= 日付 and 日付 <= '".$end."'";
		return $this->db->query($sql);
	}
	public function getinc_mon($mon, $year) {
		// **/26～**/25
		if ( $mon == 1 ) {
			$start = date("Y-m-d H:i:s", mktime(0,0,0, 12, 26, $year-1));
		}
		else {
			$start = date("Y-m-d H:i:s", mktime(0,0,0, $mon-1, 26, $year));
		}
		$end = date("Y-m-d H:i:s", mktime(23,59,59, $mon, 25, $year));
		$sql = "select 日付,カテゴリ,ジャンル,商品,メモ,場所,収入 from mydata where 方法='income' and ";
		$sql .= "'".$start."' <= 日付 and 日付 <= '".$end."'";
		return $this->db->query($sql);
	}
	public function getpay_day($day, $mon, $year) {
		$start = date("Y-m-d H:i:s", mktime(0,0,0, $mon, $day, $year));
		$end = date("Y-m-d H:i:s", mktime(23,59,59, $mon, $day, $year));
		$sql = "select 日付,カテゴリ,ジャンル,商品,メモ,場所,支出 from mydata where 方法='payment' and ";
		$sql .= "'".$start."' <= 日付 and 日付 <= '".$end."'";
		return $this->db->query($sql);
	}
	public function getinc_day($day, $mon, $year) {
		$start = date("Y-m-d H:i:s", mktime(0,0,0, $mon, $day, $year));
		$end = date("Y-m-d H:i:s", mktime(23,59,59, $mon, $day, $year));
		$sql = "select 日付,カテゴリ,ジャンル,商品,メモ,場所,収入 from mydata where 方法='income' and ";
		$sql .= "'".$start."' <= 日付 and 日付 <= '".$end."'";
		return $this->db->query($sql);
	}
	public function getpay_year($year) {
		$start = date("Y-m-d H:i:s", mktime(0,0,0, 12, 26, $year-1));
		$end = date("Y-m-d H:i:s", mktime(23,59,59, 12, 25, $year));
		$sql = "select 日付,カテゴリ,ジャンル,商品,メモ,場所,支出 from mydata where 方法='payment' and ";
		$sql .= "'".$start."' <= 日付 and 日付 <= '".$end."'";
		return $this->db->query($sql);
	}
	public function getinc_year($year) {
		$start = date("Y-m-d H:i:s", mktime(0,0,0, 12, 26, $year-1));
		$end = date("Y-m-d H:i:s", mktime(23,59,59, 12, 25, $year));
		$sql = "select 日付,カテゴリ,ジャンル,商品,メモ,場所,収入 from mydata where 方法='income' and ";
		$sql .= "'".$start."' <= 日付 and 日付 <= '".$end."'";
		return $this->db->query($sql);
	}
}
