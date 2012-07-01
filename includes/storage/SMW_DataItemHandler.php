<?php
/**
 * File holding class SMWDataItemHandler, the base for all dataitem handlers in SMW.
 *
 * @author Nischay Nahata
 *
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * Objects of this type represent all store layout that is known about a certain dataitem
 *
 * @since SMW.storerewrite
 *
 * @ingroup SMWDataItemsHandlers
 */
abstract class SMWDataItemHandler {

	/**
	 * Method to return array of fields and indexes for a DI type
	 * @since SMW.storerewrite
	 *
	 * @return array
	 */
	abstract public function getTableFields();

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * @since SMW.storerewrite
	 *
	 * @param SMWDataItem
	 * @return array
	 */
	abstract public function getWhereConds( SMWDataItem $dataItem );

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * This array is used to perform all insert operations into the DB
	 * To optimize return minimum fields having indexes
	 * @since SMW.storerewrite
	 *
	 * @param SMWDataItem
	 * @return array
	 */
	abstract public function getInsertValues( SMWDataItem $dataItem );

	/**
	 * Method to return the field used to select this type of DataItem
	 * @since SMW.storerewrite
	 * @return integer
	 * TODO - modify this to return the field instead of the int
	 */
	abstract public function getIndexField();

	/**
	 * Method to return the field used to select this type of DataItem
	 * using the label
	 * @since SMW.storerewrite
	 * @return integer
	 * TODO - modify this to return the field instead of the int
	 */
	abstract public function getLabelField();

	/**
	 * Method to create a dataitem from a type ID and array of DB keys.
	 *
	 * @since SMW.storerewrite
	 * @param $typeId typeId of the DataItem
	 * @param $dbkeys array of mixed
	 *
	 * @return SMWDataItem
	 */
	abstract public function dataItemFromDBKeys( $typeId, $dbkeys );

	/**
	 * Gets an object of the dataitem handler from the dataitem provided.
	 *
	 * @since SMW.storerewrite
	 *
	 * @param $dataItemID constant
	 *
	 * @throws MWException
	 * @return SMWDataItemHandler
	 */
	public static function getDataItemHandlerForDIType( $diType ) {
		switch ( $diType ) {
			case SMWDataItem::TYPE_NUMBER:    return new SMWDIHandlerNumber;
			case SMWDataItem::TYPE_STRING:    return new SMWDIHandlerString;
			case SMWDataItem::TYPE_BLOB:      return new SMWDIHandlerBlob;
			case SMWDataItem::TYPE_BOOLEAN:   return new SMWDIHandlerBoolean;
			case SMWDataItem::TYPE_URI:       return new SMWDIHandlerUri;
			case SMWDataItem::TYPE_TIME:      return new SMWDIHandlerTime;
			case SMWDataItem::TYPE_GEO:       return new SMWDIHandlerGeoCoord;
			case SMWDataItem::TYPE_CONTAINER: return new SMWDIHandlerContainer;
			case SMWDataItem::TYPE_WIKIPAGE:  return new SMWDIHandlerWikiPage;
			case SMWDataItem::TYPE_CONCEPT:   return new SMWDIHandlerConcept;
			case SMWDataItem::TYPE_PROPERTY:  return new SMWDIHandlerProperty;
			case SMWDataItem::TYPE_ERROR:	case SMWDataItem::TYPE_NOTYPE: default:
				throw new MWException( "The value \"$diType\" is not a valid dataitem ID." );
		}
	}
}