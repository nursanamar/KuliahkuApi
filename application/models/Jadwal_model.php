<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Jadwal_model extends CI_Model
{

  public function today($id,$hari)
  {
    // $data = $this->db->query("SELECT `matkul`.`nama` AS 'matkul',`dosen`.`nama` AS 'dosen',`kuliah`.`jam`,`kuliah`.`ruangan` FROM mahasiswa INNER JOIN (jadwal INNER JOIN ( (kuliah INNER JOIN matkul ON kuliah.idMatkul=matkul.idMatkul) INNER JOIN dosen ON kuliah.idDosen=dosen.idDosen) ON jadwal.idKuliah=kuliah.idKuliah) ON mahasiswa.idJadwal=jadwal.idJadwal WHERE mahasiswa.nim=".$id." AND kuliah.tanggal='".date('Y-m-d')."'")->result_array();
    $this->db->select('"kuliah"."idKuliah",matkul.nama AS matkul,dosen.nama AS dosen,kuliah.hari,kuliah.jam AS time,kuliah.ruangan AS room,kuliah.status,"kuliah"."idTugas"',false);
    $this->db->from('mahasiswa');
    $this->db->join('jadwal','mahasiswa.idJadwal=jadwal.idJadwal','inner');
    $this->db->join('kuliah','jadwal.idKuliah=kuliah.idKuliah','inner');
    $this->db->join('matkul','kuliah.idMatkul=matkul.idMatkul','inner');
    $this->db->join('dosen','kuliah.idDosen=dosen.idDosen','inner');
    $this->db->where('nim',$id);
    $this->db->where('kuliah.hari',(string)$hari);
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

  public function update($id,$data)
  {
    $this->db->where('idKuliah',$id);
    $this->db->update('kuliah',$data);

    return $this->kuliah_by_id($id);
  }

  public function kuliah_by_id($id)
  {
    $this->db->select('matkul.nama AS matkul, dosen.nama AS dosen,kuliah.hari,kuliah.jam AS time,kuliah.ruangan AS room,kuliah.status,"tugas"."idTugas"');
    $this->db->from('kuliah');
    $this->db->join('matkul','kuliah.idMatkul=matkul.idMatkul','inner');
    $this->db->join('dosen','kuliah.idDosen=dosen.idDosen','inner');
    $this->db->join('tugas','kuliah.idTugas=tugas.idTugas','left');
    $this->db->where('"idKuliah"',$id);

    return $this->db->get()->result_array();
  }

  public function getKuliahList($user)
  {
    $this->db->select('"kuliah"."idKuliah",matkul.nama,dosen.nama AS dosen');
    $this->db->from('mahasiswa');
    $this->db->join('jadwal','mahasiswa.idJadwal=jadwal.idJadwal','inner');
    $this->db->join('kuliah','jadwal.idKuliah=kuliah.idKuliah','inner');
    $this->db->join('matkul','kuliah.idMatkul=matkul.idMatkul','inner');
    $this->db->join('dosen','kuliah.idDosen=dosen.idDosen','inner');
    $this->db->where('nim',$user);

    return $this->db->get()->result_array();
  }
}

?>
