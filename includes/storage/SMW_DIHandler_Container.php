<?php
/**
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * This class implements Store access to Container data items.
 *
 * @since SMW.storerewrite
 *
 * @author Nischay Nahata
 * @ingroup SMWDataItemsHandlers
 */
class SMWDIHandlerContainer extends SMWDataItemHandler {

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
	public function getWhereConds( SMWDataItem $dataItem ) {
		return array( false );
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * This array is used to perform all insert operations into the DB
	 * To optimize return minimum fields having indexes
	 *
	 * @return array
	 */
	public function getInsertValues( SMWDataItem $dataItem ) {
		return array( false );
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * @since SMW.storerewrite
	 * @return integer
	 */
	public function getIndexField() {
		return -1;
	}

	/**
	 * Method to return the field used to select this type of DataItem
	 * using the label
	 * @since SMW.storerewrite
	 * @return integer
	 */
	public function getLabelField() {
		return -1;
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
		// provided for backwards compatibility only;
		// today containers are read from the store as substructures,
		// not retrieved as single complex values
		$semanticData = SMWContainerSemanticData::makeAnonymousContainer();
		foreach ( reset( $dbkeys ) as $value ) {
			if ( is_array( $value ) && ( count( $value ) == 2 ) ) {
				$diP = new SMWDIProperty( reset( $value ), false );
				$handler = SMWDataItemHandler::getDataItemHandlerForDIType( $diP->getDIType(), $this->store );
				$diV = $handler::dataItemFromDBKeys( $diP->findPropertyTypeID(), end( $value ) );
				$semanticData->addPropertyObjectValue( $diP, $diV );
			}
		}
		return new SMWDIContainer( $semanticData );
	}
}
