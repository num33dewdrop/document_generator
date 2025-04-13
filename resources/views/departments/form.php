<?php
$user = $data['user'] ?? [];
$work_experience = empty($data['work_experience'])? []: $data['work_experience'];
$department = $data['department'] ?? [];
$is_register = !isset($type) || $type === "register";

$page_name = $is_register?
	['en' =>'DEPARTMENT REGISTER', 'ja' => '所属登録']:
	['en' =>'DEPARTMENT EDIT', 'ja' => '所属編集'];

view_parts('head', ['title' => $page_name['en'], 'description' => $page_name['ja'].'の説明']);
view_parts('header', $user);
view_parts('globalNav', ["type" => "work-experiences"]);
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
    <div class="l-main__body l-main__body--info">
        <hgroup class="c-info c-info--box">
            <h2 class="c-info__title"><?= sanitize($work_experience['name']); ?></h2>
            <p class="c-info__note"><?= sanitize($work_experience['first_date']); ?> 〜 <?= sanitize($work_experience['last_date']); ?></p>
        </hgroup>
        <div class="c-section">
            <form action="<?= route( $is_register? 'departments-register.store': 'departments-edit.store', $is_register? ['w_id' => sanitize($work_experience['id'])]: [ 'w_id' => sanitize($work_experience['id']), 'd_id' => sanitize($department['id'])]);?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="<?= $is_register? 'POST' :'PUT'?>">
		        <?= csrf(); ?>
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
	                        <?= displayErrors(error('common')); ?>
                            <dl class="c-form">
                                <dt class="c-form__title">配属部署</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="department_name" class="c-form__label">部署名</label>
                                        <div class="c-input">
                                            <input type="text" name="department_name" id="department_name" value="<?= old('department_name', $is_register? []: ['department_name' => sanitize($department['name']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('department_name')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">配属期間</span>
                                        <div class="p-horizon p-horizon--5">
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="first_date" id="first_date" value="<?= old('first_date', $is_register? []: ['first_date' => sanitize($department['first_date']) ?? '']); ?>">
                                                <label for="first_date">
                                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="<?= assets('img/symbol/common.svg#calendar'); ?>"></use>
                                                    </svg>
                                                </label>
                                            </div>
                                            〜
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="last_date" id="last_date" value="<?= old('last_date', $is_register? []: ['last_date' => sanitize($department['last_date']) ?? '']); ?>">
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
                                        <label for="job_assigned" class="c-form__label">担当業務</label>
                                        <div class="c-textarea">
                                            <textarea name="job_assigned" id="job_assigned" cols="30" rows="10" placeholder="例："><?= old('job_assigned', $is_register? []: ['job_assigned' => sanitize($department['job_assigned']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('job_assigned')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="products" class="c-form__label">取扱製品</label>
                                        <div class="c-textarea">
                                            <textarea name="products" id="products" cols="30" rows="10" placeholder="例："><?= old('products', $is_register? []: ['products' => sanitize($department['products']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('products')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="tasks" class="c-form__label">業務内容</label>
                                        <div class="c-textarea">
                                            <textarea name="tasks" id="tasks" cols="30" rows="10" placeholder="例："><?= old('tasks', $is_register? []: ['tasks' => sanitize($department['tasks']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('tasks')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="scale" class="c-form__label">規模</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="scale" id="scale" value="<?= old('scale', $is_register? []: ['scale' => sanitize($department['scale']) ?? '']); ?>">人
                                        </div>
	                                    <?= displayErrors(error('scale')) ?>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox c-btnBox--full">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('departments-list.show',['w_id' => sanitize($work_experience['id'])]); ?>">戻る</a>
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
		view_parts('deleteModal', ['route' => 'departments-delete.store' , 'params' => ['w_id' => sanitize($work_experience['id']), 'd_id' => sanitize($department['id'])], 'name' => sanitize($department['name'])]);
	endif;
	?>
</main>
<?php view_parts('footer'); ?>
