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

  public function getData($table,$data)
  {
    return $this->db->insert_batch($table,$data);
  }
}

 ?>
