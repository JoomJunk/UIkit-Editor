<?php
/**
* @package    JJ_UIKit_HTML_Editor
* @copyright  Copyright (C) 2011 - 2016 JoomJunk. All rights reserved.
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC') or die;

$params = $displayData->params;

// Load jQuery and UIKit
JHtml::_('jquery.framework');
JHtml::_('behavior.core');
JHtml::_('stylesheet', 'media/plg_uikit_htmleditor/css/uikit.min.css');
JHtml::_('script', 'media/plg_uikit_htmleditor/js/uikit.min.js');
JHtml::_('script', 'media/plg_uikit_htmleditor/js/uikit-noconflict.js');

// Load Codemirror
JHtml::_('stylesheet', 'media/editors/codemirror/lib/codemirror.min.css');
JHtml::_('script', 'media/editors/codemirror/lib/codemirror.min.js');
JHtml::_('script', 'media/editors/codemirror/addon/mode/overlay.min.js');
JHtml::_('script', 'media/editors/codemirror/mode/xml/xml.min.js');
JHtml::_('script', 'media/editors/codemirror/mode/gfm/gfm.min.js');

// Load Syntax Highlighting
if ($params->get('highlight', 1) == 1)
{
	JHtml::_('script', 'media/editors/codemirror/mode/htmlmixed/htmlmixed.min.js');
	JHtml::_('script', 'media/editors/codemirror/mode/javascript/javascript.min.js');
}

// Load HTML editor
JHtml::_('stylesheet', 'media/plg_uikit_htmleditor/css/htmleditor.min.css');
JHtml::_('stylesheet', 'media/plg_uikit_htmleditor/css/simple_editor.css');
JHtml::_('script', 'media/plg_uikit_htmleditor/js/htmleditor.min.js');
