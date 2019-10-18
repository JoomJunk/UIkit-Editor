<?php
/**
* @package    JJ_UIKit_HTML_Editor
* @copyright  Copyright (C) 2011 - 2016 JoomJunk. All rights reserved.
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$params = $displayData->params;

// Load jQuery and UIKit
HTMLHelper::_('jquery.framework');
HTMLHelper::_('behavior.core');
HTMLHelper::_('stylesheet', 'plg_uikit_htmleditor/uikit.min.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'plg_uikit_htmleditor/uikit.min.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'plg_uikit_htmleditor/uikit-noconflict.js', ['version' => 'auto', 'relative' => true]);

// Load Codemirror
HTMLHelper::_('stylesheet', 'media/editors/codemirror/lib/codemirror.min.css', ['version' => 'auto']);
HTMLHelper::_('script', 'media/editors/codemirror/lib/codemirror.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/editors/codemirror/addon/mode/overlay.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/editors/codemirror/mode/xml/xml.min.js', ['version' => 'auto']);
HTMLHelper::_('script', 'media/editors/codemirror/mode/gfm/gfm.min.js', ['version' => 'auto']);

// Load Syntax Highlighting
if ($params->get('highlight', 1) == 1)
{
	HTMLHelper::_('script', 'media/editors/codemirror/mode/htmlmixed/htmlmixed.min.js', ['version' => 'auto']);
	HTMLHelper::_('script', 'media/editors/codemirror/mode/javascript/javascript.min.js', ['version' => 'auto']);
}

// Load HTML editor
HTMLHelper::_('stylesheet', 'plg_uikit_htmleditor/htmleditor.min.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'plg_uikit_htmleditor/simple_editor.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'plg_uikit_htmleditor/htmleditor.min.js', ['version' => 'auto', 'relative' => true]);
