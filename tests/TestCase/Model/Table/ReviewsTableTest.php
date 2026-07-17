<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReviewsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReviewsTable Test Case
 */
class ReviewsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReviewsTable
     */
    protected $Reviews;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Reviews',
        'app.Applications',
        'app.Admins',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Reviews') ? [] : ['className' => ReviewsTable::class];
        $this->Reviews = $this->getTableLocator()->get('Reviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Reviews);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ReviewsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ReviewsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
