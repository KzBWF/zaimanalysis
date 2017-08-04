<?php

class Top extends CI_Controller {

        public function index()
        {
		$data['title'] = "Top Menu";
                $this->load->view('form/header', $data);
                $this->load->view('top');
                $this->load->view('form/footer');
        }
}
