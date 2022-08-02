<?php

  class MessageController extends AppController {
    
    public $uses = [
      'User',
      'Message',
      'MessageThread'
    ];
    
    public $components = [
      'Paginator'
    ];
    
    public function index () {
      
    }
    
    public function addMessage($return = '') {
      if($this->request->is('post')) {
        $uid = $this->Auth->user('id');
        $data = $this->request->data;
        $errors = [];
        if(!isset($data['recipient']) || !is_numeric($data['recipient']) || $this->Auth->user('id') == $data['recipient']) {
          $errors[] = ['key' => 'recipient', 'message' => 'Invalid recipient data.'];
        } else {
          $recipient = $this->User->findById($data['recipient']);
          if(!$recipient) {
            $errors[] = ['key' => 'recipient', 'message' => 'Invalid recipient data.'];
          }
        }
        if(!isset($data['message']) || trim($data['message']) == '') {
          $errors[] = ['key' => 'message', 'message' => 'Message is required.'];
        }
        if(!$errors) {
          $messageData['Message'] = [
            'sender' => $uid,
            'recipient' => $data['recipient'],
            'created_ip' => $this->request->clientIp()
          ];
          $this->Message->set($messageData);
          $message = $this->Message->save();
          $threadData['MessageThread'] = [
            'mid' => $message['Message']['id'],
            'uid' => $uid,
            'message' => $data['message'],
            'created_ip' => $this->request->clientIp()
          ];
          $this->MessageThread->set($threadData);
          $this->MessageThread->save();
          $redirect_url = Router::url(['controller' => 'message', 'action' => 'index']);
          if($return == 'json') {
            die(json_encode(['success' => true, 'redirect' => $redirect_url]));
          } else {
            $this->redirect($redirect_url);
          }
        } else {
          if($return == 'json') {
            die(json_encode(['success' => false, 'errors' => $errors]));
          } else {
            $this->set('form_errors', $errors);
          }
        }
      }
    }
    
    public function show($id) {
      $uid = $this->Auth->user('id');
      $message = $this->Message->find('first', [
        'fields' => [
          'Message.*',
          'Sender.name',
          'Sender.email',
          'Recipient.name',
          'Recipient.email'
        ],
        'joins' => [
          [
            'table' => 'users',
            'alias' => 'Sender',
            'type' => 'INNER',
            'conditions' => 'Message.sender = Sender.id'
          ],
          [
            'table' => 'users',
            'alias' => 'Recipient',
            'type' => 'INNER',
            'conditions' => 'Message.recipient = Recipient.id'
          ]
        ],
        'conditions' => [
          'Message.id' => $id,
          'OR' => [
            'Message.sender' => $uid,
            'Message.recipient' => $uid
          ]
        ],
        'recursive' => -1
      ]);
      if(!$message) {
        $this->redirect(['controller' => 'message', 'action' => 'index']);
      }
      $this->set('message_data', $message);
    }
    
    public function deleteUserMessage($mid) {
      if(!$this->request->is('post')) {
        die(json_encode(['error' => true, 'message' => __d('errors', 'error.unauthorized_request')]));
      }
      $uid = $this->Auth->user('id');
      if(!$this->Message->canAccessMessage($mid, $uid)) {
        die(json_encode(['error' => true, 'message' => __d('errors', 'error.unauthorized_request')]));
      }
      $this->Message->delete($mid);
      die(json_encode(['success' => true]));
    }
    
    public function addThreadMessage($mid) {
      $uid = $this->Auth->user('id');
      if(!$this->Message->canAccessMessage($mid, $uid)) {
        die(json_encode(['error' => true, 'message' => __d('errors', 'error.unauthorized_request')]));
      }
      $thread_data = [
        'mid' => $mid,
        'uid' => $uid,
        'message' => $this->request->data['message'],
        'created_ip' => $this->request->clientIp()
      ];
      $this->MessageThread->set($thread_data);
      $message_thread = $this->MessageThread->save();
      $thread = $this->MessageThread->findById($message_thread['MessageThread']['id']);
      die(json_encode(['success' => true, 'message' => $thread]));
    }
    
    public function getUserMessages() {
      $last_mtid = $this->request->query['last_mtid'] ?? '';
      $limit = $this->request->query['limit'] ?? 10;
      $limit = is_numeric($limit) ? $limit : 10;
      $uid = $this->Auth->user('id');
      $conditions = [
        'OR' => [
          'Message.sender' => $uid,
          'Message.recipient' => $uid
        ]
      ];
      if($last_mtid != '') {
        $conditions['MessageThread.id <'] = $last_mtid;
      }
      // get messages
      $query_params = [
        'joins' => [
          [
            'table' => 'message_threads',
            'alias' => 'MessageThread',
            'type' => 'INNER',
            'conditions' => 'Message.last_response_id = MessageThread.id'
          ],
          [
            'table' => 'users',
            'alias' => 'User',
            'type' => 'INNER',
            'conditions' => 'MessageThread.uid = User.id'
          ]
        ],
        'order' => 'MessageThread.id DESC',
        'recursive' => -1
      ];
      $fields = [
        'fields' => [
          'Message.id',
          'MessageThread.id',
          'MessageThread.message',
          'MessageThread.created',
          'User.id',
          'User.name'
        ]
      ];
      $this->Paginator->settings = (array_merge($query_params, $fields, ['conditions' => $conditions, 'limit' => $limit]));
      $messages = $this->Paginator->paginate('Message');
      // $messages = $this->Message->find('all', array_merge($query_params, $fields, ['conditions' => $conditions, 'limit' => $limit]));
      if(count($messages) == 0) {
        die(json_encode(['success' => true, 'messages' => [], 'more_message' => false, 'last_mtid' => $last_mtid]));
      }
      // get last message for more messages
      $last_message = end($messages);
      $last_thread_id = $last_message['MessageThread']['id'];
      // check if there is more messages
      $conditions['MessageThread.id <'] = $last_thread_id;
      $more_message = $this->Message->find('first', array_merge($query_params, ['fields' => 'Message.id', 'conditions' => $conditions]));
      die(json_encode([
        'success' => true,
        'messages' => $messages,
        'more_message' => !!$more_message,
        'last_mtid' => $last_thread_id
      ]));
    }
    
    public function getThreadMessages($mid) {
      $last_mtid = $this->request->query['last_mtid'] ?? '';
      $limit = $this->request->query['limit'] ?? 10;
      $limit = is_numeric($limit) ? $limit : 10;
      $uid = $this->Auth->user('id');
      
      if(!$this->Message->canAccessMessage($mid, $uid)) {
        die(json_encode(['error' => true, 'message' => __d('errors', 'error.unauthorized_request')]));
      }
      
      $conditions = ['MessageThread.mid' => $mid];
      if($last_mtid != '') {
        $conditions['MessageThread.id <'] = $last_mtid;
      }
      $threads = $this->MessageThread->find('all', [
        'fields' => [
          'MessageThread.id',
          'MessageThread.message',
          'MessageThread.created',
          'Sender.id',
          'Sender.name'
        ],
        'joins' => [
          [
            'table' => 'users',
            'alias' => 'Sender',
            'type' => 'INNER',
            'conditions' => 'MessageThread.uid = Sender.id'
          ]
        ],
        'conditions' => $conditions,
        'limit' => $limit,
        'order' => 'MessageThread.id DESC',
        'recursive' => -1
      ]);
      if(count($threads) == 0) {
        die(json_encode(['success' => true, 'messages' => [], 'more_message' => false, 'last_mtid' => $last_mtid]));
      }
      // get last thread for more threads
      $last_message = end($threads);
      $last_thread_id = $last_message['MessageThread']['id'];
      // check if there is more messages
      $conditions['MessageThread.id <'] = $last_thread_id;
      $more_message = $this->MessageThread->find('first', [
        'fields' => 'MessageThread.id',
        'conditions' => $conditions
      ]);
      die(json_encode([
        'success' => true,
        'messages' => $threads,
        'more_message' => !!$more_message,
        'last_mtid' => $last_thread_id
      ]));
    }
    
  }

?>