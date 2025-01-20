<?php
$user = $data['user'] ?? [];
$page_name = ['en' =>'WITHDRAWAL', 'ja' => '退会'];
view_parts('head', ['title' => $page_name['en'], 'description' => $page_name['ja'].'の説明']);
view_parts('header', $user);
view_parts('globalNav');
?>
<main class="l-main">
    <div class="l-main__head">
        <hgroup class="c-title">
            <h1><?= $page_name['ja']; ?></h1>
            <p><?= $page_name['en']; ?></p>
        </hgroup>
    </div>
    <div class="l-main__body">
        <div class="c-section">
            <form action="<?= route( 'user-withdrawal.store');?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="DELETE">
		        <?= csrf(); ?>
                <div class="c-section__inner">
	                <?= displayErrors(error('common')); ?>
                    <div class="p-noResult">
                        <div class="p-noResult__inner">
                            <p class="c-text--m c-text--center">本当に退会しますか？</p>
                            <p class="c-text--m c-text--center">保存されているデータは<br>一定期間後削除されます。</p>
                        </div>
                    </div>
                    <div class="c-btnBox c-btnBox--full">
                        <div class="c-btn c-btn--frame">
                            <a href="<?= route('documents-list.show'); ?>">戻る</a>
                        </div>
                        <div class="c-btn c-btn--primary">
                            <input type="submit" value="退会する">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php view_parts('footer'); ?>
