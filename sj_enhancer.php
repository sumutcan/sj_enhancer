<?php
/**
 * @category    Joomla plugin
 * @package     SJ
 * @subpackage  plg_sj_enhancer_editor_xtd_subjects.site
 * @name        plgButtonSJ_Enhancer_Editors_XTD
 * @author      Umutcan Simsek, <umutcan.simsek@mni.thm.de>
 * @copyright   2015 TH Mittelhessen
 * @license     GNU GPL v.2
 * @link        www.mni.thm.de
 */
defined('_JEXEC') or die;
jimport('joomla.plugin.plugin');
jimport('joomla.event.plugin');
jimport('joomla.language.language');

/**
 * Class adds a button for the insertion of THM Organizer resources in editor
 * fields.
 *
 * @category    Joomla.Plugin.Editors
 * @package     thm_organizer
 * @subpackage  plg_thm_organizer_editors_xtd_subjects.site
 */
class plgButtonSJ_Enhancer extends JPlugin
{
    /**
     * Constructor
     *
     * @param   object  &$subject  The object to observe
     * @param   array   $config    An array that holds the plugin configuration
     */
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /**
     * Creates a button for the insertion of THM Organizer resources in editor
     * fields.
     *
     * @param   string  $name  the name of the editor
     *
     * @return  Jobject  the object modeling the button
     */
    public function onDisplay($name)
    {



        $editor = JFactory::getEditor();
        $doc = JFactory::getDocument();
        $getContents = $editor->getContent($name);






//here starts the view stuff
        $baseFileURL = JURI::root() . '/plugins/editors-xtd/sj_enhancer/';

        JFactory::getDocument()->addStyleSheet($baseFileURL . 'assets/subjects.css');

        // Reference to current object languages
        $lang = JFactory::getLanguage();
        $languageTag = $lang->getTag();
        $lang->load('plg_editors-xtd_sj_enhancer');

        $link = '../plugins/editors-xtd/sj_enhancer/view.php?';
        $link .= "&e_name=$name&languageTag=$languageTag";

        JHtml::_('behavior.modal');



        $postContent = '
        function enhance(x){
        var postData="stanbol='.$this->params->get('txtEnhancerSite').'&contentText="+x;
        $.ajax({
        data:postData,
        url:"'.$link.'",
        type: "POST",
        success:function(result){

        }
        });

        return true;}';

        $script = 'function getEditorText() {return '.$getContents.'}'.$postContent;

        $doc->addScript('./../libraries/jquery/js/jquery.min.js');
        $doc->addScriptDeclaration($script);
        // Button
        $button = new JObject;
        $button->set('modal', true);
        $button->set('text', JText::_('PLG_SJ_ENHANCER_BUTTON_LABEL'));
        $button->set('name', 'btnSemantify');
        $button->set('options', "{handler: 'iframe', size: {x: 770, y: 400}}");
        $button->set('onclick','enhance(getEditorText());');
        $button->set('link',$link);


        return $button;
    }
}
