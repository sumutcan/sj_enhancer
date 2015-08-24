<?php
/**
 * @category    Joomla plugin
 * @package     THM_Organizer
 * @subpackage  plg_thm_organizer_editor_xtd_subjects.site
 * @name        view.php
 * @author      Samuel Huebl, <samuel.huebl@mni.thm.de>
 * @author      James Antrim, <james.antrim@mni.thm.de>
 * @copyright   2013 TH Mittelhessen
 * @license     GNU GPL v.2
 * @link        www.mni.thm.de
 */
require_once './model.php';
require_once 'stanbolenhancer/StanbolEngineInit.php';

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();

$languageTag = SJModel::initializeLanguage();
$enhancerURL = JRequest::getString("stanbol");
$contentText = JRequest::getString("contentText");
$rootURI = str_replace('plugins/editors-xtd/sj_enhancer/', '', JURI::root());

$session = JFactory::getSession();
$enhancements = array();

$engine = new StanbolEngine("admin","admin");
$module = new StanbolEnhancer();
$module->setUrl($enhancerURL);
$operation = new Enhance(POST,array("Content-Type" => "text/plain", "Accept" => "application/rdf+xml"));
$operation->setGraphURI($rootURI);
$module->registerOperation("enhance",$operation);
$engine->registerModule("enhancer",$module);
$model = new SJModel($engine);



if ($enhancerURL && $contentText) {
    $enhancements = $model->enhance($contentText);

    $session->set("enhancements", $enhancements,"sj");

}
if ($session->get("enhancements",null,"sj") != null)
{
    $enhancements = $session->get("enhancements",null,"sj");
}






?>
<head>
    <link rel="stylesheet" type="text/css" href ="assets/enhancer.css" />
    <link rel="stylesheet" type="text/css" href ="./../../../administrator/templates/bluestork/css/template.css" />
    <script type="text/javascript">
        var editor = '<?php echo JRequest::getString('e_name'); ?>',
            languageTag = '<?php echo $languageTag; ?>',
            rootURI = '<?php echo $rootURI; ?>';
    </script>
    <script type="text/javascript" src="./../../../libraries/jquery/js/jquery.min.js" ></script>
    <script type="text/javascript" src="./../../../libraries/jquery/js/jquery.ui.core.min.js" ></script>
    <script type="text/javascript" src="assets/enhancer.js"></script>
</head>
<body>
<div id="subjects_dialog-modal">
    <div id="toolbar-box">
        <div class="m">
            <div class="toolbar-list" id="toolbar">
                <ul>
                    <li class="button" id="toolbar-insert">
                        <a href="#" onclick="insertSubjects(); return false;" class="toolbar">
                            <span class="icon-32-insert"></span>
                            <?php echo JText::_('PLG_SJ_ENHANCER_INSERT'); ?>
                        </a>
                    </li>
                </ul>
                <div class="clr"></div>
            </div>
            <div class="pagetitle icon-48-subjects">
                <h2><?php echo JText::_('PLG_SJ_ENHANCER_TITLE'); ?></h2>
            </div>
        </div>
    </div>
    <div id="element-box">
        <div class="m">

            <div class="clr"></div>
            <table class="adminlist">
                <thead>
                <tr>
                    <th>
                        Select
                    </th>
                    <th class="title">
                        Selected Text
                    </th>
                    <th width="15%">
                        Annotation Label
                    </th>
                    <th width="15%">
                        Entity
                    </th>
                    <th width="15%">
                        Entity Label(s)
                    </th>
                    <th width="5%">
                        Entity Type(s)
                    </th>
                </tr>
                </thead>

                <tbody id="selectable">
                <? $i = 0 ?>
                <?php foreach ($enhancements as $enh) :?>
                    <?php $selectedText = ""; $ranges=""; foreach ($enh->getTextAnnotations() as $textAnno) {$selectedText .= $textAnno->getSelectedText(); $ranges .= $textAnno->getStart().",".$textAnno->getEnd().";";} ?>
                    <tr class = <?php echo "row".$i%2; ?>>
                    <td>
                        <input type="checkbox" id=<?php echo "cb".$i; ?> value="<?php echo $enh->getEntity()->getId() ."-".$ranges."-".$selectedText; ?>"/>
                    </td>

                        <td><?php  echo $selectedText ?></td>
                        <td><?php  echo $enh->getEntityLabel() ?></td>
                        <td><?php  echo $enh->getEntity()->getId(); ?></td>
                        <td><?php  echo $enh->getEntity()->getLabelsAsString(); ?></td>
                        <td><?php  echo implode($enh->getEntityTypes(true),", ") ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach ;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
