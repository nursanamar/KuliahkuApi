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
    $idJadwal = $this->notif_model->getIdJadwal($user->id)[0];
    $token = $this->fcm->getToken($idJadwal['idJadwal']);
    if ($token) {
      $token = $this->fcm->addToGroup($idJadwal['idJadwal'],$data['token'],$token);
      echo "add";
    }else{
      $token = $this->fcm->createGroup($idJadwal['idJadwal'],$data['token']);
      echo "create";
    }
  }

  public function removeToken()
  {
    $data = $this->getBody();
    $user = $this->payload;
    $idJadwal = $this->notif_model->getIdJadwal($user->id)[0];
    $token = $this->fcm->getToken($idJadwal['idJadwal']);
    if($token){
      $this->fcm->removeFromGroup($data['token'],$idJadwal['idJadwal'],$token);
    }
  }
}

?>
