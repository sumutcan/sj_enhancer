<?php
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