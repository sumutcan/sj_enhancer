<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/19/15
 * Time: 1:35 AM
 */

require_once "EntityAnnotation.php";
require_once "TextAnnotation.php";
require_once "StanbolEngine.php";
require_once "StanbolEnhancer.php";
require_once "Enhance.php";
require_once "Person.php";

/*class StanbolEngineInit {


    public static function init($url)
    {
        EasyRdf_Namespace::set("stanbol","http://fise.iks-project.eu/ontology/");
        $engine = new StanbolEngine("\"admin,admin\"");
        $module = new StanbolEnhancer();
        $operation = new Enhance();

        $module->registerOperation("enhance",$operation);
        $module->setUrl($url);


    }
}*/