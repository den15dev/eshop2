export function fadeIn(element, fadeSpeed, callback) {
    if (!isDisplayed(element)) {
        doFadeIn(element, fadeSpeed, callback);
    }
}

export function fadeOut(element, fadeSpeed, callback) {
    if (isDisplayed(element)) {
        doFadeOut(element, fadeSpeed, callback);
    }
}

export function fadeToggle(element, fadeSpeed, callback) {
    if (isDisplayed(element)) {
        doFadeOut(element, fadeSpeed, callback);
    } else {
        doFadeIn(element, fadeSpeed, callback);
    }
}


function setFadeSpeed(element, fadeSpeed) {
    fadeSpeed = `${fadeSpeed/1000}s`;
    element.style.setProperty('--fade-speed', fadeSpeed);
}

function setMaxOpacity(element) {
    const maxOpacity = getComputedStyle(element).getPropertyValue('opacity');
    element.style.setProperty('--max-opacity', maxOpacity);
}

function isDisplayed(element) {
    return getComputedStyle(element).getPropertyValue('display') !== 'none';
}

function doFadeIn(element, fadeSpeed, callback) {
    element.addEventListener('animationend', removeFadeInAnimation, false);
    setFadeSpeed(element, fadeSpeed);
    setMaxOpacity(element);
    element.style.display = 'block';
    element.classList.add('fade-in');
    if (typeof callback === 'function') {
        setTimeout(() => callback(), fadeSpeed + 50);
    }
}

function doFadeOut(element, fadeSpeed, callback) {
    element.addEventListener('animationend', removeFadeOutAnimation, false);
    setFadeSpeed(element, fadeSpeed);
    setMaxOpacity(element);
    element.classList.add('fade-out');
    if (typeof callback === 'function') {
        setTimeout(() => callback(), fadeSpeed + 50);
    }
}

function removeFadeInAnimation(event) {
    event.target.classList.remove('fade-in');
    event.target.removeEventListener('animationend', removeFadeInAnimation, false);
}

function removeFadeOutAnimation(event) {
    event.target.classList.remove('fade-out');
    event.target.style.display = 'none';
    event.target.removeEventListener('animationend', removeFadeOutAnimation, false);
}