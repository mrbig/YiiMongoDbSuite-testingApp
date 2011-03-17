<?php

/**
 * Testcases for recursive array handling
 */
class RecursiveArrayTest extends TestBase
{

	/**
	 * Attaching Behaviors to EMongoEmbeddedDocument was
	 * looking for onBeforeSave
	 */
	public function testAttachBehaviors() {
		$child = new RecursiveArrayChildModel();
	}
	
	/**
	 * Testing if saving and loading a document works
	 */
	public function testSaveLoad() {
		// Creating and saving a plain document
		$model = new RecursiveArrayParentModel();
		$model->idfield = 'parent';
		
		$child = new RecursiveArrayChildModel();
		$child->field='chield1';
		
		$leaf = new RecursiveArrayLeafModel();
		$leaf->field = 'leaf1';
		
		$child->children[] = $leaf;
		
		$model->children[] = $child;
		
		$this->assertTrue($model->save());
		
		// Loading the document again
		$doc = RecursiveArrayParentModel::model()->find(array('idfield' == 'parent'));
		
		$this->assertTrue($doc instanceof RecursiveArrayParentModel);
		
		// Checking first level
		$this->assertTrue(is_array($doc->children));
		$this->assertEquals(1, count($doc->children));
		$this->assertTrue($doc->children[0] instanceof RecursiveArrayChildModel);
		$this->assertEquals('chield1', $doc->children[0]->field);
		
		//Checkging second level
		$this->assertTrue(is_array($doc->children[0]->children));
		$this->assertEquals(1, count($doc->children[0]->children));
		$this->assertTrue($doc->children[0]->children[0] instanceof RecursiveArrayLeafModel);
		$this->assertEquals('leaf1', $doc->children[0]->children[0]->field);		
	}

}
