<?php
/**
 * The class in this file provides a container for cache of subject-centred
 * Semantic data and functions to access them.
 *
 * @file
 * @ingroup SMWStore
 *
 * @author Nischay Nahata
 */

 /**
 * Class for representing cache of semantic data for one given
 * article (subject), similar to SemanticData but has access to cache in db.
 * 
 *
 * @ingroup SMWStore
 */
class SMWSemanticDataCache extends SMWSemanticData {
	
	protected $mSubject;
	protected $mIsValid = false;
	protected $cacheExists = false;

	/**
	 * Create a new SMWSemanticDataCache object that holds the data of a
	 * given SMWSemanticData object and all info about related cache.
	 * If the cache is not initialized (stored in db) initialize it too.
	 */
	public static function newFromSemanticData( SMWSemanticData $semanticData ) {
		$result = new SMWSemanticDataCache( $semanticData->getSubject() );
		$result->mPropVals = $semanticData->mPropVals;
		$result->mProperties = $semanticData->mProperties;
		$result->mHasVisibleProps = $semanticData->mHasVisibleProps;
		$result->mHasVisibleSpecs = $semanticData->mHasVisibleSpecs;
		$result->stubObject = $semanticData->stubObject;
		$result->mSubject = $semanticData->mSubject;

		$result->initializeCache();
		return $result;
	}
	
	/**
	 * This function initializes the cache. Mostly called from the constructor
	 * Hoever no action is done if smwDataCaching is disabled.
	 */
	public function initializeCache() {
		global $smwDataCaching;
		if(!$smwDataCaching)
			return;
		
		if( !$this->ifCacheExists() ){
			$this->createCache();
			$this->$mIsValid = true;
		}
		//If cache is new its valid else you have to check for validity yourself
		//and update whenever required.
		return;
	}
	
	/**
	 * This function just checks if the Cache exists in db for
	 * this subject. If it doesn't exist the field will have default value NULL
	 *
	 */
	public function ifCacheExists() {
	
		return $cacheExists;
	}
	
	/**
	 * This function stores the cache in the db
	 * if it does not exist already.
	 *
	 */
	public function createCache () {
		if(!$cacheExists) {
		}
	}
	
	/**
	 * This function updates the cache in the db with the
	 * SMWSemanticData associated with this SMWSemanticDataCache
	 * Note: We should try and update data all together i.e. in the cache and in the PropertyValue tables.
	 */
	public function updateCache () {
	}
	
	/**
	 * Checks if the Cache is valid or it needs to be updated
	 * by comparing each field with the SMWSemanticData associated.
	 * Note: We want to update only required fields. So how do we find where data is invalid?
	 * We definitely need a proper structure in db to store cached SemanticData.
	 */
	public function checkValidity () {
	
	}
	/**
	 * Not sure why would anyone delete all Cache. But we still have this function
	 * It is however of very low priority.
	 */
	public function deleteCache () {
	
	}

}