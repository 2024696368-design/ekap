<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add application-wide methods in this class.
 */
class AppController extends Controller
{
    /**
     * Initialization hook.
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
    }

    /**
     * Runs before every controller action.
     *
     * The login page is public. Every other page requires
     * an authenticated EKAP session.
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $controller = (string)$this->request
            ->getParam('controller');

        $action = (string)$this->request
            ->getParam('action');

        /*
         * Pages that can be opened without logging in.
         */
        $publicActions = [
            'Users' => [
                'login',
                'register',
            ],
        ];

        $isPublicAction =
            isset($publicActions[$controller]) &&
            in_array(
                $action,
                $publicActions[$controller],
                true
            );

        if ($isPublicAction) {
            return null;
        }

        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            $this->Flash->error(
                'Please log in to access EKAP.'
            );

            $event->stopPropagation();

            return $this->redirect('/login');
        }

        return null;
    }

    /**
     * Return the currently logged-in user information.
     */
    protected function getAuthUser(): array
    {
        return (array)$this->request
            ->getSession()
            ->read('Auth');
    }

    /**
     * Check whether the logged-in user is an administrator.
     */
    protected function isAdmin(): bool
    {
        $auth = $this->getAuthUser();

        return ($auth['role'] ?? '') === 'admin';
    }

    /**
     * Check whether the logged-in user is a student.
     */
    protected function isStudent(): bool
    {
        $auth = $this->getAuthUser();

        return ($auth['role'] ?? '') === 'student';
    }
}