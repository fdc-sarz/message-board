<?php

  class DocumentController extends AppController {
    
    public $uses = ['UserDetail'];
    
    public function beforeFilter() {
      $this->Auth->allow();
    }
    
    public function renderProfilePicture($userId) {
      $userDetail = $this->UserDetail->find('first', [
        'conditions' => ['uid' => $userId]
      ]);
      $profile_picture_path = '';
      if($userDetail && $userDetail['UserDetail']['profile_picture'] != NULL) {
        $profile_picture_path = WWW_ROOT . '/files/profile_picture/' . $userDetail['UserDetail']['uid'] . '/' . $userDetail['UserDetail']['profile_picture'];
      }
      if(!file_exists($profile_picture_path)) {
        $profile_picture_path = WWW_ROOT . '/files/default/profile_picture.jpeg';
      }
      $mime = getimagesize($profile_picture_path)['mime'];
      header('Content-Type: ' . $mime);
      readfile($profile_picture_path);
      die;
    }
  }
  
?>