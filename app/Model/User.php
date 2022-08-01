<?php
App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');

class User extends AppModel {

	public $displayField = 'name';
	
	public $hasOne = [
		'UserDetail' => [
			'className' => 'UserDetail',
			'foreignKey' => 'uid'
		]
	];
	
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => 'notBlank',
				'message' => 'error.name.required'
			],
			'lengthBetween' => [
				'rule' => ['lengthBetween', 5, 20],
				'message' => 'error.name.length'
			],
		],
		'email' => [
			'notBlank' => [
				'rule' => 'notBlank',
				'message' => 'error.email.required'
			],
			'email' => [
				'rule' => 'email',
				'message' => 'error.email.invalid'
			],
			'unique' => [
				'rule' => 'isUnique',
				'message' => 'error.email.unique'
			]
		],
		'password' => [
			'notBlank' => [
				'rule' => 'notBlank',
				'message' => 'error.password.required'
			],
			'minLength' => [
				'rule' => ['minLength', 8],
				'message' => 'error.password.minlen'
			],
			'password_confirm' => [
				'rule' => 'password_confirm',
				'message' => 'error.password.confirm'
			]
		]
	];
	
	public function updateLastLogin($id) {
		$loginData = ['id' => $id, 'last_login' => date('Y-m-d H:i:s')];
		$this->save($loginData);
	}
	
	public function beforeSave($options = [])
	{
		if(isset($this->data['User']['password'])) {
			$this->data['User']['password'] = Security::hash($this->data['User']['password'], null, true);
		}
		return true;
	}
	
	public function afterSave($created, $options = []) {
		if($created) {
			$data = ['uid' => $this->data['User']['id']];
			$this->UserDetail->set($data);
			$this->UserDetail->save();
		}
	}
	
	public function password_confirm() {
		if ($this->data['User']['password'] !== $this->data['User']['password_confirmation']) {
			return false;       
		}
		return true;
	}
	
	public function isValidImage($size, $ext) {
		$max_size = 3120000;
		if(!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
			return __('errors.invalid_file_type');
		}
		if($size > $max_size) {
			return __('errors.exceed_max_size');
		}
		return true;
	}
}
