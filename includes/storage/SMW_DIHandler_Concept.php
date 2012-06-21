<?php
/**
 * @file
 * @ingroup SMWDataItemsHandlers
 */

/**
 * This class implements Store access to Concept data items.
 *
 * @since SMW.storerewrite
 *
 * @author Nischay Nahata
 * @ingroup SMWDataItemsHandlers
 */
class SMWDIHandlerConcept extends SMWDataItemHandler {

	/**
	 * Method to return array of fields and indexes for a DI type
	 *
	 * @since SMW.storerewrite
	 *
	 * @return array
	 */
	static public function getTableFields(){
		return array(
			'objectfields' => array(
				'concept_txt' => 'l',
				'concept_docu' => 'l',
				'concept_features' => 'n',
				'concept_size' => 'n',
				'concept_depth' => 'n',
				'cache_date' => 'j',
				'cache_count' => 'j'
			),
			'indexes' => array(),
		);
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 *
	 * @since SMW.storerewrite
	 *
	 * @param SMWDataItem $dataItem
	 *
	 * @return array
	 */
	public function getWhereConds( SMWDataItem $dataItem ) {
		return array(
			$dataItem->getConceptQuery(),
			$dataItem->getDocumentation(),
			$dataItem->getQueryFeatures(),
			$dataItem->getSize(),
			$dataItem->getDepth()
		);
	}

	/**
	 * Method to return an array of fields=>values for a DataItem
	 * This array is used to perform all insert operations into the DB
	 * To optimize return minimum fields having indexes
	 *
	 * @since SMW.storerewrite
	 *
	 * @param SMWDataItem $dataItem
	 *
	 * @return array
	 */
	public function getInsertValues( SMWDataItem $dataItem ) {
		if( $dataItem->getBoolean() ) {
			return array(
				'value_xsd' => '1',
				'value_num' => 1
			);
		} else
			return array(
				'value_xsd' => '0',
				'value_num' => 0
			);
	}
}
