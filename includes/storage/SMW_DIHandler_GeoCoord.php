<?php
/**
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * This class implements Store access to CeoCoord data items.
 *
 * @since SMW.storerewrite
 *
 * @author Nischay Nahata
 * @ingroup SMWDataItemsHandlers
 */
class SMWDIHandlerGeoCoord extends SMWDataItemHandler {

	/**
	 * Method to return array of fields and indexes for a DI type
	 *
	 * @return array
	 */
	static public function getTableFields(){
		return array(
			'objectfields' => array( 'lat' => 'f', 'lon' => 'f', 'alt' => 'f' ),
			'indexes' => array( 'lat', 'lon', 'alt' ),
			);
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 *
	 * @return array
	 */
	public function getWhereConds( SMWDataItem $dataItem ) {
		$coordinateSet = $dataItem->getCoordinateSet();
		return array(
			'lat' => $coordinateSet['lat'],
			'lon' => $coordinateSet['lon']
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
		$coordinateSet = $dataItem->getCoordinateSet();
		return array(
			'lat' => $coordinateSet['lat'],
			'lon' => $coordinateSet['lon']
		);
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * @since SMW.storerewrite
	 * @return integer
	 */
	public function getIndexField() {
		//TODO - Why use lat? why was only lat used till now?
		return 0;
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * using the label
	 * @since SMW.storerewrite
	 * @return integer
	 */
	public function getLabelField() {
		return 0;
	}

	/**
	 * Method to create a dataitem from a type ID and array of DB keys.
	 *
	 * @since SMW.storerewrite
	 * @param $dbkeys array of mixed
	 *
	 * @return SMWDataItem
	 */
	static public function dataItemFromDBKeys( $typeId, $dbkeys ) {
		return new SMWDIGeoCoord( array( 'lat' => (float)$dbkeys[0], 'lon' => (float)$dbkeys[1] ) );
	}
}
