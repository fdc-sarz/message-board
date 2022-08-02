<?php
App::uses('MessageThread', 'Model');

/**
 * MessageThread Test Case
 */
class MessageThreadTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.message_thread'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MessageThread = ClassRegistry::init('MessageThread');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MessageThread);

		parent::tearDown();
	}

}
