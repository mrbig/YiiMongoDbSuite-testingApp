<?php

class ArrayBehaviorTest extends TestBase
{

	/**
	 * Cleaning the db before the test
	 */
	public static function setUpBeforeClass()
	{
		parent::setUp();
		
		// This is required to enshure, we have a db connection
		Yii::app()->mongodb->getDbInstance();

		Yii::app()->mongodb->dropDb();
	}
	
	/**
	 * We use dependent test, so dropping the db inbetween is unnecessary
	 */
	public function setUp() {
	}

	/**
	 * Test creating an embedded document
	 */
	public function testCreate() {
		$doc = new BasicArrayParentModel();
		$doc->_id = 'testdocument';
		$doc->field1 = 'val1';
		
		// Add children
		$child = new BasicArrayChildModel();
		$child->field1 = 'child1';
		$doc->children[] = $child;
		
		$child = new BasicArrayChildModel();
		$child->field1 = 'child2';
		$doc->children[] = $child;
		
		// Saving to the db
		$this->assertTrue($doc->save());
		return $doc;
	}
	
	/**
	 * Test that after adding children to the document would set the getOwner method
	 * @depends testCreate
	 */
	public function testOwnerBeforeSave($doc) {
		$this->markTestIncomplete('There is no way to implement this with the EEmbeddedArraysBehavior');
		$this->assertInstanceof('BasicArrayParentModel', $doc->children[0]->getOwner());
		$this->assertEquals($doc->_id, $doc->children[0]->getOwner()->_id);
	}
	
	/**
	 * Test loading the document back
	 *  @depends testCreate
	 */
	public function testLoading($ref) {
		
		// Loading the document
		$doc = BasicArrayParentModel::model()->findByPk('testdocument');
		
		$this->assertInstanceof('BasicArrayParentModel', $doc);
		
		$this->assertEquals(2, count($doc->children));
		
		for ($i=0; $i<2; $i++) {
			$this->assertEquals($ref->children[$i]->field1, $doc->children[$i]->field1);
		}
		
		return $doc;
	}
	
	/**
	 * Test the getOwner method on the loaded document
	 * @depends testLoading
	 */
	public function testOwnerAfterLoad($doc) {
		$this->assertInstanceof('BasicArrayParentModel', $doc->children[0]->getOwner());
		$this->assertEquals($doc->_id, $doc->children[0]->getOwner()->_id);
	}
}
