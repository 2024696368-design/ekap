<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'full_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'role' => 'Lorem ipsum dolor sit amet',
                'student_no' => 'Lorem ipsum dolor sit amet',
                'staff_no' => 'Lorem ipsum dolor sit amet',
                'faculty' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor sit amet',
                'account_status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-07-16 14:44:56',
                'modified' => '2026-07-16 14:44:56',
            ],
        ];
        parent::init();
    }
}
