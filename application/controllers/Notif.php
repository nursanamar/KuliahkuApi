<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Notif extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->checkAuth();
    $this->load->model('notif_model');
    $this->load->library('fcm');
  }

  public function storeToken()
  {

    $data = $this->getBody();
    $user = $this->payload;
    $group = $this->notif_model->getGroupToken($user->id);
    if ($group) {
      $token = $this->fcm->addToGroup($group['idJadwal'],$data['token'],$group['token']);
      $this->notif_model->updateToken($group['idJadwal'],$token['notification_key']);
    }else{
      $idJadwal = $this->notif_model->getIdJadwal($user->id)[0];
      $token = $this->fcm->createGroup($idJadwal['idJadwal'],$data['token']);
      // var_dump($token['notification_key']);
      $this->notif_model->saveToken($idJadwal['idJadwal'],$token['notification_key']);
    }
  }
}

?>
