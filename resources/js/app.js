import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const content = document.getElementById("page-content");
    content.classList.add("fade-in");

    document.querySelectorAll("a[href]").forEach(link => {
        link.addEventListener("click", e => {
            const href = link.getAttribute("href");
            if (!href.startsWith("#") && !link.target && !href.startsWith("mailto:")) {
                e.preventDefault();
                content.classList.remove("fade-in");
                content.style.opacity = 0;
                setTimeout(() => window.location.href = href, 400); // durée du fade
            }
        });
    });
});
