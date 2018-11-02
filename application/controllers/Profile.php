<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profile Controller
 *
 * This class handles profile module functionality
 *
 * @package     classiebit
 * @author      prodpk
*/


class Profile extends Private_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the users model
        $this->load->model(array('users_model','btc_model','event_model','billing_model','admin/events_model'));
        $this->load->library('file_uploads');
    }


    /**
	 * Profile Editor
     */
	function index()
	{
        // validators
        $this->form_validation
        ->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'))
        ->set_rules('username', lang('users_username'), 'trim|min_length[5]|max_length[30]|callback__check_username')
        ->set_rules('first_name', lang('users_first_name'), 'trim|min_length[2]|max_length[32]')
        ->set_rules('last_name', lang('users_last_name'), 'trim|min_length[2]|max_length[32]')
        ->set_rules('email', lang('users_email'), 'required|trim|max_length[128]|valid_email|callback__check_email')
        ->set_rules('profession', lang('users_profession'), 'trim|min_length[3]|max_length[256]')
        ->set_rules('experience', lang('users_experience'), 'trim|is_natural_no_zero')
        ->set_rules('gender', lang('users_gender'), 'required|trim|in_list[male,female,other]')
        ->set_rules('dob', lang('users_dob'), 'required|trim')
        ->set_rules('mobile', lang('users_mobile'), 'required|trim|min_length[5]|max_length[20]')
        ->set_rules('address', lang('users_address'), 'required|trim|min_length[8]|max_length[256]')
        ->set_rules('language', lang('users_language'), 'trim')
        ->set_rules('password', lang('users_password'), 'trim|min_length['.$this->settings->i_min_password.']|max_length['.$this->settings->i_max_password.']')
        ->set_rules('password_confirm', lang('users_password_confirm'), 'matches[password]');

        // upload users image
        if(! empty($_FILES['image']['name'])) // if image
        {
            $file_image         = array('folder'=>'users/images', 'input_file'=>'image');
            // update users image
            $filename_image     = $this->file_uploads->upload_file($file_image);
            // through image upload error
            if(!empty($filename_image['error']))
                $this->form_validation->set_rules('image_error', lang('common_image'), 'required', array('required'=>$filename_image['error']));
        }

        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $data                  = array();

            if(!empty($filename_image) && !isset($filename_image['error']))
                $data['image']     = $filename_image;

            if($this->input->post('password') && get_domain() !== 'classiebit.com')
                $data['password']  = $this->input->post('password');

            $data['first_name']    = $this->input->post('first_name');
            $data['last_name']     = $this->input->post('last_name');
            $data['email']         = $this->input->post('email');
            $data['gender']        = $this->input->post('gender');
            $data['dob']           = date("Y-m-d",strtotime($this->input->post('dob')));
            $data['mobile']        = $this->input->post('mobile');
            $data['profession']    = $this->input->post('profession');
            $data['experience']    = $this->input->post('experience');
            $data['address']       = $this->input->post('address');
            $data['language']      = $this->input->post('language');
            if($this->ion_auth->is_non_admin()){
              $data['role']          = 2; //set user automatically to host when profile is updated
            }

            $saved                 = $this->ion_auth->update($this->user['id'], $data);

            if ($saved)
            {
                // reload the new user data and store in session
                $this->user = (array) $this->users_model->get_users_by_id($this->user['id']);
                // unset($this->user['password']);
                // unset($this->user['salt']);

                $_SESSION['groups_id']      = $this->ion_auth->get_users_groups($this->user['id'])->row()->id;

                if($this->ion_auth->is_non_admin()){
                  $this->ion_auth->remove_from_group(3, $this->user['id']);
                  $this->ion_auth->add_to_group(2, $this->user['id']);
                }

                $saved_data = array_merge($this->user, array('group_name' => 'host'));

                $this->session->set_userdata('logged_in', $saved_data);
                $this->session->language = $this->user['language'];
                $this->session->set_flashdata('message', sprintf(lang('alert_update_success'), lang('action_profile')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('action_profile')));
            }

            // reload page and display message
            redirect('profile');
        }

        // setup page header data
        $this
        ->add_plugin_theme(array(
            "datepicker/datepicker3.css",
            "datepicker/bootstrap-datepicker.js",
            "jquery-datatable/datatables.min.css",
            "jquery-datatable/datatables.min.js",
        ), 'default')
        ->add_js_theme( "pages/user/index_i18n.js", TRUE );

        $this->set_title( lang('menu_user').' '.lang('action_profile'));
        $data = $this->includes;

        // set content data
        $content_data = array(
            'cancel_url'        => base_url(),
            'user'              => $this->user,
            'password_required' => FALSE,
            'has_billing'       => $this->billing_model->get_user_billing_id($this->user['id']),
        );

        // load views
        $data['content'] = $this->load->view('auth/profile_form', $content_data, TRUE);
        $this->load->view($this->template, $data);

	}

  function billing()
  {
    // validators
    $this->form_validation
    ->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'))
    ->set_rules('billing_name', lang('billing_name'), 'required|trim|min_length[5]|max_length[35]')
    ->set_rules('billing_lastname', lang('billing_lastname'), 'required|trim|min_length[5]|max_length[35]')
    ->set_rules('billing_address_1', lang('billing_address_1'), 'required|trim|min_length[5]|max_length[255]')
    ->set_rules('billing_address_2', lang('billing_address_2'), 'required|trim|min_length[5]|max_length[255]')
    ->set_rules('billing_city', lang('billing_city'), 'required|trim|min_length[5]|max_length[40]')
    ->set_rules('billing_state', lang('billing_state'), 'required|trim|min_length[5]|max_length[35]')
    ->set_rules('billing_country', lang('billing_country'), 'required|trim|max_length[2]');


    if ($this->form_validation->run() == TRUE)
    {
        // save the changes
        $data                  = array();

        $data['billing_name']           = $this->input->post('billing_name');
        $data['billing_lastname']       = $this->input->post('billing_lastname');
        $data['billing_method']         = $this->input->post('billing_method');
        $data['billing_address_1']      = $this->input->post('billing_address_1');
        $data['billing_address_2']      = $this->input->post('billing_address_2');
        $data['billing_city']           = $this->input->post('billing_city');
        $data['billing_state']          = $this->input->post('billing_state');
        $data['billing_country']        = $this->input->post('billing_country');
        $data['paypal']                 = $this->input->post('paypal');
        $data['btc_id']                 = $this->input->post('btc_id');
        $data['card_number']            = $this->input->post('card_number');
        $data['card_cvc']               = $this->input->post('card_cvc');
        $data['card_exp1']              = $this->input->post('card_exp1');
        $data['card_exp2']              = $this->input->post('card_exp2');
        $data['card_type']              = $this->input->post('langucard_typeage');

        $saved                 = $this->billing_model->save_user_billing($data, $this->user['id']);

        if ($saved)
        {
            $saved_data = array_merge($this->user, array('has_billing' => $saved));
            $this->session->set_userdata('logged_in', $saved_data);
            $this->session->set_flashdata('message', sprintf(lang('alert_update_success'), lang('action_billing')));
        }
        else
        {
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('action_billing')));
        }
        // reload page and display message
        redirect('profile/billing');
    }

    // setup page header data
    $this
    ->add_plugin_theme(array(
        "datepicker/datepicker3.css",
        "datepicker/bootstrap-datepicker.js",
        "jquery-datatable/datatables.min.css",
        "jquery-datatable/datatables.min.js",
    ), 'default')
    ->add_js_theme( "pages/user/index_i18n.js", TRUE );

    $this->set_title( lang('menu_user').' '.lang('action_billing'));
    $data = $this->includes;

    // set content data
    $content_data = array(
        'billing'              => $this->billing_model->get_user_billing($this->user['id'], TRUE),
        'user'                 => $this->user,
        'btc_balance'          => $this->users_model->get_user_btc($this->user['id']),
    );

    // load views
    $data['content'] = $this->load->view('auth/billing_form', $content_data, TRUE);
    $this->load->view($this->template, $data);
  }

  function get_trans_json($user_id){

    $transactions = $this->btc_model->get_user_transaction($user_id);

    $arr = '';
    foreach($transactions as $transaction){
      $event = $this->events_model->get_events_by_id($transaction['event_id']);
      if(!empty($event))
      {
        $event_title = $event->title;
      }else{
        $event_title = 'Deleted Event';
      }

      $arr[] = array(
        $event_title,
        $transaction['date'],
        $transaction['amount']. ' BTC',
        $transaction['txn_id'],
        $transaction['txn_type'],

      );
    }

    header('Content-Type: application/json');
    echo '{"data":'. json_encode( $arr ).'}';

  }

  function pre_register(){

    // validators
    $this->form_validation
    ->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'))
    ->set_rules('username', lang('users_username'), 'trim|min_length[5]|max_length[30]|callback__check_username')
    ->set_rules('first_name', lang('users_first_name'), 'trim|min_length[2]|max_length[32]')
    ->set_rules('last_name', lang('users_last_name'), 'trim|min_length[2]|max_length[32]')
    ->set_rules('email', lang('users_email'), 'required|trim|max_length[128]|valid_email|callback__check_email')
    ->set_rules('profession', lang('users_profession'), 'trim|min_length[3]|max_length[256]')
    ->set_rules('experience', lang('users_experience'), 'trim|is_natural_no_zero')
    ->set_rules('gender', lang('users_gender'), 'required|trim|in_list[male,female,other]')
    ->set_rules('dob', lang('users_dob'), 'required|trim')
    ->set_rules('mobile', lang('users_mobile'), 'required|trim|min_length[5]|max_length[20]')
    ->set_rules('address', lang('users_address'), 'required|trim|min_length[8]|max_length[256]')
    ->set_rules('language', lang('users_language'), 'trim');

    // upload users image
    if(! empty($_FILES['image']['name'])) // if image
    {
        $file_image         = array('folder'=>'users/images', 'input_file'=>'image');
        // update users image
        $filename_image     = $this->file_uploads->upload_file($file_image);
        // through image upload error
        if(!empty($filename_image['error']))
            $this->form_validation->set_rules('image_error', lang('common_image'), 'required', array('required'=>$filename_image['error']));
    }

    if ($this->form_validation->run() == TRUE)
    {
        // save the changes
        $data                  = array();

        if(!empty($filename_image) && !isset($filename_image['error']))
            $data['image']     = $filename_image;

        if($this->input->post('password') && get_domain() !== 'classiebit.com')
            $data['password']  = $this->input->post('password');

        $data['first_name']    = $this->input->post('first_name');
        $data['last_name']     = $this->input->post('last_name');
        $data['email']         = $this->input->post('email');
        $data['gender']        = $this->input->post('gender');
        $data['dob']           = date("Y-m-d",strtotime($this->input->post('dob')));
        $data['mobile']        = $this->input->post('mobile');
        $data['profession']    = $this->input->post('profession');
        $data['experience']    = $this->input->post('experience');
        $data['address']       = $this->input->post('address');
        $data['language']      = $this->input->post('language');
        if($this->ion_auth->is_non_admin()){
          $data['role']          = 2; //set user automatically to host when profile is updated
        }

        $saved                 = $this->ion_auth->update($this->user['id'], $data);

        if ($saved)
        {
            // reload the new user data and store in session
            $this->user = (array) $this->users_model->get_users_by_id($this->user['id']);
            // unset($this->user['password']);
            // unset($this->user['salt']);

            $_SESSION['groups_id']      = $this->ion_auth->get_users_groups($this->user['id'])->row()->id;

            if($this->ion_auth->is_non_admin()){
              $this->ion_auth->remove_from_group(3, $this->user['id']);
              $this->ion_auth->add_to_group(2, $this->user['id']);
            }

            $saved_data = array_merge($this->user, array('group_name' => 'host'));

            $this->session->set_userdata('logged_in', $saved_data);
            $this->session->language = $this->user['language'];
            $this->session->set_flashdata('message', sprintf(lang('alert_update_success'), lang('action_profile')));
        }
        else
        {
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('action_profile')));
        }

        // reload page and display message
        redirect('profile/pre_register');
    }

    // setup page header data
    $this
    ->add_plugin_theme(array(
        "datepicker/datepicker3.css",
        "datepicker/bootstrap-datepicker.js",
        "jquery-datatable/datatables.min.css",
        "jquery-datatable/datatables.min.js",
    ), 'default')
    ->add_js_theme( "pages/user/index_i18n.js", TRUE );

    $this->set_title( lang('menu_user').' '.lang('act_preregister'));
    $data = $this->includes;

    // set content data
    $content_data = array(
        'cancel_url'        => base_url(),
        'user'              => $this->user,
        'password_required' => FALSE,
    );

    // load views
    $data['content'] = $this->load->view('auth/preregister_form', $content_data, TRUE);
    $this->load->view($this->template, $data);
  }

    /*********BTC PAYMENT SECTION************/
    function post($url, $postfields)
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

    function check_code($redeemcode = NULL){

      $postfields = json_encode(array('redeemcode'=> $redeemcode));
      $response = $this->post("https://bitaps.com/api/get/redeemcode/info", $postfields);

      return  json_decode($response);

    }

    function get_confirmation($address, $user_id)
    {

      $address_details    = $this->btc_model->get_transaction_by_address($address, $user_id);

      if(!empty($address_details))
      {
        $redeemcode_status  =  $this->check_code($address_details[0]['redeem_code']);

        if($address_details[0]['status'] == 'successful')
        {
          return true;
        }
        if($redeemcode_status->balance < bcmul($address_details[0]['amount'], 100000000))
        {
          return false;
        }
        if($redeemcode_status->balance >= bcmul($address_details[0]['amount'], 100000000))
        {
          return true;
        }
      }
      else
      {
        return false;
      }

    }

    function payments()
    {
      //load assets
      $this
      ->add_plugin_theme(array(
          "datepicker/datepicker3.css",
          "datepicker/bootstrap-datepicker.js",
          "jquery-datatable/datatables.min.css",
          "jquery-datatable/datatables.min.js",
          "customs/admin-styles.css",
          "customs/materialize.css",
      ), 'default')
      ->add_js_theme( "pages/user/index_i18n.js", TRUE );

      $this->set_title( lang('menu_user').' '.lang('act_btc_transactions'));
      $data = $this->includes;

      $btc_addresses = $this->btc_model->get_user_addresses($this->user['id']);

      $arr = '';
      foreach ($btc_addresses as $address) {

        $txn_details = $this->btc_model->get_txn_by_aid($address['id']);

        if($this->get_confirmation($address['address'], $this->user['id']))
        {
          $is_confirmed = 'confirmed';
        }
        else
        {
          $is_confirmed = 'not confirmed';
        }

        if($address['status'] == 'pending')
        {
          $process = '<a class="btn-grey" href="'.base_url().'payment/process/'.$address['address'].'"><i class="material-icons">account_balance_wallet</i></a><a class="btn-grey" href="https://bitaps.com/'.$address['address'].'"><i class="material-icons">visibility</i></a>';
        }
        else
        {
          $process = '<a class="btn-grey" href="https://bitaps.com/'.$txn_details[0]['txn_hash'].'"><i class="material-icons">visibility</i></a>';
        }

        $arr[] =  array(
          $address['address'],
          $is_confirmed,
          $address['status'],
          $address['amount'].' BTC',
          $address['date'],
          $process,
        );

      }

      // set content data
      $content_data = array(
          'user'              => $this->user,
          'btc_addresses'     => $arr,
      );

      // load views
      $data['content'] = $this->load->view('btc/btc_user', $content_data, TRUE);
      $this->load->view($this->template, $data);
    }




    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/


    /**
     * Make sure username is available
     *
     * @param  string $username
     * @return int|boolean
     */
    function _check_username($username)
    {
        if (trim($username) != $this->user['username'] && $this->users_model->username_exists($username))
        {
            $this->form_validation->set_message('_check_username', sprintf(lang('users_username_error'), $username));
            return FALSE;
        }
        else
        {
            return $username;
        }
    }


    /**
     * Make sure email is available
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_email($email)
    {
        if (trim($email) != $this->user['email'] && $this->users_model->email_exists($email))
        {
            $this->form_validation->set_message('_check_email', sprintf(lang('users_email_error'), $email));
            return FALSE;
        }
        else
        {
            return $email;
        }
    }

}

/*End User Profile*/
