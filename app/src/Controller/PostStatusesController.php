<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\AuthorizationRequiredException;
use Authorization\Exception\ForbiddenException;

/**
 * PostStatuses Controller
 *
 * @property \App\Model\Table\PostStatusesTable $PostStatuses
 * @method \App\Model\Entity\PostStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostStatusesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $postStatuses = $this->paginate($this->PostStatuses);
            $this->set(compact('postStatuses'));
        } catch (AuthorizationRequiredException) {
            $this->Flash->error(__('404 NOT FOUND'));
        }
    }

    /**
     * View method
     *
     * @param string|null $id Post Status id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $postStatus = $this->PostStatuses->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('postStatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $postStatus = $this->PostStatuses->newEmptyEntity();
        if ($this->request->is('post')) {
            $postStatus = $this->PostStatuses->patchEntity($postStatus, $this->request->getData());
            if ($this->PostStatuses->save($postStatus)) {
                $this->Flash->success(__('The post status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post status could not be saved. Please, try again.'));
        }
        $this->set(compact('postStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post Status id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $postStatus = $this->PostStatuses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postStatus = $this->PostStatuses->patchEntity($postStatus, $this->request->getData());
            if ($this->PostStatuses->save($postStatus)) {
                $this->Flash->success(__('The post status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post status could not be saved. Please, try again.'));
        }
        $this->set(compact('postStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post Status id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postStatus = $this->PostStatuses->get($id);
        if ($this->PostStatuses->delete($postStatus)) {
            $this->Flash->success(__('The post status has been deleted.'));
        } else {
            $this->Flash->error(__('The post status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
