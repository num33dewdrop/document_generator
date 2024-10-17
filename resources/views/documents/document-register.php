

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
    <title>資料登録 | sitename</title>
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
            <h1>資料登録</h1>
            <p>RESUME REGISTER</p>
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
                                        <label for="title" class="c-form__label">タイトル</label>
                                        <div class="c-input">
                                            <input type="text" name="title" id="title" value="" placeholder="例：">
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">表示項目</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">学歴</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="title" value="">〇〇高等学校</label>
                                            <label><input type="checkbox" name="title" value="">〇〇専門学校</label>
                                            <label><input type="checkbox" name="title" value="">〇〇大学</label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">職歴</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="title" value="">株式会社〇〇〇〇〇〇〇〇</label>
                                            <label><input type="checkbox" name="title" value="">株式会社〇〇</label>
                                            <label><input type="checkbox" name="title" value="">株式会社〇〇〇〇</label>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <span class="c-form__label">資格</span>
                                        <div class="c-checkbox">
                                            <label><input type="checkbox" name="title" value="">クレーン運転士</label>
                                            <label><input type="checkbox" name="title" value="">危険物取扱者</label>
                                            <label><input type="checkbox" name="title" value="">電気工事士</label>
                                            <label><input type="checkbox" name="title" value="">フォークリフト運転講習</label>
                                            <label><input type="checkbox" name="title" value="">機械設計</label>
                                            <label><input type="checkbox" name="title" value="">電気工事士</label>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">職務経歴書</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="pr" class="c-form__label">自己PR</label>
                                        <div class="c-textarea">
                                            <textarea name="pr" id="pr" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="supplement" class="c-form__label">自己PR（補足）</label>
                                        <div class="c-textarea">
                                            <textarea name="supplement" id="supplement" cols="30" rows="10" placeholder="例："></textarea>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="c-form">
                                <dt class="c-form__title">履歴書</dt>
                                <dd class="c-form__group">
                                    <div class="c-form__input">
                                        <label for="wish" class="c-form__label">本人希望欄</label>
                                        <div class="c-textarea">
                                            <textarea name="wish" id="wish" cols="30" rows="10" placeholder="例："></textarea>
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
