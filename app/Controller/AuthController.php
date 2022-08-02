<?php

  class AuthController extends AppController {
    
    public $uses = [
      'User'
    ];
    
    public function beforeFilter() {
      $this->Auth->allow();
      if($this->Auth->user()) {
        $this->redirect(Router::url(['controller' => 'user', 'action' => 'profile']));
      }
    }
    
    public function login() {
      if($this->request->is('post')) {
        if($this->Auth->login()) {
          // session user data
          $this->Session->write('userDetail', $this->Auth->user());
          $this->User->updateLastLogin($this->Auth->user('id'));
          $this->redirect(['controller' => 'user', 'action' => 'profile']);
        } else {
          $this->set('form_errors', array('email' => [ __d('errors', 'error.invalid_login_detail') ]));
        }
      }
    }
    
    public function register($return = '') {
      if($this->request->is('post')) {
        $request_data = $this->request->data;
        $request_data['User']['created_ip'] = $this->request->clientIp();
        $this->User->set($request_data);
        if($this->User->validates()) {
          $this->User->save();
          // $this->Flash->success(__d('message_board', 'message.register.success'));
          if($return != 'json') {
            $this->redirect(['controller' => 'auth', 'action' => 'registerSuccess']);
          } else {
            $return_data = [
              'success' => true,
              'message' => __d('message_board', 'message.register.success'),
              'redirect' => Router::url(['controller' => 'auth', 'action' => 'registerSuccess'])
            ];
          }
        } else {
          if($return != 'json') {
            $this->set('form_errors', $this->User->validationErrors);
          } else {
            $errors = [];
            foreach($this->User->validationErrors as $key => $error) {
              $errors[] = ['key' => $key, 'message' => __d('errors', $error[0])];
            }
            $return_data = [
              'success' => false,
              'errors' => $errors
            ];
          }
        }
        if($return == 'json') {
          die(json_encode($return_data));
        }
      }
    }
    
    public function registerSuccess() {
    }
    
    public function isUniqueEmail() {
      if($this->request->is('post')) {
        $data['success'] = true;
        $user = $this->User->find('first', [
          'conditions' => [
            'User.id' => $this->request->data['email']
          ]
        ]);
        $data['unique'] = !$user;
        if(!$data['unique']) {
          $data['message'] = __d('errors', 'error.email.unique');
        } else {
          $data['message'] = __d('message_board', 'success.email.available');
        }
      } else {
        $data = ['success' => false, 'message' => __d('errors', 'error.unauthorized_request')];
      }
      die(json_encode($data));
    }
    
  }
  
?>