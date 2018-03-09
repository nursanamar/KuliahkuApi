<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 *
 */
class Fcm
{

  public function sendNotif($to,$data)
  {
    $curl = curl_init();
    $data = array(
      "to" => $to,
      "data" => $data,
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

  public function createGroup($id,$token)
  {
    $data = array(
      "operation" => "create",
      "notification_key_name" => $id,
      "registration_ids" => [ $token ],
    );
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://android.googleapis.com/gcm/notification",
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
        "project_id: 1053670299115"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      throw new Exception("Error Processing Request ".$err, 1);
    } else {
       return json_decode($response,true);
    }
  }

  public function addToGroup($id,$token,$groupToken)
  {
    $data = array(
      "operation" => "add",
      "notification_key_name" => $id,
      "notification_key" => $groupToken,
      "registration_ids" => [$token]
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://android.googleapis.com/gcm/notification",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_HTTPHEADER => array(
        "authorization: key=AAAA9VOk1es:APA91bE0q3yKoYwrabecvkR1MtO_0D_gLUV1f2Ad7U6joRLWIVvXMErUoCbLnYnLSW0FbrMtFkteydoROILyzAz7mcXA--ahTFiSa0i2VNiGUD8rZD56-0y51xFF3SEiUKuCcke-yF6W",
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 306c785b-2c82-a088-0010-5ca1737ac559",
        "project_id: 1053670299115"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      throw new Exception("Error Processing Request ".$err, 1);
    } else {
      return json_decode($response,true);
    }
  }

  public function getToken($idJadwal)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://android.googleapis.com/gcm/notification?notification_key_name=".$idJadwal,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "authorization: key=AAAA9VOk1es:APA91bE0q3yKoYwrabecvkR1MtO_0D_gLUV1f2Ad7U6joRLWIVvXMErUoCbLnYnLSW0FbrMtFkteydoROILyzAz7mcXA--ahTFiSa0i2VNiGUD8rZD56-0y51xFF3SEiUKuCcke-yF6W",
        "content-type: application/json",
        "project_id: 1053670299115"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      throw new Exception("Error Processing Request".$err, 1);
    } else {
      $res = json_decode($response,true);
      return (isset($res['error'])) ? false : $res['notification_key'];
    }
  }

  public function removeFromGroup($token,$groupName,$groupToken)
  {
    $data = array(
      "operation" => "remove",
      "notification_key_name" => $groupName,
      "notification_key" => $groupToken,
      "registration_ids" => [$token]
    );
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://android.googleapis.com/gcm/notification",
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
        "project_id: 1053670299115"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      throw new Exception("Error Processing Request ".$err, 1);
    } else {
      return null;
    }
  }
}



?>
