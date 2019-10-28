<div class="login-page">
    <section id="login-page">
        <form action="/login/register" method="post" class="login-form">
            <div>
                <span>아이디</span> <input type="text" name="user_id" class="id" value="<?php echo set_value('user_id'); ?>" onkeypress="javascript:press(this.form)">
                <?php
                if (strpos(form_error('user_id'), 'required')) {
                    echo '<span class="login-error">아이디를 적어야 합니다.</span>';
                } else if (strpos(form_error('user_id'), 'length')) {
                    echo '<span class="login-error">아이디를 5~12글자 사이로 해주세요.</span>';
                } else if (strpos(form_error('user_id'), 'unique')) {
                    echo '<span class="login-error">중복되는 아이디입니다.</span>';
                }
                ?>
            </div>
            <div>
                <span>비밀번호</span> <input type="password" name="user_pw" class="pw" value="<?php echo set_value('user_pw'); ?>" onkeypress="javascript:press(this.form)">
                <?php
                if (strpos(form_error('user_pw'), 'required')) {
                    echo '<span class="login-error">비밀번호를 적어야 합니다.</span>';
                } else if (strpos(form_error('user_pw'), 'length')) {
                    echo '<span class="login-error">비밀번호를 8~16글자 사이로 해주세요.</span>';
                }
                ?>
            </div>
            <div>
                <span>비밀번호 재확인</span> <input type="password" name="user_pw_re" class="pw-re" onkeypress="javascript:press(this.form)">
                <?php
                if (form_error('user_pw_re')) {
                    echo '<span class="login-error">입력하신 비밀번호와 다릅니다.</span>';
                }
                ?>
            </div>
            <div>
                <span>전화번호</span> <input type="text" name="phone" class="phone" placeholder="ex) 01011117610" value="<?php echo set_value('phone'); ?>" onkeypress="javascript:press(this.form)">
                <?php
                if (strpos(form_error('phone'), 'required')) {
                    echo '<span class="login-error">전화번호를 적어야 합니다.</span>';
                } else if (strpos(form_error('phone'), 'numeric')) {
                    echo '<span class="login-error">숫자만 입력해야 합니다.</span>';
                }
                ?>
            </div>
            <div>
                <span>이메일</span> <input type="text" name="email" class="email" value="<?php echo set_value('email'); ?>" onkeypress="javascript:press(this.form)">
                <?php
                if (strpos(form_error('email'), 'required')) {
                    echo '<span class="login-error">이메일을 적어야 합니다.</span>';
                } else if (strpos(form_error('email'), 'email')) {
                    echo '<span class="login-error">형식에 맞지 않습니다.</span>';
                }
                ?>
            </div>

            <input type="submit" value="회원가입" class="login-btn">
        </form>
    </section>
</div>