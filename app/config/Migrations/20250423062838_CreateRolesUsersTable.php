<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateRolesUsersTable extends AbstractMigration
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
        $table = $this->table('roles_users', ['id' => false, 'primary_key' => ['role_id', 'user_id']]);
        $table->addColumn('role_id', 'integer', [
            'null' => false,
        ])
        ->addColumn('user_id', 'integer', [
            'null' => false,
        ])
        ->addForeignKey('role_id', 'roles', 'id', [
            'delete'=> 'CASCADE',
            'update'=> 'NO_ACTION'
        ])
        ->addForeignKey('user_id', 'users', 'id', [
            'delete'=> 'CASCADE',
            'update'=> 'NO_ACTION'
        ])
        ->create();
        $this->execute("INSERT INTO roles_users (user_id, role_id) VALUES
        (1, 1)");
    }
}
