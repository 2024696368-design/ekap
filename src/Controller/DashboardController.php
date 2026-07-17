<?php

declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController
{
    public function index()
    {
        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');
        $applicationsTable = $this->fetchTable('Applications');

        $conditions = [];

        // Students can only see their own applications.
        if ($auth['role'] === 'student') {
            $conditions['Applications.user_id'] = $auth['id'];
        }

        $counts = [
            'total' => $applicationsTable
                ->find()
                ->where($conditions)
                ->count(),

            'submitted' => $applicationsTable
                ->find()
                ->where(array_merge($conditions, [
                    'Applications.status' => 'submitted',
                ]))
                ->count(),

            'under_review' => $applicationsTable
                ->find()
                ->where(array_merge($conditions, [
                    'Applications.status' => 'under_review',
                ]))
                ->count(),

            'approved' => $applicationsTable
                ->find()
                ->where(array_merge($conditions, [
                    'Applications.status' => 'approved',
                ]))
                ->count(),

            'rejected' => $applicationsTable
                ->find()
                ->where(array_merge($conditions, [
                    'Applications.status' => 'rejected',
                ]))
                ->count(),
        ];

        $recentApplications = $applicationsTable
            ->find()
            ->contain(['Users', 'Clubs'])
            ->where($conditions)
            ->orderBy([
                'Applications.created' => 'DESC',
            ])
            ->limit(5)
            ->all();

        $this->set(compact(
            'auth',
            'counts',
            'recentApplications'
        ));
    }
}