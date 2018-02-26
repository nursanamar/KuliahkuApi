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
    $this->sendToFcm("fcmMsg");
    $this->sendResponse($respon);
  }

  public function getKuliahList()
  {
    $user = $this->payload;
    $data = $this->jadwal_model->getKuliahList($user->id);
    $this->sendResponse($data);
  }

  public function sendToFcm($msg)
  {
    $curl = curl_init();
    $data = array(
      "to" => "fc4yj9Ip6PQ:APA91bEFkY8O2fI0fgqNrk3j9qiM6b3cuSf851jDGOqIKdlDtRwS30xyyeJeRTknBsxUYsVXC3504iJoBHktAVfzG7j2fKXHKhS12fYKjr750TRpZVovBWEr-jxBb7gLg9zGS10Jmo1g",
      "notification" => array(
        "body" => $msg
      )
    );
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_HTTPHEADER => array(
        "authorization: key=AAAA9VOk1es:APA91bE0q3yKoYwrabecvkR1MtO_0D_gLUV1f2Ad7U6joRLWIVvXMErUoCbLnYnLSW0FbrMtFkteydoROILyzAz7mcXA--ahTFiSa0i2VNiGUD8rZD56-0y51xFF3SEiUKuCcke-yF6W",
        "content-type: application/json",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      throw new Exception("Error Processing Request : ".$err, 1);
    } else {
      return true;
    }
  }

  public function KuliahById($id)
  {
    $respon = $this->jadwal_model->kuliah_by_id($id);
    $this->sendResponse($respon[0]);
  }
}


?>
