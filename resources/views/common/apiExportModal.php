<div id="exportModal" class="c-modal">
	<div class="c-modal__content js-targetExportModal">
		<div class="c-modal__head">
			<h2 class="c-modal__title">
				<svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
					<use href="<?= assets('img/symbol/control.svg#export'); ?>"></use>
				</svg>
				資料出力
			</h2>
			<button class="c-close js-hideModal"></button>
		</div>
		<div class="c-modal__body">
			<div class="c-info">
				<h3 class="c-info__title js-insertExportName">該当データ</h3>
				<p class="c-info__note">※経歴書：docs形式、履歴書：xml形式で出力</p>
			</div>
		</div>
		<div class="c-modal__foot">
			<div class="c-btn c-btn--cansel">
				<button class="js-hideModal">キャンセル</button>
			</div>
			<div class="c-btn c-btn--primary">
				<button type="submit"
						class="js-handleExport js-insertExportId"
						data-id="0"
						data-token="<?= session()->get('_token'); ?>"
						data-target="<?= $parts_data['target'] ?? '' ?>"
				>出力する</button>
			</div>
		</div>
	</div>
</div>