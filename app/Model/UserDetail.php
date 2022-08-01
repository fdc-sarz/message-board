<?php
App::uses('AppModel', 'Model');
/**
 * UserDetail Model
 *
 * @property User $User
 */
class UserDetail extends AppModel {

	public $belongsTo = array(
		'User' => [
			'className' => 'User',
			'foreignKey' => 'uid'
		]
	);
	
	public $displayField = 'id';
}
