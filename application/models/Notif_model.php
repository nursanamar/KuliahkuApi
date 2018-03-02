<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Notif_model extends CI_Model
{

  public function getGroupToken($nim)
  {
    $this->db->select("token,mahasiswa.idJadwal");
    $this->db->from('notif');
    $this->db->join('mahasiswa',"mahasiswa.idJadwal=notif.idJadwal");
    $this->db->where('nim',$nim);

    $result = $this->db->get()->result_array();

    return (isset($result[0])) ? $result[0] : false;

  }

  public function saveToken($id,$token)
  {
    $data = array(
      'idJadwal' => $id,
      'token' => $token
    );
    $this->db->insert('notif',$data);
  }

  public function updateToken($id,$token)
  {
    $this->db->set('token',$token);
    $this->db->where('idJadwal',$id);
    $this->db->update('notif');
  }

  public function getIdJadwal($nim)
  {
    $this->db->select('idJadwal');
    $this->db->from('mahasiswa');
    $this->db->where('nim',$nim);

    return $this->db->get()->result_array();
  }

}


?>
