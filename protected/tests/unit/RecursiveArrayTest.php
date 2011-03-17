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
	
}
