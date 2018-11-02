<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payment controller for FetishBNB
 * Author: Rob Reyes/Starcoders
 * Date: 10/11/2018
 *
 *
 */
class Payment extends Private_Controller {

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
      $this->load->helper('language');
    }

    public function btc($tx_type)
    {
      $amount = $this->input->post('amount');

      $this->add_js_theme( "pages/btc/index_i18n.js", TRUE);

      $this->set_title('Pay via Bitcoin');

      $data = $this->includes;

      $content_data = array(
        'pay_amount' => $amount,
        'txn_type'   => $tx_type,
      );

      $data['content'] = $this->load->view('btc_page', $content_data, TRUE);
      $this->load->view($this->template, $data);
    }

    public function process($address)
    {
      $address = $this->btc_model->get_transaction_by_address($address, $this->user['id']);

      $this->add_js_theme( "pages/btc/index_i18n.js", TRUE);

      $this->set_title('Process Bitcoin');

      $data = $this->includes;

      $content_data = array(
        'address' => $address,
        'pay_amount' => $address[0]['amount'],
      );

      $data['content'] = $this->load->view('btc/btc_process', $content_data, TRUE);
      $this->load->view($this->template, $data);
    }

    public function test()
    {

      $this->set_title('Pay via Bitcoin');

      $data = $this->includes;
      $data['content'] = $this->load->view('btc_test', NULL, TRUE);
      $this->load->view($this->template, $data);
    }

    public function success($txn_hash)
    {
      $this->set_title('Pay via Bitcoin');

      $btc_details = $this->btc_model->get_txn_by_hash($txn_hash);

      $content_data = array(
        'btc_details' => $btc_details,
        'payment_act' => array( 'status' => 'success', 'msg' => 'A payment has been successfully made! '.$btc_details[0]['amount'].' of BTC has been credited to your account.'),
      );

      $data = $this->includes;
      $data['content'] = $this->load->view('btc/btc_success', $content_data, TRUE);
      $this->load->view($this->template, $data);
    }

    public function pending($id)
    {
      $this->set_title('Pay via Bitcoin');

      $content_data = array(
        'btc_details' => $this->btc_model->get_transaction_by_id($id),
        'payment_act' => array( 'status' => 'success', 'msg' => 'A BTC transfer has been confirmed, wait for the transfer to complete and proceed with the processing of your payment. '),
      );

      $data = $this->includes;
      $data['content'] = $this->load->view('btc/btc_success', $content_data, TRUE);
      $this->load->view($this->template, $data);
    }

    public function error()
    {
      $this->set_title('Pay via Bitcoin');

      $content_data = array(
        'payment_act' => array( 'status' => 'error', 'msg' => 'Transfer has failed, please check your details and try again.'),
      );

      $data = $this->includes;
      $data['content'] = $this->load->view('btc/btc_success', $content_data, TRUE);
      $this->load->view($this->template, $data);
    }

}
