<?php
$user = $data['user']?? [];
$document = $data['document'] ?? [];
$academic_background = $data['academic_background'] ?? [];
$work_experience = $data['work_experience'] ?? [];
$qualification = $data['qualification'] ?? [];

$is_register = !isset($type) || $type === "register" || $type === "copy";
$is_inherit = !isset($type) || $type === "edit" || $type === "copy";
$page_name = $is_register?
	['en' =>'DOCUMENT REGISTER', 'ja' => '資料登録']:
	['en' =>'DOCUMENT EDIT', 'ja' => '資料編集'];

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
        <div class="c-btnBox">
            <div class="c-btn c-btn--deleteFrame c-btn--auto">
                <button class="js-showDeleteModal">
                    <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/control.svg#delete'); ?>"></use>
                    </svg>
                    削除
                </button>
            </div>
            <div class="c-btn c-btn--frame c-btn--auto">
                <button class="js-showExportModal">
                    <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/control.svg#export'); ?>"></use>
                    </svg>
                    出力
                </button>
            </div>
        </div>
	    <?php endif; ?>
    </div>
    <div class="l-main__body">
        <div class="c-section">
            <form action="<?= route( $is_register? 'documents-register.store': 'documents-edit.store', $is_register? []: ['id' => sanitize($document['id'])]);?>" method="post" enctype="multipart/form-data">
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
                                        <label for="document_name" class="c-form__label">タイトル</label>
                                        <div class="c-input">
                                            <input type="text" name="document_name" id="document_name" value="<?= old('document_name', $is_inherit? ['document_name' => sanitize($document['name']) ?? '']:[]); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('document_name')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">表示項目</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">学歴</span>
                                        <?php if(! empty($academic_background["records"])): ?>
                                            <div class="c-checkbox">
                                                <?php foreach ($academic_background["records"] as $key => $value): ?>
                                                <label><input type="checkbox" name="academic_background[]" value="<?= $value["id"]; ?>" <?= in_array( $value["id"], oldArray('academic_background', $is_inherit? ['academic_background' => explode(',', $document['academic_backgrounds']) ?? []] : []))? 'checked': ''; ?>><?= $value["name"]; ?></label>
                                                <?php endforeach; ?>
                                            </div>
                                            <?= displayErrors(error('academic_background[]')) ?>
                                        <?php else: ?>
                                            学歴を登録してください。
                                        <?php endif; ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">職歴</span>
	                                    <?php if(! empty($work_experience["records"])): ?>
                                            <div class="c-checkbox">
                                            <?php foreach ($work_experience["records"] as $key => $value): ?>
                                                <label><input type="checkbox" name="work_experience[]" value="<?= $value["id"]; ?>" <?= in_array( $value["id"], oldArray('work_experience', $is_inherit? ['work_experience' => explode(',', $document['work_experiences']) ?? []] : []))? 'checked': ''; ?>><?= $value["name"]; ?></label>
                                            <?php endforeach; ?>
                                            </div>
                                            <?= displayErrors(error('work_experience[]')) ?>
	                                    <?php else: ?>
                                            職歴を登録してください。
	                                    <?php endif; ?>
                                    </div>

                                    <div class="c-form__input">
                                        <span class="c-form__label">資格</span>
	                                    <?php if(! empty($qualification["records"])): ?>
                                            <div class="c-checkbox">
			                                    <?php foreach ($qualification["records"] as $key => $value): ?>
                                                <label><input type="checkbox" name="qualification[]" value="<?= $value["id"]; ?>" <?= in_array( $value["id"], oldArray('qualification', $is_inherit? ['qualification' => explode(',', $document['qualifications']) ?? []] : []))? 'checked': ''; ?>><?= $value["name"]; ?></label>
			                                    <?php endforeach; ?>
                                            </div>
		                                    <?= displayErrors(error('qualification[]')) ?>
	                                    <?php else: ?>
                                            資格を登録してください。
	                                    <?php endif; ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">職務経歴書</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="pr" class="c-form__label">自己PR</label>
                                        <div class="c-textarea">
                                            <textarea name="pr" id="pr" cols="30" rows="10" placeholder="例："><?= old('pr', $is_inherit? ['pr' => sanitize($document['pr']) ?? ''] : []); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('pr')) ?>
                                    </div>

                                    <div class="c-form__input">
                                        <label for="supplement" class="c-form__label">自己PR（補足）</label>
                                        <div class="c-textarea">
                                            <textarea name="supplement" id="supplement" cols="30" rows="10" placeholder="例："><?= old('supplement', $is_inherit? ['supplement' => sanitize($document['supplement']) ?? '']: []); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('supplement')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">履歴書</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="wish" class="c-form__label">本人希望欄</label>
                                        <div class="c-textarea">
                                            <textarea name="wish" id="wish" cols="30" rows="10" placeholder="例："><?= old('wish', $is_inherit? ['wish' => sanitize($document['wish']) ?? ''] : []); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('wish')) ?>
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
                            <input type="submit" value="<?= $is_register ? '登録' : '編集'; ?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<?php
	if(!$is_register):
		view_parts('deleteModal', ['route' => 'documents-delete.store' ,'params' => ['id' => sanitize($document['id'])], 'name' => sanitize($document['name'])]);
		view_parts('exportModal', ['route' => 'documents-export.store' ,'params' => ['id' => sanitize($document['id'])], 'name' => sanitize($document['name'])]);
	endif;
	?>
</main>
<?php view_parts('footer'); ?>