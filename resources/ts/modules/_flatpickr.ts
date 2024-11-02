import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js";
interface FlatpickrOptions {
    handleClass: string;
    handleRangeClass: string;
    inputClass: string;
}

export default class Flatpickr {
    private nodeList: NodeListOf<Element>;
    private readonly inputClass: string;
    constructor({handleClass, handleRangeClass, inputClass}: FlatpickrOptions) {
        this.nodeList = document.querySelectorAll(`.${handleClass}`);
        console.log(handleRangeClass);
        this.inputClass = inputClass;
        this.nodeList.forEach(elem => {
            const input = elem.querySelector(`.${this.inputClass}`);
            if (input instanceof HTMLInputElement) {
                flatpickr(input, {
                    locale: Japanese,
                    dateFormat: "Y-m-d",
                    disableMobile: true
                });
            }
        });
    }
}