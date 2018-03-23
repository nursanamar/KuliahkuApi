<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Migration_lib',null,'migrat');

	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function login()
	{
		$response = array();
		$check = false;
		try {
		  $check = $this->validateLogin();
		} catch (Exception $e) {

		}
    if($check){
      $token = $this->generateToken();
      $response = array(
        'status' => 'ok',
        'desc' => "Login succes",
        'data' => array(
          'token' => $token,
          'user' => $this->user,
        ),
      );

    }else {
      $response = array(
        'status' => 'failed',
        'desc' => $e->getMessage(),
      );
    }
    $this->sendResponse($response);
	}

	public function welcome()
	{
		echo "<h1 align='center'>. . . . . .</h1>";
	}

	public function feedData($table)
	{
		$data = $this->getBody();
		$res['status'] = $this->login->feedData($table,$data);
		$this->sendResponse($res);
	}

	public function getData($table)
	{
		$data = $this->login->getData($table);
		$this->sendResponse($data);
	}

	public function fixJadwal($idJadwal)
	{
		$data = $this->getBody();
		$res = $this->login->deleteJadwal($idJadwal);

		$this->sendResponse($res);
	}

	public function mahasiswa()
	{
		$data = $this->getBody();
		$user = array();
		$mahasiswa = array();
		foreach ($data as $value) {
			$user[] = array(
				"nim" => $value['nim'],
				"nama" => $value['nama'],
				"pass" => password_hash($value['pass'],PASSWORD_DEFAULT),
			);
			$mahasiswa[] = array(
				"nim" => $value['nim'],
				"mahasiswa" => $value['nama'],
				"idJadwal" => "JDL0002",
			);
		}
		$res['user'] = $this->login->feedData('user',$user);
		$res['mahasiswa'] = $this->login->feedData('mahasiswa',$mahasiswa);
		$this->sendResponse($res);
	}
}
