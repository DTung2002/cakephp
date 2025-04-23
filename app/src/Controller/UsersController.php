<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        try {
            $user = $this->Authentication->getIdentity();
            parent::beforeFilter(event: $event);

            $this->Authentication->addUnauthenticatedActions(['login', 'signup']);
            $skippedActions = ['login', 'signup', 'logout'];

            if (in_array($this->request->getParam('action'), $skippedActions)) {
                $this->Authorization->skipAuthorization();
            }
        } catch (RecordNotFoundException) {
            $this->redirect(['action' => 'login']);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $user = $this->request->getAttribute('identity');        
            $query = $this->Users->find();
            $this->Authorization->applyScope($query);
            $users = $this->paginate($query);
            $this->set(compact('users'));
        } catch (RecordNotFoundException) {
            $this->redirect(['action' => 'logout']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => ['Roles', 'Posts'],
            ]);
            $this->Authorization->authorize($user);
    
            $this->set(compact('user'));
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        try {
            $user = $this->Users->newEmptyEntity();
            $this->Authorization->authorize($user);
            if ($this->request->is('post')) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            // $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
            $this->set(compact('user'));
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['action' => 'index']);        }
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => ['Roles'],
            ]);
            $this->Authorization->authorize($user);
            // if (empty($user->roles)) {
            //     $user->roles = [];
            // }
        
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
        
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            // $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
            $this->set(compact('user'));
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            $this->Authorization->authorize($user);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('The user has been deleted.'));
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }
    
            return $this->redirect(['action' => 'index']);
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['action' => 'index']);        
        }
    }
    
    public function login() {
        $this->request->allowMethod(['post', 'get']);
        $result = $this->Authentication->getResult();
    
        if ($result && $result->isValid()) {
            return $this->redirect(['controller' => 'Posts','action' => 'index']);
        }
        if ($this->request->is('post', 'get')) {
            if (!$result->isValid()) {
                $this->Flash->error(__('Invalid username or password'));
            } else {
                $this->Flash->error(__('Authentication failed. Please try again.'));
            }
        }
    }
    
    public function signup()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registration successful!'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect(['action' => 'login']);
        }
    }
}
