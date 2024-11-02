<?php
view_parts('head', $data);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
    <hgroup class="c-title">
        <h1>所属登録</h1>
        <p>DEPARTMENT REGISTER</p>
    </hgroup>
    
</div>
    <div class="l-main__body l-main__body--info">
        <hgroup class="c-info c-info--box">
            <h2 class="c-info__title">株式会社〇〇〇〇</h2>
            <p class="c-info__note">2012/04/03 〜 2023/07/16</p>
        </hgroup>
        <div class="c-section">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
                            <dl class="c-form">
                                <dt class="c-form__title">配属部署</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="title" class="c-form__label">部署名</label>
                                        <div class="c-input">
                                            <input type="text" name="title" id="title" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="date_range" class="c-form__label">配属期間</label>
                                        <div class="c-input c-input--dateRange">
                                            <input type="text" name="date_range" id="date_range" value="2020/04/01 - 2024/05/16" readonly>
                                            <label for="date_range">
                                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="./img/symbol/common.svg#calendar"></use>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="business" class="c-form__label">担当業務</label>
                                        <div class="c-textarea">
                                            <textarea name="business" id="business" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="product" class="c-form__label">取扱製品</label>
                                        <div class="c-textarea">
                                            <textarea name="product" id="product" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="job_summary" class="c-form__label">業務内容</label>
                                        <div class="c-textarea">
                                            <textarea name="job_summary" id="job_summary" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="number_of_employees" class="c-form__label">規模</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="number_of_employees" id="number_of_employees" value="">人
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
