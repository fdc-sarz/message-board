<?php
App::uses('AppModel', 'Model');
App::import('Message', 'Model');
/**
 * MessageThread Model
 *
 */
class MessageThread extends AppModel {
  
  public $displayField = 'id';
  
  public $belongsTo = [
    'Sender' => [
      'className' => 'User',
      'foreignKey' => 'uid',
      'fields' => ['id', 'name']
    ]
  ];
  
  public function afterSave($created, $options = array()) {
    if($created) {
      $mid = $this->data['MessageThread']['mid'];
      $thread_id = $this->data['MessageThread']['id'];
      $messageData = ['id' => $mid, 'last_response_id' => $thread_id];
      $message = new Message();
      $message->set($messageData);
      $message->save();
    }
  }
  
}
