<script src="/static/lib/ckeditor/ckeditor.js"></script>

<div class="add-page">
    <section id="add-page">
        <form action="/story/update/<?=$board->post_id?>" method="post">
            <?php
            // set_rules로 유효성 검사 실패시 띄운다.
            if (validation_errors()) {
                echo "<script>alert('제목, 내용을 채워주세요.');</script>";
            }
            ?>
            <div class="fromBox">
                <input type="text" name="title" class="title" value="<?=$board->title?>">
                <br>
                <textarea name="description" class="description"><?=$board->contents?></textarea>
                <input type="submit" class="submit" value="전송">
            </div>
        </form>
    </section>
</div>

<script>
    CKEDITOR.replace('description', {
        'filebrowserUploadUrl': '/story/upload_receive_from_ck',
        height: 400
    });
</script>