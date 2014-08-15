<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

	public function initialize()
	{
		// In jedem Controller sprachenabhänige Strings initialisieren
		$this->view->setVar("t", $this->_getTranslation());
	}
	
	protected function _getTranslation()
	{
		//Ask browser what is the best language
		$language = $this->request->getBestLanguage();
		
		if(strtolower($language) == "de-de")
			$language = "de";
		
		$path = dirname(__FILE__)."/../strings/".$language.".php";
		
		//Check if we have a translation file for that lang
		if (file_exists($path)) {
			require $path;
		} else {
			// fallback to some default
			require dirname(__FILE__)."/../strings/en.php";
		}
		
		//Return a translation object
		return new \Phalcon\Translate\Adapter\NativeArray(array(
				"content" => $strings
		));
	
	}
	
}
