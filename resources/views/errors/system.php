<?php
view_parts('head', ['title' => 'ERROR', 'description' => 'ERRORの説明']);
view_parts('header');
view_parts('globalNav', ["type" => ""]);
?>
<main class="l-main">
	<div class="l-main__head">
		<hgroup class="c-title">
			<h1>500 エラー</h1>
			<p>ERROR</p>
		</hgroup>
	</div>
	<div class="l-main__body">
		<div class="p-noResult">
			<div class="p-noResult__inner">
				<p class="c-text--m c-text--error c-text--center">予期せぬエラーが発生しました。</p>
				<p class="c-text--m c-text--error c-text--center">サポートが必要な場合は、管理者までご連絡ください。</p>
			</div>
		</div>
	</div>
</main>
<?php view_parts('footer'); ?>

