<script src="/static/lib/ckeditor/ckeditor.js"></script>

<div class="add-page">
    <section id="add-page">
        <form action="/story/add" method="post">
            <?php
            // set_rules로 유효성 검사 실패시 띄운다.
            if (validation_errors()) {
                echo "<script>alert('제목, 내용을 채워주세요.');</script>";
            }
            ?>
            <div class="fromBox">
                <input type="text" name="title" class="title">
                모집 기한: <input type="datetime-local" name="app_period" class="app_period">
                <br>
                <textarea name="description" class="description"></textarea>
                <input type="submit" class="submit" value="전송">
            </div>
        </form>
    </section>
</div>

<script>
    // ckeditor를 화면에 생성하는 api
    // name이 description인 값을 ck에디터가 가져온다
    CKEDITOR.replace('description', {
        'filebrowserUploadUrl': '/story/upload_receive_from_ck',
        height: 400
    });
</script>