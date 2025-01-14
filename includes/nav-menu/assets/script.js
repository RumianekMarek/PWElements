document.addEventListener("DOMContentLoaded", function () {
    const pweNavMenu = document.querySelector('.pwe-menu');
    const pweNavMenuHome = document.querySelector("body.home .pwe-menu");
    const burgerCheckbox = document.querySelector('.pwe-menu__burger-checkbox');
    const menuContainer = document.querySelector('.pwe-menu__container');

    // Background color for nav menu
    if (pweNavMenuHome && window.innerWidth >= 960) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > 70) {
                pweNavMenuHome.style.background = accent_color;
            } else {
                pweNavMenuHome.style.background = "transparent";
            }
        });
    }

    // Click outside the menu container
    if (burgerCheckbox && menuContainer) {
        document.addEventListener("click", function (e) {
            if (burgerCheckbox.checked && !menuContainer.contains(e.target) && e.target !== burgerCheckbox) {
                burgerCheckbox.checked = false;
                pweNavMenu.classList.remove("burger-menu");

                // Close all open submenus
                const openSubmenus = document.querySelectorAll('.pwe-menu__submenu.visible');
                openSubmenus.forEach(submenu => {
                    closeSubmenu(submenu);
                });
            }
        });
    }

    // Overlay menu (active-unactive)
    if (burgerCheckbox && pweNavMenu) {
        burgerCheckbox.addEventListener("change", function () {
            if (this.checked) {
                pweNavMenu.classList.add("burger-menu");
            } else {
                pweNavMenu.classList.remove("burger-menu");

                // Close all open submenus
                const openSubmenus = document.querySelectorAll('.pwe-menu__submenu.visible');
                openSubmenus.forEach(submenu => {
                    closeSubmenu(submenu);
                });
            }
        });
    }

    // Function to close submenu
    const closeSubmenu = (submenu) => {
        if (submenu) {
            submenu.style.height = `${submenu.scrollHeight}px`;
            requestAnimationFrame(() => {
                submenu.style.height = "0";
            });
            submenu.classList.remove("visible");
        }
    };

    // Function to open submenu
    const openSubmenu = (submenu) => {
        if (submenu) {
            submenu.style.height = "0";
            submenu.classList.add("visible");
            requestAnimationFrame(() => {
                submenu.style.height = `${submenu.scrollHeight}px`;
            });
        }
    };

    // Function to switch submenus
    const toggleSubmenu = (link) => {
        const submenu = link.parentElement.querySelector(".pwe-menu__submenu");

        if (submenu) {
            const isVisible = submenu.classList.contains("visible");

            // Close all other submenus on the same level
            const siblings = Array.from(link.parentElement.parentElement.children)
                .filter(item => item !== link.parentElement);

            siblings.forEach(sibling => {
                const siblingSubmenu = sibling.querySelector(".pwe-menu__submenu");
                if (siblingSubmenu && siblingSubmenu.classList.contains("visible")) {
                    closeSubmenu(siblingSubmenu);
                }
            });

            // Open or close the current submenu
            if (isVisible) {
                closeSubmenu(submenu);
            } else {
                openSubmenu(submenu);
            }

            // Remove height after animation is finished
            submenu.addEventListener(
                "transitionend",
                function () {
                    if (submenu.classList.contains("visible")) {
                        submenu.style.height = "auto";
                    }
                },
                { once: true }
            );
        }
    };

    // Handling clicks on submenu links
    const menuLinks = document.querySelectorAll(".pwe-menu__item.has-children > a, .pwe-menu__submenu-item.has-children > a");
    if (menuLinks.length && window.innerWidth < 960) {
        menuLinks.forEach(link => {
            let clickedOnce = false;

            link.addEventListener("click", function (e) {
                const href = this.getAttribute("href");

                // Links without `href` or with `#` always open/close submenu
                if (!href || href === "#") {
                    e.preventDefault();
                    toggleSubmenu(this);
                    return;
                }

                const submenu = this.parentElement.querySelector(".pwe-menu__submenu");
                if (submenu && !submenu.classList.contains("visible")) {
                    // Block link
                    e.preventDefault();
                    // Open submenu
                    toggleSubmenu(this); 
                    clickedOnce = true;
                } else if (clickedOnce) {
                    // Second click: allow the transition if the link is valid
                    clickedOnce = false;
                } else {
                    // Block link
                    e.preventDefault();
                    // Close submenu if open
                    toggleSubmenu(this); 
                }
            });
        });
    }
});
