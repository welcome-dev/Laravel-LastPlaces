<?php
namespace App\Model; 
use Eloquent;

/**
 * CmsDescription Model
 */
class DestinationCountryDescription extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'destination_country_description';
	
	/**
	 * function for find result from database 
	 *
	 * @param null
	 * 
	 * @return array
	 */		
	public static function showResult(){
		
		$currentLanguageId	=	Session::get('currentLanguageId');
		$result		=	 DestinationCountryDescription::select('source_col_name','source_col_description')->where('language_id' , $currentLanguageId);
		return $result;
	} //end showResult()
	
}// end CmsDescription class