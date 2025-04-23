<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePoststatuses extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('post_statuses');
        $table->addColumn('name', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->create();
        $this->execute("INSERT INTO post_statuses (name) VALUES
        ('public'), 
        ('private')");
    }
}
