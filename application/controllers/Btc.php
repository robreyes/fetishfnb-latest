<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BTC Payment controller for FetishBNB
 * Author: Rob Reyes/Starcoders
 * Date: 10/08/2018
 * This uses bitaps API for processing
 *
 */


class Btc extends Private_Controller {

  /**
   * Constructor
   */
  function __construct()
  {
      parent::__construct();

      //load models
      $this->load->model(array(
                          'notifications_model',
                          'event_model',
                          'users_model',
                          'admin/ebookings_model',
                          'admin/events_model',
                          'btc_model',
                      ));

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

  private function process_btc($user_id, $amount, $act)
  {
    $user_balance = $this->users_model->get_user_btc($user_id);

    if($act == 'credit')
    {
      $new_balance = bcadd($user_balance, $amount, 8);
    }
    if($act == 'booking')
    {
      $new_balance = bcsub($user_balance, $amount, 8);
    }

    $flag = $this->users_model->save_users(array('btc_balance' => $new_balance), $user_id);

    if($flag)
    {
      return true;
    }
    else
    {
      return false;
    }
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
        ->set_output($response);

  }

  public function create_redeemcode()
  {
    $confirmations = 1; // the desired number of confirmations
    $data = file_get_contents("https://bitaps.com/api/create/redeemcode?confirmations=". $confirmations);
    $response = json_decode($data,true);

     return $this->output
         ->set_content_type('application/json')
         ->set_status_header(200) // Return status
         ->set_output(json_encode($response));
  }

  public function check_redeemcode($redeemcode = NULL, $format = NULL){

    if(!isset($redeemcode))
    {
      $redeemcode = $this->input->post('redeem_code');
    }

    $postfields = json_encode(array('redeemcode'=> $redeemcode));
    $response = $this->post_api("https://bitaps.com/api/get/redeemcode/info", $postfields);

    if($format == 'array')
    {
      return json_decode($response);
    }
    else
    {
      return $this->output
          ->set_content_type('application/json')
          ->set_status_header(200) // Return status
          ->set_output(json_encode($response));
    }
  }

  public function add_redeem_code_to_user()
  {
    $redeemcode     = $this->input->post('redeem_code');
    $amount         = $this->input->post('redeem_amount');
    $fee            = $this->input->post('redeem_fee');
    $address        = $this->input->post('redeem_address');
    $invoice        = $this->input->post('redeem_invoice');

    $check_redeemcode = $this->check_redeemcode($redeemcode, 'array');

    if($check_redeemcode->pending_balance >= $amount)
    {

      $data = array(
        'address'      => $address,
        'invoice'      => $invoice,
        'redeem_code'  => $redeemcode,
        'amount'       => bcsub($amount, $fee, 8),
        'user_id'      => $this->user['id'],
        'status'       => 'pending',
        'date'         => date('Y-m-d H:i:s'),
      );

      $id = $this->btc_model->add_btc_address($data);

      if($id)
      {
        $this->session->set_flashdata('message',  lang('btc_transaction_success'));
        redirect(base_url('payment/pending/'.$id));
      }
      else
      {
        $this->session->set_flashdata('message',  lang('btc_transaction_error'));
        redirect(base_url('payment/error'));
      }

    }

  }


  public function process_redeemcode()
  {
    $redeemcode     = $this->input->post('redeem_code');
    $payout_address =  '31zkWFG4UZbTwzosRzpzx84oQgxH5XxM2R';
    $amount         = $this->input->post('redeem_amount');
    $address        = $this->input->post('redeem_address');
    $txn_type       = $this->input->post('txn_type');

    $check_redeemcode = $this->check_redeemcode($redeemcode, 'array');

    if($check_redeemcode->balance >= $amount)
    {
      $postfields = json_encode(array('redeemcode'=> $redeemcode, 'address'=> $payout_address, 'amount'=>'All available'));
      $response = $this->post_api("https://bitaps.com/api/use/redeemcode", $postfields);

      $response_data = (object) json_decode($response);

      if($response_data->status != 'failed')
      {
        $address_detais = $this->btc_model->get_transaction_by_address($address, $this->user['id']);

        $data = array(
          'event_id'        => 0,
          'user_id'         => $this->user['id'],
          'date'            => date('Y-m-d H:i:s'),
          'amount'          => $amount,
          'txn_id'          => substr( str_shuffle( str_repeat( 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 10 ) ), 0, 10 ),
          'txn_type'        => $txn_type,
          'txn_hash'        => $response_data->tx_hash,
          'address_id'      => $address_detais[0]['id'],
        );

        $this->btc_model->add_btc_address(array('status'=>'successful'), $address_detais[0]['id']);

        $id = $this->btc_model->add_btc_transaction($data);

        if($id)
        {
          $flag = $this->process_btc($this->user['id'], $amount, $txn_type);

          if($flag)
          {
            $this->session->set_flashdata('message',  lang('btc_payment_success'));
            redirect(base_url('payment/success/'.$response_data->tx_hash));
          }
        }
      }
      else
      {
        print_r($response_data);
      }
    }

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

  public function calculate_fees($input, $output, $priority)
  {
    $get_fees       = json_decode(file_get_contents('https://bitaps.com/api/fee'),true);
    $input_calc     = bcmul(148, $input);
    $output_calc    = bcmul(34, $output);

    if($priority == 'high')
    {
      $priority_fee = $get_fees['high'];
    }
    else if($priority == 'medium')
    {
      $priority_fee = $get_fees['medium'];
    }
    else if($priority == 'low')
    {
      $priority_fee = $get_fees['low'];
    }

    $combined_tx = bcadd($input_calc, $output_calc);
    $final_calc  = bcadd($combined_tx, 10);

    $result = bcmul($final_calc, $priority_fee);

    return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200) // Return status
        ->set_output(json_encode(array(
          'fee'          => bcdiv($result, 100000000, 8),
          'rates'        => $get_fees,
          'input'        => $input,
          'output'       => $output,
          'input_calc'   => $input_calc,
          'output_calc'  => $output_calc,
          'combined_tx'  => $combined_tx,
        )
       ));
  }

}
