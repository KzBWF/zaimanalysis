<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_zaimdata extends CI_Migration {
        public function up() {
                $this->dbforge->add_field(array(
                        'id'    => array(
                                'type'          =>      'INT',
				'unsingned'	=>	TRUE,
				'auto_increment' =>	TRUE,
                        ),
                        '日付'    => array(
                                'type'          =>      'TIMESTAMP',
                        ),
                        '方法'   =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        'カテゴリ'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        'ジャンル'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '支払元'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '入金先'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '商品'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        'メモ'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '255',
                        ),
                        '場所'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '通貨'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '収入'          =>      array(
                                'type'          =>      'INT',
                        ),
                        '支出'          =>      array(
                                'type'          =>      'INT',
                        ),
                        '振替'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '残高調整'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '通貨変換前の金額'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                        '集計の設定'          =>      array(
                                'type'          =>      'VARCHAR',
                              	'constraint'    =>      '64',
                        ),
                ));
                // @ $this->dbforge->add_key(array('日付','カテゴリ','ジャンル','商品','メモ','場所','収入','支出'), TRUE);
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('mydata');
        }
        public function down() {
                $this->dbforge->drop_table('mydata');
        }
}
