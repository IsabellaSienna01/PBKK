document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('#mobile-menu-button');
    const mobileMenu = document.querySelector('#mobile-menu');
    const openIcon = document.querySelector('[data-menu-icon="open"]');
    const closeIcon = document.querySelector('[data-menu-icon="close"]');

    if (menuButton && mobileMenu && openIcon && closeIcon) {
        const setMenuState = (isOpen) => {
            mobileMenu.classList.toggle('hidden', !isOpen);
            openIcon.classList.toggle('hidden', isOpen);
            closeIcon.classList.toggle('hidden', !isOpen);
            menuButton.setAttribute('aria-expanded', String(isOpen));
        };

        menuButton.addEventListener('click', () => {
            const isOpen = menuButton.getAttribute('aria-expanded') === 'true';

            setMenuState(!isOpen);
        });

        mobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenuState(false));
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                setMenuState(false);
            }
        });
    }

    const calculatorForm = document.querySelector('#gpa-calculator-form');

    if (!calculatorForm) {
        return;
    }

    const semesterOneInput = document.querySelector('#gpa-ip1');
    const semesterTwoInput = document.querySelector('#gpa-ip2');
    const semesterOneBar = document.querySelector('[data-gpa-bar="ip1"]');
    const semesterTwoBar = document.querySelector('[data-gpa-bar="ip2"]');
    const totalOutput = document.querySelector('[data-gpa-total]');
    const averageOutput = document.querySelector('[data-gpa-average]');
    const formError = document.querySelector('#gpa-form-error');

    if (!semesterOneInput || !semesterTwoInput || !semesterOneBar || !semesterTwoBar || !totalOutput || !averageOutput || !formError) {
        return;
    }

    const getGpaValue = (input) => Number.parseFloat(input.value);
    const isValidGpa = (value) => Number.isFinite(value) && value >= 0 && value <= 4;
    const getBarWidth = (value) => (isValidGpa(value) ? (value / 4) * 100 : 0);

    const updatePreview = () => {
        const semesterOneGpa = getGpaValue(semesterOneInput);
        const semesterTwoGpa = getGpaValue(semesterTwoInput);

        semesterOneBar.style.width = `${getBarWidth(semesterOneGpa)}%`;
        semesterTwoBar.style.width = `${getBarWidth(semesterTwoGpa)}%`;

        if (isValidGpa(semesterOneGpa) && isValidGpa(semesterTwoGpa)) {
            const totalGpa = semesterOneGpa + semesterTwoGpa;
            const averageGpa = totalGpa / 2;

            totalOutput.textContent = totalGpa.toFixed(2);
            averageOutput.textContent = averageGpa.toFixed(2);
        }
    };

    const showFormError = (message) => {
        formError.textContent = message;
        formError.classList.remove('hidden');
    };

    semesterOneInput.addEventListener('input', updatePreview);
    semesterTwoInput.addEventListener('input', updatePreview);

    calculatorForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const semesterOneGpa = getGpaValue(semesterOneInput);
        const semesterTwoGpa = getGpaValue(semesterTwoInput);

        if (!isValidGpa(semesterOneGpa) || !isValidGpa(semesterTwoGpa)) {
            showFormError('Masukkan dua nilai GPA berupa angka dari 0.00 sampai 4.00.');

            return;
        }

        formError.classList.add('hidden');

        const calculatorUrl = calculatorForm.dataset.calculatorUrl
            .replace('__IP1__', encodeURIComponent(semesterOneGpa.toFixed(2)))
            .replace('__IP2__', encodeURIComponent(semesterTwoGpa.toFixed(2)));

        window.location.assign(calculatorUrl);
    });

    updatePreview();
});
