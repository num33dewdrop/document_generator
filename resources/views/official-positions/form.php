<?php
$user = $data['user'] ?? [];
$work_experience = empty($data['work_experience'])? []: $data['work_experience'];
$official_position = $data['official_position'] ?? [];
$is_register = !isset($type) || $type === "register";

$page_name = $is_register?
	['en' =>'OFFICIAL POSITION REGISTER', 'ja' => '役職登録']:
	['en' =>'OFFICIAL POSITION EDIT', 'ja' => '役職編集'];

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
    <div class="l-main__body l-main__body--info">
        <hgroup class="c-info c-info--box">
            <h2 class="c-info__title"><?= sanitize($work_experience['name']); ?></h2>
            <p class="c-info__note"><?= sanitize($work_experience['first_date']); ?> 〜 <?= sanitize($work_experience['last_date']); ?></p>
        </hgroup>
        <div class="c-section">
            <form action="<?= route( $is_register? 'official-positions-register.store': 'official-positions-edit.store', $is_register? ['w_id' => sanitize($work_experience['id'])]: [ 'w_id' => sanitize($work_experience['id']), 'o_id' => sanitize($official_position['id'])]);?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="<?= $is_register? 'POST' :'PUT'?>">
		        <?= csrf(); ?>
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
	                        <?= displayErrors(error('common')); ?>
                            <dl class="c-form">
                                <dt class="c-form__title">役職</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="official_position_name" class="c-form__label">役職名</label>
                                        <div class="c-input">
                                            <input type="text" name="official_position_name" id="official_position_name" value="<?= old('official_position_name', $is_register? []: ['official_position_name' => sanitize($official_position['name']) ?? '']); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('official_position_name')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">担当期間</span>
                                        <div class="p-horizon p-horizon--5">
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="first_date" id="first_date" value="<?= old('first_date', $is_register? []: ['first_date' => sanitize($official_position['first_date']) ?? '']); ?>">
                                                <label for="first_date">
                                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="<?= assets('img/symbol/common.svg#calendar'); ?>"></use>
                                                    </svg>
                                                </label>
                                            </div>
                                            〜
                                            <div class="c-input c-input--date js-flatpickr">
                                                <input type="text" class="js-flatpickr__input" name="last_date" id="last_date" value="<?= old('last_date', $is_register? []: ['last_date' => sanitize($official_position['last_date']) ?? '']); ?>">
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
                                        <label for="scale" class="c-form__label">規模</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="scale" id="scale" value="<?= old('scale', $is_register? []: ['scale' => sanitize($official_position['scale']) ?? '']); ?>">人
                                        </div>
		                                <?= displayErrors(error('scale')) ?>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox c-btnBox--full">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('official-positions-list.show',['w_id' => sanitize($work_experience['id'])]); ?>">戻る</a>
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
		view_parts('deleteModal', ['route' => 'official-positions-delete.store' , 'params' => ['w_id' => sanitize($work_experience['id']), 'o_id' => sanitize($official_position['id'])], 'name' => sanitize($official_position['name'])]);
	endif;
	?>
</main>
<?php view_parts('footer'); ?>
