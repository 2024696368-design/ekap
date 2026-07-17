<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClubsFixture
 */
class ClubsFixture extends TestFixture
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
                'club_name' => 'Lorem ipsum dolor sit amet',
                'registration_no' => 'Lorem ipsum dolor sit amet',
                'faculty' => 'Lorem ipsum dolor sit amet',
                'advisor_name' => 'Lorem ipsum dolor sit amet',
                'advisor_email' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-07-16 14:45:17',
                'modified' => '2026-07-16 14:45:17',
            ],
        ];
        parent::init();
    }
}
