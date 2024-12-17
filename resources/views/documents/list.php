<?php
$list = empty($data['list'])? []: $data['list'];
$paginate = empty($data['paginator'])? '': $data['paginator']->links();
view_parts('head', ['title' => 'DOCUMENT LIST', 'description' => 'DOCUMENT LISTの説明']);
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
            <a href="<?= route('documents-register.show'); ?>">新規作成</a>
        </div>
    </div>
    <div class="l-main__body">
	    <?php if(!empty($list['records'])): ?>
        <div class="c-pager c-pager--pc">
            <p class="c-pager__count">全<?= $list['total']; ?>件中 <?= $list['min']; ?> - <?= $list['max']; ?>件表示</p>
            <ul class="c-pager__list">
			    <?= $paginate; ?>
            </ul>
        </div>
        <ul class="c-list">
            <?php foreach ($list['records'] as $key => $value): ?>
            <li class="c-card js-parentSlide">
                <div class="c-card__content js-handleSlide">
                    <div class="c-card__body">
                        <p class="c-card__time">
                            <time datetime="<?= sanitize($value['update_at']); ?>"><?= sanitize($value['update_at']); ?></time>
                            <span class="c-label">更新</span>
                        </p>
                        <h2 class="c-card__title"><?= sanitize($value['name']); ?></h2>
                    </div>
                    <div class="c-card__foot">
                        <div class="c-card__btn">
                            <a href="<?= route('documents-edit.show', ['id' => sanitize($value['id'])]); ?>">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="<?= assets('img/symbol/control.svg#edit'); ?>"></use>
                                </svg>
                                編集
                            </a>
                        </div>
                        <div class="c-card__btn">
                            <a href="<?= route('documents-copy.show', ['id' => sanitize($value['id'])]); ?>">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="<?= assets('img/symbol/control.svg#copy'); ?>"></use>
                                </svg>
                                複製
                            </a>
                        </div>
                        <div class="c-card__btn c-card__btn--export">
                            <button class="js-showExportModal" data-id="<?= sanitize($value['id']); ?>" data-name="<?= sanitize($value['name']); ?>">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="<?= assets('img/symbol/control.svg#export'); ?>"></use>
                                </svg>
                                出力
                            </button>
                        </div>
                        <div class="c-card__btn c-card__btn--delete">
                            <button class="js-showDeleteModal" data-id="<?= sanitize($value['id']); ?>" data-name="<?= sanitize($value['name']); ?>">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="<?= assets('img/symbol/control.svg#delete'); ?>"></use>
                                </svg>
                                削除
                            </button>
                        </div>
                    </div>
                    <div class="c-slide c-slide--delete js-targetSlide">
                        <button class="js-showDeleteModal" data-id="<?= sanitize($value['id']); ?>" data-name="<?= sanitize($value['name']); ?>">
                            <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                <use href="<?= assets('img/symbol/control.svg#delete'); ?>"></use>
                            </svg>
                            削除
                        </button>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
            <div class="c-pager--end">
                <ul class="c-pager__list">
				    <?= $paginate; ?>
                </ul>
            </div>
	    <?php else: ?>
            <div class="p-noResult">
                <div class="p-noResult__inner">
                    <p class="c-text--m c-text--center">資料の登録がありません。</p>
                    <p class="c-text--m c-text--center">新規作成ボタンから資料を登録してください。</p>
                </div>
            </div>
	    <?php endif; ?>
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
	<?php view_parts('apiDeleteModal', ["target" => 'document']); ?>
</main>
<?php view_parts('footer'); ?>

