<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 */
class Message extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	
	public function canAccessMessage($mid, $uid) {
		$message = $this->find('first', [
			'fields' => ['Message.id'],
			'conditions' => [
				'Message.id' => $mid,
				'OR' => [
					'Message.sender' => $uid,
					'Message.recipient' => $uid
				]
			]
		]);
		return !!$message;
	}

}
