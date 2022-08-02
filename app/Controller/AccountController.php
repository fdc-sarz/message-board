<?php

  class AccountController extends AppController {
    
    public $uses = ['User', 'UserDetail'];
    
    public function uploadPhoto() {
      if($this->request->is('post')) {
        $photo = $this->movePhoto();
        if(isset($photo['file_name'])) {
          // update db
          $this->UserDetail->set(['id' => (int)$this->Session->read('userDetail.UserDetail.id'), 'profile_picture' => $photo['file_name']]);
          $this->UserDetail->save();
          $user = $this->Auth->user();
          $this->updateSession();
          $this->redirect(['controller' => 'user', 'action' => 'dashboard']);
        } else {
          $this->set('form_errors', $photo['errors']);
        }
      }
    }
    
    public function editProfile() {
      $uid = $this->Auth->user('id');
      $userdetail = $this->UserDetail->findByUid($uid);
      if($this->request->is(['post', 'put'])) {
        $request_data = $this->request->data;
        $user_update = [
          'id' => $uid,
          'name' => $request_data['User']['name']
        ];
        $this->User->set($user_update);
        $valid_user = $this->User->validates();
        
        $user_detail_update = $request_data;
        $user_detail_update['UserDetail']['id'] = $userdetail['UserDetail']['id'];
        $photo = $this->movePhoto();
        if(isset($photo['file_name']) && $photo['file_name'] != 'no file') {
          $user_detail_update['UserDetail']['profile_picture'] = $photo['file_name'];
        } else {
          unset($user_detail_update['UserDetail']['profile_picture']);
        }
        $this->UserDetail->set($user_detail_update);
        $valid_user_detail = $this->UserDetail->validates();
        
        if($valid_user && $valid_user_detail && !isset($photo['errors'])) {
          $this->UserDetail->save();
          $this->User->save();
          $this->updateSession();
          $this->redirect(['controller' => 'user', 'action' => 'dashboard']);
        } else {
          $this->set('form_errors', array_merge($photo['errors'] ?? [], $this->User->validationErrors, $this->UserDetail->validationErrors));
        }
        
      } else {
        $this->request->data = $userdetail;
        $this->request->data['User']['name'] = $this->Auth->user('name');
      }
      $this->set('birth_date', $this->request->data['UserDetail']['birth_date'] ? date('m/d/Y', strtotime($this->request->data['UserDetail']['birth_date'])) : '');
    }
    
    public function editEmail() {
      if($this->request->is(['post', 'put'])) {
        $request_data = [
          'id' => $this->Auth->user('id'),
          'email' => $this->request->data['User']['email'],
          'modified_ip' => $this->request->clientIp()
        ];
        $this->User->set($request_data);
        if($this->User->validates()) {
          $this->User->save();
          $this->updateSession();
          $this->redirect(['controller' => 'user', 'action' => 'dashboard']);
        }
        $this->set('form_errors', $this->User->validationErrors);
      } else {
        $this->request->data['User']['email'] = $this->Auth->user('email');
      }
    }
    
    public function changePassword() {
      if($this->request->is(['post', 'put'])) {
        $request_data = [
          'id' => $this->Auth->user('id'),
          'password' => $this->request->data['User']['password'] ?? '',
          'password_confirmation' => $this->request->data['User']['password_confirmation'] ?? '',
          'modified_ip' => $this->request->clientIp()
        ];
        $this->User->set($request_data);
        if($this->User->validates()) {
          $this->User->save();
          $this->redirect(['controller' => 'user', 'action' => 'dashboard']);
        }
        $this->set('form_errors', $this->User->validationErrors);
      }
    }
    
    private function updateSession() {
      $last_login = $this->Session->read('userDetail.last_login');
      $user = $this->User->findById($this->Auth->user('id'));
      $userData = $user['User'];
      unset($user['User']);
      $newSession = array_merge($userData, $user);
      $newSession['last_login'] = $last_login;
      $this->Session->write('userDetail', $newSession);
    }
    
    private function movePhoto() {
      $profile_picture = $this->data['UserDetail']['profile_picture'];
      if(isset($profile_picture) && $profile_picture['name'] != '') {
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
            return ['file_name' => $new_file_name];
          } else {
            return ['errors' => ['profile_picture' => __('errors.unable_to_upload')]];
          }
        } else {
          return ['errors' => ['profile_picture' => $validate_image]];
        }
      }
      return ['file_name' => 'no file'];
    }
  }
  
?>