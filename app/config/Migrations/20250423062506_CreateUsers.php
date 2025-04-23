<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('username', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('email', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('password', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addIndex(['username'], ['unique' => true])
        ->addIndex(['email'], ['unique' => true])
        ->create();
        $this->execute("INSERT INTO users (username, password, email) VALUES
            ('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'admin@example.com')"
        );
    }
}
