<?php
$user = $data['user'] ?? [];
$prefectures = $data['prefectures']?? [];
$page_name = ['en' =>'EDIT MEMBER INFORMATION', 'ja' => '会員情報編集'];
view_parts('head', ['title' => $page_name['en'], 'description' => $page_name['ja'].'の説明']);
view_parts('header', $user);
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
        <hgroup class="c-title">
            <h1><?= $page_name['ja']; ?></h1>
            <p><?= $page_name['en']; ?></p>
        </hgroup>
    </div>
    <div class="l-main__body">
        <div class="c-section">
            <form action="<?= route( 'user-edit.store');?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
		        <?= csrf(); ?>
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
	                        <?= displayErrors(error('common')); ?>
                            <dl class="c-form">
                                <dt class="c-form__title">基本情報</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="name" class="c-form__label">氏名</label>
                                        <div class="c-input">
                                            <input type="text" name="name" id="name" value="<?= old('name', ['name' => sanitize($user['name']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('name')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="name_ruby" class="c-form__label">氏名（フリガナ）</label>
                                        <div class="c-input">
                                            <input type="text" name="name_ruby" id="name_ruby" value="<?= old('name_ruby', ['name_ruby' => sanitize($user['name_ruby']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('name_ruby')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="birthday" class="c-form__label">生年月日</label>
                                        <div class="c-input c-input--date js-flatpickr">
                                            <input type="text" class="js-flatpickr__input" name="birthday" id="birthday" value="<?= old('birthday', ['birthday' => sanitize($user['birthday']) ?? '']); ?>" readonly>
                                            <label for="birthday">
                                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="<?= assets('img/symbol/common.svg#calendar'); ?>"></use>
                                                </svg>
                                            </label>
                                        </div>
		                                <?= displayErrors(error('birthday')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">性別</span>
                                        <div class="c-radio">
                                            <label><input type="radio" name="sex" value="0" <?= old('sex', ['sex' => sanitize($user['sex']) ?? '']) === "0" ? "checked": ""; ?>>男</label>
                                            <label><input type="radio" name="sex" value="1" <?= old('sex', ['sex' => sanitize($user['sex']) ?? '']) === "1" ? "checked": ""; ?>>女</label>
                                        </div>
	                                    <?= displayErrors(error('sex')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="dependents" class="c-form__label">扶養親族</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="dependents" id="dependents" value="<?= old('dependents', ['dependents' => sanitize($user['dependents']) ?? '']); ?>">人
                                        </div>
	                                    <?= displayErrors(error('dependents')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">配偶者</span>
                                        <div class="c-radio">
                                            <label><input type="radio" name="partner" value="0" <?= old('partner', ['partner' => sanitize($user['partner']) ?? '']) === "0" ? "checked": ""; ?>>無</label>
                                            <label><input type="radio" name="partner" value="1" <?= old('partner', ['partner' => sanitize($user['partner']) ?? '']) === "1" ? "checked": ""; ?>>有</label>
                                        </div>
	                                    <?= displayErrors(error('partner')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">配偶者の扶養義務</span>
                                        <div class="c-radio">
                                            <label><input type="radio" name="partner_support" value="0" <?= old('partner_support', ['partner_support' => sanitize($user['partner_support']) ?? '']) === "0" ? "checked": ""; ?>>無</label>
                                            <label><input type="radio" name="partner_support" value="1" <?= old('partner_support', ['partner_support' => sanitize($user['partner_support']) ?? '']) === "1" ? "checked": ""; ?>>有</label>
                                        </div>
	                                    <?= displayErrors(error('partner_support')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">連絡先</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="fixed_phone" class="c-form__label">固定電話番号</label>
                                        <div class="c-input">
                                            <input type="tel" name="fixed_phone" id="fixed_phone" value="<?= old('fixed_phone', ['fixed_phone' => sanitize($user['fixed_phone']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('fixed_phone')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="mobile_phone" class="c-form__label">携帯電話番号</label>
                                        <div class="c-input">
                                            <input type="tel" name="mobile_phone" id="mobile_phone" value="<?= old('mobile_phone', ['mobile_phone' => sanitize($user['mobile_phone']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('mobile_phone')) ?>
                                    </div>


                                    <div class="c-form__input">
                                        <label for="contact_phone" class="c-form__label">連絡先電話番号</label>
                                        <div class="c-input">
                                            <input type="tel" name="contact_phone" id="contact_phone" value="<?= old('contact_phone', ['contact_phone' => sanitize($user['contact_phone']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('contact_phone')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="email" class="c-form__label">メールアドレス</label>
                                        <div class="c-input">
                                            <input type="email" name="email" id="email" value="<?= old('email', ['email' => sanitize($user['email']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('email')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">住所</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="zip" class="c-form__label">郵便番号</label>
                                        <div class="c-input c-input--mid">
                                            <input type="text" name="zip" id="zip" value="<?= old('zip', ['zip' => sanitize($user['zip']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('zip')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="prefectures_id" class="c-form__label">都道府県</label>
                                        <div class="c-select">
                                            <select name="prefectures_id" id="prefectures_id">
                                                <option value="" <?= old('prefectures_id', ['prefectures_id' => sanitize($user['prefectures_id']) ?? '']) === ""? "selected":"" ?>>選択してください</option>
                                                <?php foreach ($prefectures["records"] as $key => $value): ?>
                                                <option value="<?= $value["id"] ?>" <?= $value["id"] === old('prefectures_id', ['prefectures_id' => sanitize( $user['prefectures_id']) ?? ''])? "selected":"" ?>><?= $value["name"] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
	                                    <?= displayErrors(error('prefectures_id')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="city_town_village" class="c-form__label">市区町村以降</label>
                                        <div class="c-input">
                                            <input type="text" name="city_town_village" id="city_town_village" value="<?= old('city_town_village', ['city_town_village' => sanitize($user['city_town_village']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('city_town_village')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">連絡先住所</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="contact_zip" class="c-form__label">郵便番号</label>
                                        <div class="c-input c-input--mid">
                                            <input type="text" name="contact_zip" id="contact_zip" value="<?= old('contact_zip', ['contact_zip' => sanitize($user['contact_zip']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('contact_zip')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="contact_prefectures_id" class="c-form__label">都道府県</label>
                                        <div class="c-select">
                                            <select name="contact_prefectures_id" id="contact_prefectures_id">
                                                <option value="" <?= old('contact_prefectures_id', ['contact_prefectures_id' => sanitize($user['contact_prefectures_id']) ?? '']) === ""? "selected":"" ?>>選択してください</option>
	                                            <?php foreach ($prefectures["records"] as $key => $value): ?>
                                                <option value="<?= $value["id"] ?>" <?= $value["id"] === old('contact_prefectures_id', ['contact_prefectures_id' => sanitize($user['contact_prefectures_id']) ?? ''])? "selected":"" ?>><?= $value["name"] ?></option>
	                                            <?php endforeach; ?>
                                            </select>
                                        </div>
	                                    <?= displayErrors(error('contact_prefectures_id')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="contact_city_town_village" class="c-form__label">市区町村以降</label>
                                        <div class="c-input">
                                            <input type="text" name="contact_city_town_village" id="contact_city_town_village" value="<?= old('contact_city_town_village', ['contact_city_town_village' => sanitize($user['contact_city_town_village']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('contact_city_town_village')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">Microsoft Office</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="word" class="c-form__label">Word</label>
                                        <div class="c-textarea">
                                            <textarea name="word" id="word" cols="30" rows="10" placeholder="例："><?= old('word', ['word' => sanitize($user['word']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('word')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="excel" class="c-form__label">Excel</label>
                                        <div class="c-textarea">
                                            <textarea name="excel" id="excel" cols="30" rows="10" placeholder="例："><?= old('excel', ['excel' => sanitize($user['excel']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('excel')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="power_point" class="c-form__label">PowerPoint</label>
                                        <div class="c-textarea">
                                            <textarea name="power_point" id="power_point" cols="30" rows="10" placeholder="例："><?= old('power_point', ['power_point' => sanitize($user['power_point']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('power_point')) ?>
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
                                                <input type="hidden" name="db_pic" value="<?= empty($user['pic'])? "" : sanitize($user['pic']); ?>">
                                                <input type="file" name="pic" class="c-imgDrop__file js-inputFile">
                                                <img src="<?= empty($user['pic'])? assets("img/whole/no-passport-img.svg"): sanitize($user['pic']); ?>" alt="証明写真" class="c-imgDrop__img">
                                            </label>
                                        </div>
	                                    <?= displayErrors(error('pic')) ?>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox c-btnBox--full">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('documents-list.show'); ?>">戻る</a>
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
