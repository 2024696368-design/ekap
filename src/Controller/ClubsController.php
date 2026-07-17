<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Clubs Controller
 *
 * @property \App\Model\Table\ClubsTable $Clubs
 */
class ClubsController extends AppController
{
    /**
     * List registered clubs and societies.
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $query = $this->Clubs
            ->find()
            ->orderBy([
                'Clubs.status' => 'ASC',
                'Clubs.club_name' => 'ASC',
            ]);

        $clubs = $this->paginate($query);
        $this->set(compact('clubs'));
    }

    /**
     * View a club.
     *
     * @param string|null $id Club id.
     * @return \Cake\Http\Response|null|void
     */
    public function view($id = null)
    {
        $club = $this->Clubs->get($id, contain: ['Applications']);
        $this->set(compact('club'));
    }

    /**
     * Register a new club or society.
     *
     * @return \Cake\Http\Response|null|void
     */
    public function add()
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(
                'Only administrators can register clubs and societies.'
            );

            return $this->redirect('/dashboard');
        }

        $club = $this->Clubs->newEmptyEntity();
        $club->status = 'active';
        $facultyOptions = $this->facultyOptions();
        $statusOptions = $this->statusOptions();

        if ($this->request->is('post')) {
            $club = $this->Clubs->patchEntity(
                $club,
                $this->request->getData()
            );

            if ($this->Clubs->save($club)) {
                $this->Flash->success(
                    'The club was registered successfully and is now available in the application form.'
                );

                return $this->redirect([
                    'action' => 'view',
                    $club->id,
                ]);
            }

            $this->Flash->error(
                'The club could not be registered. Please correct the highlighted fields.'
            );
        }

        $this->set(compact(
            'club',
            'facultyOptions',
            'statusOptions'
        ));
    }

    /**
     * Edit a club or society.
     *
     * @param string|null $id Club id.
     * @return \Cake\Http\Response|null|void
     */
    public function edit($id = null)
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(
                'Only administrators can edit clubs and societies.'
            );

            return $this->redirect('/dashboard');
        }

        $club = $this->Clubs->get($id);
        $facultyOptions = $this->facultyOptions();
        $statusOptions = $this->statusOptions();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $club = $this->Clubs->patchEntity(
                $club,
                $this->request->getData()
            );

            if ($this->Clubs->save($club)) {
                $this->Flash->success(
                    'The club information was updated successfully.'
                );

                return $this->redirect([
                    'action' => 'view',
                    $club->id,
                ]);
            }

            $this->Flash->error(
                'The club could not be updated. Please correct the highlighted fields.'
            );
        }

        $this->set(compact(
            'club',
            'facultyOptions',
            'statusOptions'
        ));
    }

    /**
     * Delete a club.
     *
     * @param string|null $id Club id.
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        if (!$this->isAdmin()) {
            $this->Flash->error(
                'Only administrators can delete clubs.'
            );

            return $this->redirect('/dashboard');
        }

        $club = $this->Clubs->get($id);

        if ($club->club_name === 'Others') {
            $this->Flash->error(
                'The system option “Others” cannot be deleted.'
            );

            return $this->redirect([
                'action' => 'index',
            ]);
        }

        if ($this->Clubs->delete($club)) {
            $this->Flash->success(
                'The club was deleted successfully.'
            );
        } else {
            $this->Flash->error(
                'The club could not be deleted because it may have related applications.'
            );
        }

        return $this->redirect([
            'action' => 'index',
        ]);
    }

    /**
     * Faculty options for UiTM Puncak Perdana.
     *
     * @return array<string, string>
     */
    private function facultyOptions(): array
    {
        return [
            'Faculty of Information Science' =>
                'Faculty of Information Science',
            'Faculty of Film, Theatre & Animation' =>
                'Faculty of Film, Theatre & Animation',
            'University / Cross-Faculty' =>
                'University / Cross-Faculty',
        ];
    }

    /**
     * Club status options.
     *
     * @return array<string, string>
     */
    private function statusOptions(): array
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ];
    }
}
