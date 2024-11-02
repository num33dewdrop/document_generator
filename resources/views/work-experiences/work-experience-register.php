<?php
view_parts('head', $data);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
    <hgroup class="c-title">
        <h1>職歴登録</h1>
        <p>WORKS REGISTER</p>
    </hgroup>
    
</div>
    <div class="l-main__body">
        <div class="c-section">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="c-section__inner">
                    <div class="c-box">
                        <div class="c-box__inner">
                            <dl class="c-form">
                                <dt class="c-form__title">会社情報</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="title" class="c-form__label">会社名</label>
                                        <div class="c-input">
                                            <input type="text" name="title" id="title" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="date_range" class="c-form__label">雇用期間</label>
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
                                        <label for="business" class="c-form__label">事業内容</label>
                                        <div class="c-textarea">
                                            <textarea name="business" id="business" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="capital_stock" class="c-form__label">資本金</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="capital_stock" id="capital_stock" value="">円
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="total_sales" class="c-form__label">売上高</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="total_sales" id="total_sales" value="">円
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="number_of_employees" class="c-form__label">従業員数</label>
                                        <div class="c-input c-input--num c-input--text">
                                            <input type="number" name="number_of_employees" id="number_of_employees" value="">人
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="employment_status" class="c-form__label">雇用形態</label>
                                        <div class="c-select">
                                            <select name="employment_status" id="employment_status">
                                                <option value="">選択してください</option>
                                                <option value="1">正社員</option>
                                                <option value="2">準社員</option>
                                                <option value="3">アルバイト</option>
                                                <option value="4">その他</option>
                                            </select>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="job_summary" class="c-form__label">職務要約</label>
                                        <div class="c-textarea">
                                            <textarea name="job_summary" id="job_summary" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="last_career" class="c-form__label">最終経歴</label>
                                        <div class="c-select">
                                            <select name="last_career" id="last_career">
                                                <option value="">選択してください</option>
                                            </select>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">経験</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="work_experience" class="c-form__label">実務経験</label>
                                        <div class="c-textarea">
                                            <textarea name="work_experience" id="work_experience" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="track_record" class="c-form__label">実績</label>
                                        <div class="c-textarea">
                                            <textarea name="track_record" id="track_record" cols="30" rows="10" placeholder="例："></textarea>
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