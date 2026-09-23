import { createIcons, Moon, Sun } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons: { Moon, Sun } });

    const themeToggle = document.querySelector('#theme-toggle');

    if (themeToggle) {
        const updateThemeButton = () => {
            const isDark = document.documentElement.classList.contains('dark');

            themeToggle.setAttribute('aria-checked', String(isDark));
        };

        updateThemeButton();

        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');

            try {
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            } catch (_) {
                // The selected theme remains active until the page changes.
            }

            updateThemeButton();
        });
    }

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
});
