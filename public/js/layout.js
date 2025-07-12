document.addEventListener("DOMContentLoaded", () => {
    // Sidebar Navbar Toggles
    const menuToggle = document.getElementById("menuToggle");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const overlay = document.getElementById("overlay");
    const profileBtn = document.getElementById("profileBtn");
    const profileDropdown = document.getElementById("profileDropdown");
    const menuItems = document.querySelectorAll(".menu-item");

    menuToggle?.addEventListener("click", () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle("open");
            overlay.classList.toggle("active");
        } else {
            sidebar.classList.toggle("collapsed");
            mainContent.classList.toggle("expanded");
        }
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.remove("open");
        overlay.classList.remove("active");
    });

    profileBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
        if (
            !profileDropdown.contains(e.target) &&
            !profileBtn.contains(e.target)
        ) {
            profileDropdown.classList.remove("active");
        }
    });

    menuItems.forEach((item) => {
        item.addEventListener("click", (e) => {
            // e.preventDefault();
            menuItems.forEach((mi) => mi.classList.remove("active"));
            item.classList.add("active");

            if (window.innerWidth <= 768) {
                sidebar.classList.remove("open");
                overlay.classList.remove("active");
            }
        });
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove("open");
            overlay.classList.remove("active");
            mainContent.classList.toggle(
                "expanded",
                sidebar.classList.contains("collapsed")
            );
        } else {
            sidebar.classList.remove("collapsed");
            mainContent.classList.remove("expanded");
        }
    });

    // Clickable Row
    const handleClickable = () => {
        document
            .querySelectorAll(".clickable-row, .clickable-card")
            .forEach((el) => {
                el.addEventListener("click", () => {
                    window.location.href = el.dataset.href;
                });
            });
    };

    handleClickable();
});
