<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class User extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function chekUser($nim)
  {
    $this->db->select("*");
    $this->db->where('nim',$nim);
    $result = $this->db->get('user')->result_array();

    return (isset($result[0])) ? $result[0] : null;
  }

  public function feedData($table,$data)
  {
    return $this->db->insert_batch($table,$data);
  }

  public function getData($table)
  {
    return $this->db->get($table)->result_array();
  }

  public function deleteJadwal($idJadwal)
  {
    $this->db->where('idJadwal',$idJadwal);
   return $this->db->delete('jadwal');
  }
}

 ?>
