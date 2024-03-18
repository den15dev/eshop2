import '../common/effects/slide.js';

const slideSpeed = 50;

export default function init() {
    // ----- Set event listeners for filter dropdowns -----
    document.querySelectorAll('.filters-dropdown').forEach(dd_block => {
        const filters_header = dd_block.querySelector('.filters-header');
        const filters_section = dd_block.querySelector('.filters-section, .filters-section-scroll');
        const chevron = dd_block.querySelector('.filters-chevron svg');
        let collapsed = dd_block.dataset.collapsed;

        filters_header.addEventListener('click', () => {
            collapsed = dd_block.dataset.collapsed;

            if (collapsed === 'on') {
                filters_section.slideDown(slideSpeed);
                dd_block.dataset.collapsed = 'off';
                chevron.classList.add('down');
            } else if (collapsed === 'off') {
                filters_section.slideUp(slideSpeed);
                dd_block.dataset.collapsed = 'on';
                chevron.classList.remove('down');
            }
        });
    });

    // ----- Duplicate input values in the other form (desktop or mobile) -----
    document.querySelectorAll('#filterFormDesktop input').forEach(input_elem => {
        input_elem.addEventListener('change', () => {
            setDuplicateInputValue(input_elem, '#filterFormMobile');
        });
    });

    document.querySelectorAll('#filterFormMobile input').forEach(input_elem => {
        input_elem.addEventListener('change', () => {
            setDuplicateInputValue(input_elem, '#filterFormDesktop');
        });
    });

    // ----- Remove empty inputs' values from formData (min and max prices) -----
    document.querySelectorAll('#filterFormDesktop, #filterFormMobile').forEach(form => {
        form.addEventListener('formdata', event => {
            let formData = event.formData;
            for (let [name, value] of Array.from(formData.entries())) {
                if (value === '') formData.delete(name);
            }
        });
    });
}

function setDuplicateInputValue(current_input, formId) {
    const target_input = document.querySelector(`${formId} input[name="${current_input.name}"]`);
    if (target_input.type === 'checkbox') {
        target_input.checked = current_input.checked;
    } else if (target_input.type === 'text') {
        target_input.value = current_input.value;
    }
}