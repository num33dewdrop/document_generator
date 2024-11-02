<?php
view_parts('head', $data);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
    <hgroup class="c-title">
        <h1>学歴登録</h1>
        <p>ACADEMIC BACKGROUND REGISTER</p>
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
                                        <label for="title" class="c-form__label">学校名</label>
                                        <div class="c-input">
                                            <input type="text" name="title" id="title" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="date_range" class="c-form__label">在籍期間</label>
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
                                        <label for="employment_status" class="c-form__label">最終経歴</label>
                                        <div class="c-select">
                                            <select name="employment_status" id="employment_status">
                                                <option value="">選択してください</option>
                                                <option value="1">卒業</option>
                                                <option value="2">在籍中</option>
                                                <option value="3">中退</option>
                                            </select>
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
