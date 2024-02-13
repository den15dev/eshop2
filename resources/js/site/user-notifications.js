import '../common/effects/slide.js';

const notifications = document.querySelectorAll('.user-notification');

const slideSpeed = 50;

export default function init() {
    if (notifications) {
        notifications.forEach(notification => {
            const id = notification.dataset.id;
            const notifHeadBtn = notification.querySelector('.user-notification_head');
            const notifBody = notification.querySelector('.user-notification_message');

            notifHeadBtn.addEventListener('click', () => {
                if (notification.dataset.collapsed === 'on') {
                    notifBody.slideDown(slideSpeed);

                    if (notification.dataset.unread === 'yes') {
                        console.log('Go to server and mark as read');

                        notification.dataset.unread = 'no';
                        notifHeadBtn.classList.remove('unread');
                    }

                    notifHeadBtn.classList.add('active');
                    notification.dataset.collapsed = 'off';
                } else {
                    notifBody.slideUp(slideSpeed);
                    notifHeadBtn.classList.remove('active');
                    notification.dataset.collapsed = 'on';
                }
            });
        });
    }
}