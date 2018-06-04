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
    $besok = (((int)$hari) === 7) ? 1 : ((int)$hari) + 1;
    $data['tomorrow'] = $this->jadwal_model->today($id,$besok);
    $this->sendResponse($data);
  }

  public function updateData()
  {
    $data = $this->getBody();
    $respon = $this->jadwal_model->update($data['id'],$data['data']);
    
    if (isset($data['data']['status'])) {
      if ($data['data']['status'] == "Masuk") {
          $fcmMsg = "Mata Kuliah " . $respon[0]['matkul'] . " jadi Masuk";
      } else {
          $fcmMsg = "Mata Kuliah " . $respon[0]['matkul'] . " Batal Masuk";
      }
    } else {
      $fcmMsg = "Mata Kuliah " . $respon[0]['matkul'] . " di ubah ke ";
      if (isset($data['data']['hari'])) {
          $hari = array("Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
          $fcmMsg .= "hari " . $hari[$data['data']['hari']] . " ";
      }
      if (isset($data['data']['jam'])) {
          $fcmMsg .= "jam " . $data['data']['jam'] . " ";
      }
    }
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
    $customNotif = array(
      "body"  => $msg,
      "big_text" => $msg,
      "priority" => "high",
      "show_in_foreground" =>  true,
      "sound" => "default",
      "wake_screen" => true,
      "lights" => true,
      "content_available" => true,
    );
    $data = array(
        "custom_notification" => $customNotif
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

  public function getAll()
  {
    $id = $this->payload->id;
    $data = $this->jadwal_model->getAll($id);
    $res = array();
    for ($i=0; $i < 7 ; $i++) { 
      $res[$i] = array();
      foreach ($data as $value) {
        if($i == ($value['hari'] - 1)){
          $res[$i][] = $value;
        }
      }
    }
    // var_dump($res);
    $this->sendResponse($res);
  }
}


?>
