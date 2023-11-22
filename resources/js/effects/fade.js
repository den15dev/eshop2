export function fadeIn(element, fadeSpeed) {
    if (!isDisplayed(element)) {
        doFadeIn(element, fadeSpeed);
    }
}

export function fadeOut(element, fadeSpeed) {
    if (isDisplayed(element)) {
        doFadeOut(element, fadeSpeed);
    }
}

export function fadeToggle(element, fadeSpeed) {
    if (isDisplayed(element)) {
        doFadeOut(element, fadeSpeed);
    } else {
        doFadeIn(element, fadeSpeed);
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

function doFadeIn(element, fadeSpeed) {
    element.addEventListener('animationend', removeFadeInAnimation, false);
    setFadeSpeed(element, fadeSpeed);
    setMaxOpacity(element);
    element.style.display = 'block';
    element.classList.add('fade-in');
}

function doFadeOut(element, fadeSpeed) {
    element.addEventListener('animationend', removeFadeOutAnimation, false);
    setFadeSpeed(element, fadeSpeed);
    setMaxOpacity(element);
    element.classList.add('fade-out');
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