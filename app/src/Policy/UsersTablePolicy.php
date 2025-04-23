<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\UsersTable;
use Authorization\IdentityInterface;
use Cake\ORM\TableRegistry;

/**
 * Users policy
 */
class UsersTablePolicy
{
    protected function isAdmin($user)
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->get($user->getIdentifier(), ['contain' => ['Roles']]);
    
        foreach ($user->roles as $role) {
            if ($role->name === 'admin') {
                return true; 
            }
        }
        return false; 
    }
    public function scopeIndex($user, $query)
    {
        if ($this->isAdmin($user)) {
            return $query;
        }
        return $query->where(['Users.id' => $user->getIdentifier()]);
    }
}
