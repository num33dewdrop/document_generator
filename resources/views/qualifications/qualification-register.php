<?php
view_parts('head', $data);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
        <hgroup class="c-title">
            <h1>資格登録</h1>
            <p>QUALIFICATION REGISTER</p>
        </hgroup>
    </div>
    <div class="l-main__body">
        <div class="c-section">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
	                        <?= displayErrors(error('common')); ?>
                            <dl class="c-form">
                                <dt class="c-form__title">基本情報</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="qualification_name" class="c-form__label">資格名</label>
                                        <div class="c-input">
                                            <input type="text" name="qualification_name" id="qualification_name" value="<?= old('qualification_name'); ?>" placeholder="例：">
                                        </div>
	                                    <?= displayErrors(error('qualification_name')) ?>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="acquisition_date" class="c-form__label">取得年月日</label>
                                        <div class="c-input c-input--date js-flatpickr">
                                            <input type="text" class="js-flatpickr__input" name="acquisition_date" id="acquisition_date" value="<?= old('acquisition_date'); ?>">
                                            <label for="acquisition_date">
                                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="<?= assets('img/symbol/common.svg#calendar'); ?>"></use>
                                                </svg>
                                            </label>
                                        </div>
	                                    <?= displayErrors(error('acquisition_date')) ?>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="c-btnBox">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('qualifications-list.show'); ?>">戻る</a>
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
