<?php
declare(strict_types=1);

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Applications Controller
 *
 * @property \App\Model\Table\ApplicationsTable $Applications
 */
class ApplicationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        $query = $this->Applications
            ->find()
            ->contain([
                'Users',
                'Clubs',
            ]);

        /*
        * Students can only see applications created by them.
        * Admins do not receive this condition, so they see everything.
        */
        if ($auth['role'] === 'student') {
            $query->where([
                'Applications.user_id' => $auth['id'],
            ]);
        }

        $search = trim(
            (string)$this->request->getQuery('search')
        );

        $status = trim(
            (string)$this->request->getQuery('status')
        );

        if ($search !== '') {
            $query->where([
                'OR' => [
                    'Applications.program_title LIKE' =>
                        '%' . $search . '%',

                    'Applications.reference_no LIKE' =>
                        '%' . $search . '%',

                    'Clubs.club_name LIKE' =>
                        '%' . $search . '%',
                ],
            ]);
        }

        if ($status !== '') {
            $query->where([
                'Applications.status' => $status,
            ]);
        }

        $query->orderBy([
            'Applications.created' => 'DESC',
        ]);

        $applications = $this->paginate($query);

        $this->set(compact(
            'applications',
            'auth',
            'search',
            'status'
        ));
    }

    /**
     * View method
     *
     * @param string|null $id Application id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        $application = $this->Applications->get($id, contain: [
            'Users',
            'Clubs',
            'Documents',
            'Reviews',
        ]);

        /*
        * Prevent students from opening another student's application
        * by manually changing the URL.
        */
        if (
            $auth['role'] === 'student' &&
            (int)$application->user_id !== (int)$auth['id']
        ) {
            $this->Flash->error(
                'You are not allowed to view this application.'
            );

            return $this->redirect([
                'action' => 'index',
            ]);
        }

        $this->set(compact(
            'application',
            'auth'
        ));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        /*
        * Only students submit programme applications.
        */
        if ($auth['role'] !== 'student') {
            $this->Flash->error(
                'Only student representatives can create applications.'
            );

            return $this->redirect('/dashboard');
        }

        $application = $this->Applications->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            /*
            * Never trust user_id or status sent through the form.
            * Set them from the logged-in session.
            */
            $data['user_id'] = $auth['id'];
            $data['status'] = 'draft';
            $data['reference_no'] = null;
            $data['submitted_at'] = null;

            // These legacy fields are no longer shown in the application form.
            $data['department_head'] = null;
            $data['attendance_type'] = 'physical';
            $data['location_type'] = 'inside_campus';

            $data['male_participants'] =
                (int)($data['male_participants'] ?? 0);

            $data['female_participants'] =
                (int)($data['female_participants'] ?? 0);

            $data['total_participants'] =
                $data['male_participants'] +
                $data['female_participants'];

            $application = $this->Applications->patchEntity(
                $application,
                $data
            );

            if ($this->Applications->save($application)) {
                $this->Flash->success(
                    'The programme application was saved as a draft.'
                );

                return $this->redirect([
                    'action' => 'view',
                    $application->id,
                ]);
            }

            $this->Flash->error(
                'The application could not be saved. Please check the form.'
            );
        }

        $clubs = $this->clubOptions();

        $organiserTypeOptions = $this->organiserTypeOptions();
        $programLevelOptions = $this->programLevelOptions();
        $programCategoryOptions = $this->programCategoryOptions();

        $this->set(compact(
            'application',
            'clubs',
            'auth',
            'organiserTypeOptions',
            'programLevelOptions',
            'programCategoryOptions'
        ));
    }

    /**
     * Edit method
     *
     * @param string|null $id Application id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        $application = $this->Applications->get($id);

        /*
        * HEP administrators review applications through a separate
        * approval function. They should not edit the student's form.
        */
        if ($auth['role'] !== 'student') {
            $this->Flash->error(
                'HEP administrators cannot modify student programme details.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        if ((int)$application->user_id !== (int)$auth['id']) {
            $this->Flash->error(
                'You cannot edit another student’s application.'
            );

            return $this->redirect([
                'action' => 'index',
            ]);
        }

        $editableStatuses = [
            'draft',
            'changes_requested',
        ];

        if (!in_array(
            $application->status,
            $editableStatuses,
            true
        )) {
            $this->Flash->error(
                'This application can no longer be edited.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            /*
            * Prevent changes to protected fields.
            */
            unset(
                $data['user_id'],
                $data['status'],
                $data['reference_no'],
                $data['submitted_at'],
                $data['admin_comment'],
                $data['department_head'],
                $data['attendance_type'],
                $data['location_type']
            );

            $data['department_head'] = null;
            $data['attendance_type'] = 'physical';
            $data['location_type'] = 'inside_campus';

            $data['male_participants'] =
                (int)($data['male_participants'] ?? 0);

            $data['female_participants'] =
                (int)($data['female_participants'] ?? 0);

            $data['total_participants'] =
                $data['male_participants'] +
                $data['female_participants'];

            $application = $this->Applications->patchEntity(
                $application,
                $data
            );

            if ($this->Applications->save($application)) {
                $this->Flash->success(
                    'The application was updated successfully.'
                );

                return $this->redirect([
                    'action' => 'view',
                    $application->id,
                ]);
            }

            $this->Flash->error(
                'The application could not be updated.'
            );
        }

        $clubs = $this->clubOptions();

        $organiserTypeOptions = $this->organiserTypeOptions();
        $programLevelOptions = $this->programLevelOptions();
        $programCategoryOptions = $this->programCategoryOptions();

        $this->set(compact(
            'application',
            'clubs',
            'auth',
            'organiserTypeOptions',
            'programLevelOptions',
            'programCategoryOptions'
        ));
    }

    /**Submit method
     * 
     */

    public function submit($id = null)
    {
        $this->request->allowMethod(['post']);

        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        if ($auth['role'] !== 'student') {
            $this->Flash->error(
                'Only students can submit programme applications.'
            );

            return $this->redirect('/dashboard');
        }

        $application = $this->Applications->get($id);

        if ((int)$application->user_id !== (int)$auth['id']) {
            $this->Flash->error(
                'You cannot submit another student’s application.'
            );

            return $this->redirect([
                'action' => 'index',
            ]);
        }

        $allowedStatuses = [
            'draft',
            'changes_requested',
        ];

        if (!in_array(
            $application->status,
            $allowedStatuses,
            true
        )) {
            $this->Flash->error(
                'This application has already been submitted.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        /*
        * Generate the reference number only once.
        * Example: EKAP/2026/0001
        */
        if (empty($application->reference_no)) {
            $application->reference_no =
                'EKAP/' .
                date('Y') .
                '/' .
                str_pad(
                    (string)$application->id,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
        }

        $application->status = 'submitted';
        $application->submitted_at = date('Y-m-d H:i:s');

        if ($this->Applications->save($application)) {
            $this->Flash->success(
                'The application was submitted successfully to HEP.'
            );

            return $this->redirect([
                'action' => 'view',
                $application->id,
            ]);
        }

        $this->Flash->error(
            'The application could not be submitted. Please try again.'
        );

        return $this->redirect([
            'action' => 'view',
            $id,
        ]);
    }


    /**
     * Review method
     *
     * Allows HEP administrators to mark an application as under review,
     * request changes, approve, or reject it. Every decision is stored
     * in the reviews table.
     *
     * @param string|null $id Application id.
     * @return \Cake\Http\Response|null Redirects to the application view.
     */
    public function review($id = null)
    {
        $this->request->allowMethod(['post']);

        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        if (($auth['role'] ?? '') !== 'admin') {
            $this->Flash->error(
                'Only HEP administrators can review applications.'
            );

            return $this->redirect('/dashboard');
        }

        $application = $this->Applications->get($id);

        $reviewableStatuses = [
            'submitted',
            'under_review',
        ];

        if (!in_array(
            $application->status,
            $reviewableStatuses,
            true
        )) {
            $this->Flash->error(
                'This application is not ready for HEP review.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        $decision = trim(
            (string)$this->request->getData('decision')
        );

        $comments = trim(
            (string)$this->request->getData('comments')
        );

        $internalNotes = trim(
            (string)$this->request->getData('internal_notes')
        );

        $approvedAmountInput =
            $this->request->getData('approved_amount');

        $approvedAmount =
            $approvedAmountInput === null ||
            $approvedAmountInput === ''
                ? null
                : (float)$approvedAmountInput;

        $allowedDecisions = [
            'under_review',
            'changes_requested',
            'approved',
            'rejected',
        ];

        if (!in_array(
            $decision,
            $allowedDecisions,
            true
        )) {
            $this->Flash->error(
                'Please select a valid HEP decision.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        if (
            in_array(
                $decision,
                ['changes_requested', 'rejected'],
                true
            ) &&
            $comments === ''
        ) {
            $this->Flash->error(
                'Comments are required when requesting changes or rejecting an application.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        if (
            $decision === 'under_review' &&
            $comments === ''
        ) {
            $comments =
                'Your application is currently being reviewed by HEP.';
        }

        if (
            $decision === 'approved' &&
            $comments === ''
        ) {
            $comments =
                'Your programme application has been approved by HEP.';
        }

        if (
            $decision === 'approved' &&
            (
                $approvedAmount === null ||
                $approvedAmount < 0
            )
        ) {
            $this->Flash->error(
                'Please enter the approved allocation amount.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        if (
            $decision === 'approved' &&
            $application->requested_allocation !== null &&
            $approvedAmount >
                (float)$application->requested_allocation
        ) {
            $this->Flash->error(
                'The approved amount cannot exceed the requested allocation.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        $reviewsTable = $this->fetchTable('Reviews');
        $connection = $this->Applications->getConnection();

        try {
            $connection->transactional(
                function () use (
                    $reviewsTable,
                    $application,
                    $auth,
                    $decision,
                    $comments,
                    $internalNotes,
                    $approvedAmount
                ): void {
                    $review = $reviewsTable->newEntity([
                        'application_id' => $application->id,
                        'admin_id' => $auth['id'],
                        'decision' => $decision,
                        'comments' => $comments,
                        'internal_notes' => $internalNotes,
                    ]);

                    if (!$reviewsTable->save($review)) {
                        throw new \RuntimeException(
                            'The review record could not be saved.'
                        );
                    }

                    $application->status = $decision;
                    $application->admin_comment = $comments;

                    if ($decision === 'approved') {
                        $application->approved_amount =
                            $approvedAmount;
                    }

                    if ($decision === 'rejected') {
                        $application->approved_amount = null;
                    }

                    if (!$this->Applications->save($application)) {
                        throw new \RuntimeException(
                            'The application status could not be updated.'
                        );
                    }
                }
            );
        } catch (\Throwable $exception) {
            $this->Flash->error(
                'The HEP decision could not be saved. Please try again.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        $decisionLabel = ucwords(
            str_replace('_', ' ', $decision)
        );

        $this->Flash->success(
            'Application updated to: ' .
            $decisionLabel .
            '.'
        );

        return $this->redirect([
            'action' => 'view',
            $id,
        ]);
    }

    /**
     * Generate the official PDF approval letter.
     *
     * @param string|null $id Application id.
     * @return \Cake\Http\Response|null
     */
    public function approvalLetter($id = null)
    {
        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        $application = $this->Applications->get($id, contain: [
            'Users',
            'Clubs',
            'Reviews',
        ]);

        // Students may only download their own approval letter.
        if (
            ($auth['role'] ?? '') === 'student' &&
            (int)$application->user_id !== (int)($auth['id'] ?? 0)
        ) {
            $this->Flash->error(
                'You are not allowed to download this approval letter.'
            );

            return $this->redirect([
                'action' => 'index',
            ]);
        }

        if ($application->status !== 'approved') {
            $this->Flash->error(
                'An approval letter is available only after HEP approves the application.'
            );

            return $this->redirect([
                'action' => 'view',
                $id,
            ]);
        }

        // Find the latest approved review.
        $approvalReview = null;

        foreach ($application->reviews as $review) {
            if ($review->decision !== 'approved') {
                continue;
            }

            if (
                $approvalReview === null ||
                $review->created > $approvalReview->created
            ) {
                $approvalReview = $review;
            }
        }

        $approvalDate =
            $approvalReview->created
            ?? $application->modified
            ?? new \DateTimeImmutable();

        $letter = [
            'reference' =>
                $application->reference_no
                ?: (
                    'EKAP/' .
                    date('Y') .
                    '/' .
                    str_pad(
                        (string)$application->id,
                        4,
                        '0',
                        STR_PAD_LEFT
                    )
                ),

            'university_name' =>
                'Universiti Teknologi MARA',

            'faculty_name' =>
                'Fakulti Sains Maklumat',

            'office_name' =>
                'Bahagian Hal Ehwal Pelajar',

            'campus_name' =>
                'Kampus Puncak Perdana',

            'postal_address' =>
                '40150 Shah Alam, Selangor',

            'signatory_name' =>
                'Pegawai Hal Ehwal Pelajar',

            'signatory_position' =>
                'Pegawai Hal Ehwal Pelajar',

            'carbon_copy' =>
                'Timbalan Dekan (Hal Ehwal Pelajar)',
        ];

        $imageToDataUri = static function (
            string $path
        ): ?string {
            if (!is_file($path)) {
                return null;
            }

            $mime = mime_content_type($path);

            if ($mime === false) {
                return null;
            }

            return 'data:' .
                $mime .
                ';base64,' .
                base64_encode(
                    (string)file_get_contents($path)
                );
        };

        //Logo for pdf.
        $uitmLogoData = $imageToDataUri(
            WWW_ROOT .
            'img' .
            DS .
            'uitm-logo.png'
        );

        $ekapLogoData = $imageToDataUri(
            WWW_ROOT .
            'img' .
            DS .
            'ekap-logo.png'
        );

        $signatureData = $imageToDataUri(
            WWW_ROOT .
            'img' .
            DS .
            'hep-signature.png'
        );

        $this->set(compact(
            'application',
            'letter',
            'approvalReview',
            'approvalDate',
            'uitmLogoData',
            'ekapLogoData',
            'signatureData'
        ));

        $this->viewBuilder()->setLayout('pdf');

        $renderedView = $this->render(
            '/Applications/pdf/approval_letter'
        );

        $html = (string)$renderedView->getBody();

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Add page numbering after the document is rendered.
        $canvas = $dompdf->getCanvas();

        $font = $dompdf
            ->getFontMetrics()
            ->getFont(
                'DejaVu Sans',
                'normal'
            );

        $canvas->page_text(
            455,
            815,
            'Halaman {PAGE_NUM} / {PAGE_COUNT}',
            $font,
            8,
            [0.35, 0.35, 0.35]
        );

        $safeReference = preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '_',
            (string)$letter['reference']
        );

        $filename =
            'Surat_Kelulusan_' .
            trim(
                (string)$safeReference,
                '_'
            ) .
            '.pdf';

        return $this->response
            ->withType('application/pdf')
            ->withHeader(
                'Content-Disposition',
                'inline; filename="' .
                $filename .
                '"'
            )
            ->withStringBody(
                $dompdf->output()
            );
    }


    /**
     * Active club options used by application forms.
     *
     * Every active club registered by an administrator is included. A
     * database-backed "Others" option is created automatically so that the
     * selected value still satisfies the applications.club_id foreign key.
     *
     * @return array<int, string>
     */
    private function clubOptions(): array
    {
        $clubsTable = $this->Applications->Clubs;

        $otherClub = $clubsTable
            ->find()
            ->where([
                'Clubs.club_name' => 'Others',
            ])
            ->first();

        if ($otherClub === null) {
            $otherClub = $clubsTable->newEntity([
                'club_name' => 'Others',
                'registration_no' => 'EKAP-OTHER-001',
                'faculty' => null,
                'advisor_name' => null,
                'advisor_email' => null,
                'status' => 'active',
            ]);

            $clubsTable->saveOrFail($otherClub);
        } elseif ($otherClub->status !== 'active') {
            $otherClub->status = 'active';
            $clubsTable->saveOrFail($otherClub);
        }

        $options = $clubsTable
            ->find('list', keyField: 'id', valueField: 'club_name')
            ->where([
                'Clubs.status' => 'active',
                'Clubs.id !=' => $otherClub->id,
            ])
            ->orderBy([
                'Clubs.club_name' => 'ASC',
            ])
            ->limit(200)
            ->toArray();

        $options[(int)$otherClub->id] = 'Others';

        return $options;
    }


    /**
     * Organiser type options used by application forms.
     *
     * @return array<string, string>
     */
    private function organiserTypeOptions(): array
    {
        return [
            'Club/Society' => 'Club/Society',
            'Faculty/Department' => 'Faculty/Department',
            'MPP/Student Council' => 'MPP/Student Council',
            'Joint Organization' => 'Joint Organization',
            'External Organization' => 'External Organization',
        ];
    }

    /**
     * Programme level options used by application forms.
     *
     * @return array<string, string>
     */
    private function programLevelOptions(): array
    {
        return [
            'International' => 'International',
            'National' => 'National',
            'State' => 'State',
            'District' => 'District',
            'University' => 'University',
            'Faculty' => 'Faculty',
            'Club/Student Society' => 'Club/Student Society',
            'College' => 'College',
        ];
    }

    /**
     * Programme category options used by application forms.
     *
     * @return array<string, string>
     */
    private function programCategoryOptions(): array
    {
        return [
            'Academic' => 'Academic',
            'Cultural/Heritage' => 'Cultural/Heritage',
            'Religious Affairs' => 'Religious Affairs',
            'Volunteering' => 'Volunteering',
            'Business/Entrepreneurship' => 'Business/Entrepreneurship',
            'Public Speaking' => 'Public Speaking',
            'Science & Innovation' => 'Science & Innovation',
            'Intellectual Forum' => 'Intellectual Forum',
        ];
    }

    /**
     * Delete method
     *
     * @param string|null $id Application id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete',
        ]);

        $session = $this->request->getSession();

        if (!$session->check('Auth')) {
            return $this->redirect('/login');
        }

        $auth = $session->read('Auth');

        $application = $this->Applications->get($id);

        if ($auth['role'] === 'student') {
            if ((int)$application->user_id !== (int)$auth['id']) {
                $this->Flash->error(
                    'You cannot delete another student’s application.'
                );

                return $this->redirect([
                    'action' => 'index',
                ]);
            }

            if ($application->status !== 'draft') {
                $this->Flash->error(
                    'Only draft applications can be deleted.'
                );

                return $this->redirect([
                    'action' => 'view',
                    $id,
                ]);
            }
        }

        if ($this->Applications->delete($application)) {
            $this->Flash->success(
                'The application was deleted successfully.'
            );
        } else {
            $this->Flash->error(
                'The application could not be deleted.'
            );
        }

        return $this->redirect([
            'action' => 'index',
        ]);
    }
}