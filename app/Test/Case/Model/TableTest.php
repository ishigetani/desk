<?php
App::uses('Table', 'Model');

/**
 * Table Test Case
 *
 */
class TableTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.table'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Table = ClassRegistry::init('Table');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Table);

		parent::tearDown();
	}

}
