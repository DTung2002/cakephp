<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePosts extends AbstractMigration
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
        $table = $this->table('posts');
        $table->addColumn('title', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('content', 'text', [
            'null' => false,
        ])
        ->addColumn('create_at', 'datetime', [
            'null' => false,
        ])
        ->addColumn('user_id', 'integer', [
            'null' => true,
        ])
        ->addColumn('status_id', 'integer', [
            'null' => true,
        ])
        ->addForeignKey('user_id', 'users', 'id', [
            'delete'=> 'SET_NULL',
            'update'=> 'NO_ACTION'
        ])
        ->addForeignKey('status_id', 'post_statuses', 'id', [
            'delete'=> 'SET_NULL',
            'update'=> 'NO_ACTION'
        ])
        ->create();
    }
}
