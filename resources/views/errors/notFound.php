<?php
view_parts('head', ['title' => 'ERROR', 'description' => 'ERRORの説明']);
view_parts('header');
view_parts('globalNav');
?>
	<main class="l-main">
		<div class="l-main__head">
			<hgroup class="c-title">
				<h1>404 エラー</h1>
				<p>ERROR</p>
			</hgroup>
		</div>
		<div class="l-main__body">
			<div class="p-noResult">
				<div class="p-noResult__inner">
					<p class="c-text--m c-text--error c-text--center">お探しのページが見つかりません。</p>
					<p class="c-text--m c-text--error c-text--center">ご覧になっていたページの有効期限が過ぎている、またはリンクが無効になっているなどが考えられます。</p>
				</div>
			</div>
		</div>
	</main>
<?php view_parts('footer'); ?>