# e-KAP Final Upgrade Notes

Implemented upgrades:

1. Public user registration
   - Login page now includes **Register New User**.
   - Public route: `/register`.
   - Registration supports Student and Admin roles.
   - Student registrations are active immediately.
   - Public Admin registrations are inactive until an existing admin activates them.

2. Role-specific user IDs
   - Student role displays and requires **Student ID**.
   - Admin role displays and requires **Staff ID**.
   - The unused ID field is cleared before saving.

3. Faculty dropdown
   - Faculty of Information Science
   - Faculty of Film, Theater & Animation

4. Application form cleanup
   - Department Head removed.
   - Attendance Type removed.
   - Location Type removed.
   - Legacy database columns are retained for compatibility and populated internally.

5. Organiser Type dropdown
   - Club/Society
   - Faculty/Department
   - MPP/Student Council
   - Joint Organization
   - External Organization

6. Programme Level dropdown
   - International
   - National
   - State
   - District
   - University
   - Faculty
   - Club/Student Society
   - College

7. Programme Category dropdown
   - Academic
   - Cultural/Heritage
   - Religious Affairs
   - Volunteering
   - Business/Entrepreneurship
   - Public Speaking
   - Science & Innovation
   - Intellectual Forum

## Main files changed

- `config/routes.php`
- `src/Controller/AppController.php`
- `src/Controller/UsersController.php`
- `src/Controller/ApplicationsController.php`
- `src/Model/Table/UsersTable.php`
- `src/Model/Table/ApplicationsTable.php`
- `templates/Users/login.php`
- `templates/Users/register.php`
- `templates/Users/add.php`
- `templates/Users/edit.php`
- `templates/Users/view.php`
- `templates/Applications/add.php`
- `templates/Applications/edit.php`
- `templates/Applications/view.php`
- `templates/Applications/pdf/approval_letter.php`

## Test URLs

- Login: `http://localhost:8765/login`
- Register: `http://localhost:8765/register`
- New application: `http://localhost:8765/applications/add`

## Important admin-registration behavior

A user may select Admin during public registration, but the new Admin account is created with `account_status = inactive`. An existing admin must open **Manage Users → Edit** and change the account status to **Active** before that user can log in.
