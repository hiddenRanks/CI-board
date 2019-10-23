<div class="profile">
    <section id="profile">
        <form action="/user/userinfo" method="post" enctype="multipart/form-data">
            <div class="profile-frame">
                <span>유저 정보</span>
                <div class="userinfo">
                    <div class="file-box">
                        <div class="img_wrap">
                            <img id="img" src="<?= $userinfo->profile ?>">
                        </div>

                        <label for="img-file">업로드</label>
                        <input type="file" name="img-file" id="img-file" accept="image/*" value="<?= $userinfo->profile ?>">
                    </div>
                    <div class="info-box">
                        <span class="profile-id">
                            <span><?= $userinfo->user_id ?></span>
                        </span>
                        <div class="stats">
                            <span class="rank">짐꾼</span> /
                            <span class="level">1</span> 레벨
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-frame">
                <span>개인 정보</span>
                <div class="privacy">
                    <div>
                        <span class="privacy-tag">생년월일</span>
                        <input type="date" name="birthday" value="<?= $userinfo->birthday ?>">
                    </div>
                    <div>
                        <span class="privacy-tag">실명</span>
                        <input type="text" name="real_name" placeholder="이름을 입력해주세요." value="<?= $userinfo->real_name ?>">
                    </div>
                    <div>
                        <span class="privacy-tag">키</span>
                        <input type="number" name="height" placeholder="키를 입력해주세요." value="<?= $userinfo->height ?>">
                    </div>
                    <div>
                        <span class="privacy-tag">몸무게</span>
                        <input type="number" name="weight" placeholder="몸무게를 입력해주세요." value="<?= $userinfo->weight ?>">
                    </div>
                    <div>
                        <span class="privacy-tag">나이</span>
                        <input type="number" name="age" placeholder="나이를 입력해주세요." value="<?= $userinfo->age ?>"> <br>
                    </div>
                    <div>
                        <span class="privacy-tag">성별</span>
                        <div class="check-option">
                            <input type="radio" name="gender" id="none" value="none" <?= $userinfo->gender == "none" ? 'checked' : '' ?>> <label for="none">없음</label>
                            <input type="radio" name="gender" id="men" value="men" <?= $userinfo->gender == "men" ? 'checked' : '' ?>> <label for="men">남</label>
                            <input type="radio" name="gender" id="women" value="women" <?= $userinfo->gender == "women" ? 'checked' : '' ?>> <label for="women">여</label>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" class="submit" value="수정">
        </form>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    function readURL(input) {
        // input에 파일이 하나 이상 있을 시
        if (input.files && input.files[0]) {
            // 파일 읽기
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);

            // #img에 있는 src에 input에 있는 파일 값을 넘겨줌
            reader.onload = function(e) {
                $('#img').attr('src', e.target.result);
            }
        }
    }

    $("#img-file").change(function() {
        readURL(this);
    });
</script>