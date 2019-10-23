<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Story extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('board_model');
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

    public function index()
    {
        $this->_head();

        $read = $this->board_model->getAll();
        $date = date("m-d", strtotime("+1 day"));
        $this->load->view('story', array('board' => $read, 'timestamp' => $date));

        $this->_foot();
    }

    function view($board_kinds, $id_kinds, $post_id)
    {
        $this->_head();

        $this->board_model->hits($post_id);
        $read = $this->board_model->get($post_id);
        $comment = $this->board_model->comment_call($post_id);

        // 검색을 해서 신청을 햇을 시 $apply = true, 안 햇을 시 $apply = false
        if(!empty($this->session->userdata('is_login'))) {
            $apply = $this->board_model->apply_call($post_id, $this->session->userdata('user_id'));
            if ($apply == true) {
                $apply = true;
            } else {
                $apply = false;
            }
        } else {
            $apply = false;
        }

        // 게시판 정보와 운동 정보가 함께 있을 시
        if ($read['board'] && $read['join']) {
            $this->load->view('read', array('read' => $read['board'], 'join' => $read['join'], 'comment' => $comment, 'apply' => $apply));
        } else {
            $this->load->view('read', array('read' => $read['board'], 'join' => NULL, 'comment' => $comment, 'apply' => $apply));
        }

        $this->_foot();
    }

    // 게시판 작성 관련
    function add()
    {
        // user_data() 가 아닌 userdata()
        if (!$this->session->userdata('is_login')) {
            redirect('/story');
        }

        $this->_head();
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', '제목', 'required');
        $this->form_validation->set_rules('description', '내용', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('add');
        } else {
            $this->board_model->add($this->input->post('title'), $this->input->post('description'), $this->input->post('app_period'), $this->session->userdata('user_id'));
            $this->session->set_flashdata('msg', '게시판 작성 성공!');            
            redirect('/story');
        }

        $this->load->view('foot');
    }

    // 게시판 삭제 관련
    function delete($id)
    {
        $this->board_model->delete($id);
        $this->session->set_flashdata('msg', '삭제되었습니다.');
        redirect('/story');
    }

    // 게시판 수정 관련
    function update($id)
    {
        $this->_head();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', '제목', 'required');
        $this->form_validation->set_rules('description', '내용', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = $this->board_model->get($id);
            $this->load->view('update', array('board' => $data['board']));
        } else {
            $update = $this->board_model->update($this->input->post('title'), $this->input->post('description'), $id, $this->session->userdata('is_login'));
            if ($update == null) {
                $this->session->set_flashdata('msg', '로그인을 해야만 가능한 서비스입니다.');
            } else {
                redirect('/story');
            }
        }

        $this->load->view('foot');
    }

    // CKEditor 사진 업로드 관련
    function upload_receive_from_ck()
    {
        // 사용자가 업로드 한 파일을 /static/user/ 디렉토리에 저장
        $config['upload_path'] = './static/user';
        // gif,jpg,png 파일만 업로드를 허용
        $config['allowed_types'] = 'gif|jpg|png';
        // 허용되는 파일의 최대 사이즈(0일시 제한x)
        $config['max_size'] = '0';
        // 이미지인 경우 허용되는 최대 폭(0일시 제한x)
        $config['max_width']  = '0';
        // 이미지인 경우 허용되는 최대 높이(0일시 제한x)
        $config['max_height']  = '0';

        $this->load->library('upload', $config);

        // do_upload안에 들어갈 upload는 에디터가 자동으로 생성함
        if (!$this->upload->do_upload("upload")) {
            // echo "<script>alert('업로드에 실패했습니다." . $this->upload->display_errors('', '') . "');</script>";
            echo "<script>alert('업로드에 실패했습니다. 이미지 타입(gif, jpg, png)을 확인해 주세요.');</script>";
        } else {
            $CKEditorFuncNum = $this->input->get('CKEditorFuncNum');

            $data = $this->upload->data();
            $filename = $data['file_name'];

            $url = '/static/user/' . $filename;

            echo "<script>
            window.parent.CKEDITOR.tools.callFunction(
                '" . $CKEditorFuncNum . "',
                '" . $url . "',
                '전송 성공',
            );
            </script>";
        }
    }

    // 좋아요 관련
    function like()
    {
        if (!empty($this->session->userdata('is_login'))) {
            $checker = $this->board_model->likeChecker($this->input->post('post_id'), $this->session->userdata('user_id'));
            if ($checker == true) {
                $error = 2; // 2: 중복 에러
                echo $error;
            } else {
                $this->board_model->likeSave($this->input->post('post_id'), $this->session->userdata('user_id'));
                $result = $this->board_model->like($this->input->post('post_id'));
                echo $result;
            }
        } else {
            $error = 1; // 1: 로그인 에러
            echo $error;
        }
    }

    // 모집 신청
    function apply()
    {
        if (!empty($this->session->userdata('is_login'))) {
            $checker = $this->board_model->applyChecker($this->input->post('post_id'), $this->session->userdata('user_id'));
            if ($checker == true) {
                $error = 2; // 2: 중복 에러
                echo $error;
            } else {
                $result = $this->board_model->apply($this->input->post('post_id'));
                if ($result != null) {
                    $this->board_model->applySave($this->input->post('post_id'), $this->session->userdata('user_id'));
                    echo $result + 1;
                } else {
                    $error = 3; // 3: 신청 기간 종료
                    echo $error;
                }
            }
        } else {
            $error = 1; // 1: 로그인 에러
            echo $error;
        }
    }

    // 댓글 관련
    function comment()
    {
        if (!empty($this->session->userdata('is_login'))) {
            $this->board_model->comment_save($this->input->post('post_id'), $this->session->userdata('user_id'), $this->input->post('content'));
        } else {
            $error = 1;
            echo $error;
        }
    }

    // 답글 달기
    function reply()
    {
        if (!empty($this->session->userdata('is_login'))) {
            $this->board_model->reply_save($this->input->post('post_id'), $this->session->userdata('user_id'), $this->input->post('content'), $this->input->post('parent_id'));
        } else {
            $error = 1;
            echo $error;
        }
    }

    // 답글 보기
    function replyView()
    {
        $result = $this->board_model->reply_call($this->input->post('post_id'), $this->input->post('parent_id'));
        foreach ($result as $item) {
            $list[] = array(
                'user_id' => $item->user_id,
                'profile' => $item->profile,
                'rank' => $item->rank,
                'level' => $item->level,
                'reply' => $item->comment_contents,
                'date' => $item->comment_date,
                'error' => false
            );
        }

        if(!empty($list)) {
            echo json_encode($list); // 받은 배열을 json으로 변경해서 ajax에 보내기
        } else {
            $error[] = array('error' => true);
            echo json_encode($error);
        }
    }
}

// http://m.tranggle.com/story/ => 여기까지는 메인 페이지(리스트형) 영역
// /view/story/post_id/216298 => 여기서 부터는 함수(파라미터) 영역
