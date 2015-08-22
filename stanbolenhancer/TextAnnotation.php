<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/19/15
 * Time: 12:15 AM
 */

class TextAnnotation extends siwcms\Enhancement {

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