<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $roles = $this->paginate($this->Roles);
            foreach ($roles as $role) {
                $this->Authorization->authorize($role);
            }
            $this->set(compact('roles'));
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['controller' => 'Users','action' => 'index']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $role = $this->Roles->get($id, [
                'contain' => ['Users'],
            ]);
            $this->Authorization->authorize($role);
    
            $this->set(compact('role'));
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['controller' => 'Users','action' => 'index']);        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        try {
            $role = $this->Roles->newEmptyEntity();
            $this->Authorization->authorize($role);
    
            if ($this->request->is('post')) {
                $role = $this->Roles->patchEntity($role, $this->request->getData());
                if ($this->Roles->save($role)) {
                    $this->Flash->success(__('The role has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
            $users = $this->Roles->Users->find('list', ['limit' => 200])->all();
            $this->set(compact('role', 'users'));
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['controller' => 'Users','action' => 'index']);        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Users'],
        ]);
        $this->Authorization->authorize($role);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $users = $this->Roles->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('role', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete']);
            $role = $this->Roles->get($id);
            $this->Authorization->authorize($role);
    
            if ($this->Roles->delete($role)) {
                $this->Flash->success(__('The role has been deleted.'));
            } else {
                $this->Flash->error(__('The role could not be deleted. Please, try again.'));
            }
    
            return $this->redirect(['action' => 'index']);
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['controller' => 'Users','action' => 'index']);        
        }
    }
}
