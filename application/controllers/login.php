<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
    }
    
    function _head()
    {
        $this->load->view('head');
    }

    function _foot()
    {
        $this->load->view('foot');
    }

	function login()
	{
        $this->_head();
        $this->load->helper('url');

        if(!$this->session->userdata('is_login')) {
            $this->load->view('login');
        } else {
            redirect('/story');
        }

        $this->_foot();
    }

    function login_now()
    {
        $this->load->helper('url');

        $user = $this->user_model->getInfo(array('user_id'=>$this->input->post('user_id')));
        if($this->input->post('user_id') == $user->user_id && password_verify($this->input->post('user_pw'), $user->user_pw))  {
            $this->session->set_userdata('is_login', true);
            $this->session->set_userdata('user_id', $user->user_id);

            redirect('/story');
        } else {
            $this->session->set_flashdata('msg', '아이디 혹은 비밀번호가 틀렸습니다.');
            redirect('/login/login');
        }
    }
    
    function register()
    {
        $this->_head();

        $this->load->helper('url');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_id', '유저 아이디', 'required|min_length[5]|max_length[12]|is_unique[tb_user_info.user_id]');
        $this->form_validation->set_rules('user_pw', '유저 비밀번호', 'required|min_length[8]|max_length[16]|matches[user_pw_re]');
        $this->form_validation->set_rules('user_pw_re', '비밀번호 재확인', 'required');
        $this->form_validation->set_rules('phone', '전화번호', 'required|numeric');
        $this->form_validation->set_rules('email', '이메일', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('register');
        } else {
            // 페스워드 헬퍼가 없을 시 생성
            if(!function_exists('password_hash')) {
                $this->load->helper('password');
            }

            $hash = password_hash($this->input->post('user_pw'), PASSWORD_BCRYPT);
            $option = array(
                'user_id'=>$this->input->post('user_id'),
                'user_pw'=>$hash,
                'phone'=>$this->input->post('phone'),
                'email'=>$this->input->post('email')
            );

            $result =  $this->user_model->add($option);
            if($result) {
                $this->session->set_flashdata('msg', '회원가입중 문제 발생');
                $this->load->view('register');
            } else {
                $this->session->set_flashdata('msg', '회원가입이 완료되었습니다.');
                redirect('/login/login');
            }
        }

        $this->_foot();
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->load->helper('url');
        redirect('/story');
    }
}
