<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApplicationsFixture
 */
class ApplicationsFixture extends TestFixture
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
                'user_id' => 1,
                'club_id' => 1,
                'reference_no' => 'Lorem ipsum dolor sit amet',
                'organiser_type' => 'Lorem ipsum dolor sit amet',
                'department_head' => 'Lorem ipsum dolor sit amet',
                'program_title' => 'Lorem ipsum dolor sit amet',
                'program_level' => 'Lorem ipsum dolor sit amet',
                'program_category' => 'Lorem ipsum dolor sit amet',
                'attendance_type' => 'Lorem ipsum dolor sit amet',
                'location_type' => 'Lorem ipsum dolor sit amet',
                'venue' => 'Lorem ipsum dolor sit amet',
                'target_group' => 'Lorem ipsum dolor sit amet',
                'start_datetime' => '2026-07-16 14:45:34',
                'end_datetime' => '2026-07-16 14:45:34',
                'male_participants' => 1,
                'female_participants' => 1,
                'total_participants' => 1,
                'program_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'objectives' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'expected_outcomes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'estimated_budget' => 1.5,
                'requested_allocation' => 1.5,
                'funding_source' => 'Lorem ipsum dolor sit amet',
                'has_risk' => 1,
                'risk_level' => 'Lorem ipsum dolor sit amet',
                'risk_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'safety_action' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'person_in_charge' => 'Lorem ipsum dolor sit amet',
                'pic_phone' => 'Lorem ipsum dolor sit amet',
                'pic_email' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'admin_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'submitted_at' => '2026-07-16 14:45:34',
                'created' => '2026-07-16 14:45:34',
                'modified' => '2026-07-16 14:45:34',
            ],
        ];
        parent::init();
    }
}
