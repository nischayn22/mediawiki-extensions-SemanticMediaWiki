<?php

/**
 * Class for the 'ask' parser functions.
 * @see http://semantic-mediawiki.org/wiki/Help:Inline_queries#Introduction_to_.23ask
 *
 * @since 1.5.3
 *
 * @file SMW_Ask.php
 * @ingroup SMW
 * @ingroup ParserHooks
 *
 * @author Markus Krötzsch
 * @author Jeroen De Dauw
 */
class SMWAsk {

	/**
	 * Method for handling the ask parser function.
	 *
	 * @since 1.5.3
	 *
	 * @param Parser $parser
	 */
	public static function render( Parser &$parser ) {
		global $smwgQEnabled, $smwgIQRunningNumber, $wgTitle;

		if ( $smwgQEnabled ) {
			$smwgIQRunningNumber++;

			$rawParams = func_get_args();
			array_shift( $rawParams ); // We already know the $parser ...

			//get the queryString here itself
			SMWQueryProcessor::processFunctionParams( $rawParams, $queryString, $params, $printouts, false );
			SMWQueryProcessor::addThisPrintout( $printouts, $params );
			$params = SMWQueryProcessor::getProcessedParams( $params, $printouts );

			$result = SMWQueryProcessor::getResultFromQueryString( $queryString, $params, $printouts, SMW_OUTPUT_WIKI, SMWQueryProcessor::INLINE_QUERY );
		} else {
			$result = smwfEncodeMessages( array( wfMsgForContent( 'smw_iq_disabled' ) ) );
		}

		if ( !is_null( $wgTitle ) && $wgTitle->isSpecialPage() ) {
			global $wgOut;
			SMWOutputs::commitToOutputPage( $wgOut );
		}
		else {
			SMWOutputs::commitToParser( $parser );
		}

		//make a Subobject with a ASK Property for this query
		self::makeAskProperty( $parser, $rawParams, $queryString );
		return $result;
	}

	protected function makeAskProperty( $parser, $rawParams, $queryString ) {
		$subobjectName = '_' . md5( serialize($rawParams ) );

		$mainSemanticData = SMWParseData::getSMWData( $parser );
		$subject = $mainSemanticData->getSubject();

		$diSubWikiPage = new SMWDIWikiPage( $subject->getDBkey(),
				$subject->getNamespace(), $subject->getInterwiki(),
				$subobjectName );

		$semanticData = new SMWContainerSemanticData( $diSubWikiPage );

		$propertyDi = new SMWDIProperty( '_ASKText' );
		$semanticData->addPropertyObjectValue( $propertyDi, new SMWDIBlob( $queryString ) );

		//add the subobject to SMWSemanticData
		$propertyDi = new SMWDIProperty( '_ASK' );
		$subObjectDi = new SMWDIContainer( $semanticData );
		SMWParseData::getSMWData( $parser )->addPropertyObjectValue( $propertyDi, $subObjectDi );
	}

}