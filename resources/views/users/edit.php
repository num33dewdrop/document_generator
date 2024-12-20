<?php
view_parts('head', ['title'=>'EDIT MEMBER INFORMATION', 'description'=> 'EDIT MEMBER INFORMATIONの説明']);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
    <hgroup class="c-title">
        <h1>会員情報編集</h1>
        <p>EDIT MEMBER INFORMATION</p>
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
                                        <label for="name" class="c-form__label">氏名</label>
                                        <div class="c-input">
                                            <input type="text" name="name" id="name" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="name_ruby" class="c-form__label">氏名（フリガナ）</label>
                                        <div class="c-input">
                                            <input type="text" name="name_ruby" id="name_ruby" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="birthday" class="c-form__label">生年月日</label>
                                        <div class="c-input c-input--date">
                                            <input type="text" name="birthday" id="birthday" value="2020/04/01" readonly>
                                            <label for="birthday">
                                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="./img/symbol/common.svg#calendar"></use>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">性別</span>
                                        <div class="c-radio">
                                            <label><input type="radio" name="sex" value="">男</label>
                                            <label><input type="radio" name="sex" value="">女</label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="dependents" class="c-form__label">扶養親族</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="dependents" id="dependents" value="">人
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">配偶者</span>
                                        <div class="c-radio">
                                            <label><input type="radio" name="partner" value="">有</label>
                                            <label><input type="radio" name="partner" value="">無</label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">配偶者の扶養義務</span>
                                        <div class="c-radio">
                                            <label><input type="radio" name="duty_to_support" value="">有</label>
                                            <label><input type="radio" name="duty_to_support" value="">無</label>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">連絡先</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="fixed_phone_number" class="c-form__label">固定電話番号</label>
                                        <div class="c-input">
                                            <input type="tel" name="fixed_phone_number" id="fixed_phone_number" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="mobile_phone_number" class="c-form__label">携帯電話番号</label>
                                        <div class="c-input">
                                            <input type="tel" name="mobile_phone_number" id="mobile_phone_number" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="contact_phone_number" class="c-form__label">連絡先電話番号</label>
                                        <div class="c-input">
                                            <input type="tel" name="contact_phone_number" id="contact_phone_number" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="email" class="c-form__label">メールアドレス</label>
                                        <div class="c-input">
                                            <input type="email" name="email" id="email" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">住所</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="zip" class="c-form__label">郵便番号</label>
                                        <div class="c-input c-input--mid">
                                            <input type="text" name="zip" id="zip" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="prefectures" class="c-form__label">都道府県</label>
                                        <div class="c-select">
                                            <select name="prefectures" id="prefectures">
                                                <option value="">選択してください</option>
                                                <option value="1">北海道</option>
                                                <option value="2">青森</option>
                                                <option value="3">秋田</option>
                                            </select>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="municipalities" class="c-form__label">市区町村以降</label>
                                        <div class="c-input">
                                            <input type="text" name="municipalities" id="municipalities" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">連絡先住所</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="contact_zip" class="c-form__label">郵便番号</label>
                                        <div class="c-input c-input--mid">
                                            <input type="text" name="contact_zip" id="contact_zip" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="contact_prefectures" class="c-form__label">都道府県</label>
                                        <div class="c-select">
                                            <select name="contact_prefectures" id="contact_prefectures">
                                                <option value="">選択してください</option>
                                                <option value="1">北海道</option>
                                                <option value="2">青森</option>
                                                <option value="3">秋田</option>
                                            </select>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="contact_municipalities" class="c-form__label">市区町村以降</label>
                                        <div class="c-input">
                                            <input type="text" name="contact_municipalities" id="contact_municipalities" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">Microsoft Office</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="word" class="c-form__label">Word</label>
                                        <div class="c-textarea">
                                            <textarea name="word" id="word" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="excel" class="c-form__label">Excel</label>
                                        <div class="c-textarea">
                                            <textarea name="excel" id="excel" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="power_point" class="c-form__label">PowerPoint</label>
                                        <div class="c-textarea">
                                            <textarea name="power_point" id="power_point" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">証明写真</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <div class="c-imgDrop">
                                            <label class="c-imgDrop__label js-dropArea">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                                                <input type="file" name="pic" class="c-imgDrop__file js-inputFile">
                                                <img src="../img/whole/no-passport-img_e1dd4d68649101e60589.svg" alt="" class="c-imgDrop__img">
                                            </label>
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
