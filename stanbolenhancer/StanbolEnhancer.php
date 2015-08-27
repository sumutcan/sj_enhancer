<?php
/**
 * Semantic Joomla! Enhancer Plugin
 *
 * @category  Joomla_Plugin
 * @package   SJ
 * @name      plgButtonSJ_Enhancer_Editors_XTD
 * @author    Umutcan Simsek, <umutcan.simsek@mni.thm.de>
 * @copyright 2015 TH Mittelhessen
 * @license   GNU GPL v.2
 * @link      www.mni.thm.de
 */
use siwcms\Operation;
use siwcms\SemanticEngineModule;

/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/21/15
 * Time: 1:38 PM
 */

class StanbolEnhancer extends SemanticEngineModule {

    public function __construct()
    {

    }

    /**
     * @param $operationName
     * @param Operation $operation
     */
    public function registerOperation($operationName, Operation $operation)
    {
        parent::registerOperation($operationName, $operation);
    }

}