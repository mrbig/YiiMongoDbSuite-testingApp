<?php

class BasicArrayParentModel extends BasicTestModel
{
	public $children = array();
	
	public $field1;
	
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 *  Return the array config
	 *  @return array
	 */
	public function behaviors() {
		return array(
			array(
				'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
				'arrayPropertyName' => 'children',
				'arrayDocClassName' => 'BasicArrayChildModel',
			)
		);
	}
	
}