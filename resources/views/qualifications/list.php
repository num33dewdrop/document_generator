<?php
$list = empty($data['list'])? []: $data['list'];
$paginate = empty($data['paginator'])? '': $data['paginator']->links();
view_parts('head', ['title' => 'QUALIFICATION LIST', 'description' => 'QUALIFICATION LISTの説明']);
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
                                <a href="<?= route('qualifications-edit.show', ['id' => sanitize($value['id'])]); ?>">
                                    <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                        <use href="<?= assets('img/symbol/control.svg#edit'); ?>"></use>
                                    </svg>
                                    編集
                                </a>
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
        結果なし
        <?php endif; ?>
    </div>
	<?php view_parts('apiDeleteModal'); ?>
</main>
<?php view_parts('footer'); ?>