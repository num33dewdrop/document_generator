import ImgDrop from './modules/_imgDrop';
import ToggleIsOpen from './modules/_toggleIsOpen';
import Slide from './modules/_slide';
import Popup from './modules/_popup';
import Flatpickr from './modules/_flatpickr';
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
    handleRangeClass: 'js-flatpickr--range',
    inputClass: 'js-flatpickr__input'
};


new ImgDrop(imgDropObj);
new ToggleIsOpen(menuObj);
new Slide(slideObj);
new Popup(exportModalObj);
new Popup(deleteModalObj);
new Flatpickr(flatpickrObj);