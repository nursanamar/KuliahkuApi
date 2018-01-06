<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Jadwal extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->checkAuth();
    $this->load->model('jadwal_model');
  }

  public function getData()
  {
    $id = $this->payload->id;
    $data = $this->jadwal_model->today($id);
    $this->sendResponse($data);
    // var_dump(date('Y-m-d')+date('d')+1);
  }
}


?>
