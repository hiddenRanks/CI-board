<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Board_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // 게시글 전체 가져오기
    function getAll()
    {
        $this->db->select('*');
        $this->db->from('tb_user_board');
        $this->db->order_by('post_id', 'desc');
        // $this->db->limit(15); // 다른 페이지를 만들 시간이 없으므로 주석

        return $this->db->get();
    }

    // 게시글 정보 가져오기(운동 정보가 있으면 동시에)
    function get($info)
    {
        // 게시판 정보
        $board = $this->db->get_where('tb_user_board', array('post_id' => $info))->row();

        // 운동 정보
        $this->db->select('c.*');
        $this->db->from('tb_gpx_course a');
        $this->db->join('tb_user_board b', 'b.file_path=a.file_path')->where('b.file_path', $board->file_path);
        $this->db->join('tb_exercise_record c', "c.gpx_id=a.gpx_id");

        $exercise = $this->db->get();

        // 'board' => 게시판 정보, 'join' => 운동 정보
        $array = array('board' => $board, 'join' => $exercise);

        return $array;
    }

    // 게시판 작성
    function add($title, $contents, $app_period, $write_id)
    {
        $this->db->set('write_date', 'NOW()', false);
        return $this->db->insert('tb_user_board', array(
            'user_id' => $write_id,
            'title' => $title,
            'contents' => $contents,
            'app_period' => $app_period
        ));

        return $this->db->insert_id();
    }

    // 게시파 삭제
    function delete($post_id)
    {
        return $this->db->delete('tb_user_board', array('post_id' => $post_id));
    }

    // 게시판 수정
    function update($title, $contents, $post_id, $is_login)
    {
        if ($is_login) {
            $this->db->where('post_id', $post_id);
            return $this->db->update('tb_user_board', array('title' => $title, 'contents' => $contents));
        } else {
            return null;
        }
    }

    // 조회수
    function hits($post_id)
    {
        $board_idx = intval($post_id); // 정수형 값 반환
        $date = date('Y-m-d'); // ex) 2019-10-16
        $this->load->helper('cookie');
        if (empty(get_cookie("board_{$board_idx}_{$date}"))) {
            $this->db->set('hits', 'hits + 1', false); // true로 하면 hits + 1이 그대로 들어가 버린다.
            $this->db->where('post_id', $board_idx);
            $this->db->update('tb_user_board');

            set_cookie("board_{$board_idx}_{$date}", "1", time() + 86400);
        }
    }

    // 좋아요: 카운트
    function like($post_id)
    {
        $this->db->set('likes', 'likes + 1', false);
        $this->db->where('post_id', $post_id);
        $this->db->update('tb_user_board');

        // 좋아요 조회
        $board = $this->db->get_where('tb_user_board', array('post_id' => $post_id))->row();

        return $board->likes;
    }

    // 좋아요: 유저 아이디와 게시판 아이디 저장(중복 체크를 위한 저장)
    function likeSave($post_id, $user_id)
    {
        $data = array(
            'post_id' => $post_id,
            'user_id' => $user_id
        );
        $this->db->insert('tb_user_like', $data);

        return $this->db->insert_id();
    }

    // 좋아요: 중복 체크
    function likeChecker($post_id, $user_id)
    {
        $board = $this->db->get_where('tb_user_like', array('post_id' => $post_id, 'user_id' => $user_id))->row();

        return $board;
    }


    // 신청: 카운트
    function apply($post_id)
    {
        // 신청 조회
        $board = $this->db->get_where('tb_user_board', array('post_id' => $post_id))->row();
        $now_time = strtotime(date('Y-m-d H:i:s'));
        $record_time = strtotime($board->app_period);

        if ($now_time > $record_time) {
            return null;
        } else {
            $this->db->set('recruit_cnt', 'recruit_cnt + 1', false);
            $this->db->where('post_id', $post_id);
            $this->db->update('tb_user_board');

            return $board->recruit_cnt;
        }
    }

    // 신청: 유저 아이디와 게시판 아이디 저장(중복 체크를 위한 저장)
    function applySave($post_id, $user_id)
    {
        $data = array(
            'post_id' => $post_id,
            'user_id' => $user_id
        );
        $this->db->insert('tb_user_apply', $data);

        return $this->db->insert_id();
    }

    // 신청: 중복 및 기간체크
    function applyChecker($post_id, $user_id)
    {
        $apply = $this->db->get_where('tb_user_apply', array('post_id' => $post_id, 'user_id' => $user_id))->row_array();
        if(count($apply) == 2) {
            return true;
        } else {
            return false;
        }
    }

    // 신청: 유저 확인
    function apply_call($post_id, $user_id)
    {
        $apply = $this->db->get_where('tb_user_apply', array('post_id' => $post_id, 'user_id' => $user_id))->row_array();
        if(count($apply) == 2) {
            return true;
        } else {
            return false;
        }
    }

    // 댓글 추가
    function comment_save($post_id, $user_id, $content)
    {
        // 댓글-답글 카운트
        $this->db->set('comment_cnt', 'comment_cnt + 1', false);
        $this->db->where('post_id', $post_id);
        $this->db->update('tb_user_board');

        // 댓글 추가
        $this->db->set('comment_date', 'NOW()', false);
        return $this->db->insert('tb_user_comment', array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'comment_contents' => $content
        ));

        return $this->db->insert_id();
    }

    // 댓글 불러오기
    function comment_call($post_id)
    {
        $this->db->select('a.*, b.profile, b.rank, b.level');
        $this->db->from('tb_user_comment a');
        $this->db->join('tb_user_profile b', 'b.user_id=a.user_id')->where(array('a.post_id' => $post_id, 'a.grpno' => 0));
        $this->db->order_by('a.comment_id', 'desc');
        $query = $this->db->get();

        return $query->result();
    }

    // 답글 추가
    function reply_save($post_id, $user_id, $content, $parent_id)
    {
        // 댓글-답글 카운트
        $this->db->set('comment_cnt', 'comment_cnt + 1', false);
        $this->db->where('post_id', $post_id);
        $this->db->update('tb_user_board');

        // 답글 카운트
        $this->db->set('reply_cnt', 'reply_cnt + 1', false);
        $this->db->where('comment_id', $parent_id);
        $this->db->update('tb_user_comment');

        // 답글 추가
        $this->db->set('comment_date', 'NOW()', false);
        return $this->db->insert('tb_user_comment', array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'comment_contents' => $content,
            'grpno' => $parent_id,
            'depth' => 1
        ));

        return $this->db->insert_id();
    }

    // 답글 불러오기
    function reply_call($post_id, $parent_id)
    {
        $this->db->select('a.*, b.profile, b.rank, b.level');
        $this->db->from('tb_user_comment a');
        $this->db->join('tb_user_profile b', 'b.user_id=a.user_id')->where(array('a.post_id' => $post_id, 'a.grpno' => $parent_id));
        $query = $this->db->get();

        return $query->result();
    }
}
