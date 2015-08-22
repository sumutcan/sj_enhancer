<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/21/15
 * Time: 12:58 PM
 */
use \siwcms\SemanticEngine;

require_once "StanbolEngineOptions.php";



class StanbolEngine extends SemanticEngine {

    public function __construct($username=null,$password=null)
    {
        $options = new StanbolEngineOptions();
        $options->setAuth($username,$password);

        parent::__construct($options);

    }

    public function registerModule($moduleName,  \siwcms\SemanticEngineModule $module)
    {
        parent::registerModule($moduleName,$module);
    }

    public function enhance($text)
    {
        return parent::runModule("enhancer","enhance",$text);


    }

}