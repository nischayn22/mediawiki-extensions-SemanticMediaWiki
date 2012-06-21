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
	 * The store used by this store handler
	 *
	 * @since SMW.storerewrite
	 * @var SMWSQLStore2
	 */
	protected $store;


	public function __construct( &$parentstore ) {
		$this->store = $parentstore;
	}

	/**
	 * Method to return array of fields and indexes for a DI type
	 *
	 * @return array
	 */
	static public function getTableFields(){
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
		$oid = $this->store->makeSMWPageID( $di->getDBkey(), $di->getNamespace(), $di->getInterwiki(), $di->getSubobjectName() );
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
		$oid = $this->store->makeSMWPageID( $di->getDBkey(), $di->getNamespace(), $di->getInterwiki(), $di->getSubobjectName() );
		return array( 'o_id' => $oid );
	}
}
