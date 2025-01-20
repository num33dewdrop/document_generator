<?php
$user = $data['user'] ?? [];
$workExperience = $data["work_experiences"] ?? [];
$employmentStatus = $data["employment_status"]["records"] ?? [];
$lastCareer = $data["last_career"]["records"] ?? [];
$is_register = !isset($type) || $type === "register";
$page_name = $is_register?
	['en' =>'ACADEMIC BACKGROUND REGISTER', 'ja' => '職歴登録']:
	['en' =>'ACADEMIC BACKGROUND EDIT', 'ja' => '職歴編集'];

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
	    <?php if(!$is_register): ?>
            <div class="c-btn c-btn--deleteFrame c-btn--auto">
                <button class="js-showDeleteModal">
                    <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/control.svg#delete'); ?>"></use>
                    </svg>
                    削除
                </button>
            </div>
	    <?php endif; ?>
    </div>
    <div class="l-main__body">
        <div class="c-section">
            <form action="<?= route( $is_register? 'work-experiences-register.store': 'work-experiences-edit.store', $is_register? []: ['id' => sanitize($workExperience['id'])]);?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="<?= $is_register? 'POST' :'PUT'?>">
		        <?= csrf(); ?>
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
	                        <?= displayErrors(error('common')); ?>
                            <dl class="c-form">
                                <dt class="c-form__title">会社情報</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="company_name" class="c-form__label">会社名</label>
                                        <div class="c-input">
                                            <input type="text" name="company_name" id="company_name" value="<?= old('company_name', $is_register? []: ['company_name' => sanitize($workExperience['name']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('company_name')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">雇用期間</span>
                                        <div class="p-horizon p-horizon--5">
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="first_date" id="first_date" value="<?= old('first_date', $is_register? []: ['first_date' => sanitize($workExperience['first_date']) ?? '']); ?>">
                                                <label for="first_date">
                                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="<?= assets('img/symbol/common.svg#calendar'); ?>"></use>
                                                    </svg>
                                                </label>
                                            </div>
                                            〜
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="last_date" id="last_date" value="<?= old('last_date', $is_register? []: ['last_date' => sanitize($workExperience['last_date']) ?? '']); ?>">
                                                <label for="last_date">
                                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="<?= assets('img/symbol/common.svg#calendar'); ?>"></use>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
	                                    <?= displayErrors(error('first_date')) ?>
	                                    <?= displayErrors(error('last_date')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="business" class="c-form__label">事業内容</label>
                                        <div class="c-textarea">
                                            <textarea name="business" id="business" cols="30" rows="10" placeholder="例："><?= old('business', $is_register? []: ['business' => sanitize($workExperience['business']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('business')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="capital_stock" class="c-form__label">資本金</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="capital_stock" id="capital_stock" value="<?= old('capital_stock', $is_register? []: ['capital_stock' => sanitize($workExperience['capital_stock']) ?? '']); ?>">円
                                        </div>
	                                    <?= displayErrors(error('capital_stock')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="sales" class="c-form__label">売上高</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="sales" id="sales" value="<?= old('sales', $is_register? []: ['sales' => sanitize($workExperience['sales']) ?? '']); ?>">円
                                        </div>
	                                    <?= displayErrors(error('sales')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="number_of_employees" class="c-form__label">従業員数</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="number_of_employees" id="number_of_employees" value="<?= old('number_of_employees', $is_register? []: ['number_of_employees' => sanitize($workExperience['number_of_employees']) ?? '']); ?>">人
                                        </div>
	                                    <?= displayErrors(error('number_of_employees')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="employment_status" class="c-form__label">雇用形態</label>
                                        <div class="c-select">
                                            <select name="employment_status" id="employment_status">
                                                <option value="">選択してください</option>
	                                            <?php foreach ($employmentStatus as  $key => $value): ?>
                                                    <option value="<?= sanitize($value["id"]); ?>" <?= old('employment_status', $is_register? []: ['employment_status' => sanitize($workExperience['employment_status_id']) ?? '']) === sanitize($value["id"])? "selected": ""; ?>><?= sanitize($value["name"]); ?></option>
	                                            <?php endforeach; ?>
                                            </select>
                                        </div>
	                                    <?= displayErrors(error('employment_status')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="job_summary" class="c-form__label">職務要約</label>
                                        <div class="c-textarea">
                                            <textarea name="job_summary" id="job_summary" cols="30" rows="10" placeholder="例："><?= old('job_summary', $is_register? []: ['job_summary' => sanitize($workExperience['job_summary']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('job_summary')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="last_career" class="c-form__label">最終経歴</label>
                                        <div class="c-select">
                                            <select name="last_career" id="last_career">
                                                <option value="">選択してください</option>
			                                    <?php foreach ($lastCareer as  $key => $value): ?>
                                                    <option value="<?= sanitize($value["id"]); ?>" <?= old('last_career', $is_register? []: ['last_career' => sanitize($workExperience['last_career_id']) ?? '']) === sanitize($value["id"])? "selected": ""; ?>><?= sanitize($value["name"]); ?></option>
			                                    <?php endforeach; ?>
                                            </select>
                                        </div>
	                                    <?= displayErrors(error('last_career')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">経験</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="experience" class="c-form__label">実務経験</label>
                                        <div class="c-textarea">
                                            <textarea name="experience" id="experience" cols="30" rows="10" placeholder="例："><?= old('experience', $is_register? []: ['experience' => sanitize($workExperience['experience']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('experience')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="track_record" class="c-form__label">実績</label>
                                        <div class="c-textarea">
                                            <textarea name="track_record" id="track_record" cols="30" rows="10" placeholder="例："><?= old('track_record', $is_register? []: ['track_record' => sanitize($workExperience['track_record']) ?? '']); ?></textarea>

                                        </div>
	                                    <?= displayErrors(error('track_record')) ?>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox c-btnBox--full">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('work-experiences-list.show'); ?>">戻る</a>
                        </div>
                        <div class="c-btn c-btn--primary">
                            <input type="submit" value="保存">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<?php
	if(!$is_register):
		view_parts('deleteModal', ['route' => 'work-experiences-delete.store' ,'params' => ['id' => sanitize($workExperience['id'])], 'name' => sanitize($workExperience['name'])]);
	endif;
	?>
</main>
<?php view_parts('footer'); ?>
