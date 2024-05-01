import handleOpeners from '../../common/openers.js';

const openers = [
    {
        button: '#headerMobileLeftBtn',
        container: '#headerLeftMenuCont',
        openActions() {
            document.querySelector(this.button).classList.add('opened');
        },
        closeActions() {
            document.querySelector(this.button).classList.remove('opened');
        }
    },

    {
        button: '#headerMobileRightBtn',
        container: '#headerRightMenuCont',
        openActions() {
            document.querySelector(this.button).classList.add('opened');
        },
        closeActions() {
            document.querySelector(this.button).classList.remove('opened');
        }
    },
];


export default function init() {
    handleOpeners(openers);
}