<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateRoles extends AbstractMigration
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
        $table = $this->table('roles');
        $table->addColumn('name', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('description', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->create();
        $this->execute("INSERT INTO roles (name, description) VALUES
        ('admin', 'You have all permissions')");
    }
}
