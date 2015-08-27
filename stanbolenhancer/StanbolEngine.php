<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/21/15
 * Time: 12:58 PM
 */
use \siwcms\SemanticEngine;
use siwcms\SemanticEngineModule;

require_once "StanbolEngineOptions.php";


/**
 * Class StanbolEngine
 */
class StanbolEngine extends SemanticEngine {

    /**
     * Cosntructor
     *
     * @param null $username Username for RESTful authentication
     * @param null $password Password for RESTful authentication
     */
    public function __construct($username=null,$password=null)
    {
        $options = new StanbolEngineOptions();
        $options->setAuth($username, $password);

        parent::__construct($options);

    }

    /**
     * The method that registers a module to the engine
     *
     * @param string               $moduleName Name of the module
     * @param SemanticEngineModule $module     Module to be registered to engine
     *
     * @return void
     */
    public function registerModule($moduleName,  SemanticEngineModule $module)
    {
        parent::registerModule($moduleName, $module);
    }

    /**
     * Method that runs the relavent module
     *
     * @param string $text String to be enhanced
     *
     * @return array Enhancements in an array
     */
    public function enhance($text)
    {
        return parent::runModule("enhancer", "enhance", $text);


    }

}