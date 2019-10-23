<div class="read-frame">
    <section id="read-frame">
        <input type="hidden" class="post-id" value="<?= $read->post_id ?>">
        <div class="read-title">
            <h2><?= $read->title ?></h2>
            <div class="read-info">
                <span>writeBy <?= $read->user_id ?></span>
            </div>
        </div>

        <div class="hit-like">
            <span class="likes">
                <i class="far fa-heart"></i>&nbsp;<span><?= $read->likes ?></span>
            </span>
            <span class="hits">
                <i class="far fa-eye"></i></i>&nbsp;<span><?= $read->hits ?></span>
            </span>
        </div>

        <?php if ($read->app_period != null && $read->app_period != '0000-00-00 00:00:00'): ?>
            <div class="come-together">
                <span class="period-btn">
                    <?php if ($apply): ?>
                        모집완료
                    <?php else: ?>
                        모집신청
                    <?php endif ?>
                </span>
                모집 기간 <?= $read->app_period ?>까지
            </div>
            <div class="period_cnt">
                <?php if ($read->recruit_cnt == null): ?>
                    <span>0</span>
                <?php else: ?>
                    <span><?= $read->recruit_cnt ?></span>
                <?php endif ?>
                명이 신청했습니다.
            </div>
        <?php endif ?>

        <?php if ($join != NULL): ?>
            <div class="exercise-total">
                <?php foreach ($join->result() as $item): ?>
                    <span class="sport-title"><?= $item->sport ?></span>
                    <div class="exercise-total-result">
                        <span class="exercise-total-list">
                            <span class="record-title">거리</span>
                            <strong><?= $item->total_dist ?></strong>
                            <span class="unit">km/h</span>
                        </span>
                        <span class="exercise-total-list">
                            <span class="record-title">전체 시간</span>
                            <strong><?= $item->total_time ?></strong>
                        </span>
                        <span class="exercise-total-list">
                            <span class="record-title">평균속도</span>
                            <strong><?= $item->avg_spd ?></strong>
                            <span class="unit">km/h</span>
                        </span>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <div class="read-content"><?= $read->contents ?></div>

        <?php if ($join != NULL): ?>
            <div class="read-exercise">
                <?php foreach ($join->result() as $item): ?>
                    <ul class="item-act">
                        <li>
                            <label>시&emsp;&emsp;간</label>
                            <ul class="item-list">
                                <li>
                                    <p>운동시간</p>
                                    <span><?= $item->sport_time ?></span>
                                </li>
                                <li>
                                    <p>전체시간</p>
                                    <span><?= $item->total_time ?></span>
                                </li>
                                <li>
                                    <p>휴식시간</p>
                                    <span><?= $item->break_time ?></span>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>거&emsp;&emsp;리</label>
                            <ul class="item-list">
                                <li>
                                    <p>운동거리</p>
                                    <span>
                                        <?= $item->sport_dist ?> <span class="unit">km</span>
                                    </span>
                                </li>
                                <li>
                                    <p>총 거리</p>
                                    <span>
                                        <?= $item->total_dist ?> <span class="unit">km</span>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>속&emsp;&emsp;도</label>
                            <ul class="item-list">
                                <li>
                                    <p>최고속도</p>
                                    <span>
                                        <?= $item->max_spd ?> <span class="unit">km/h</span>
                                    </span>
                                </li>
                                <li>
                                    <p>평균속도</p>
                                    <span>
                                        <?= $item->avg_spd ?> <span class="unit">km/h</span>
                                    </span>
                                </li>
                                <li>
                                    <p>구간속도</p>
                                    <span>
                                        <?= $item->section_spd ?> <span class="unit">km/h</span>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>고&emsp;&emsp;도</label>
                            <ul class="item-list">
                                <li>
                                    <p>시작고도</p>
                                    <span>
                                        <?= $item->start_alt ?> <span class="unit">m</span>
                                    </span>
                                </li>
                                <li>
                                    <p>최고고도</p>
                                    <span>
                                        <?= $item->max_alt ?> <span class="unit">m</span>
                                    </span>
                                </li>
                                <li>
                                    <p>누적고도</p>
                                    <span>
                                        <?= $item->acc_alt ?> <span class="unit">m</span>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>경&ensp;사&ensp;도</label>
                            <ul class="item-list">
                                <li>
                                    <p>오르막</p>
                                    <span>
                                        <?= $item->ascent ?> <span class="unit">km</span>
                                    </span>
                                </li>
                                <li>
                                    <p>내리막</p>
                                    <span>
                                        <?= $item->down_hill ?> <span class="unit">km</span>
                                    </span>
                                </li>
                                <li>
                                    <p>평지</p>
                                    <span>
                                        <?= $item->plain ?> <span class="unit">km</span>
                                    </span>
                                </li>
                                <li>
                                    <p>평균경사도</p>
                                    <span>
                                        <?= $item->slope ?> <span class="unit">%</span>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label>소모열량</label>
                            <span>
                                <?= $item->calori_burn ?> <span class="unit">kcal</span>
                            </span>
                        </li>
                    </ul>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <?php if ($this->session->userdata('is_login') && ($this->session->userdata('user_id') == $read->user_id)): ?>
            <div class="btn-box">
                <a href="/story/delete/<?= $read->post_id ?>" class="remove-btn">삭제</a>
                <a href="/story/update/<?= $read->post_id ?>" class="update-btn">수정</a>
            </div>
        <?php endif ?>

        <div class="comment-box">
            <?php if (!$this->session->userdata('is_login')): ?>
                <a href="/login/login">댓글을 다실려면&nbsp;<span>로그인</span>을 하셔야합니다.</a>
            <?php else: ?>
                <textarea name="comment_form" id="comment-form"></textarea>
                <span class="comment-btn">전송</span>
            <?php endif ?>
        </div>
        <div class="comment-area">
            <ul>
                <?php foreach ($comment as $item): ?>
                    <li>
                        <div class="comment-userinfo">
                            <span class="comment-profile"><img src="<?= $item->profile ?>"></span>
                            <div>
                                <span class="comment-id"><?= $item->user_id ?></span>
                                <span class="comment-state">(<?= $item->rank ?> / <?= $item->level ?>)</span>
                            </div>
                        </div>
                        <div class="comment-contents"><?= $item->comment_contents ?></div>
                        <div class="comment-date"><?= $item->comment_date ?></div>
                        <!-- href="/story/reply/item->comment_id"  -->
                        <a onclick="javascript:openTab('<?= $item->comment_id ?>', '<?= $item->user_id ?>')">
                            답글 <span class="reply_cnt"><?= $item->reply_cnt ?></span>
                        </a>
                        <div class="reply" id="<?= $item->comment_id ?>">
                            <ul>

                            </ul>
                        </div>
                        <div class="reply-formbox" id="reply-<?= $item->comment_id ?>">
                            <?php if (!$this->session->userdata('is_login')): ?>
                                <a href="/login/login">답글을 다실려면&nbsp;<span>로그인</span>을 하셔야합니다.</a>
                            <?php else: ?>
                                <textarea name="reply_form" id="reply-form"></textarea>
                                <span class="reply-btn">전송</span>
                            <?php endif ?>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    // 조회수 기능
    $(document).on('click', '.likes', function() {
        let post_id = $('.post-id').val();

        $.ajax({
            url: "/story/like",
            type: "POST",
            data: {
                post_id: post_id
            },
            success: function(data) {
                // console.log(data);
                if (data == 1) {
                    alert('로그인한 사용자만 가능한 서비스입니다.');
                    location.replace('/login/login');
                } else if (data == 2) {
                    alert('이미 좋아요를 누르셧습니다.');
                } else {
                    $('.likes > span').replaceWith(data);
                }
            },
            error: function(request, status, error) {
                alert("code: " + request.status + "\n" + "message: " + request.responseText + "\n" + "error: " + error);
            }
        });
    });

    // 신청 기능
    $(document).on('click', '.period-btn', function() {
        let post_id = $('.post-id').val();

        $.ajax({
            url: "/story/apply",
            type: "POST",
            data: {
                post_id: post_id
            },
            success: function(data) {
                // console.log(data);
                if (data == 1) {
                    alert('로그인한 사용자만 가능한 서비스입니다.');
                    location.replace('/login/login');
                } else if (data == 2) {
                    alert('이미 신청하셧습니다.');
                } else if (data == 3) {
                    alert('신청 기간이 이미 종료되었습니다.');
                } else {
                    $('.period_cnt > span').replaceWith(data);
                }
            },
            error: function(request, status, error) {
                alert("code: " + request.status + "\n" + "message: " + request.responseText + "\n" + "error: " + error);
            }
        });
    });

    // 댓글 기능
    $(document).on('click', '.comment-btn', function() {
        let post_id = $('.post-id').val();
        let comment_form = $('#comment-form').val();

        if(!comment_form) {
            alert('내용을 넣으셔야합니다.');
            return;
        }

        $.ajax({
            url: "/story/comment",
            type: "POST",
            data: {
                post_id: post_id,
                content: comment_form
            },
            success: function(data) {
                // console.log(data);
                if (data == 1) {
                    alert('로그인한 사용자만 가능한 서비스입니다.');
                    location.replace('/login/login');
                } else {
                    alert('등록 완료!');
                    location.replace('/story/view/story/post_id/' + post_id);
                }
            },
            error: function(request, status, error) {
                alert("code: " + request.status + "\n" + "message: " + request.responseText + "\n" + "error: " + error);
            }
        });
    });

    // 답글(출력 및 전송)
    let click_cnt = 0;

    function openTab(comment_id, user_id) {
        if (click_cnt == 1) {
            $('#' + comment_id).css('display', 'none');
            $('#reply-' + comment_id).css('display', 'none');
            click_cnt = 0;
        } else {
            // 답글 불러오기
            let post_id = $('.post-id').val();

            $.ajax({
                url: "/story/replyView",
                type: "POST",
                data: {
                    post_id: post_id,
                    parent_id: comment_id
                },
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    let htmls = "";
                    if (data[0].error == false) {
                        // function(value, index, array)
                        data.forEach(function(v, i, a) {
                            htmls += '<li class="reply-box">'; // 시작
                            htmls += '<div>'; // 유저 정보들 감싸기
                            htmls += '<div class="reply-userinfo">'; // 유저 정보 박스
                            htmls += '<span class="reply-profile"><img src="' + v.profile + '"></span>'; // 유저 프로필 사진
                            htmls += '<div class="reply-userstat">'; // 유저 스텟 박스
                            htmls += '<span class="reply-id">' + v.user_id + '</span>'; // 유저 아이디
                            htmls += '<span class="reply-state"> (' + v.rank + ' / ' + v.level + ')</span>'; // 유저 스텟
                            htmls += '</div>'; // 유저 스텟 박스 끝
                            htmls += '</div>'; // 유저 정보 박스 끝
                            htmls += '<div class="reply-contents">' + v.reply + '</div>'; // 답글 내용
                            htmls += '<div class="reply-date">' + v.date + '</div>'; // 답글 쓴 날짜
                            htmls += '</div>'; // 유저 정보들 감싸기 끝
                            htmls += '</li>'; // 시작 끝
                        });
                    } else {
                        htmls += '<li class="none-box">답글이 없습니다.</li>';
                    }
                    $('#' + comment_id).html(htmls);
                    htmls = "";
                },
                error: function(request, status, error) {
                    alert("code: " + request.status + "\n" + "message: " + request.responseText + "\n" + "error: " + error);
                }
            });

            $('#' + comment_id).css('display', 'block');
            $('#reply-' + comment_id).css('display', 'block');
            click_cnt = 1;
        }

        // 답글 달기
        let parent_id = comment_id;
        $(document).on('click', '.reply-btn', function() {
            var post_id = $('.post-id').val();
            var reply_form = $('#reply-form').val();

            if(!reply_form) {
                alert('내용을 넣으셔야합니다.');
                return;
            }

            $.ajax({
                url: "/story/reply",
                type: "POST",
                data: {
                    post_id: post_id,
                    content: reply_form,
                    parent_id: parent_id
                },
                success: function(data) {
                    // console.log(data);
                    if (data == 1) {
                        alert('로그인한 사용자만 가능한 서비스입니다.');
                        location.replace('/login/login');
                    } else {
                        alert('답글 등록!');
                        location.replace('/story/view/story/post_id/' + post_id);
                    }
                },
                error: function(request, status, error) {
                    alert("code: " + request.status + "\n" + "message: " + request.responseText + "\n" + "error: " + error);
                }
            });
        });
    }
</script>