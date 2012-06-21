<?php
/**
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * This class implements Store access to Number data items.
 *
 * @since SMW.storerewrite
 *
 * @author Nischay Nahata
 * @ingroup SMWDataItemsHandlers
 */
class SMWDIHandlerNumber extends SMWDataItemHandler {

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
		return array(
			'value_xsd' => $dataItem->getSerialization(),
			'value_num' => floatval( $dataItem->getNumber() )
			);
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * This array is used to perform all insert operations into the DB
	 * To optimize return minimum fields having indexes
	 *
	 * @return array
	 */
	public function getInsertValues( SMWDataItem $dataItem ) {
		return array(
			'value_xsd' => $dataItem->getSerialization(),
			'value_num' => floatval( $dataItem->getNumber() )
			);
	}
}
