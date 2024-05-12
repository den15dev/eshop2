import { csrf, lang } from "../../common/global.js";
import { showErrorMessage } from "../../common/modals.js";

const reactionConts = document.querySelectorAll('.review-reactions');

export default function init() {
    reactionConts.forEach(reactCont => {
        const review_id = reactCont.dataset.id;
        const likeBtn = reactCont.querySelector('.review-reactions_up');
        const dislikeBtn = reactCont.querySelector('.review-reactions_down');

        if (!likeBtn.classList.contains('disabled')) {
            likeBtn.addEventListener('click', () => {
                updateReaction(reactCont, review_id, true);
            });
        }

        if (!dislikeBtn.classList.contains('disabled')) {
            dislikeBtn.addEventListener('click', () => {
                updateReaction(reactCont, review_id, false);
            });
        }
    });
}


function updateReaction(reactCont, review_id, up_down) {
    fetch(`/${lang}/reaction/store`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            review_id: review_id,
            up_down: up_down,
        }),
    })
    .then(response => {
        if (!response.ok) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return response.json();
    })
    .then(result => {
        updateDOM(reactCont, result);
    })
    .catch(err => showErrorMessage(err));
}


function updateDOM(reactCont, data) {
    const likeBtn = reactCont.querySelector('.review-reactions_up');
    const likesNumCont = likeBtn.querySelector('.review-reactions_number');
    const dislikeBtn = reactCont.querySelector('.review-reactions_down');
    const dislikesNumCont = dislikeBtn.querySelector('.review-reactions_number');

    likesNumCont.innerText = data.likes;
    dislikesNumCont.innerText = data.dislikes;

    if (data.active === null) {
        likeBtn.classList.remove('active');
        dislikeBtn.classList.remove('active');
    } else if (data.active) {
        likeBtn.classList.add('active');
        dislikeBtn.classList.remove('active');
    } else {
        likeBtn.classList.remove('active');
        dislikeBtn.classList.add('active');
    }
}