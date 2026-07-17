# e-KAP Final Interface Upgrade

This upgrade adds:

- A consistent e-KAP header, responsive navigation bar and footer on every standard page.
- The e-KAP logo as a home button linking to the dashboard for both students and administrators.
- Bootstrap 5, Bootstrap Icons, Google Font (Inter), and Vanta.js on authentication pages.
- A Joomla-inspired administration shell: compact top navigation, card-based content, role-aware actions, and responsive tables.
- Responsive mobile layouts for forms, tables, navigation, dashboards, login and registration.
- Demo login credentials for the administrator and student accounts.
- Professional club registration and editing pages for administrators.
- Automatic inclusion of all active registered clubs in student application forms.
- A database-backed **Others** club option that remains compatible with the `club_id` foreign key.
- Clean, section-based application add/edit forms.
- Removal of CakePHP branding and CakePHP logo assets from the public interface.

## External UI dependencies

The browser loads the following through CDNs:

- Bootstrap 5.3.3
- Bootstrap Icons 1.11.3
- Google Font: Inter
- Three.js r134
- Vanta.js NET

The application remains usable with its local CSS if the CDN visual effects are unavailable, although Bootstrap icons and the animated Vanta background require internet access.

## Demo accounts

- Admin: `admin@ekap.test` / `Password123!`
- Student: `student@ekap.test` / `Password123!`

## Club dropdown behavior

Only clubs with `status = active` appear in the application form. The system creates a protected active club record named **Others** the first time the application form loads. Administrators cannot delete this protected option.
