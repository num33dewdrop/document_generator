<header class="l-header">
	<div class="l-header__inner c-menu js-parentMenu">
		<div class="l-header__logo">
			<a href="<?= route('documents-list.show'); ?>" class="test">
                <img src="<?= assets('img/whole/logo.svg'); ?>" alt="ロゴ">
            </a>
		</div>
		<button class="c-menu__btn js-handleMenu"><span></span></button>
		<div class="c-menu__target">
			<div class="c-user c-menu__name">
				<div class="c-user__img">
					<img src="<?= assets('img/whole/no-user.svg'); ?>" alt="">
				</div>
				<p class="c-user__name">結城 羽津子</p>
			</div>
			<ul class="c-menu__list">
				<li class="c-menu__item"><a href="<?= route('user-edit.show') ?>">会員情報編集</a></li>
				<li class="c-menu__item"><a href="<?= route('documents-list.show'); ?>">資料一覧</a></li>
				<li class="c-menu__item"><a href="<?= route('work-experiences-list.show'); ?>">職歴一覧</a></li>
				<li class="c-menu__item"><a href="<?= route('academic-backgrounds-list.show'); ?>">学歴一覧</a></li>
				<li class="c-menu__item"><a href="<?= route('qualifications-list.show'); ?>">資格一覧</a></li>
				<li class="c-menu__item"><a href="<?= route('user-logout.store') ?>">ログアウト</a></li>
				<li class="c-menu__item"><a href="<?= route('user-withdrawal.show') ?>">退会</a></li>
			</ul>
		</div>
	</div>
    <div class="c-flash js-flash">
		<?php if ($error = session()->getFlash('error')): ?>
            <p class="c-flash__message c-flash__message--error c-text--m c-text--center"><?= $error; ?></p>
        <?php elseif ($success = session()->getFlash('success')): ?>
            <p class="c-flash__message c-flash__message--success c-text--m c-text--center"><?= $success; ?></p>
	    <?php endif; ?>
    </div>
</header>
<div class="l-container">
