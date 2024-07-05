export default class Dashboard {
    static getAdminBaseUri() {
        const meta = document.head.querySelector('meta[name="admin-base-uri"]');
        if (!meta) {
            return '/';
        }

        if (!meta.content) {
            return '/';
        }

        return meta.content;
    }

    static initialize() {
        const adminBaseUri = Dashboard.getAdminBaseUri();

        const btnToggleAppSidebarEl = document.querySelector(
            ".btn-toggle-app-sidebar",
        );
        if (btnToggleAppSidebarEl) {
            btnToggleAppSidebarEl.addEventListener("click", async () => {
                if (window.innerWidth >= 1200) {
                    document.body.classList.toggle("hide-app-sidebar");
                    if (document.body.classList.contains("hide-app-sidebar")) {
                        await window.axios.post(adminBaseUri + "/sidebar-toggle", {
                            app_sidebar_hide: true,
                        });
                    } else {
                        await window.axios.post(adminBaseUri + "/sidebar-toggle", {
                            app_sidebar_hide: false,
                        });
                    }
                } else {
                    document.body.classList.toggle("show-app-sidebar");
                }
            });
        }

        const appSidebarBackEl = document.querySelector(".app-sidebar-back");
        if (appSidebarBackEl) {
            appSidebarBackEl.addEventListener("click", function () {
                document.body.classList.remove("show-app-sidebar");
            });
        }

        const submenuItems = document.querySelectorAll(
            ".app-sidebar-menu li:has(ul)",
        );

        Array.from(submenuItems).forEach((submenuItem) => {
            const anchor = submenuItem.querySelector("a");
            anchor.addEventListener("click", (e) => {
                e.preventDefault();
                submenuItem.classList.toggle("active");
            });
        });
    }
}