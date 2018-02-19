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
    $hari = date('N');
    $data['today'] = $this->jadwal_model->today($id,$hari);
    $data['tomorrow'] = $this->jadwal_model->today($id,((int)$hari)+1);
    $this->sendResponse($data);
  }

  public function updateData()
  {
    $data = $this->getBody();
    $respon = $this->jadwal_model->update($data['id'],$data['data']);
    $wsData = array("action" => "update","msg" => "Jadwal mata kuliah di update");
    $this->sendToSocket(json_encode($wsData),'/jadwal');
    $this->sendResponse($respon);
  }

  public function getKuliahList()
  {
    $user = $this->payload;
    $data = $this->jadwal_model->getKuliahList($user->id);
    $this->sendResponse($data);
  }

  public function sendToSocket($data,$path)
  {
    // $data = json_encode($data);
    $this->load->library('Wsclient');
    $this->wsclient->init('localhost',$path,'localhost',false,4444);
    $this->wsclient->connect();
    $this->wsclient->send(WS_FRAME_TEXT, $data, 1);
    $this->wsclient->disconnect();
  }

  public function KuliahById($id)
  {
    $respon = $this->jadwal_model->kuliah_by_id($id);
    $this->sendResponse($respon[0]);
  }
}


?>
