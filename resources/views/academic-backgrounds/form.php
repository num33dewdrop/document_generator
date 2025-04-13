<?php
$user = $data['user'] ?? [];
$academicBackground = $data['academic_background'] ?? [];
$lastCareer = $data['last_career']['records'] ?? [];
$is_register = !isset($type) || $type === "register";
$page_name = $is_register?
	['en' =>'ACADEMIC BACKGROUND REGISTER', 'ja' => '学歴登録']:
	['en' =>'ACADEMIC BACKGROUND EDIT', 'ja' => '学歴編集'];

view_parts('head', ['title' => $page_name['en'], 'description' => $page_name['ja'].'の説明']);
view_parts('header', $user);
view_parts('globalNav', ["type" => "academic-backgrounds"]);
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
            <form action="<?= route( $is_register? 'academic-backgrounds-register.store': 'academic-backgrounds-edit.store', $is_register? []: ['id' => sanitize($academicBackground['id'])]);?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="<?= $is_register? 'POST' :'PUT'?>">
		        <?= csrf(); ?>
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
	                        <?= displayErrors(error('common')); ?>
                            <dl class="c-form">
                                <dt class="c-form__title">基本情報</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="academic_name" class="c-form__label">学校名</label>
                                        <div class="c-input">
                                            <input type="text" name="academic_name" id="academic_name" value="<?= old('academic_name', $is_register? []: ['academic_name' => sanitize($academicBackground['name']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('academic_name')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">在籍期間</span>
                                        <div class="p-horizon p-horizon--5">
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="first_date" id="first_date" value="<?= old('first_date', $is_register? []: ['first_date' => sanitize($academicBackground['first_date']) ?? '']); ?>">
                                                <label for="first_date">
                                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="<?= assets('img/symbol/common.svg#calendar'); ?>"></use>
                                                    </svg>
                                                </label>
                                            </div>
                                            〜
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="last_date" id="last_date" value="<?= old('last_date', $is_register? []: ['last_date' => sanitize($academicBackground['last_date']) ?? '']); ?>">
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
                                        <label for="last_career" class="c-form__label">最終経歴</label>
                                        <div class="c-select">
                                            <select name="last_career" id="last_career">
                                                <option value="">選択してください</option>
                                                <?php foreach ($lastCareer as  $key => $value): ?>
                                                <option value="<?= sanitize($value["id"]); ?>" <?= old('last_career', $is_register? []: ['last_career' => sanitize($academicBackground['last_career_id']) ?? '']) === sanitize($value["id"])? "selected": ""; ?>><?= sanitize($value["name"]); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
	                                    <?= displayErrors(error('last_career')) ?>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox c-btnBox--full">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('academic-backgrounds-list.show'); ?>">戻る</a>
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
		view_parts('deleteModal', ['route' => 'academic-backgrounds-delete.store' ,'params' => ['id' => sanitize($academicBackground['id'])], 'name' => sanitize($academicBackground['name'])]);
	endif;
	?>
</main>
<?php view_parts('footer'); ?>
