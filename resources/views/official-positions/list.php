<?php
$user = $data['user'] ?? [];
$work_experience = empty($data['work_experience'])? []: $data['work_experience'];
$list = empty($data['official_positions']['list'])? []: $data['official_positions']['list'];
$paginate = empty($data['official_positions']['paginator'])? '': $data['official_positions']['paginator']->links();
view_parts('head', ['title' => 'OFFICIAL POSITION LIST', 'description' => 'OFFICIAL POSITION LISTの説明']);
view_parts('header', $user);
view_parts('globalNav', ["type" => "work-experiences"]);
?>
<main class="l-main">
    <div class="l-main__head">
        <hgroup class="c-title">
            <h1>所属一覧</h1>
            <p>OFFICIAL POSITION LIST</p>
        </hgroup>
        <div class="c-btn c-btn--create">
            <a href="<?= route('official-positions-register.show', ['w_id' => sanitize($work_experience['id'])]); ?>">新規作成</a>
        </div>
    </div>
    <div class="l-main__body l-main__body--info">
        <hgroup class="c-info c-info--box">
            <h2 class="c-info__title"><?= sanitize($work_experience['name']); ?></h2>
            <p class="c-info__note"><?= sanitize($work_experience['first_date']); ?> 〜 <?= sanitize($work_experience['last_date']); ?></p>
        </hgroup>
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
                            <a href="<?= route('official-positions-edit.show', ['w_id' => sanitize($work_experience['id']) ,'o_id' => sanitize($value['id'])]); ?>">
                                <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <use href="<?= assets('img/symbol/control.svg#edit'); ?>"></use>
                                </svg>
                                編集
                            </a>
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
                <p class="c-text--m c-text--center">役職の登録がありません。</p>
                <p class="c-text--m c-text--center">新規作成ボタンから役職を登録してください。</p>
            </div>
        </div>
	    <?php endif; ?>
    </div>
	<?php view_parts('apiDeleteModal', ["target" => 'official-position']); ?>
</main>
<?php view_parts('footer'); ?>