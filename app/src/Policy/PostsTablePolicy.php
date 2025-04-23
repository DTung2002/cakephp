<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\PostsTable;
use Authorization\IdentityInterface;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Post;

/**
 * Posts policy
 */
class PostsTablePolicy
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
    public function scopeView($user, $query)
    {
        if ($this->isAdmin($user)) {
            return $query;
        }
        return $query->where(['Posts.status_id' => 1]);
    }
}
