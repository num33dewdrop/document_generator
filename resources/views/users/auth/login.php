<?php
$client_id = $data["client_id"]?? "";
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
<!--            <form action="" method="post" enctype="multipart/form-data">-->
<!--	            --><?php //= csrf(); ?>
                <div class="c-section__inner">
                    <div class="c-box c-box--high">
                        <div class="c-box__inner c-box__inner--center">
                            <p class="c-text--center c-box__item c-box__item--full">当サイトはGoogleの機能を活用しています。<br>Googleでログインしてください。</p>
                            <div class="c-box__item c-box__item--full">
                                <a href="<?= route('user-login.google') ?>">
                                    Googleでログイン
                                </a>
<!--                                <script src="https://accounts.google.com/gsi/client" async></script>-->
<!--                                <div id="g_id_onload"-->
<!--                                     data-client_id="--><?php //= $client_id ?><!--"-->
<!--                                     data-context="signin"-->
<!--                                     data-ux_mode="popup"-->
<!--                                     data-login_uri="--><?php //= base_domain().route('user-redirect.store') ?><!--"-->
<!--                                     data-auto_prompt="false">-->
<!--                                </div>-->
<!---->
<!--                                <div class="g_id_signin"-->
<!--                                     data-type="standard"-->
<!--                                     data-shape="pill"-->
<!--                                     data-theme="outline"-->
<!--                                     data-text="signin_with"-->
<!--                                     data-size="large"-->
<!--                                     data-logo_alignment="left">-->
<!--                                </div>-->
                            </div>
                        </div>

<!--                        <div class="c-box__inner">-->
<!--                           --><?php //= displayErrors(error('common')); ?>
<!--                            <div class="c-form">-->
<!--                                <div class="c-form__group">-->
<!--                                    <div class="c-form__input">-->
<!--                                        <label for="email" class="c-form__label">メールアドレス</label>-->
<!--                                        <div class="c-input">-->
<!--                                            <input type="text" name="email" id="email" value="--><?php //= old('email'); ?><!--" placeholder="例：">-->
<!--                                        </div>-->
<!--                                         --><?php //= displayErrors(error('email')); ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="c-form__group">-->
<!--                                    <div class="c-form__input">-->
<!--                                        <label for="password" class="c-form__label">パスワード</label>-->
<!--                                        <div class="c-input">-->
<!--                                            <input type="password" name="password" id="password" value="" autocomplete="off">-->
<!--                                        </div>-->
<!--                                        --><?php //= displayErrors(error('password')); ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="c-form__group">-->
<!--                                    <div class="c-form__input">-->
<!--                                        <div class="c-form__input">-->
<!--                                            <div class="c-checkbox">-->
<!--                                                <label><input type="checkbox" name="password_save[]" value="save">次回ログインを省略する</label>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
<!--                    <div class="c-btnBox c-btnBox--full">-->
<!--                        <div class="c-btn c-btn--frame">-->
<!--                            <a href="--><?php //= route('user-register.index'); ?><!--">新規登録</a>-->
<!--                        </div>-->
<!--                        <div class="c-btn c-btn--primary">-->
<!--                            <input type="submit" value="ログイン">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="c-textBox c-textBox--center">-->
<!--                        <a class="c-anchor" href="--><?php //= route('user-register.index'); ?><!--">パスワードを忘れた方はこちら</a>-->
<!--                    </div>-->
                </div>
<!--            </form>-->
        </div>
    </div>
</main>
<?php view_parts('footer'); ?>