(function () {
    'use strict';

    function initVanta() {
        const target = document.getElementById('ekap-vanta');

        if (!target || typeof window.VANTA === 'undefined' || typeof window.THREE === 'undefined') {
            return;
        }

        window.VANTA.NET({
            el: target,
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200,
            minWidth: 200,
            scale: 1,
            scaleMobile: 1,
            color: 0x2dd4bf,
            backgroundColor: 0x063f35,
            points: 8,
            maxDistance: 19,
            spacing: 17,
            showDots: true
        });
    }

    function initDemoCredentials() {
        const buttons = document.querySelectorAll('[data-demo-email][data-demo-password]');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        if (!emailInput || !passwordInput) {
            return;
        }

        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                emailInput.value = button.dataset.demoEmail || '';
                passwordInput.value = button.dataset.demoPassword || '';
                emailInput.dispatchEvent(new Event('input', { bubbles: true }));
                passwordInput.dispatchEvent(new Event('input', { bubbles: true }));
                passwordInput.focus();
            });
        });
    }

    function initRoleFields() {
        const role = document.getElementById('role');
        const studentField = document.getElementById('student-id-field');
        const staffField = document.getElementById('staff-id-field');
        const studentInput = document.getElementById('student-no');
        const staffInput = document.getElementById('staff-no');
        const adminNote = document.getElementById('admin-registration-note');

        if (!role || !studentField || !staffField || !studentInput || !staffInput) {
            return;
        }

        function updateRoleFields() {
            const isAdmin = role.value === 'admin';

            studentField.hidden = isAdmin;
            staffField.hidden = !isAdmin;
            studentInput.required = !isAdmin;
            studentInput.disabled = isAdmin;
            staffInput.required = isAdmin;
            staffInput.disabled = !isAdmin;

            if (adminNote) {
                adminNote.hidden = !isAdmin;
            }
        }

        role.addEventListener('change', updateRoleFields);
        updateRoleFields();
    }

    function initParticipantTotal() {
        const male = document.getElementById('male-participants');
        const female = document.getElementById('female-participants');
        const total = document.getElementById('total-participants');

        if (!male || !female || !total) {
            return;
        }

        function updateTotal() {
            const maleValue = Number.parseInt(male.value || '0', 10) || 0;
            const femaleValue = Number.parseInt(female.value || '0', 10) || 0;
            total.value = String(maleValue + femaleValue);
        }

        male.addEventListener('input', updateTotal);
        female.addEventListener('input', updateTotal);
        updateTotal();
    }

    function initMobileNavClose() {
        const nav = document.getElementById('ekapPrimaryNav');

        if (!nav || typeof window.bootstrap === 'undefined') {
            return;
        }

        nav.querySelectorAll('a.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth >= 992 || !nav.classList.contains('show')) {
                    return;
                }

                window.bootstrap.Collapse.getOrCreateInstance(nav).hide();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initVanta();
        initDemoCredentials();
        initRoleFields();
        initParticipantTotal();
        initMobileNavClose();
    });
})();
