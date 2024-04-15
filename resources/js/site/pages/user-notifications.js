import '../../common/effects/slide.js';
import {csrf, lang} from "../../common/global.js";
import {showErrorMessage} from "../../common/modals.js";

const notifications = document.querySelectorAll('.user-notification');

const slideSpeed = 50;

export default function init() {
    if (notifications) {
        const markAllAsReadBtn = document.querySelector('#markAllAsReadBtn');

        notifications.forEach(notification => {
            const id = notification.dataset.id;
            const notifHeadBtn = notification.querySelector('.user-notification_head');
            const notifBody = notification.querySelector('.user-notification_message');

            notifHeadBtn.addEventListener('click', () => {
                if (notification.dataset.collapsed === 'on') {
                    notifBody.slideDown(slideSpeed);

                    if (notification.dataset.unread === 'yes') {
                        markAsRead(id, (result) => {
                            const unreadCont = document.querySelector('.user-notifications_count');
                            unreadCont.innerText = result.unread_report;

                            if (!result.unread_count) {
                                markAllAsReadBtn.remove();
                            }

                            notification.dataset.unread = 'no';
                            notifHeadBtn.classList.remove('unread');
                            updateBadges(result.unread_count);
                        });
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

        if (markAllAsReadBtn) {
            markAllAsReadBtn.addEventListener('click', () => {
                markAsRead(null, (result) => {
                    if (result.all_read) {
                        window.location.reload();
                    }
                });
            });
        }
    }
}


function markAsRead(id, updateDOM) {
    fetch(`/${lang}/user/notification/read`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            id: id,
        }),
    })
    .then(response => {
        if (!response.ok) throw new Error(`${response.status} (${response.statusText})`);
        return response.json();
    })
    .then(result => {
        updateDOM(result);
    })
    .catch(err => showErrorMessage(err.message));
}


function updateBadges(unread_count) {
    const desktopBadge = document.querySelector('#unreadNotificationsBadgeDesktop');
    const mobileBadge = document.querySelector('#unreadNotificationsBadgeMobile');
    const desktopDot = document.querySelector('#desktopProfileBtn .badge-dot-red');
    const mobileDot = document.querySelector('#bottomNavProfileBtn .badge-dot-red');

    desktopBadge.innerText = unread_count;
    mobileBadge.innerText = unread_count;

    if (!unread_count) {
        desktopDot.classList.remove('active');
        mobileDot.classList.remove('active');
        desktopBadge.classList.remove('active');
        mobileBadge.classList.remove('active');
    }
}