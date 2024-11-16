import { fadeIn, fadeOut } from "./_fadeIn";

interface PopupElements {
    handleShowClass: string;
    handleHideClass: string;
    targetClass: string;
    parentId: string;
    insertIdClass: string;
    insertNameClass: string;
}

export default class Popup {
    private readonly handleShow!: NodeListOf<HTMLButtonElement>;
    private readonly handleHide!: NodeListOf<HTMLElement>;
    private readonly target!: HTMLElement | null;
    private readonly bg: HTMLDivElement = document.createElement('div');
    private readonly parent: HTMLElement | null;
    public insertId!: HTMLElement | null;
    private insertName!: HTMLElement | null;

    constructor({ parentId, handleShowClass, handleHideClass, targetClass, insertIdClass, insertNameClass }: PopupElements) {
        this.parent = this.getElement<HTMLElement>(`#${parentId}`);
        // 要素が存在しない場合は早期リターン
        if (!this.parent) return;

        this.handleShow = this.getElements<HTMLButtonElement>(`.${handleShowClass}`);
        this.handleHide = this.getElementsFromParent<HTMLElement>(this.parent, `.${handleHideClass}`);
        this.target = this.getElementFromParent<HTMLElement>(this.parent, `.${targetClass}`);
        this.insertId = this.getElementFromParent<HTMLElement>(this.parent, `.${insertIdClass}`);
        this.insertName = this.getElementFromParent<HTMLElement>(this.parent, `.${insertNameClass}`);
        this.setupBackground();
        this.addEventListeners();
    }

    private setupBackground(): void {
        this.bg.classList.add('c-modal__bg');
        this.bg.addEventListener('click', () => this.onHidePopup());
        this.parent!.appendChild(this.bg); // parent が null でないことを保証する
    }

    private addEventListeners(): void {
        this.handleShow.forEach(elem => {
            elem.addEventListener('click', () => this.onShowPopup(elem.dataset));
        });

        this.handleHide.forEach(elem => {
            elem.addEventListener('click', () => this.onHidePopup());
        });
    }

    private onShowPopup(data: DOMStringMap): void {
        if (!this.warnIfNull(this.target, "Target element not found.")) return;
        if (this.insertId && data.id) {
            this.insertId.innerText = data.id;
        }
        if (this.insertName && data.name) {
            this.insertName.innerText = data.name;
        }
        fadeIn(this.target);
        fadeIn(this.bg);
    }

    private onHidePopup(): void {
        if (!this.warnIfNull(this.target, "Target element not found.")) return;
        fadeOut(this.target);
        fadeOut(this.bg);
    }

    private getElement<T extends HTMLElement>(selector: string): T | null {
        return document.querySelector<T>(selector);
    }

    private getElements<T extends HTMLElement>(selector: string): NodeListOf<T> {
        return document.querySelectorAll<T>(selector);
    }

    private getElementFromParent<T extends HTMLElement>(parent: HTMLElement, selector: string): T | null {
        return parent.querySelector<T>(selector);
    }

    private getElementsFromParent<T extends HTMLElement>(parent: HTMLElement, selector: string): NodeListOf<T> {
        return parent.querySelectorAll<T>(selector);
    }

    private warnIfNull<T>(element: T | null, msg: string): element is T {
        if (!element) {
            console.warn(msg);
            return false;
        }
        return true;
    }
}
