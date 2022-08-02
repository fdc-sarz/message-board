<?php

  class UserController extends AppController {
    
    public $components = ['Paginator'];
    
    public function beforeFilter() {
      // die(var_dump($this->Auth->user()));
    }
    
    public function profile($id) {
      $user = $this->User->findById($id);
      if(!$user) {
        $this->redirect(['controller' => 'user', 'action' => 'dashboard']);
      }
      $this->set('user', $user);
    }
    
    public function dashboard() {
    }
    
    public function loadRecipients() {
      $limit = $this->request->query['limit'] ?? 10;
      $limit = is_numeric($limit) ? $limit : 10;
      $search = $this->request->query['search'] ?? '';
      $this->Paginator->settings = [
        'fields' => [
          'User.id',
          'User.name'
        ],
        'conditions' => [
          'User.name LIKE' => "%$search%",
          'User.id <>' => $this->Auth->user('id')
        ],
        'limit' => $limit,
        'order' => 'User.name ASC'
      ];
      $users = $this->Paginator->paginate('User');
      die(json_encode(['items' => $users]));
    }
    
    public function logout() {
      $this->Session->delete('userDetail');
      $this->redirect($this->Auth->logout());
    }
    
  }
?>