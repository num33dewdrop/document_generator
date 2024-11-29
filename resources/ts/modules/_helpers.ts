export const fadeIn = (elem: HTMLElement, display: string = 'block', duration: number = 300, delay: number = 30): void => {
    if (elem.style.display === 'none' || elem.style.display === '') {
        const coefficient = 1 / (duration / delay);
        elem.style.display = display;
        elem.style.opacity = String(0);
        let opacity = Number(elem.style.opacity);
        const animation = setInterval(() => {
            opacity += coefficient;
            elem.style.opacity = String(opacity);
            if (opacity >= 1) {
                elem.style.opacity = String(1);
                clearInterval(animation);
            }
        }, delay);
    }
};

export const fadeOut = (elem: HTMLElement, duration: number = 300, delay: number = 40): void => {
    if (elem.style.display !== 'none') {
        const coefficient = 1 / (duration / delay);
        elem.style.opacity = String(1);
        let opacity = Number(elem.style.opacity);
        const animation = setInterval(() => {
            opacity -= coefficient;
            elem.style.opacity = String(opacity);
            if (opacity <= 0) {
                elem.style.display = 'none';
                elem.style.opacity = String(0);
                clearInterval(animation);
            }
        }, delay);
    }
};

export const slideIn = (elem: HTMLElement, display: string = 'block', duration: number = 300, delay: number = 30) => {
    if (elem.style.display === 'none' || elem.style.display === '') {
        const coefficient = 1 / (duration / delay);
        elem.style.display = display;
        const endHeight = Number(elem.clientHeight);
        elem.style.height = String(0);
        let height = 0;
        const animation = setInterval(() => {
            height += Math.round(endHeight * coefficient);
            elem.style.height = String(height)+'px';
            if (height >= endHeight) {
                elem.style.height = String(endHeight)+'px';
                clearInterval(animation);
            }
        }, delay);
    }
};

export const slideOut = (elem: HTMLElement, duration: number = 400, delay: number = 30) => {
    if (elem.style.display !== 'none') {
        const coefficient = 1 / (duration / delay);
        const endHeight = Number(elem.clientHeight);
        let height = endHeight;
        const animation = setInterval(() => {
            height -= Math.round(endHeight * coefficient);
            elem.style.height = String(height)+'px';
            if (height <= 0) {
                elem.style.height = '0px';
                clearInterval(animation);
            }
        }, delay);
    }
};