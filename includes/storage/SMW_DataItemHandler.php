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
 *
 * @since SMW.storerewrite
 *
 * @ingroup SMWDataItemsHandlers
 */
class SMWDataItemHandler {

	/**
	 * Gets an object of the dataitem handler from the dataitem provided.
	 * @since SMW.storerewrite
	 *
	 * @param $dataItem SMWDataItem
	 *
	 * @throws MWException
	 * @return DataItemHandler
	 *
	 */
	public static function getDataItemHandlerForDI( $di, $store ) {
		switch ( $di->getDIType() ) {
			case SMWDataItem::TYPE_NUMBER:    return new SMWDIHandlerNumber;
			case SMWDataItem::TYPE_STRING:    return new SMWDIHandlerString;
			case SMWDataItem::TYPE_BLOB:      return new SMWDIHandlerBlob;
			case SMWDataItem::TYPE_BOOLEAN:   return new SMWDIHandlerBoolean;
			case SMWDataItem::TYPE_URI:       return new SMWDIHandlerUri;
			case SMWDataItem::TYPE_TIME:      return new SMWDIHandlerTime;
			case SMWDataItem::TYPE_GEO:       return new SMWDIHandlerGeoCoord;
			case SMWDataItem::TYPE_CONTAINER: return new SMWDIHandlerContainer;
			case SMWDataItem::TYPE_WIKIPAGE:  return new SMWDIHandlerWikiPage ( $store );
			case SMWDataItem::TYPE_CONCEPT:   return new SMWDIHandlerConcept;
			case SMWDataItem::TYPE_PROPERTY:  return new SMWDIHandlerProperty;
			case SMWDataItem::TYPE_ERROR:	case SMWDataItem::TYPE_NOTYPE: default:
				throw new MWException( "The value \"$diType\" is not a valid dataitem ID." );
		}
	}
}