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
    $fcmMsg = "Jadwal mata kuliah di update";
    $this->sendToFcm($data['id'],$fcmMsg);
    $this->sendResponse($respon);
  }

  public function getKuliahList()
  {
    $user = $this->payload;
    $data = $this->jadwal_model->getKuliahList($user->id);
    $this->sendResponse($data);
  }

  public function sendToFcm($idKuliah,$msg)
  {
    $this->load->model('notif_model');
    $this->load->library('fcm');
    $data = array(
      "body" => $msg,
    );
    $idJadwal = $this->notif_model->getToken($idKuliah);
    foreach ($idJadwal as $key => $value) {
      $token = $this->fcm->getToken($value['idJadwal']);
      if($token){
        $this->fcm->sendNotif($token,$data);
      }
    }
  }

  public function KuliahById($id)
  {
    $respon = $this->jadwal_model->kuliah_by_id($id);
    $this->sendResponse($respon[0]);
  }
}


?>
