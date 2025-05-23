interface SlideElements {
    handleClass: string;
    targetClass: string;
    parentClass: string;
}

export default class Slide {
    private parentSlide: NodeListOf<HTMLElement>;
    private initX: number;
    private readonly targetClass: string;
    public current: HTMLElement | null = null;

    constructor({ handleClass, targetClass, parentClass }: SlideElements) {
        this.parentSlide = document.querySelectorAll(`.${parentClass}`);
        this.targetClass = targetClass;
        this.initX = 0;
        this.parentSlide.forEach(elem => {
            const handle: HTMLElement | null = elem.querySelector(`.${handleClass}`);
            const target: HTMLElement | null = elem.querySelector(`.${targetClass}`);
            if (!this.warnIfNull(handle, "Handle element not found.")) return;
            if (!this.warnIfNull(target, "Target element not found.")) return;

            const bg = document.createElement('div');
            bg.classList.add('c-card__bg','js-resetOverlay');
            bg.addEventListener('touchstart', () => this.onHideEvent(target, bg, elem));
            elem.appendChild(bg);
            handle.addEventListener('touchstart', (e: TouchEvent) => this.onTouchStart(e, bg));
            handle.addEventListener('touchmove', (e: TouchEvent) => this.onTouchMove(e, target));
            handle.addEventListener('touchend', (e: TouchEvent) => this.onTouchEnd(e, target, bg, elem));
        });
    }

    private showOverlay(overlay: HTMLElement): void {
        overlay.style.display = 'block'; // オーバーレイを表示
    }

    private hideOverlay(overlay: HTMLElement): void {
        overlay.style.display = 'none'; // オーバーレイを非表示
    }

    private resetTargetStyles(target: HTMLElement): void {
        target.style.left = "";
        target.style.boxShadow = "";
    }
    private resetTargetClass(target: HTMLElement, parent: HTMLElement): void {
        parent.classList.remove('is-show');
        target.classList.remove('is-show', 'is-delete');
    }

    private onHideEvent(target: HTMLElement, overlay: HTMLElement, parent: HTMLElement): void {
        this.resetTargetStyles(target);
        this.resetTargetClass(target, parent);
        this.hideOverlay(overlay);
    }

    private onTouchStart(e: TouchEvent, overlay:HTMLElement): void {
        e.stopPropagation();
        this.initX = e.touches[0].clientX;
        this.showOverlay(overlay);
    }

    private onTouchMove(e: TouchEvent, target: HTMLElement | null): void {
        e.stopPropagation();
        if (!this.warnIfNull(target, "Target element not found.")) return;
        const moveX = e.touches[0].clientX;
        if (this.initX - moveX > 0) {
            target.style.left = `calc(100% - ${this.initX - moveX}px)`;
            target.style.boxShadow = "0 -3px 13px rgba(0, 0, 0, 0.02), 0 -3px 25px rgba(0, 0, 0, 0.08)";
        }
    }

    private onTouchEnd(e: TouchEvent, target: HTMLElement, overlay: HTMLElement, parent :HTMLElement): void {
        e.stopPropagation();

        const endX = e.changedTouches[0].clientX;
        const diff = this.initX - endX;

        if (diff < 5 && diff !== 0) {
            parent.classList.remove('is-show');
            target.classList.remove('is-show', 'is-delete');
            this.resetTargetStyles(target);
            this.hideOverlay(overlay);
            this.current = null;
            return;
        }
        if (diff >= 5 && diff < 200) {
            parent.classList.add('is-show');
            target.classList.add('is-show');
            target.classList.remove('is-delete');
            this.resetTargetStyles(target);
            this.current = parent;
            return;
        }
        if (diff >= 200) {
            parent.classList.add('is-show');
            target.classList.remove('is-show');
            target.classList.add('is-delete');
            this.resetTargetStyles(target);
            this.current = parent;
            return;
        }
    }
    private warnIfNull<T>(element: T | null, msg: string): element is T {
        if (!element) {
            console.warn(msg);
            return false;
        }
        return true;
    }
}