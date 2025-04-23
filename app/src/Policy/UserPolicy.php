<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Cake\ORM\TableRegistry;

/**
 * User policy
 */
class UserPolicy
{
        /**
     * Check if $user can create User
     *
     * @param Authorization\IdentityInterface $u The user.
     * @param App\Model\Entity\User $r
     * @return bool
     */
    protected function isMe(IdentityInterface $u, User $resource)
    {
        return $resource->id === $u->getIdentifier(); 
    }
   
    /**
     * Check if $user can create User
     *
     * @param Authorization\IdentityInterface $u The user.
     * @param App\Model\Entity\User $r
     * @return bool
     */
    protected function isAdmin(IdentityInterface $u, User $resource)
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

    public function canAdd(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource);    
    }

    public function canEdit(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource) || $this->isMe($user,$resource);
    }

    public function canDelete(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource) || $this->isMe($user,$resource);
    }

    public function canView(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource) || $this->isMe($user,$resource);
    }
}
