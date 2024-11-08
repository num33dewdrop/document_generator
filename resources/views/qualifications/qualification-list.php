<?php
$head = empty($data['head'])? []: $data['head'];
$result = empty($data['result'])? []: $data['result'];
$list = empty($result['list'])? []: $result['list'];
$total = empty($list['total'])? 0: $list['total'];
$min = empty($list['min'])? 0: $list['min'];
$max = empty($list['max'])? 0: $list['max'];
$records = empty($list['records'])? []: $list['records'];

view_parts('head', $head);
view_parts('header');
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
        <hgroup class="c-title">
            <h1>資格一覧</h1>
            <p>QUALIFICATION LIST</p>
        </hgroup>
        <div class="c-btn c-btn--create">
            <a href="<?= route('qualifications-register.show'); ?>">新規追加</a>
        </div>
    </div>
    <div class="l-main__body">
        <div class="c-pager c-pager--pc">
            <p class="c-pager__count">全<?= $total; ?>件中 <?= $min; ?> - <?= $max; ?>件表示</p>
            <ul class="c-pager__list">
                <?php if(!empty($result['paginator'])) $result['paginator']->links(); ?>
            </ul>
        </div>
        <ul class="c-list">
            <?php foreach ($records as $key => $value): ?>
                <li class="c-card js-parentSlide">
                    <div class="c-card__content js-handleSlide">
                        <div class="c-card__body">
                            <p class="c-card__time">
                                <time datetime="2024-06-13"><?= sanitize($value['update_at']); ?></time>
                                <span class="c-label">更新</span>
                            </p>
                            <h2 class="c-card__title"><?= sanitize($value['name']); ?></h2>
                        </div>
                        <div class="c-card__foot">
                            <div class="c-card__btn">
                                <a href="<?= route('qualifications-edit.show'); ?>" id="<?= sanitize($value['id']); ?>">
                                    <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                        <use href="<?= assets('img/symbol/control.svg#edit'); ?>"></use>
                                    </svg>
                                    編集
                                </a>
                            </div>
                        </div>
                        <div class="c-slide c-slide--delete js-targetSlide">
                            <button class="js-handleDelete" id="<?= sanitize($value['id']); ?>">
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
	            <?php if(!empty($result['paginator'])) $result['paginator']->links(); ?>
            </ul>
        </div>
    </div>
    <div id="deleteModal" class="c-modal">
        <div class="c-modal__content js-targetDeleteModal">
            <div class="c-modal__head">
                <h2 class="c-modal__title c-modal__title--delete">
                    <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/control.svg#delete'); ?>"></use>
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
                    <button class="js-exportReport">削除する</button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php view_parts('footer'); ?>