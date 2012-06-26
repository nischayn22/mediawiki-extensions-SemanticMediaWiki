<?php
/**
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * This class implements Store access to Time data items.
 *
 * @since SMW.storerewrite
 *
 * @author Nischay Nahata
 * @ingroup SMWDataItemsHandlers
 */
class SMWDIHandlerWikiPage extends SMWDataItemHandler {

	/**
	 * Method to return array of fields and indexes for a DI type
	 *
	 * @return array
	 */
	public function getTableFields(){
		return array(
			'objectfields' => array( 'o_id' => 'p' ),
			'indexes' => array( 'o_id' ),
		);
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 *
	 * @return array
	 */
	public function getWhereConds( SMWDataItem $di) {
		$oid = smwfGetStore()->getSMWPageID( $di->getDBkey(), $di->getNamespace(), $di->getInterwiki(), $di->getSubobjectName() );
		return array( 'o_id' => $oid );
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * This array is used to perform all insert operations into the DB
	 * To optimize return minimum fields having indexes
	 *
	 * @return array
	 */
	public function getInsertValues( SMWDataItem $di ) {
		$oid = smwfGetStore()->makeSMWPageID( $di->getDBkey(), $di->getNamespace(), $di->getInterwiki(), $di->getSubobjectName() );
		return array( 'o_id' => $oid );
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * @since SMW.storerewrite
	 * @return integer
	 */
	public function getIndexField() {
		//returning 3 so fetchSemanticData will use smw_sortkey
		return 3;
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * using the label
	 * @since SMW.storerewrite
	 * @return integer
	 */
	public function getLabelField() {
		//returning 3 so fetchSemanticData will use smw_sortkey
		return 3;
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
		if ( $typeId == '__spf' ) {
			$pagedbkey = str_replace( ' ', '_', $dbkeys[0] );
			return new SMWDIWikiPage( $pagedbkey, SF_NS_FORM, '' );
		} elseif ( count( $dbkeys ) >= 5 ) { // with subobject name (and sortkey)
			return new SMWDIWikiPage( $dbkeys[0], intval( $dbkeys[1] ), $dbkeys[2], $dbkeys[4] );
		} elseif ( count( $dbkeys ) >= 3 ) { // without subobject name (just for b/c)
			return new SMWDIWikiPage( $dbkeys[0], intval( $dbkeys[1] ), $dbkeys[2] );
		}
		throw new SMWDataItemException( 'Failed to create data item from DB keys.' );
	}
}
