

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BIZ+UDPGothic:wght@400;700&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <title>所属登録 | sitename</title>
    <meta name="description" content="説明文">
<link href="../css/style.css" rel="stylesheet"></head>
<body>
<header class="l-header">
    <div class="l-header__inner c-menu js-parentMenu">
        <div class="l-header__logo">
            <a href="../../../../php"><img src="../../img/whole/logo.svg" alt="ロゴ"></a>
        </div>
        <button class="c-menu__btn js-handleMenu"><span></span></button>
        <div class="c-menu__target">
            <div class="c-user c-menu__name">
                <div class="c-user__img">
                    <img src="../../img/whole/no-user.svg" alt="">
                </div>
                <p class="c-user__name">結城 羽津子</p>
            </div>
            <ul class="c-menu__list">
                <li class="c-menu__item"><a href="">会員情報編集</a></li>
                <li class="c-menu__item"><a href="">資料一覧</a></li>
                <li class="c-menu__item"><a href="">職歴一覧</a></li>
                <li class="c-menu__item"><a href="">学歴一覧</a></li>
                <li class="c-menu__item"><a href="">資格一覧</a></li>
                <li class="c-menu__item"><a href="">ログアウト</a></li>
                <li class="c-menu__item"><a href="">退会</a></li>
            </ul>
        </div>
    </div>
</header>
<div class="l-container">

<div class="l-globalNav">
    <nav>
        <ul>
            
            <li class="">
                <a class="current" href="../../../../php">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="../img/symbol/global_nav.svg#home"></use>
                    </svg>
                    <span>ホーム</span>
                </a>
            </li>
            
            <li class="">
                <a class="" href="work-experience-list">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="../img/symbol/global_nav.svg#works"></use>
                    </svg>
                    <span>職歴一覧</span>
                </a>
            </li>
            
            <li class="">
                <a class="" href="academic-background-list">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="../img/symbol/global_nav.svg#academic"></use>
                    </svg>
                    <span>学歴一覧</span>
                </a>
            </li>
            
            <li class="">
                <a class="" href="qualification-list">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="../img/symbol/global_nav.svg#qualification"></use>
                    </svg>
                    <span>資格一覧</span>
                </a>
            </li>
            
            <li class="">
                <a class="" href="user-edit">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="../img/symbol/global_nav.svg#user"></use>
                    </svg>
                    <span>会員情報</span>
                </a>
            </li>
            
        </ul>
    </nav>
</div>
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
</div>
<footer>
</footer>
<script defer src="../js/bundle.js"></script></body>
</html>
