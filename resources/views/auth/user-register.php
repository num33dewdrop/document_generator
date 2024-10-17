<?php
view_parts('head');
view_parts('header-general');
?>
<main class="l-main l-main--full">
    <div class="l-main__head l-main__head--center">
        <hgroup class="c-title c-title--center">
            <h1>会員登録</h1>
            <p>USER REGISTER</p>
        </hgroup>
    </div>
    <div class="l-main__body l-main__body--full">
        <div class="c-section c-section--max">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="c-section__inner">
                    <div class="c-box c-box--wide">
                        <div class="c-box__inner">
                            <div class="c-form">
                                <div class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="email" class="c-form__label">氏名</label>
                                        <div class="c-input">
                                            <input type="text" name="name" id="name" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="email" class="c-form__label">メールアドレス</label>
                                        <div class="c-input">
                                            <input type="text" name="email" id="email" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="pass" class="c-form__label">パスワード</label>
                                        <div class="c-input">
                                            <input type="password" name="pass" id="pass" value="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="pass_re" class="c-form__label">パスワード再入力</label>
                                        <div class="c-input">
                                            <input type="password" name="pass_re" id="pass_re" value="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="c-btnBox">
                        <div class="c-btn c-btn--primary">
                            <input type="submit" value="登録する">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php view_parts('footer'); ?>