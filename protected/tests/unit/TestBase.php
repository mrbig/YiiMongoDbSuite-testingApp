<?php

class TestBase extends CTestCase
{
	public function setUp()
	{
		parent::setUp();
		
		// This is required to enshure, we have a db connection
		Yii::app()->mongodb->getDbInstance();

		Yii::app()->mongodb->dropDb();
	}
}