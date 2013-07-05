<?php

abstract class TableDataprovider
{
	public static function getTestGetContentType()
	{
		$data[] = array('com_foftest', 'foobar', 'com_foftest.foobar', 'Wrong content type');
		$data[] = array('com_foftest', 'foobars', 'com_foftest.foobar', 'Wrong content type');

		return $data;
	}

	public static function getTestBind()
	{
		//TODO Create a dataset with "rules", too

		// Check when onBeforeBind is false
		$data[] = array(false, false, array(), array(), array());

		// Check binding with array
		$data[] = array(true, true, array('title' => 'Binded array title'), array(), array(
			array(
				'field' => 'title',
				'value' => 'Binded array title',
				'msg'   => 'Wrong value binded')
		)
		);

		// Check binding with object
		$bind   = new stdClass();
		$bind->title = 'Binded object title';

		$data[] = array(true, true, $bind, array(), array(
			array(
				'field' => 'title',
				'value' => 'Binded object title',
				'msg'   => 'Wrong value binded')
		)
		);

		// Check binding with array and array ignore fields
		$bind   = new stdClass();
		$bind->title = 'Binded object title';
		$bind->slug  = 'Ignored field';

		$data[] = array(true, true, $bind, array('slug'), array(
			array(
				'field' => 'title',
				'value' => 'Binded object title',
				'msg'   => 'Wrong value binded'),
			array(
				'field' => 'slug',
				'value' => '',
				'msg'   => 'Ignored field binded')
		)
		);

		// Check binding with array and string ignore fields
		$bind              = new stdClass();
		$bind->title       = 'Binded object title';
		$bind->slug        = 'Ignored field';
		$bind->created_by  = 'Ignored field';

		$data[] = array(true, true, $bind, 'slug created_by', array(
			array(
				'field' => 'title',
				'value' => 'Binded object title',
				'msg'   => 'Wrong value binded'),
			array(
				'field' => 'slug',
				'value' => '',
				'msg'   => 'Ignored field binded'),
			array(
				'field' => 'created_by',
				'value' => '',
				'msg'   => 'Ignored field binded')
		)
		);

		return $data;
	}

	public static function getTestStore()
	{
		// Test vs onBefore returns false
		$data[] = array(
			array('before' => false, 'after' => false),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid'      => 3,
				'alias'       => '',
				'assetkey'    => 'com_foftest.foobar',
				'bind'        => array('title' => 'Modified title', 'enabled' => 0),
				'nullable'    => '',
				'updateNulls' => false
			),
			array('return' => false, 'more' => false)
		);

		// Test vs onAfter returns false
		$data[] = array(
			array('before' => true, 'after' => false),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid'      => 3,
				'alias'       => '',
				'assetkey'    => 'com_foftest.foobar',
				'bind'        => array('title' => 'Modified title', 'enabled' => 0),
				'nullable'    => '',
				'updateNulls' => false
			),
			array('return' => false, 'more' => false)
		);

		// Update test with assets, without updating nulls
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid'      => 3,
				'alias'       => '',
				'assetkey'    => 'com_foftest.foobar',
				'bind'        => array('title' => 'Modified title', 'enabled' => 0),
				'nullable'    => array('created_by' => null),
				'updateNulls' => false
			),
			array('return' => true, 'more' => true)
		);

		// Update test with assets, updating nulls
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid'      => 3,
				'alias'       => '',
				'assetkey'    => 'com_foftest.foobar',
				'bind'        => array('title' => 'Modified title', 'enabled' => 0),
				'nullable'    => array('created_by' => null),
				'updateNulls' => true
			),
			array('return' => true, 'more' => true)
		);

		// Update test without assets
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_bares', 'id' => 'foftest_bare_id'),
			array(
				'loadid'      => 3,
				'alias'       => '',
				'assetkey'    => '',
				'bind'        => array('title'=> 'Modified title'),
				'nullable'    => '',
				'updateNulls' => false
			),
			array('return' => true, 'more' => true)
		);

		// Insert new object with assets, updating nulls
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid'   => '',
				'alias'    => '',
				'assetkey' => 'com_foftest.foobar',
				'bind'     => array('title' => 'New element', 'enabled' => 0),
				'nullable' => array('created_by' => null),
				'updateNulls' => true
			),
			array('return' => true, 'more' => true)
		);

		// Insert new object with assets, without updating nulls
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid'      => '',
				'alias'       => '',
				'assetkey'    => 'com_foftest.foobar',
				'bind'        => array('title' => 'New element', 'enabled' => 0),
				'nullable'    => array('created_by' => null),
				'updateNulls' => false
			),
			array('return' => true, 'more' => true)
		);

		// Update test with assets and alias
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobaraliases', 'id' => 'id_foobar_aliases'),
			array(
				'loadid'      => 3,
				'alias'       => 'fo_asset_id',
				'assetkey'    => '',
				'bind'        => array('fo_title' => 'Modified title', 'fo_enabled' => 0),
				'nullable'    => '',
				'updateNulls' => false
			),
			array('return' => true, 'more' => true)
		);

		return $data;
	}

	public static function getTestMove()
	{
		// Test vs table not loaded
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 0, 'delta'  => 1, 'where' => ''),
			array('return' => false)
		);

		// Test vs onBeforeMove returns false
		$data[] = array(
			array('before' => false, 'after' => false),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 4, 'delta'  => 0, 'where' => ''),
			array('return' => false)
		);

		// Test vs delta = 0 and onAfterMove returns false
		$data[] = array(
			array('before' => true, 'after' => false),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 4, 'delta'  => 0, 'where' => ''),
			array('return' => false)
		);

		// Test vs delta = 0 and onAfterMove returns true
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 4, 'delta'  => 0, 'where' => ''),
			array('return' => true, 'more' => false)
		);

		// Test vs delta = 1 (everything else ok) inner record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 4, 'delta'  => 1, 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 5,
				'msg'    => 'Move() wrong ordering with delta = 1, no where',
				'find'   => array(
					'id'    => 5,
					'value' => 4,
					'msg'   => 'Move() wrong record swapping with delta = 1, no where'
				)
			)
		);

		// Test vs delta = 1 (everything else ok) outer record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 5, 'delta'  => 1, 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 5,
				'msg'    => 'Move() wrong ordering with delta = 1, no where'
			)
		);

		// Test vs delta = -1 (everything else ok) inner record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 4, 'delta'  => -1, 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 3,
				'msg'    => 'Move() wrong ordering with delta = -1, no where',
				'find'   => array(
					'id'    => 3,
					'value' => 4,
					'msg'   => 'Move() wrong record swapping with delta = -1, no where'
				)

			)
		);

		// Test vs delta = -1 (everything else ok) outer record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 1, 'delta'  => -1, 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 1,
				'msg'    => 'Move() wrong ordering with delta = -1, no where'
			)
		);

		// Test vs delta = 1 and where (everything else ok), inner record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 2, 'delta'  => 1, 'where' => 'enabled = 0'),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 4,
				'msg'    => 'Move() wrong ordering with delta = 1, where enabled = 0',
				'find'   => array(
					'id'    => 4,
					'value' => 2,
					'msg'   => 'Move() wrong record swapping with delta = 1, where enabled = 0'
				)
			)
		);

		// Test vs delta = 1 and where (everything else ok), outer record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 4, 'delta'  => 1, 'where' => 'enabled = 0'),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 4,
				'msg'    => 'Move() wrong ordering with delta = 1, where enabled = 0',
			)
		);

		// Test vs delta = -1 and where (everything else ok), outer record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 2, 'delta'  => -1, 'where' => 'enabled = 0'),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 2,
				'msg'    => 'Move() wrong ordering with delta = -1, where enabled = 0',
			)
		);

		// Test vs delta = -1 and where (everything else ok), inner record
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id'     => 4, 'delta'  => -1, 'where' => 'enabled = 0'),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 2,
				'msg'    => 'Move() wrong ordering with delta = 1, where enabled = 0',
				'find'   => array(
					'id'    => 2,
					'value' => 4,
					'msg'   => 'Move() wrong record swapping with delta = 1, where enabled = 0'
				)
			)
		);

		// Test vs delta = 1, using aliases
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobaraliases', 'id' => 'id_foobar_aliases'),
			array('id'     => 4, 'alias' => 'fo_ordering', 'delta'  => 1, 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'value'  => 5,
				'msg'    => 'Move() wrong ordering with delta = 1, no where',
				'find'   => array(
					'id'    => 5,
					'value' => 4,
					'msg'   => 'Move() wrong record swapping with delta = 1, no where'
				)
			)
		);

		return $data;
	}

	public static function getTestReorder()
	{
		// Test vs onBeforeReorder returns false
		$data[] = array(
			array('before' => false, 'after' => false),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id' => '', 'ordering' => '', 'where' => ''),
			array('return' => false)
		);

		// Test vs reorder, positive number, no where
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id' => 3, 'ordering' => 100, 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'msg'    => 'Reorder() wrong reordered recordset with positive number, no where',
				'list'   => array(
					array('foftest_foobar_id' => 1, 'ordering' => 1),
					array('foftest_foobar_id' => 2, 'ordering' => 2),
					array('foftest_foobar_id' => 4, 'ordering' => 3),
					array('foftest_foobar_id' => 5, 'ordering' => 4),
					array('foftest_foobar_id' => 3, 'ordering' => 5)
				)
			)
		);

		// Test vs reorder, negative number, no where
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id' => 3, 'ordering' => -100, 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'msg'    => 'Reorder() wrong reordered recordset with negative number, no where',
				'list'   => array(
					array('foftest_foobar_id' => 3, 'ordering' => -100),
					array('foftest_foobar_id' => 1, 'ordering' => 1),
					array('foftest_foobar_id' => 2, 'ordering' => 2),
					array('foftest_foobar_id' => 4, 'ordering' => 3),
					array('foftest_foobar_id' => 5, 'ordering' => 4)
				)
			)
		);

		// Test vs reorder, positive number, where enabled = 1
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id' => 3, 'ordering' => 100, 'where' => 'enabled = 1'),
			array(
				'return' => true,
				'more'   => true,
				'msg'    => 'Reorder() wrong reordered recordset with positive number, where enabled = 1',
				'list'   => array(
					array('foftest_foobar_id' => 1, 'ordering' => 1),
					array('foftest_foobar_id' => 5, 'ordering' => 2),
					array('foftest_foobar_id' => 3, 'ordering' => 3)
				)
			)
		);

		// Test vs reorder, negative number, where enabled = 1
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('id' => 3, 'ordering' => -100, 'where' => 'enabled = 1'),
			array(
				'return' => true,
				'more'   => true,
				'msg'    => 'Reorder() wrong reordered recordset with negative number, where enabled = 1',
				'list'   => array(
					array('foftest_foobar_id' => 3, 'ordering' => -100),
					array('foftest_foobar_id' => 1, 'ordering' => 1),
					array('foftest_foobar_id' => 5, 'ordering' => 2)
				)
			)
		);

		// Test vs aliased reorder, positive number, no where
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table'  => 'jos_foftest_foobaraliases', 'id' => 'id_foobar_aliases'),
			array('id' => 3, 'ordering' => 100, 'alias' => 'fo_ordering', 'where' => ''),
			array(
				'return' => true,
				'more'   => true,
				'msg'    => 'Reorder() wrong aliased reordered recordset with positive number, no where',
				'list'   => array(
					array('id_foobar_aliases' => 1, 'fo_ordering' => 1),
					array('id_foobar_aliases' => 2, 'fo_ordering' => 2),
					array('id_foobar_aliases' => 4, 'fo_ordering' => 3),
					array('id_foobar_aliases' => 5, 'fo_ordering' => 4),
					array('id_foobar_aliases' => 3, 'fo_ordering' => 5)
				)
			)
		);

		return $data;
	}

	public static function getTestCheckout()
	{
		// Test vs table without checkout support
		$data[] = array(
			array('table' => 'jos_foftest_bares', 'id' => 'foftest_bare_id'),
			array(
				'loadid' => '',
				'user'   => 99,
				'id'     => 5,
				'alias'  => ''
			),
			array(
				'return' => true,
				'more'   => false
			)
		);

		// Test vs table, no id given
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid' => '',
				'user'   => 99,
				'id'     => null,
				'alias'  => ''
			),
			array(
				'return' => false,
				'more'   => false
			)
		);

		// Test vs table, id given
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid' => '',
				'user'   => 99,
				'id'     => 4,
				'alias'  => ''
			),
			array(
				'return' => true,
				'more'   => true
			)
		);

		// Test vs table, no id given, load it first
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid' => 4,
				'user'   => 99,
				'id'     => null,
				'alias'  => ''
			),
			array(
				'return' => true,
				'more'   => true
			)
		);

		// Test vs aliased table, no id given, load it first
		$data[] = array(
			array('table' => 'jos_foftest_foobaraliases', 'id' => 'id_foobar_aliases'),
			array(
				'loadid' => 4,
				'user'   => 99,
				'id'     => null,
				'alias'  => array(
					'lockby' => 'fo_locked_by',
					'lockon' => 'fo_locked_on'
				)
			),
			array(
				'return' => true,
				'more'   => true
			)
		);

		return $data;
	}

	public static function getTestCheckin()
	{
		// Test vs table without checkin support
		$data[] = array(
			array('table' => 'jos_foftest_bares', 'id' => 'foftest_bare_id'),
			array(
				'loadid' => '',
				'id'     => 5,
				'alias'  => ''
			),
			array(
				'return' => true,
				'more'   => false
			)
		);

		// Test vs table, no id given
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid' => '',
				'id'     => null,
				'alias'  => ''
			),
			array(
				'return' => false,
				'more'   => false
			)
		);

		// Test vs table, id given
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid' => '',
				'id'     => 4,
				'alias'  => ''
			),
			array(
				'return' => true,
				'more'   => true
			)
		);

		// Test vs table, no id given, load it first
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'loadid' => 4,
				'id'     => null,
				'alias'  => ''
			),
			array(
				'return' => true,
				'more'   => true
			)
		);

		// Test vs aliased table, no id given, load it first
		$data[] = array(
			array('table' => 'jos_foftest_foobaraliases', 'id' => 'id_foobar_aliases'),
			array(
				'loadid' => 4,
				'id'     => null,
				'alias'  => array(
					'lockby' => 'fo_locked_by',
					'lockon' => 'fo_locked_on'
				)
			),
			array(
				'return' => true,
				'more'   => true
			)
		);

		return $data;
	}

	public static function getTestIsCheckedOut()
	{
		// Unlocked record, no user
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'id'        => 4,
				'alias'     => '',
				'with'      => ''
			),
			array(
				'return'    => false,
				'msg'       => 'isCheckedOut: Wrong return value, unlocked record with no user'
			)
		);

		// Unlocked record, with user
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'id'        => 4,
				'alias'     => '',
				'with'      => 42
			),
			array(
				'return'    => false,
				'msg'       => 'isCheckedOut: Wrong return value, unlocked record with user'
			)
		);

		// Locked record, without user
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'id'        => 5,
				'alias'     => '',
				'with'      => ''
			),
			array(
				'return'    => true,
				'msg'       => 'isCheckedOut: Wrong return value, locked record without user'
			)
		);

		// Locked record, with user
		$data[] = array(
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'id'        => 5,
				'alias'     => '',
				'with'      => 42
			),
			array(
				'return'    => true,
				'msg'       => 'isCheckedOut: Wrong return value, locked record with user'
			)
		);

		// Locked record, without user
		$data[] = array(
			array('table' => 'jos_foftest_foobaraliases', 'id' => 'id_foobar_aliases'),
			array(
				'id'        => 5,
				'alias'     => array(
					'lockon'  => 'fo_locked_on',
					'lockby'  => 'fo_locked_by'
				),
				'with'      => 42
			),
			array(
				'return'    => true,
				'msg'       => 'isCheckedOut: Wrong return value, locked record with user'
			)
		);

		return $data;
	}

	public static function getTestCopy()
	{
		// Test with onBefore returning false
		$data[] = array(
			array('before' => false, 'after' => true),
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('alias'  => '', 'loadid' => '', 'cids' => 1),
			array('return' => true,	'more' => true,	'cids' => array(1 => 0))
		);

		// Test with no ids
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('alias'  => '','loadid' => '','cids' => ''),
			array('return' => false, 'more' => false)
		);

		// Single record, loading it first
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('alias'  => '', 'loadid' => 1, 'cids' => ''),
			array('return' => true, 'more' => true, 'cids' => array(1 => 6))
		);

		// Single record, passing it to the copy function
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('alias'  => '', 'loadid' => '', 'cids' => 2),
			array('return' => true,	'more' => true,	'cids' => array(2 => 6))
		);

		// Single record, checked out (so it shold be skipped)
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array('alias'  => '', 'loadid' => '', 'cids' => 5),
			array('return' => true, 'more' => true,	'cids' => array(5 => 0))
		);

		// Multiple records, some of them shouldn't be copied
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table' => 'jos_foftest_foobars', 'id' => 'foftest_foobar_id'),
			array(
				'alias'  => '',
				'loadid' => '',
				'cids'   => array(1,3,4,5)
			),
			array(
				'return' => true,
				'more'   => true,
				'cids'   => array(
					1 => 6,
					3 => 7,
					4 => 8,
					5 => 0,
				)
			)
		);

		// Test vs bare table (no special columns)
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table' => 'jos_foftest_bares', 'id' => 'foftest_bare_id'),
			array(
				'alias'  => '',
				'loadid' => '',
				'cids'   => array(1,2,3)
			),
			array(
				'return' => true,
				'more'   => true,
				'cids'   => array(
					1 => 4,
					2 => 5,
					3 => 6
				)
			)
		);

		// Test vs table with aliases
		$data[] = array(
			array('before' => true, 'after' => true),
			array('table' => 'jos_foftest_foobaraliases', 'id' => 'id_foobar_aliases'),
			array(
				'alias'  => array(
					'slug'        => 'fo_slug',
					'title'       => 'fo_title',
					'created_by'  => 'fo_created_by',
					'created_on'  => 'fo_created_on',
					'modified_by' => 'fo_modified_by',
					'modified_on' => 'fo_modified_on',
					'locked_by'   => 'fo_locked_by',
					'locked_on'   => 'fo_locked_on'
				),
				'loadid' => '',
				'cids'   => array(1,2,5)
			),
			array(
				'return' => true,
				'more'   => true,
				'cids'   => array(
					1 => 6,
					2 => 7,
					5 => 0
				)
			)
		);

		return $data;
	}
}