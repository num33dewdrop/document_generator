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
                                            <input type="text" name="document_name" id="document_name" value="<?= old('document_name', $is_register? []: ['document_name' => sanitize($document['name']) ?? '']); ?>" placeholder="例：">
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
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="academic_background[]" value="">〇〇高等学校</label>
                                            <label><input type="checkbox" name="academic_background[]" value="">〇〇専門学校</label>
                                            <label><input type="checkbox" name="academic_background[]" value="">〇〇大学</label>
                                        </div>
	                                    <?= displayErrors(error('academic_background[]')) ?>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">職歴</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="work_experience[]" value="">株式会社〇〇〇〇〇〇〇〇</label>
                                            <label><input type="checkbox" name="work_experience[]" value="">株式会社〇〇</label>
                                            <label><input type="checkbox" name="work_experience[]" value="">株式会社〇〇〇〇</label>
                                        </div>
	                                    <?= displayErrors(error('work_experience[]')) ?>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">資格</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="qualification[]" value="">クレーン運転士</label>
                                            <label><input type="checkbox" name="qualification[]" value="">危険物取扱者</label>
                                            <label><input type="checkbox" name="qualification[]" value="">電気工事士</label>
                                            <label><input type="checkbox" name="qualification[]" value="">フォークリフト運転講習</label>
                                            <label><input type="checkbox" name="qualification[]" value="">機械設計</label>
                                            <label><input type="checkbox" name="qualification[]" value="">電気工事士</label>
                                        </div>
	                                    <?= displayErrors(error('qualification[]')) ?>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">職務経歴書</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="pr" class="c-form__label">自己PR</label>
                                        <div class="c-textarea">
                                            <textarea name="pr" id="pr" cols="30" rows="10" placeholder="例："><?= old('pr', $is_register? []: ['pr' => sanitize($document['pr']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('pr')) ?>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="supplement" class="c-form__label">自己PR（補足）</label>
                                        <div class="c-textarea">
                                            <textarea name="supplement" id="supplement" cols="30" rows="10" placeholder="例："><?= old('supplement', $is_register? []: ['supplement' => sanitize($document['supplement']) ?? '']); ?></textarea>
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
                                            <textarea name="wish" id="wish" cols="30" rows="10" placeholder="例："><?= old('wish', $is_register? []: ['wish' => sanitize($document['wish']) ?? '']); ?></textarea>
                                        </div>
	                                    <?= displayErrors(error('wish')) ?>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox">
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
	<?php
	if(!$is_register):
		view_parts('deleteModal', ['route' => 'documents-delete.store' ,'params' => ['id' => sanitize($document['id'])], 'name' => sanitize($document['name'])]);
	endif;
	?>
</main>
<?php view_parts('footer'); ?>