<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentsFixture
 */
class DocumentsFixture extends TestFixture
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
                'application_id' => 1,
                'document_type' => 'Lorem ipsum dolor sit amet',
                'file_name' => 'Lorem ipsum dolor sit amet',
                'file_path' => 'Lorem ipsum dolor sit amet',
                'file_type' => 'Lorem ipsum dolor sit amet',
                'file_size' => 1,
                'created' => '2026-07-16 14:45:48',
                'modified' => '2026-07-16 14:45:48',
            ],
        ];
        parent::init();
    }
}
