<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BTC Payment controller for FetishBNB
 * Author: Rob Reyes/Starcoders
 * Date: 10/08/2018
 * This uses bitaps API for processing
 *
 */


class Btc extends Public_Controller {

  /**
   * Constructor
   */
  function __construct()
  {
      parent::__construct();
  }

  private function post_api($url, $postfields)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    return $result;
  }

  public function create_payout()
  {
    $post_data = array(
      'payout_address'    =>  $this->input->post('payout_address'),
      'callback'          =>  urlencode($this->input->post('callback')),
      'confirmations'     =>  $this->input->post('confirmations'),
      'fee_level'         =>  $this->input->post('fee_level'),
    );

    $response = file_get_contents("https://bitaps.com/api/create/payment/". $post_data['payout_address']. "/" . $post_data['callback'] . "?confirmations=" . $post_data['confirmations']. "&fee_level=" . $post_data['fee_level']);

    return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200) // Return status
        ->set_output(json_encode(array(
          'data' => $response)
        ));

  }

  public function create_redeemcode($format)
  {
    $confirmations = 3; // the desired number of confirmations
    $data = file_get_contents("https://bitaps.com/api/create/redeemcode?confirmations=". $confirmations);
    $response = json_decode($data,true);

      if($format == 'json')
      {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200) // Return status
            ->set_output(json_encode(array(
              'data' => $response)
            ));
      }else{
        return $response;
      }
  }

  public function check_redeemcode(){
    $redeemcode = $this->input->post('redeem_code');

    $postfields = json_encode(array('redeemcode'=> $redeemcode));
    $response = $this->post_api("https://bitaps.com/api/get/redeemcode/info", $postfields);

    return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200) // Return status
        ->set_output(json_encode(array(
          'data' => $response)
        ));
  }

  public function process_redeemcode()
  {
    $redeemcode     = $this->input->post('redeem_code');
    $payout_address =  '';
    $amount         = "All available";

    $postfields = json_encode(array('redeemcode'=> $redeemcode, 'address'=> $address, 'amount'=>$amount ));
    $response = $this->post_api("https://bitaps.com/api/use/redeemcode", $postfields);

    return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200) // Return status
        ->set_output(json_encode(array(
          'data' => $response)
        ));
  }

  public function get_redeem_code()
  {
    $redeem = $this->input->post('redeem_code');
    $postfields = json_encode(array('redeemcode'=> $redeem));
    $response = $this->post_api("https://bitaps.com/api/get/redeemcode/info", $postfields);

    return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200) // Return status
        ->set_output(json_encode(array(
          'data' => $response)
        ));
  }

  public function generate_qr()
  {
    $message = $this->input->post('value');

    return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200) // Return status
        ->set_output(json_encode(
          array(
            'img_url' => 'https://bitaps.com/api/qrcode/png/'. urlencode( $message ))
          ));
  }


  function test()
  {

    // setup page header data
    $this->set_title('BTC test');

    $data = $this->includes;
    $data['content'] = $this->load->view('btc_test', NULL, TRUE);
    $this->load->view($this->template, $data);
  }
}
