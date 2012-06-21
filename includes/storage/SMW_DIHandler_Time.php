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
class SMWDIHandlerTime extends SMWDataItemHandler {

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
		$xsdvalue = $dataItem->getYear() . "/" .
				( ( $dataItem->getPrecision() >= SMWDITime::PREC_YM ) ? $dataItem->getMonth() : '' ) . "/" .
				( ( $dataItem->getPrecision() >= SMWDITime::PREC_YMD ) ? $dataItem->getDay() : '' ) . "T";
		if ( $dataItem->getPrecision() == SMWDITime::PREC_YMDT ) {
			$xsdvalue .= sprintf( "%02d", $dataItem->getHour() ) . ':' .
					sprintf( "%02d", $dataItem->getMinute()) . ':' .
					sprintf( "%02d", $dataItem->getSecond() );
		}

		return array(
			'value_xsd' => $xsdvalue,
			'value_num' => $dataItem->getSortKey()
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
		$xsdvalue = $dataItem->getYear() . "/" .
				( ( $dataItem->getPrecision() >= SMWDITime::PREC_YM ) ? $dataItem->getMonth() : '' ) . "/" .
				( ( $dataItem->getPrecision() >= SMWDITime::PREC_YMD ) ? $dataItem->getDay() : '' ) . "T";
		if ( $dataItem->getPrecision() == SMWDITime::PREC_YMDT ) {
			$xsdvalue .= sprintf( "%02d", $dataItem->getHour() ) . ':' .
					sprintf( "%02d", $dataItem->getMinute()) . ':' .
					sprintf( "%02d", $dataItem->getSecond() );
		}

		return array(
			'value_xsd' => $xsdvalue,
			'value_num' => $dataItem->getSortKey()
			);
	}
}
