<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Post;
use Authorization\IdentityInterface;
use Cake\ORM\TableRegistry;

/**
 * Post policy
 */
class PostPolicy
{
    /**
     * Check if $user can create User
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Post $p
     * @return bool
     */
    protected function isAuthor(IdentityInterface $user, Post $post)
    {
        return $post->user_id === $user->getIdentifier();
    }
    /**
     * Check if $user can create User
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Post $p
     * @return bool
     */
    protected function isAdmin(IdentityInterface $user, Post $post)
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
    public function canCreate(IdentityInterface $user, Post $post)
    {
       return true;
    }

    public function canEdit(IdentityInterface $user, Post $post)
    {
        return $this->isAuthor($user, $post);
    }


    public function canDelete(IdentityInterface $user, Post $post)
    {
        return $this->isAdmin($user,$post) || $this->isAuthor($user,$post);
    }

    public function canView(IdentityInterface $user, Post $post)
    {
        return null;
    }
}
