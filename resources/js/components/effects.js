export function fadeToggle2(element, fadeSpeed) {
    fadeSpeed = `${fadeSpeed/1000}s`;
    element.style.setProperty('--fade-speed', fadeSpeed);

    if (element.classList.contains('fade0')) {
        element.classList.add('fade-trans');
        element.clientWidth;
        element.classList.remove('fade0');
    } else {
        element.classList.add('fade-trans');
        element.classList.add('fade0');
    }
}

export function fadeInit() {
    let fadeElements = document.querySelectorAll('.fade0, .fade1');

    fadeElements.forEach((fadeElem) => {
        fadeElem.addEventListener('transitionend', function() {
            fadeElem.classList.remove('fade-trans');
        }, false);
    });
}