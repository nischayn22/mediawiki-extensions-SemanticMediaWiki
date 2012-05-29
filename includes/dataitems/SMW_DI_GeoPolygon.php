<?php

class SMWDIGeoPolygon extends SMWDIContainer {

	const POLYGON_DELIMITER = ':';
	protected $childrenPropertyType;

	public function __construct(SMWContainerSemanticData $semanticData){
		parent::__construct($semanticData);
		$this->childrenPropertyType =  new SMWDIProperty('_geo');
	}

	public function addPolygonPoint(SMWDIGeoCoord $coord){
		$this->m_semanticData->addPropertyObjectValue(
			$this->childrenPropertyType,
			$coord
		);
	}

	/**
	 * Return a value that can be used for sorting data of this type.
	 * If the data is of a numerical type, the sorting must be done in
	 * numerical order. If the data is a string, the data must be sorted
	 * alphabetically.
	 *
	 * @note Every data item returns a sort key, even if there is no
	 * natural linear order for the type. SMW must order listed data
	 * in some way in any case. If there is a natural order (e.g. for
	 * Booleans where false < true), then the sortkey must agree with
	 * this order (e.g. for Booleans where false maps to 0, and true
	 * maps to 1).
	 *
	 * @note Wiki pages are a special case in SMW. They are ordered by a
	 * sortkey that is assigned to them as a property value. When pages are
	 * sorted, this data should be used if possible.
	 *
	 * @return float or string
	 */
	public function getSortKey() {
		return sizeof($this->m_semanticData->getProperties());
	}

	/**
	 * Get a UTF-8 encoded string serialization of this data item.
	 * The serialisation should be concise and need not be pretty, but it
	 * must allow unserialization. Each subclass of SMWDataItem implements
	 * a static method doUnserialize() for this purpose.
	 * @return string
	 */
	public function getSerialization() {
		$serialization = array();
		foreach ($this->m_semanticData->getPropertyValues($this->childrenPropertyType) as $coord){
			$serialization[] = $coord->getSerialization();
		}
		return join(self::POLYGON_DELIMITER ,$serialization);
	}

	/**
	 * Convenience method that returns a constant that defines the concrete
	 * class that implements this data item. Used to switch when processing
	 * data items.
	 * @return integer that specifies the basic type of data item
	 */
	public function getDIType() {
		return SMWDataItem::TYPE_CONTAINER;
	}

	/**
	 * @static
	 * @param $serialization
	 */
	public static function doUnserialize( $serialization ) {
		$rawCoords = explode(self::POLYGON_DELIMITER,$serialization);
		$instance = new self(SMWContainerSemanticData::makeAnonymousContainer());

		foreach($rawCoords as $rawCoord){
			$instance->addPolygonPoint(SMWDIGeoCoord::doUnserialize($rawCoord));
		}

		return $instance;
	}
}
