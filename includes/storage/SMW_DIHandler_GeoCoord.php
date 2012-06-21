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
}
