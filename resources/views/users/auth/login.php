<?php
view_parts('head', ['title'=>'USER LOGIN', 'description'=>'USER LOGINの説明']);
view_parts('header-general');
?>
<main class="l-main l-main--full">
    <div class="l-main__head l-main__head--center">
        <hgroup class="c-title c-title--center">
            <h1>ログイン</h1>
            <p>LOGIN</p>
        </hgroup>
    </div>
    <div class="l-main__body l-main__body--full">
        <div class="c-section c-section--max">
            <form action="" method="post" enctype="multipart/form-data">
	            <?= csrf(); ?>
                <div class="c-section__inner">
                    <div class="c-box c-box--wide">
                        <div class="c-box__inner">
                           <?= displayErrors(error('common')); ?>
                            <div class="c-form">
                                <div class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="email" class="c-form__label">メールアドレス</label>
                                        <div class="c-input">
                                            <input type="text" name="email" id="email" value="<?= old('email'); ?>" placeholder="例：">
                                        </div>
                                         <?= displayErrors(error('email')); ?>
                                    </div>
                                </div>
                                <div class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="password" class="c-form__label">パスワード</label>
                                        <div class="c-input">
                                            <input type="password" name="password" id="password" value="" autocomplete="off">
                                        </div>
                                        <?= displayErrors(error('password')); ?>
                                    </div>
                                </div>
                                <div class="c-form__group">
                                    <div class="c-form__input">
                                        <div class="c-form__input">
                                            <div class="c-checkbox">
                                                <label><input type="checkbox" name="password_save[]" value="save">次回ログインを省略する</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="c-btnBox c-btnBox--full">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('user-register.index'); ?>">新規登録</a>
                        </div>
                        <div class="c-btn c-btn--primary">
                            <input type="submit" value="ログイン">
                        </div>
                    </div>
                    <div class="c-textBox c-textBox--center">
                        <a class="c-anchor" href="<?= route('user-register.index'); ?>">パスワードを忘れた方はこちら</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php view_parts('footer'); ?>