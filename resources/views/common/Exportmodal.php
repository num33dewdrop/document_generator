<div id="exportModal" class="c-modal">
	<div class="c-modal__content js-targetExportModal">
		<div class="c-modal__head">
			<h2 class="c-modal__title">
				<svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
					<use href="<?= assets('img/symbol/control.svg#delete'); ?>"></use>
				</svg>
				資料出力
			</h2>
			<button class="c-close js-hideModal"></button>
		</div>
		<form action="<?= route($parts_data['route'] ?? '', $parts_data['params']?? []) ?>" method="post">
			<input type="hidden" name="_method" value="DELETE">
			<?= csrf(); ?>
			<div class="c-modal__body">
				<div class="c-info">
					<h3 class="c-info__title js-insertExportName"><?= $parts_data['name']?? '該当データ'; ?></h3>
					<p class="c-info__note">※経歴書：docs形式、履歴書：xml形式で出力</p>
				</div>
			</div>
			<div class="c-modal__foot">
				<div class="c-btn c-btn--cansel">
					<button class="js-hideModal">キャンセル</button>
				</div>
				<div class="c-btn c-btn--primary">
					<button type="submit">出力する</button>
				</div>
			</div>
		</form>
	</div>
</div>
