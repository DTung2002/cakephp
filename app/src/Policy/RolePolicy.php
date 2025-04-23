<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\ORM\TableRegistry;
/**
 * Role policy
 */
class RolePolicy implements BeforePolicyInterface
{ 
    public function before($user, $resource, $action)
    {
        if ($this->isAdmin($user)) {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can create User
     *
     * @param Authorization\IdentityInterface $u The user.
     * @param App\Model\Entity\User $r
     * @return bool
     */
    protected function isAdmin(IdentityInterface $u)
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->get($u->getIdentifier(), ['contain' => ['Roles']]);
    
        foreach ($user->roles as $role) {
            if ($role->name === 'admin') {
                return true; 
            }
        }
        return false; 
    }
}
