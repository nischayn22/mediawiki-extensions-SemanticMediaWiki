<?php
/**
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * This class implements Store access to Blob data items.
 *
 * @since SMW.storerewrite
 *
 * @author Nischay Nahata
 * @ingroup SMWDataItemsHandlers
 */
class SMWDIHandlerBlob extends SMWDataItemHandler {

	/**
	 * Method to return array of fields and indexes for a DI type
	 *
	 * @return array
	 */
	public function getTableFields(){
		return array(
			'objectfields' => array( 'value_blob' => 'l' ),
			'indexes' => array(),
		);
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 *
	 * @return array
	 */
	public function getWhereConds( SMWDataItem $dataItem ) {
		return array( 'value_blob' => $dataItem->getString() );
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * This array is used to perform all insert operations into the DB
	 * To optimize return minimum fields having indexes
	 *
	 * @return array
	 */
	public function getInsertValues( SMWDataItem $dataItem ) {
		return array( 'value_blob' => $dataItem->getString() );
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * @since SMW.storerewrite
	 * @return string
	 */
	public function getIndexField() {
		return '';
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * using the label
	 * @since SMW.storerewrite
	 * @return string
	 */
	public function getLabelField() {
		return '';
	}

	/**
	 * Method to create a dataitem from a type ID and array of DB keys.
	 *
	 * @since SMW.storerewrite
	 * @param $dbkeys array of mixed
	 *
	 * @return SMWDataItem
	 */
	public function dataItemFromDBKeys( $typeId, $dbkeys ) {
		return new SMWDIBlob( $dbkeys[0] );
	}
}
