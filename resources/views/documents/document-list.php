<?php
view_parts('head', $data);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
        <hgroup class="c-title">
            <h1>資料一覧</h1>
            <p>DOCUMENT LIST</p>
        </hgroup>
        <div class="c-btn c-btn--create">
            <a href="<?= route('documents-register.show'); ?>">新規追加</a>
        </div>
    </div>
    <div class="l-main__body">
        <div class="c-pager c-pager--pc">
            <p class="c-pager__count">全999件中 1 - 100件表示</p>
            <ul class="c-pager__list">
                <li>
                    <a href="" class="c-pager__link" disabled="">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#first"></use>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="" class="c-pager__link" disabled="">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#prev"></use>
                        </svg>
                    </a>
                </li>
                <li><a href="" class="c-pager__link c-pager__link--active">1</a></li>
                <li><a href="" class="c-pager__link">2</a></li>
                <li><a href="" class="c-pager__link">3</a></li>
                <li><a href="" class="c-pager__link">4</a></li>
                <li><a href="" class="c-pager__link">5</a></li>
                <li>
                    <a href="" class="c-pager__link">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#next"></use>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="" class="c-pager__link">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#last"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <ul class="c-list">
            <li class="c-card js-parentSlide">
                <div class="c-card__content js-handleSlide">
                    <div class="c-card__body">
                        <p class="c-card__time">
                            <time datetime="2024-06-13">2024-06-13</time>
                            <span class="c-label">更新</span>
                        </p>
                        <h2 class="c-card__title">WEBプログラマー応募用（フロント）</h2>
                    </div>
                    <div class="c-card__foot">
                        <div class="c-card__btn">
                            <a href="<?= route('documents-edit.show'); ?>">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="./assets/img/symbol/control.svg#edit"></use>
                                </svg>
                                編集
                            </a>
                        </div>
                        <div class="c-card__btn">
                            <a href="<?= route('documents-copy.show'); ?>">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="./assets/img/symbol/control.svg#copy"></use>
                                </svg>
                                複製
                            </a>
                        </div>
                        <div class="c-card__btn c-card__btn--export">
                            <button class="js-showExportModal">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="./assets/img/symbol/control.svg#export"></use>
                                </svg>
                                出力
                            </button>
                        </div>
                        <div class="c-card__btn c-card__btn--delete">
                            <button class="js-showDeleteModal">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="./assets/img/symbol/control.svg#delete"></use>
                                </svg>
                                削除
                            </button>
                        </div>
                    </div>
                    <div class="c-slide c-slide--delete js-targetSlide">
                        <button class="js-showDeleteModal">
                            <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                <use href="./assets/img/symbol/control.svg#delete"></use>
                            </svg>
                            削除
                        </button>
                    </div>
                </div>
            </li>
        </ul>
        <div class="c-pager--end">
            <ul class="c-pager__list">
                <li>
                    <a href="" class="c-pager__link" disabled="">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#first"></use>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="" class="c-pager__link" disabled="">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#prev"></use>
                        </svg>
                    </a>
                </li>
                <li><a href="" class="c-pager__link c-pager__link--active">1</a></li>
                <li><a href="" class="c-pager__link">2</a></li>
                <li><a href="" class="c-pager__link">3</a></li>
                <li><a href="" class="c-pager__link">4</a></li>
                <li><a href="" class="c-pager__link">5</a></li>
                <li>
                    <a href="" class="c-pager__link">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#next"></use>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="" class="c-pager__link">
                        <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg">
                            <use href="./assets/img/symbol/arrow.svg#last"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div id="exportModal" class="c-modal">
        <div class="c-modal__content js-targetExportModal">
            <div class="c-modal__head">
                <h2 class="c-modal__title">
                    <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                        <use href="./assets/img/symbol/control.svg#export"></use>
                    </svg>
                    資料出力
                </h2>
                <button class="c-close js-hideModal"></button>
            </div>
            <div class="c-modal__body">
                <div class="c-info">
                    <h3 class="c-info__title">WEBプログラマー応募用（フロント）</h3>
                    <p class="c-info__note">※経歴書：docs形式、履歴書：xml形式で出力</p>
                </div>
            </div>
            <div class="c-modal__foot">
                <div class="c-btn c-btn--cansel">
                    <button class="js-hideModal">キャンセル</button>
                </div>
                <div class="c-btn c-btn--primary">
                    <button class="js-exportReport">出力</button>
                </div>
            </div>
        </div>
    </div>
    <div id="deleteModal" class="c-modal">
        <div class="c-modal__content js-targetDeleteModal">
            <div class="c-modal__head">
                <h2 class="c-modal__title c-modal__title--delete">
                    <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                        <use href="./assets/img/symbol/control.svg#delete"></use>
                    </svg>
                    削除
                </h2>
                <button class="c-close js-hideModal"></button>
            </div>
            <div class="c-modal__body">
                <div class="c-info">
                    <h3 class="c-info__title">WEBプログラマー応募用（フロント）</h3>
                    <p class="c-info__note">※この操作は元に戻せません。本当に削除してもよろしいですか？</p>
                </div>
            </div>
            <div class="c-modal__foot">
                <div class="c-btn c-btn--cansel">
                    <button class="js-hideModal">キャンセル</button>
                </div>
                <div class="c-btn c-btn--delete">
                    <button class="js-handleDelete">削除する</button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php view_parts('footer'); ?>

