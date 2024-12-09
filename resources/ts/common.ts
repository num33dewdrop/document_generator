import ImgDrop from './modules/_imgDrop';
import ToggleIsOpen from './modules/_toggleIsOpen';
import Slide from './modules/_slide';
import Popup from './modules/_popup';
import Flatpickr from './modules/_flatpickr';
import FlashMessage from './modules/_flashMessage';
import {fetchApi} from "./api/_fetch";
import {jump} from "./modules/_helpers";
import '../scss/style.scss';


const imgDropObj = {
    labelClass: 'js-dropArea', // HTMLLabelElementのクラス名
    inputClass: 'js-inputFile' // HTMLInputElementのクラス名
};
const menuObj = {
    parentClass: 'js-parentMenu',
    handleClass: 'js-handleMenu'
};
const slideObj = {
    handleClass : 'js-handleSlide',
    targetClass : 'js-targetSlide',
    parentClass : 'js-parentSlide'
};
const exportModalObj = {
    handleShowClass: 'js-showExportModal',
    handleHideClass: 'js-hideModal',
    targetClass: 'js-targetExportModal',
    parentId: 'exportModal',
    insertIdClass: 'js-insertExportId',
    insertNameClass: 'js-insertExportName',
};
const deleteModalObj = {
    handleShowClass: 'js-showDeleteModal',
    handleHideClass: 'js-hideModal',
    targetClass: 'js-targetDeleteModal',
    parentId: 'deleteModal',
    insertIdClass: 'js-insertDeleteId',
    insertNameClass: 'js-insertDeleteName',
};
const flatpickrObj = {
    handleClass: 'js-flatpickr',
    inputClass: 'js-flatpickr__input',
    range: false
};
const flatpickrRangeObj = {
    handleClass: 'js-flatpickr--range',
    inputClass: 'js-flatpickr__input',
    range: true
};
const flashMessageObj = {
    targetClass: 'js-flash'
};

new ImgDrop(imgDropObj);
new ToggleIsOpen(menuObj);
new Slide(slideObj);
new Flatpickr(flatpickrObj);
new Flatpickr(flatpickrRangeObj);

new Popup(exportModalObj);
const DeleteModal = new Popup(deleteModalObj);
new FlashMessage(flashMessageObj);

// console.log(ExportModal);

const $apiHandleDelete : NodeListOf<HTMLButtonElement> = document.querySelectorAll('.js-handleDelete');
const $flash : HTMLDivElement | null = document.querySelector('.js-flash');
$apiHandleDelete.forEach(elem => {
    elem.addEventListener('click', async e => {
        if(! (e.currentTarget instanceof HTMLButtonElement) || !$flash) {
            return false;
        }
        const id = e.currentTarget.dataset.id?? '';
        const target = e.currentTarget.dataset.target?? '';
        const token = e.currentTarget.dataset.token?? '';
        if(id === '' || token === '') {
            return false;
        }
        const response = await fetchApi('./api/' + target + '/delete?id=' + id, 'DELETE', token);
        const json = await response.json();
        if(!response.ok) {
            $flash.innerHTML = `<p class="c-flash__message c-flash__message--error c-text--m c-text--center">${json.error}</p>`;
        }
        DeleteModal.onHidePopup();
        jump();
    });
});
