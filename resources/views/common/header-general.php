<header class="l-header l-header--center">
	<div class="l-header__inner l-header__inner--center">
		<div class="l-header__logo">
			<a href="<?php echo route('user-login.index'); ?>" class="test">
				<img src="<?php echo assets('img/whole/logo.svg'); ?>" alt="ロゴ">
			</a>
		</div>
	</div>
    <div class="c-flash c-flash--general js-flash">
		<?php if ($error = session()->getFlash('error')): ?>
            <p class="c-flash__message c-flash__message--error c-text--m c-text--center"><?= $error; ?></p>
		<?php elseif ($success = session()->getFlash('success')): ?>
            <p class="c-flash__message c-flash__message--success c-text--m c-text--center"><?= $success; ?></p>
		<?php endif; ?>
    </div>
</header>
<div class="l-container l-container--col1">
