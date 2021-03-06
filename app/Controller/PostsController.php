<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController {

/**
 * Components
 *
 * @var array
 */

  public $helpers = array('Html', 'Form');

	public $components = array('Paginator');

  public function index() {
    $this->set('posts', $this->Post->find('all'));
  }

  public function add() {
    if ($this->request->is('post')) {
      //Added this line
      $this->request->data['Post']['user_id'] = $this->Auth->user('id');
      if ($this->Post->save($this->request->data)) {
        $this->Flash->success(__('Your post has been saved.'));
        return $this->redirect(array('action' => 'index'));
      }
    }
  }

  public function edit() {
    if ($this->request->is('post')) {
      //Added this line
      $this->request->data['Post']['user_id'] = $this->Auth->user('id');
      if ($this->Post->save($this->request->data)) {
        $this->Flash->success(__('Your post has been saved.'));
        return $this->redirect(array('action' => 'index'));
      }
    }
  }

  public function isAuthorized($user) {
    // All registered users can add posts
    if ($this->action === 'add') {
      return true;
    }

    // The owner of a post can edit and delete it
    if (in_array($this->action, array('edit', 'delete'))) {
      $postId = (int) $this->request->params['pass'][0];
      if ($this->Post->isOwnedBy($postId, $user['id'])) {
        return true;
      }
    }

    return parent::isAuthorized($user);
  }


}
