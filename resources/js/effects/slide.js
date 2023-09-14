/* plain JS slideToggle https://github.com/ericbutler555/plain-js-slidetoggle */

HTMLElement.prototype.slideToggle = function(duration, callback) {
    if (this.clientHeight === 0) {
        _s(this, duration, callback, true);
    } else {
        _s(this, duration, callback);
    }
};

HTMLElement.prototype.slideUp = function(duration, callback) {
    _s(this, duration, callback);
};

HTMLElement.prototype.slideDown = function (duration, callback) {
    _s(this, duration, callback, true);
};

function _s(el, duration, callback, isDown) {

    if (typeof duration === 'undefined') duration = 400;
    if (typeof isDown === 'undefined') isDown = false;

    el.style.overflow = "hidden";
    if (isDown) el.style.display = "block";

    let elStyles        = window.getComputedStyle(el);

    let elHeight        = parseFloat(elStyles.getPropertyValue('height'));
    let elPaddingTop    = parseFloat(elStyles.getPropertyValue('padding-top'));
    let elPaddingBottom = parseFloat(elStyles.getPropertyValue('padding-bottom'));
    let elMarginTop     = parseFloat(elStyles.getPropertyValue('margin-top'));
    let elMarginBottom  = parseFloat(elStyles.getPropertyValue('margin-bottom'));

    let stepHeight        = elHeight        / duration;
    let stepPaddingTop    = elPaddingTop    / duration;
    let stepPaddingBottom = elPaddingBottom / duration;
    let stepMarginTop     = elMarginTop     / duration;
    let stepMarginBottom  = elMarginBottom  / duration;

    let start;

    function step(timestamp) {

        if (start === undefined) start = timestamp;

        let elapsed = timestamp - start;

        if (isDown) {
            el.style.height        = (stepHeight        * elapsed) + "px";
            el.style.paddingTop    = (stepPaddingTop    * elapsed) + "px";
            el.style.paddingBottom = (stepPaddingBottom * elapsed) + "px";
            el.style.marginTop     = (stepMarginTop     * elapsed) + "px";
            el.style.marginBottom  = (stepMarginBottom  * elapsed) + "px";
        } else {
            el.style.height        = elHeight        - (stepHeight        * elapsed) + "px";
            el.style.paddingTop    = elPaddingTop    - (stepPaddingTop    * elapsed) + "px";
            el.style.paddingBottom = elPaddingBottom - (stepPaddingBottom * elapsed) + "px";
            el.style.marginTop     = elMarginTop     - (stepMarginTop     * elapsed) + "px";
            el.style.marginBottom  = elMarginBottom  - (stepMarginBottom  * elapsed) + "px";
        }

        if (elapsed >= duration) {
            el.style.height        = "";
            el.style.paddingTop    = "";
            el.style.paddingBottom = "";
            el.style.marginTop     = "";
            el.style.marginBottom  = "";
            el.style.overflow      = "";
            if (!isDown) el.style.display = "none";
            if (typeof callback === 'function') callback();
        } else {
            window.requestAnimationFrame(step);
        }
    }

    window.requestAnimationFrame(step);
}