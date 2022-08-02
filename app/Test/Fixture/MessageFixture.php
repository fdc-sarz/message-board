<?php
/**
 * Message Fixture
 */
class MessageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'sender' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false),
		'recipient' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created_ip' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_ip' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'sender' => 1,
			'recipient' => 1,
			'created' => '2022-08-02 03:21:53',
			'created_ip' => 'Lorem ipsum dolor sit amet',
			'modified' => '2022-08-02 03:21:53',
			'modified_ip' => 'Lorem ipsum dolor sit amet'
		),
	);

}
