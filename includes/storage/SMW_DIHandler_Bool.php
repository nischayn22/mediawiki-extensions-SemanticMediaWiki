<?php
/**
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * This class implements Store access to Boolean data items.
 *
 * @since SMW.storerewrite
 *
 * @author Nischay Nahata
 * @ingroup SMWDataItemsHandlers
 */
class SMWDIHandlerBoolean extends SMWDataItemHandler {

	/**
	 * Method to return array of fields and indexes for a DI type
	 *
	 * @return array
	 */
	static public function getTableFields(){
		return array(
			'objectfields' => array( 'value_xsd' => 't', 'value_num' => 'f' ),
			'indexes' => array( 'value_num', 'value_xsd' ),
			);
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 *
	 * @return array
	 */
	public function getWhereConds( SMWDataItem $dataItem ) {
		if ( $dataItem->getBoolean() ) {
			return array(
				'value_xsd' => '1',
				'value_num' => 1
				);
		} else {
			return array(
				'value_xsd' => '0',
				'value_num' => 0
				);
		}
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * This array is used to perform all insert operations into the DB
	 * To optimize return minimum fields having indexes
	 *
	 * @return array
	 */
	public function getInsertValues( SMWDataItem $dataItem ) {
		if ( $dataItem->getBoolean() ) {
			return array(
				'value_xsd' => '1',
				'value_num' => 1
				);
		} else {
			return array(
				'value_xsd' => '0',
				'value_num' => 0
				);
		}
	}
}
