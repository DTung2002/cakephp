<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;
use DateTime;
/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $user = $this->Authentication->getIdentity();
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $skippedActions = ['index', 'add'];
        // Check if the current action is in the skipped actions array
        if (in_array($this->request->getParam('action'), $skippedActions)) {
            $this->Authorization->skipAuthorization();
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'PostStatuses'],
        ];
        $posts = $this->paginate($this->Posts);

        $this->set(compact('posts'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Posts->find()
            ->where(['Posts.id' => $id]);
        
        $this->Authorization->applyScope($query);
        
        try {
            $post = $query->firstOrFail();
            $this->set(compact('post'));
        } catch (RecordNotFoundException) {
            $this->Flash->error(__('You can not see this post!'));
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
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $post = $this->Posts->newEmptyEntity();
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            $post->user_id = $userId;
            $currentDateTime = new DateTime();
            $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
            $post->create_at = $formattedDateTime;
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $statuses = $this->Posts->PostStatuses->find('list', options: ['limit' => 200])->all();
        $this->set(compact('post', 'statuses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $post = $this->Posts->get($id, [
                'contain' => [],
            ]);
            $this->Authorization->authorize($post);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $post = $this->Posts->patchEntity($post, $this->request->getData());
                if ($this->Posts->save($post)) {
                    $this->Flash->success(__('The post has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
            $statuses = $this->Posts->PostStatuses->find('list', options: ['limit' => 200])->all();
            $this->set(compact('post', 'statuses'));
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['action' => 'index']);

        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $this->request->allowMethod(['post', 'delete']);
            $post = $this->Posts->get($id);
            $this->Authorization->authorize($post);

            if ($this->Posts->delete($post)) {
                $this->Flash->success(__('The post has been deleted.'));
            } else {
                $this->Flash->error(__('The post could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
            
        } catch (ForbiddenException) {
            $this->Flash->error(__('You do not have permission to access the resource!'));
            return $this->redirect(['action' => 'index']);        }
    }
}
