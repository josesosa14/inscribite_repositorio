<?php

class Migrate extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index() {
        if ($this->migration->current() === FALSE) {
            show_error($this->migration->error_string());
        }else{
            die('todo en orden');
        }
    }

}
