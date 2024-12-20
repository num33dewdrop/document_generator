<?php
$document = $data["document"] ?? [];

$is_register = !isset($type) || $type === "register" || $type === "copy";
$page_name = $is_register?
	['en' =>'DOCUMENT REGISTER', 'ja' => '資料登録']:
	['en' =>'DOCUMENT EDIT', 'ja' => '資料編集'];

view_parts('head', ['title' => $page_name['en'], 'description' => $page_name['ja'].'の説明']);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
        <hgroup class="c-title">
            <h1>資料登録</h1>
            <p>DOCUMENT REGISTER</p>
        </hgroup>
    </div>
    <div class="l-main__body">
        <div class="c-section">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
                            <dl class="c-form">
                                <dt class="c-form__title">基本情報</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="title" class="c-form__label">タイトル</label>
                                        <div class="c-input">
                                            <input type="text" name="title" id="title" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">表示項目</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">学歴</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="title" value="">〇〇高等学校</label>
                                            <label><input type="checkbox" name="title" value="">〇〇専門学校</label>
                                            <label><input type="checkbox" name="title" value="">〇〇大学</label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">職歴</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="title" value="">株式会社〇〇〇〇〇〇〇〇</label>
                                            <label><input type="checkbox" name="title" value="">株式会社〇〇</label>
                                            <label><input type="checkbox" name="title" value="">株式会社〇〇〇〇</label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">資格</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="title" value="">クレーン運転士</label>
                                            <label><input type="checkbox" name="title" value="">危険物取扱者</label>
                                            <label><input type="checkbox" name="title" value="">電気工事士</label>
                                            <label><input type="checkbox" name="title" value="">フォークリフト運転講習</label>
                                            <label><input type="checkbox" name="title" value="">機械設計</label>
                                            <label><input type="checkbox" name="title" value="">電気工事士</label>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">職務経歴書</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="pr" class="c-form__label">自己PR</label>
                                        <div class="c-textarea">
                                            <textarea name="pr" id="pr" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="supplement" class="c-form__label">自己PR（補足）</label>
                                        <div class="c-textarea">
                                            <textarea name="supplement" id="supplement" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">履歴書</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="wish" class="c-form__label">本人希望欄</label>
                                        <div class="c-textarea">
                                            <textarea name="wish" id="wish" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox">
                        <div class="c-btn c-btn--frame">
                            <a href="../../../../php">戻る</a>
                        </div>
                        <div class="c-btn c-btn--primary">
                            <input type="submit" value="保存">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php view_parts('footer'); ?>