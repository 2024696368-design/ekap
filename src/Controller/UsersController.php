<?php

declare(strict_types=1);

namespace App\Controller;

use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Login method.
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $session = $this->request->getSession();

        if ($session->check('Auth')) {
            return $this->redirect('/dashboard');
        }

        if ($this->request->is('post')) {
            $email = trim((string)$this->request->getData('email'));
            $password = (string)$this->request->getData('password');

            $user = $this->Users
                ->find()
                ->where([
                    'Users.email' => $email,
                    'Users.account_status' => 'active',
                ])
                ->first();

            $hasher = new DefaultPasswordHasher();

            if (
                $user !== null &&
                $hasher->check($password, $user->password)
            ) {
                $session->renew();

                $session->write('Auth', [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]);

                $this->Flash->success(
                    'Welcome, ' . $user->full_name . '.'
                );

                return $this->redirect('/dashboard');
            }

            $this->Flash->error(
                'Invalid email or password. Inactive administrator accounts must be activated by an existing administrator.'
            );
        }
    }

    /**
     * Public registration method.
     *
     * Student accounts are activated immediately. Public administrator
     * registrations are created as inactive and require an existing
     * administrator to activate them.
     */
    public function register()
    {
        $this->request->allowMethod(['get', 'post']);
        $session = $this->request->getSession();

        if ($session->check('Auth')) {
            return $this->redirect('/dashboard');
        }

        $user = $this->Users->newEmptyEntity();
        $roleOptions = $this->roleOptions();
        $facultyOptions = $this->facultyOptions();

        if ($this->request->is('post')) {
            $data = $this->normaliseUserData(
                $this->request->getData(),
                true
            );

            $user = $this->Users->patchEntity($user, $data);
            $hasRequiredIdentifier = $this->validateRoleIdentifier($user);

            if ($hasRequiredIdentifier && $this->Users->save($user)) {
                if ($user->role === 'admin') {
                    $this->Flash->success(
                        'Administrator registration submitted. An existing administrator must activate the account before login.'
                    );
                } else {
                    $this->Flash->success(
                        'Registration successful. You may now log in to e-KAP.'
                    );
                }

                return $this->redirect('/login');
            }

            $this->Flash->error(
                'Registration could not be completed. Please correct the highlighted fields.'
            );
        }

        $this->set(compact(
            'user',
            'roleOptions',
            'facultyOptions'
        ));
    }

    /**
     * Index method.
     */
    public function index()
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(
                'Only administrators can manage user accounts.'
            );

            return $this->redirect('/dashboard');
        }

        $query = $this->Users->find()
            ->orderBy([
                'Users.created' => 'DESC',
            ]);

        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method.
     *
     * @param string|null $id User id.
     */
    public function view($id = null)
    {
        $auth = $this->getAuthUser();
        $user = $this->Users->get($id);

        $isOwnProfile =
            (int)$user->id === (int)($auth['id'] ?? 0);

        if (!$this->isAdmin() && !$isOwnProfile) {
            $this->Flash->error(
                'You are not allowed to view this user profile.'
            );

            return $this->redirect('/dashboard');
        }

        $this->set(compact('user', 'auth'));
    }

    /**
     * Add method for administrators.
     */
    public function add()
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(
                'Only administrators can create user accounts.'
            );

            return $this->redirect('/dashboard');
        }

        $user = $this->Users->newEmptyEntity();
        $roleOptions = $this->roleOptions();
        $facultyOptions = $this->facultyOptions();

        if ($this->request->is('post')) {
            $data = $this->normaliseUserData(
                $this->request->getData(),
                false
            );

            $user = $this->Users->patchEntity($user, $data);
            $hasRequiredIdentifier = $this->validateRoleIdentifier($user);

            if ($hasRequiredIdentifier && $this->Users->save($user)) {
                $this->Flash->success(
                    'The user account was created successfully.'
                );

                return $this->redirect([
                    'action' => 'index',
                ]);
            }

            $this->Flash->error(
                'The user account could not be created. Please correct the highlighted fields.'
            );
        }

        $this->set(compact(
            'user',
            'roleOptions',
            'facultyOptions'
        ));
    }

    /**
     * Edit method.
     *
     * @param string|null $id User id.
     */
    public function edit($id = null)
    {
        $auth = $this->getAuthUser();
        $user = $this->Users->get($id);

        $isOwnProfile =
            (int)$user->id === (int)($auth['id'] ?? 0);

        if (!$this->isAdmin() && !$isOwnProfile) {
            $this->Flash->error(
                'You are not allowed to edit this user profile.'
            );

            return $this->redirect('/dashboard');
        }

        $roleOptions = $this->roleOptions();
        $facultyOptions = $this->facultyOptions();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!$this->isAdmin()) {
                unset(
                    $data['role'],
                    $data['account_status'],
                    $data['staff_no']
                );
            } else {
                $data = $this->normaliseUserData($data, false);
            }

            if (
                !isset($data['password']) ||
                trim((string)$data['password']) === ''
            ) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);
            $hasRequiredIdentifier = $this->validateRoleIdentifier($user);

            if ($hasRequiredIdentifier && $this->Users->save($user)) {
                if ($isOwnProfile) {
                    $session = $this->request->getSession();

                    $session->write(
                        'Auth.full_name',
                        $user->full_name
                    );

                    $session->write(
                        'Auth.email',
                        $user->email
                    );

                    $session->write(
                        'Auth.role',
                        $user->role
                    );
                }

                $this->Flash->success(
                    'The profile was updated successfully.'
                );

                return $this->redirect([
                    'action' => 'view',
                    $user->id,
                ]);
            }

            $this->Flash->error(
                'The profile could not be updated. Please correct the highlighted fields.'
            );
        }

        $this->set(compact(
            'user',
            'auth',
            'roleOptions',
            'facultyOptions'
        ));
    }

    /**
     * Delete method.
     *
     * @param string|null $id User id.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        if (!$this->isAdmin()) {
            $this->Flash->error(
                'Only administrators can delete user accounts.'
            );

            return $this->redirect('/dashboard');
        }

        $auth = $this->getAuthUser();
        $user = $this->Users->get($id);

        if ((int)$user->id === (int)($auth['id'] ?? 0)) {
            $this->Flash->error(
                'You cannot delete your own administrator account.'
            );

            return $this->redirect([
                'action' => 'index',
            ]);
        }

        if ($this->Users->delete($user)) {
            $this->Flash->success(
                'The user account was deleted successfully.'
            );
        } else {
            $this->Flash->error(
                'The user account could not be deleted.'
            );
        }

        return $this->redirect([
            'action' => 'index',
        ]);
    }

    /**
     * Logout method.
     */
    public function logout()
    {
        $this->request->allowMethod(['get', 'post']);

        $session = $this->request->getSession();
        $session->destroy();

        $this->Flash->success(
            'You have logged out successfully.'
        );

        return $this->redirect('/login');
    }

    /**
     * Role choices used by registration and user management forms.
     *
     * @return array<string, string>
     */
    private function roleOptions(): array
    {
        return [
            'student' => 'Student',
            'admin' => 'Admin',
        ];
    }

    /**
     * Faculty choices available at UiTM Puncak Perdana.
     *
     * @return array<string, string>
     */
    private function facultyOptions(): array
    {
        return [
            'Faculty of Information Science' =>
                'Faculty of Information Science',
            'Faculty of Film, Theater & Animation' =>
                'Faculty of Film, Theater & Animation',
        ];
    }

    /**
     * Normalise role-specific fields before validation and saving.
     *
     * @param array<string, mixed> $data Submitted data.
     * @param bool $publicRegistration Whether this is public registration.
     * @return array<string, mixed>
     */
    private function normaliseUserData(
        array $data,
        bool $publicRegistration
    ): array {
        $role = (string)($data['role'] ?? 'student');

        if (!array_key_exists($role, $this->roleOptions())) {
            $role = 'student';
        }

        $data['role'] = $role;

        if ($role === 'student') {
            $data['student_no'] = trim(
                (string)($data['student_no'] ?? '')
            );
            $data['staff_no'] = null;
        } else {
            $data['staff_no'] = trim(
                (string)($data['staff_no'] ?? '')
            );
            $data['student_no'] = null;
        }

        if ($publicRegistration) {
            $data['account_status'] =
                $role === 'admin'
                    ? 'inactive'
                    : 'active';
        } elseif (!isset($data['account_status'])) {
            $data['account_status'] = 'active';
        }

        return $data;
    }

    /**
     * Add a clear validation error for the ID required by the selected role.
     */
    private function validateRoleIdentifier(object $user): bool
    {
        if (
            $user->role === 'student' &&
            trim((string)$user->student_no) === ''
        ) {
            $user->setError('student_no', [
                'requiredForRole' =>
                    'Student ID is required for a student account.',
            ]);

            return false;
        }

        if (
            $user->role === 'admin' &&
            trim((string)$user->staff_no) === ''
        ) {
            $user->setError('staff_no', [
                'requiredForRole' =>
                    'Staff ID is required for an admin account.',
            ]);

            return false;
        }

        return true;
    }
}
