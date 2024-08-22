/*
-----------------------------------------------------------------------------
* Template Name    : DashHub - PHP Tailwind CSS Admin & Dashboard Template  * 
* Author           : Parv Infotech                                          *
* Version          : 1.0.0                                                  *
* Created          : May 2024                                               *
* File Description : Main Js file of the template                           *
*----------------------------------------------------------------------------
*/

document.addEventListener("alpine:init", () => {
    Alpine.data("collapse", () => ({
        collapse: false,

        collapseSidebar() {
            this.collapse = !this.collapse;
        },
    }));
    Alpine.data("dropdown", (initialOpenState = false) => ({
        open: initialOpenState,

        toggle() {
            this.open = !this.open;
        },
    }));
    Alpine.data("modals", (initialOpenState = false) => ({
        open: initialOpenState,

        toggle() {
            this.open = !this.open;
        },
    }));

    // main - custom functions
    Alpine.data("main", (value) => ({}));

    Alpine.store("app", {
        // sidebar
        sidebar: false,
        toggleSidebar() {
            this.sidebar = !this.sidebar;
        },

        // Light and dark Mode
        mode: Alpine.$persist("light"),
        toggleMode(val) {
            if (!val) {
                val = this.mode || "light"; // light And Dark
            }

            this.mode = val;
        },

        toggleFullScreen() {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                document.documentElement.requestFullscreen();
            }
        },
    });
});


function togglePasswordVisibilityForLogin() {
    var passwordInput = document.getElementById('inputpassword');
    var eyeIcon = document.getElementById('eyeIcon');
    var eyeSlashIcon = document.getElementById('eyeSlashIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.style.display = 'none';
        eyeSlashIcon.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        eyeIcon.style.display = 'block';
        eyeSlashIcon.style.display = 'none';
    }
}

function togglePasswordVisibility(inputId) {
    var passwordInput = document.getElementsByName(inputId)[0];
    var eyeIcon = document.getElementById('eyeIcon' + inputId);
    var eyeSlashIcon = document.getElementById('eyeSlashIcon' + inputId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.style.display = 'none';
        eyeSlashIcon.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        eyeIcon.style.display = 'block';
        eyeSlashIcon.style.display = 'none';
    }
}