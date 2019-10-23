<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->helper('url');
    }

    function _head()
    {
        $this->load->view('head');
    }

    function _foot()
    {
        $this->load->view('foot');
    }

    // 유저 정보 수정
    function userinfo()
    {
        $this->_head();

        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('msg', '로그인을 해야만 가능한 서비스입니다.');
            redirect('/login/login');
        } else {
            $this->load->library('form_validation');

            // 전부다 자연수인지 확인
            $this->form_validation->set_rules('height', '높이', 'is_natural');
            $this->form_validation->set_rules('weight', '몸무게', 'is_natural');
            $this->form_validation->set_rules('age', '나이', 'is_natural');

            if ($this->form_validation->run() == FALSE) {
                $user = $this->user_model->getProfile(array('user_id' => $this->session->userdata('user_id')));
                $this->load->view('userProfile', array('userinfo' => $user));
            } else {
                // 파일명 변경
                $img = $_FILES['img-file']['tmp_name'];
                if ($img) {
                    $file_name = $_FILES['img-file']['name'];
                    $type_check = explode('.', $file_name);
                    $type_check[0] = $type_check[0] . '_' . $this->session->userdata('user_id');
                    $img_checker = true;
                } else {
                    $img_checker = false;
                }

                // 사용자가 업로드 한 파일을 /static/imgs/profile 디렉토리에 저장
                $config['upload_path'] = './static/imgs/profile';
                // gif,jpg,png 파일만 업로드를 허용
                $config['allowed_types'] = 'gif|jpg|png';
                // 파일명 교체
                $config['file_name'] = $type_check[0];
                // 한글 파일명 이름 암호화
                $config['encrypt_name'] = 'TRUE';
                // 허용되는 파일의 최대 사이즈(0은 제한x)
                $config['max_size'] = '0';
                // 이미지인 경우 허용되는 최대 폭(0은 제한x)
                $config['max_width'] = '0';
                // 이미지인 경우 허용되는 최대 높이(0은 제한x)
                $config['max_height'] = '0';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('img-file') && $img_checker) {
                    echo "<script>alert('업로드에 실패했습니다." . $this->upload->display_errors('', '') . "');</script>"; // 개발자용
                    redirect('user/userinfo');
                } else {
                    $user = $this->user_model->getProfile(array('user_id' => $this->session->userdata('user_id')));

                    // 변경될 키 체크
                    if ($this->input->post('height') != $user->height && $this->input->post('height') >= 0) {
                        $height = $this->input->post('height');
                    } else {
                        $height = $user->height;
                    }

                    // 변경될 몸무게 체크
                    if ($this->input->post('weight') != $user->weight && $this->input->post('weight') >= 0) {
                        $weight = $this->input->post('weight');
                    } else {
                        $weight = $user->weight;
                    }

                    // 변경될 나이 체크
                    if ($this->input->post('age') != $user->age && $this->input->post('age') >= 0) {
                        $age = $this->input->post('age');
                    } else {
                        $age = $user->age;
                    }

                    // gender option
                    $radioVal = $this->input->post('gender');

                    if ($img_checker) {
                        $data = $this->upload->data();
                        $filename = $data['file_name'];
                        $url = '/static/imgs/profile/' . $filename;

                        $data = array(
                            'birthday' => $this->input->post('birthday'),
                            'real_name' => $this->input->post('real_name'),
                            'height' => $height,
                            'weight' => $weight,
                            'age' => $age,
                            'gender' => $radioVal,
                            'img_url' => $url,
                        );
                    } else {
                        $data = array(
                            'birthday' => $this->input->post('birthday'),
                            'real_name' => $this->input->post('real_name'),
                            'height' => $height,
                            'weight' => $weight,
                            'age' => $age,
                            'gender' => $radioVal,
                        );
                    }


                    $data = $this->user_model->saveProfile($data, $img_checker);
                    if ($data == null) {
                        $this->session->set_flashdata('msg', '프로필 저장에 실패하셧습니다.');
                        redirect('/user/userinfo');
                    } else {
                        $this->session->set_flashdata('msg', '프로필 저장에 성공');
                        redirect('/story');
                    }
                }
            }
        }

        $this->_foot();
    }
}
