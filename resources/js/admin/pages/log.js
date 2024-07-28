const logUpdateTime = document.querySelector('#logUpdateTime');

export default function init() {
    if (logUpdateTime) {
        setTimeout(() => {
            window.location.reload();
        }, 30000);
    }
}