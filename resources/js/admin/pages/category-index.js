import '../../common/effects/slide.js';

const categoryTree = document.querySelector('.category-tree');

export default function init() {
    if (categoryTree) {
        const itemBtns = document.querySelectorAll('.category-tree_item-text');

        itemBtns.forEach(itemBtn => {
            itemBtn.addEventListener('click', () => {
                const sublist = itemBtn.closest('li').querySelector('ul');

                if (sublist) {
                    sublist.slideToggle(100, () => {
                        collapseChildren(sublist);
                    });

                    const chevron = itemBtn.parentNode.querySelector('.category-tree_chevron-icon');
                    chevron?.classList.toggle('down');
                }
            });
        });
    }
}


function collapseChildren(list) {
    if (list.style.display === 'none') {
        const sublists = list.querySelectorAll('ul');

        sublists.forEach(sublist => {
            sublist.style.display = 'none';
            sublist.parentNode.querySelector('.category-tree_chevron-icon')?.classList.remove('down');
        });
    }
}