<div class="l-globalNav">
    <nav>
        <ul>
            <li class="">
                <a class="<?= isset($parts_data) && $parts_data["type"] === "documents"? "current":"";  ?>" href="<?= route('documents-list.show'); ?>">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/global_nav.svg#home'); ?>"></use>
                    </svg>
                    <span>ホーム</span>
                </a>
            </li>
            <li class="">
                <a class="<?= isset($parts_data) && $parts_data["type"] === "work-experiences"? "current":"";  ?>" href="<?= route('work-experiences-list.show'); ?>">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/global_nav.svg#works'); ?>"></use>
                    </svg>
                    <span>職歴一覧</span>
                </a>
            </li>
            <li class="">
                <a class="<?= isset($parts_data) && $parts_data["type"] === "academic-backgrounds"? "current":"";  ?>" href="<?= route('academic-backgrounds-list.show'); ?>">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/global_nav.svg#academic'); ?>"></use>
                    </svg>
                    <span>学歴一覧</span>
                </a>
            </li>
            <li class="">
                <a class="<?= isset($parts_data) && $parts_data["type"] === "qualifications"? "current":"";  ?>" href="<?= route('qualifications-list.show'); ?>">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/global_nav.svg#qualification'); ?>"></use>
                    </svg>
                    <span>資格一覧</span>
                </a>
            </li>
            <li class="">
                <a class="<?= isset($parts_data) && $parts_data["type"] === "user-edit"? "current":"";  ?>" href="<?= route('user-edit.show'); ?>">
                    <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                        <use href="<?= assets('img/symbol/global_nav.svg#user'); ?>"></use>
                    </svg>
                    <span>会員情報</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
