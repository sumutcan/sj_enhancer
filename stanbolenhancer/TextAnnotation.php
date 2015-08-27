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
use siwcms\Enhancement;
/**
 * The class that extends SIWCMS Enhancement class stores stanbol text annotations
 *
 * @category Joomla.Plugin.Editors
 * @package  Thm_Organizer
 * @author   Umutcan Simsek, <umutcan.simsek@mni.thm.de>
 * @license  GNU GPL v.2
 * @link     www.mni.thm.de
 */
class TextAnnotation extends Enhancement
{

    private $_selectedText;

    /**
     * @return mixed
     */
    public function getSelectedText()
    {
        return $this->_selectedText;
    }

    /**
     * @param mixed $selectedText
     */
    public function setSelectedText($selectedText)
    {
        $this->_selectedText = $selectedText;
    }

    public function __construct($id, $start, $end, $confidence)
    {
        parent::setId($id);
        parent::setStart($start);
        parent::setEnd($end);
        parent::setConfidence($confidence);
    }

    public static function createFromRDF(EasyRdf_Resource $annoResource)
    {
        $textAnno = new TextAnnotation($annoResource->getUri(),$annoResource->getLiteral("stanbol:start")->getValue(), $annoResource->getLiteral("stanbol:end")->getValue(), $annoResource->getLiteral("stanbol:confidence")->getValue());
        $textAnno->setSelectedText($annoResource->getLiteral("stanbol:selected-text")->getValue());

        return $textAnno;
    }
}