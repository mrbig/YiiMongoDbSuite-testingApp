<?php

class RecursiveArrayChildModel extends EMongoEmbeddedDocument {

	public $field;
	
	public $children = array();

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	/**
	 * Returnt the behaviors config
	 * 
	 * @return array
	 */
	public function behaviors(){

		return array(
			array(
				'class'=>'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
				'arrayPropertyName'=>'children',
				'arrayDocClassName'=> 'RecursiveArrayLeafModel'
			),
		);
	}
}