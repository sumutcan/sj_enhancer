<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/21/15
 * Time: 12:58 PM
 */
use \siwcms\SemanticEngine;

require_once "StanbolEngineOptions.php";


/**
 * Class StanbolEngine
 */
class StanbolEngine extends SemanticEngine {

    /**
     * @param null $username
     * @param null $password
     */
    public function __construct($username=null,$password=null)
    {
        $options = new StanbolEngineOptions();
        $options->setAuth($username,$password);

        parent::__construct($options);

    }

    /**
     * @param $moduleName
     * @param \siwcms\SemanticEngineModule $module
     * @return mixed|void
     */
    public function registerModule($moduleName,  \siwcms\SemanticEngineModule $module)
    {
        parent::registerModule($moduleName,$module);
    }

    /**
     * @param $text
     * @return mixed
     */
    public function enhance($text)
    {
        return parent::runModule("enhancer","enhance",$text);


    }

}