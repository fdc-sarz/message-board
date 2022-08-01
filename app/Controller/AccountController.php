<?php

  class AccountController extends AppController {
    
    public $uses = ['User', 'UserDetail'];
    
    public function uploadPhoto() {
      if($this->request->is('post')) {
        $profile_picture = $this->data['User']['profile_picture'];
        $size = $profile_picture['size'];
        $ext = pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
        $validate_image = $this->User->isValidImage($size, $ext);
        if($validate_image === true) {
          $uid = $this->Auth->user('id');
          $new_file_name = strtotime('now') . '.' . $ext;
          $profile_picture_path = 'files/profile_picture';
          if(!is_dir(WWW_ROOT . $profile_picture_path)) {
            mkdir(WWW_ROOT . $profile_picture_path);
          }
          if(!is_dir(WWW_ROOT . $profile_picture_path . '/' . $uid)) {
            mkdir(WWW_ROOT . $profile_picture_path . '/' . $uid);
          }
          if(move_uploaded_file($profile_picture['tmp_name'], WWW_ROOT . $profile_picture_path . '/' . $uid . '/' . $new_file_name)) {
            // update db
            $this->UserDetail->set(['id' => (int)$this->Session->read('userDetail.UserDetail.id'), 'profile_picture' => $new_file_name]);
            $this->UserDetail->save();
            $user = $this->Auth->user();
            $last_login = $this->Session->read('userDetail.last_login');
            $user['last_login'] = $last_login;
            
            $this->Session->write('userDetail', $user);
            $this->redirect(['controller' => 'user', 'action' => 'profile']);
          } else {
            $this->set('form_errors', ['profile_picture' => __('errors.unable_to_upload')]);
          }
        } else {
          $this->set('form_errors', ['profile_picture' => $validate_image]);
        }
      }
    }
  }
  
?>