<?php

  class UserController extends AppController {
    
    public function beforeFilter() {
      // die(var_dump($this->Auth->user()));
    }
    
    public function profile() {
      $this->User->updateLastLogin($this->Session->read('userDetail.id'));
    }
    
    public function logout() {
      $this->Session->delete('userDetail');
      $this->redirect($this->Auth->logout());
    }
    
  }
?>