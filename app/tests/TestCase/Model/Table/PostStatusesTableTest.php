<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostStatusesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostStatusesTable Test Case
 */
class PostStatusesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PostStatusesTable
     */
    protected $PostStatuses;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PostStatuses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PostStatuses') ? [] : ['className' => PostStatusesTable::class];
        $this->PostStatuses = $this->getTableLocator()->get('PostStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PostStatuses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PostStatusesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
