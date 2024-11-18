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
        <form action="<?= route('qualifications-delete.store', ['id' => $parts_data['id']?? '{id}' ]) ?>" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="<?= session()->get('_token'); ?>">
            <div class="c-modal__body">
                <div class="c-info">
                    <h3 class="c-info__title js-insertDeleteName"><?= $parts_data['name']?? '該当データ'; ?></h3>
                    <p class="c-info__note">※この操作は元に戻せません。本当に削除してもよろしいですか？</p>
                </div>
            </div>
            <div class="c-modal__foot">
                <div class="c-btn c-btn--cansel">
                    <button class="js-hideModal">キャンセル</button>
                </div>
                <div class="c-btn c-btn--delete">
                    <button type="submit">削除する</button>
                </div>
            </div>
        </form>
    </div>
</div>
