<?php
/**
* @package    JJ_UIKit_HTML_Editor
* @copyright  Copyright (C) 2011 - 2016 JoomJunk. All rights reserved.
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC') or die;

$options = $displayData->options;
$params  = $displayData->params;
$name    = $displayData->name;
$id      = $displayData->id;
$cols    = $displayData->cols;
$rows    = $displayData->rows;
$content = $displayData->content;
$buttons = $displayData->buttons;

$paramDisplay      = $params->get('display', 'split');
$paramMaxSplitSize = $params->get('maxsplitsize', 1000);

JFactory::getDocument()->addScriptDeclaration('
	var JJ_UIKIT_htmleditor = null;

	jQuery(function($) {
		var id            = ' . json_encode($id) . ', options = ' . json_encode($options) . ';
		var editorElement = $("#" + id);

		JJ_UIKIT_htmleditor = JJ_UIKIT.htmleditor(editorElement, {
			mode         : \'' . $paramDisplay . '\',
			maxsplitsize : ' . $paramMaxSplitSize . ',
			lblPreview   : \'' . JText::_('JJ_UIKIT_HTMLEDITOR_LBL_PREVIEW') . '\',
		});

		$("#editor-xtd-buttons a:last-child").removeAttr("onclick").attr("id", "JJ_UIKIT_readmore");

		$(document).on("click", "#JJ_UIKIT_readmore", function(e){

			e.preventDefault();

			var content = editorElement.val();
			if (content.match(/<hr\s+id=(\'|")system-readmore(\'|")\s*\/*>/i))
			{
				alert("' . JText::_('PLG_READMORE_ALREADY_EXISTS', true) . '");
				return false;
			}
			else
			{
				JJ_UIKIT_htmleditor.replaceSelection("<hr id=\"system-readmore\" />");
			}
		});
		
		$(".uk-htmleditor-button-preview a").on("click", function() {
			$(".uk-htmleditor-preview").height("500px");
		});
	});
');
?>

<?php echo '<textarea name="', $name, '" id="', $id, '" cols="', $cols, '" rows="', $rows, '">', $content, '</textarea>'; ?>

<?php echo $displayData->buttons; ?>
