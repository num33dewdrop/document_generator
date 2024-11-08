import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js";
interface FlatpickrOptions {
    handleClass: string;
    // handleRangeClass: string;
    inputClass: string;
    range: boolean;
}

export default class Flatpickr {
    private nodeList: NodeListOf<Element>;
    private readonly inputClass: string;
    constructor({handleClass, inputClass, range = false}: FlatpickrOptions) {
        this.nodeList = document.querySelectorAll(`.${handleClass}`);
        this.inputClass = inputClass;
        this.nodeList.forEach(elem => {
            const input = elem.querySelector(`.${this.inputClass}`);
            if (input instanceof HTMLInputElement) {
                flatpickr(input, {
                    locale: Japanese,
                    dateFormat: "Y.m.d",
                    disableMobile: true,
                    mode: range? 'range':'single'
                });
            }
        });
    }
}