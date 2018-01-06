<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Jadwal_model extends CI_Model
{

  public function today($id)
  {
    // $data = $this->db->query("SELECT `matkul`.`nama` AS 'matkul',`dosen`.`nama` AS 'dosen',`kuliah`.`jam`,`kuliah`.`ruangan` FROM mahasiswa INNER JOIN (jadwal INNER JOIN ( (kuliah INNER JOIN matkul ON kuliah.idMatkul=matkul.idMatkul) INNER JOIN dosen ON kuliah.idDosen=dosen.idDosen) ON jadwal.idKuliah=kuliah.idKuliah) ON mahasiswa.idJadwal=jadwal.idJadwal WHERE mahasiswa.nim=".$id." AND kuliah.tanggal='".date('Y-m-d')."'")->result_array();
    $this->db->select("`matkul`.`nama` AS 'matkul',`dosen`.`nama` AS 'dosen',`kuliah`.`jam` AS 'time',`kuliah`.`ruangan` AS 'room',`kuliah`.`status`,`kuliah`.`idTugas`",false);
    $this->db->from('mahasiswa');
    $this->db->join('jadwal','mahasiswa.idJadwal=jadwal.idJadwal','inner');
    $this->db->join('kuliah','jadwal.idKuliah=kuliah.idKuliah','inner');
    $this->db->join('matkul','kuliah.idMatkul=matkul.idMatkul','inner');
    $this->db->join('dosen','kuliah.idDosen=dosen.idDosen','inner');
    $this->db->where('nim',$id);
    // $this->db->group_start()
    //   ->from('jadwal')
    //   ->group_start()
    //     ->group_start()
    //       ->from('kuliah')
    //       ->join('matkul','kuliah.idMatkul=matkul.idMatkul')
    //     ->group_end()
    //   ->group_end();
    $data = $this->db->get()->result_array();
    return $data;
  }
}

?>
