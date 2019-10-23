<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // 회원 가입
    function add($info)
    {
        // 유저 필수 정보 추가
        $this->db->set('user_id', $info['user_id']);
        $this->db->set('user_pw', $info['user_pw']);
        $this->db->set('phone', $info['phone']);
        $this->db->set('email', $info['email']);
        $this->db->set('reg_date', 'NOW()', false);
        $this->db->set('mod_date', 'NOW()', false);
        $this->db->insert('tb_user_info');

        $result = $this->db->insert_id();

        // 유저 선택 정보 추가
        $this->db->set('user_id', $info['user_id']);
        $this->db->set('height', 0);
        $this->db->set('weight', 0);
        $this->db->set('age', 0);
        $this->db->set('gender', 'none');
        $this->db->set('profile', '/static/imgs/noImage/noImage.png');
        $this->db->set('rank', '짐꾼');
        $this->db->set('level', 1);
        $this->db->set('mod_date', 'NOW()', false);
        $this->db->insert('tb_user_profile');

        return $result;
    }

    // 유저 정보
    function getInfo($info)
    {
        $result = $this->db->get_where('tb_user_info', array('user_id' => $info['user_id']))->row();
        return $result;
    }

    // 유저 프로필 정보
    function getProfile($info)
    {
        $result = $this->db->get_where('tb_user_profile', array('user_id' => $info['user_id']))->row();
        return $result;
    }

    // 유저 프로필 저장
    function saveProfile($info, $img_checker)
    {
        if ($this->session->userdata('is_login')) {
            // 유저 생년월일, 실명, 키, 몸무게, 나이, 성별
            $this->db->where('user_id', $this->session->userdata('user_id'));

            if ($img_checker) {
                $profile_info = array(
                    'birthday' => $info['birthday'],
                    'real_name' => $info['real_name'],
                    'height' => $info['height'],
                    'weight' => $info['weight'],
                    'age' => $info['age'],
                    'gender' => $info['gender'],
                    'profile' => $info['img_url'],
                    'mod_date' => date('Y-m-d', time())
                );
                $data = $this->db->update('tb_user_profile', $profile_info);
            } else {
                $profile_info = array(
                    'birthday' => $info['birthday'],
                    'real_name' => $info['real_name'],
                    'height' => $info['height'],
                    'weight' => $info['weight'],
                    'age' => $info['age'],
                    'gender' => $info['gender'],
                    'mod_date' => date('Y-m-d', time())
                );
                $data = $this->db->update('tb_user_profile', $profile_info);
            }
            return $data;
        } else {
            return null;
        }
    }
}
