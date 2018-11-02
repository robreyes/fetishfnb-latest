<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Welcome Controller
 *
 * This class handles welcome module functionality
 *
 * @package     classiebit
 * @author      prodpk
*/

class Welcome extends Public_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->load->model(array(
                            'admin/gallaries_model',
                            'admin/testimonials_model',
                            'admin/blogs_model',
                            'notifications_model',
                            'course_model',
                            'event_model',
                            'users_model',
                        ));
    }

    private function get_featured_c_e()
    {
        $data['f_courses']          = $this->course_model->get_f_courses();
        $data['f_events']           = $this->event_model->get_f_events();

        $tutor_ids                          = array();
        foreach($this->ion_auth->get_users_by_group(2)->result() as $val)
            $tutor_ids[] = $val->user_id;

        $data['tutors']             = $this->course_model->get_tutors($tutor_ids);

        foreach($data['f_courses'] as $key => $val)
            if($val->users_id)
                foreach($data['tutors'] as $v)
                    if($v->id === $val->users_id)
                        $val->tutor = $v;

        return $data;
    }

    /**
	 * Default
     */
	function index()
	{

    //check if being accessed from other domain and the redirect if needed
    $base_url = parse_url(base_url());
    $base_host = $base_url['host'];

    if($_SERVER['HTTP_HOST'] != $base_host)
    {
      redirect(base_url());
    }

    /* Initialize assets and title */
        $this
        ->add_plugin_theme(array(
            "owl-carousel/owl.carousel.css",
            "owl-carousel/owl.carousel.min.js",
            "hero-slider/js/main.js",
            "hero-slider/css/style.css",
            "js-cookie/src/js.cookie.js",
            "jquery-modal/jquery-modal-master/jquery.modal.min.css",
            "jquery-modal/jquery-modal-master/jquery.modal.min.js",
            "theme-lib/counter.js",
            "theme-lib/isotope.pkgd.min.js",
            "theme-lib/jquery.mb.YTPlayer.min.js",
            // "theme-lib/jquery.stellar.min.js",
            'easy-autocomplete/easy-autocomplete.min.css',
            'easy-autocomplete/easy-autocomplete.themes.min.css',
            'easy-autocomplete/jquery.easy-autocomplete.min.js',
        ), 'default')
        ->add_js_theme( "pages/welcome/index_i18n.js", TRUE );

        // setup page header data
        $this->set_title(sprintf(lang('welcome title'), $this->settings->site_name));

        $data           = $this->includes;

        $c_e_data       = $this->get_featured_c_e();

        // set content data
        $content_data   = array(
            'gallaries'       => $this->gallaries_model->get_gallaries(6),
            'testimonials'    => $this->testimonials_model->get_testimonials(),
            'f_courses'       => $c_e_data['f_courses'],
            'f_events'        => $this->event_model->get_rand_events(6),
            'tutors'          => $c_e_data['tutors'],
            'count_courses'   => $this->course_model->count_courses(),
            'count_batches'   => $this->course_model->count_batches(),
            'count_events'    => $this->event_model->count_events(),
            'count_tutors'    => $this->users_model->count_users(),
            'u_events'        => $this->event_model->get_u_events(),
            'blogs'           => $this->blogs_model->get_blogs(3),
            'rand_cat_events' => $this->event_model->get_cat_rand_events(6),
        );

        // load views
        $data['content'] = $this->load->view('welcome', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}

  function save_contact()
  {
    $this->form_validation->set_rules('contact_email', lang('users_email'), 'required|trim|max_length[128]|valid_email|is_unique[contacts.email]');
    $this->form_validation->set_message('is_unique', lang('optin_sub_error_exist'));

    if($this->form_validation->run() === FALSE)
    {
      // for fetching specific fields errors in order to view errors on each field seperately
      $error_fields = array();
      foreach($_POST as $key => $val)
          if(form_error($key))
              $error_fields[] = $key;

      echo json_encode(array('flag' => 0, 'msg' => validation_errors(), 'error_fields' => json_encode($error_fields)));
      exit;
    }

    $data  = array();
    $data['email']         = $this->input->post('contact_email');
    $data['date_added']    = date("Y-m-d h:i:sa");

    $flag = $this->users_model->save_contact($data);

    if($flag)
    {

        $notification   = array(
            'contacts_id'   =>  $flag,
            'n_type'        => 'contact',
            'n_content'     => 'noti_new_added',
            'n_url'         => site_url('admin/contacts'),
        );
        $this->notifications_model->save_notifications($notification);
        $this->session->set_flashdata('message', sprintf(lang('optin_sub_success')));

        header('Content-Type: application/json');
        echo json_encode(array(
                                'flag'  => 1,
                                'msg'   => $this->session->flashdata('message'),
                                'type'  => 'success',
                            ));
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode(array(
                            'flag'  => 0,
                            'msg'   => $this->session->flashdata('message'),
                            'type'  => 'fail',
                        ));
    exit;

  }

}

/* Welcome controller ends */
