import {slideIn, slideOut} from "./_helpers";
interface FlashElements {
    targetClass: string;
}
export default class FlashMessage {
    private readonly target: HTMLDivElement | null;
    constructor({targetClass} : FlashElements) {
        this.target = document.querySelector(`.${targetClass}`);
        if (!this.warnIfNull(this.target, "Handle element not found.")) return;
        const message = (this.target.innerText).trim();
        if(message.length) {
            this.onShowMessage();
        }
    }
    public onShowMessage () {
        if (!this.warnIfNull(this.target, "Handle element not found.")) return;
        slideIn(this.target);
        setTimeout(() => {
            if (!this.warnIfNull(this.target, "Handle element not found.")) return;
            slideOut(this.target);
        }, 3000);
    }
    private warnIfNull<T>(element: T | null, msg: string): element is T {
        if (!element) {
            console.warn(msg);
            return false;
        }
        return true;
    }
}