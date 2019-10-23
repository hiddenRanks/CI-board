<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/lib/fontawesome-free-5.11.2-web/css/all.min.css">

    <?php if ($this->session->flashdata('msg')): ?>
        <script>
            alert('<?= $this->session->flashdata('msg') ?>');
        </script>
    <?php endif ?>
</head>

<body>
    <header>
        <section id="head-menu">
            <a href="/story">
                <h1>게시판</h1>
            </a>

            <div class="user-box">
                <?php if ($this->session->userdata('is_login')): ?>
                    어서오세요, <a href="/user/userinfo"><?= $this->session->userdata('user_id') ?></a>님! &nbsp;
                    <a href="/login/logout" class="logout-btn">로그아웃</a> &nbsp;
                    <a href="/story/add" class="write-btn">글쓰기</a>
                <?php else: ?>
                    <a href="/login/login">로그인</a>
                    <a href="/login/register">회원가입</a>
                <?php endif ?>
            </div>
        </section>
    </header>