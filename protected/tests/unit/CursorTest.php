<?

/**
 * Various tests for cursor handling
 */
class CursorTest extends TestBase
{
	// We use these to generate documents
	protected $fields = array(
		'a' => 'docA',
		'b' => 'docB',
		'c' => 'docC',
		'd' => 'docD',
		'e' => 'docE',
		'f' =>'docF',
	);

	/**
	 * Add some documents to the collection
	 */
	public function setUp() {
		BasicOperationsModel::model()->getCollection()->drop();

		foreach ($this->fields as $key=>$name) {
			$model = new BasicOperationsModel();
			$model->field1 = $name;
			$model->field2 = $key;
			$model->save();
		}
	}

	/**
	 * Test to find all as array
	 */
	public function testAllArray() {
		Yii::app()->mongodb->useCursor = false;
		$arr = BasicOperationsModel::model()->findAll();
		
		$this->assertTrue(is_array($arr));
		$this->assertEquals(count($this->fields), count($arr));
		
		$fields = $this->fields;
		foreach ($arr as $doc) {
			unset($fields[$doc->field2]);
		}
		$this->assertEquals(0, count($fields));
	}

	/**
	 * Test to find all as cursor
	 */
	public function testAllCursor() {
		Yii::app()->mongodb->useCursor = true;
		$arr = BasicOperationsModel::model()->findAll();
		
		$this->assertTrue($arr instanceof EMongoCursor);
		$this->assertEquals(count($this->fields), count($arr));
		
		$fields = $this->fields;
		foreach ($arr as $doc) {
			unset($fields[$doc->field2]);
		}
		$this->assertEquals(0, count($fields));
	}

}
