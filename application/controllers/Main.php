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
		try {
		  $check = $this->validateLogin();
		} catch (Exception $e) {
      $this->output->set_status_header(400);
			die();
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
        'desc' => "login failed, please check your pass",
      );
    }
    $this->sendResponse($response);
	}

	public function welcome()
	{
		echo "<h1 align='center'>. . . . . .</h1>";
	}

	public function generator($table)
	{
		$data = $this->getBody();
		$res['status'] = $this->login->getData($table,$data);
		$this->sendResponse($res);
	}

	public function xml($id,$sig)
	{
		$type = $this->input->get('type');
		switch($type) {
			case "inquiry":
				$data  = array(
			 	'response' => 'VA Static Response',
			 	'va_number' => $id,
			 	'amount' => 'xxx',
			 	'cust_name' => 'sss'
				);
			break;
			case "payment":
				$data = array(
					'response' => 'VA Static Response',
				 	'va_number' => $id,
				 	'amount' => $this->input->get("amount"),
				 	'cust_name' => 'sss'
				);
			break;
		}

		$this->sendXml($data);

	}

	public function sendXml($data)
	{
		$xml = new SimpleXMLElement("<faspay/>");
		foreach ($data as $key => $value) {
		 $xml->addChild($key,$value);
		}
		$this->output->set_content_type('application/xml');
		$this->output->set_output($xml->asXML());
	}
}
