<?php
/**
* @package    JJ_UIKit_HTML_Editor
* @copyright  Copyright (C) 2011 - 2016 JoomJunk. All rights reserved.
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC') or die;

class plgEditorUikit_htmleditor extends JPlugin
{
	protected $autoloadLanguage = true;

	public function onInit()
	{
		static $done = false;

		// Do this only once.
		if ($done)
		{
			return;
		}

		$done = true;

		// JJ UIKit HTML editor shall have its own group of plugins to modify and extend its behavior
		$result     = JPluginHelper::importPlugin('editors_uikit_htmleditor');
		$dispatcher = JEventDispatcher::getInstance();

		// At this point, params can be modified by a plugin before going to the layout renderer.
		$dispatcher->trigger('onUikit_HtmleditorBeforeInit', array(&$this->params));

		$displayData = (object) array('params'  => $this->params);

		// We need to do output buffering here because layouts may actually 'echo' things which we do not want.
		ob_start();
		JLayoutHelper::render('editors.uikit_htmleditor.init', $displayData, __DIR__ . '/layouts');
		ob_end_clean();

		$dispatcher->trigger('onUikit_HtmleditorAfterInit', array(&$this->params));
	}

	/**
	 * Copy editor content to form field.
	 *
	 * @param   string  $id  The id of the editor field.
	 *
	 * @return  string  Javascript
	 */
	public function onSave($id)
	{
		$id = json_encode((string) $id);

		return 'document.getElementById(' . $id . ').value = jQuery(' . $id . ').val();';
	}

	/**
	 * Get the editor content.
	 *
	 * @param   string  $id  The id of the editor field.
	 *
	 * @return  string  Javascript
	 */
	public function onGetContent($id)
	{
		$id = json_encode((string) $id);

		return 'jQuery(' . $id . ').val();';
	}

	/**
	 * Set the editor content.
	 *
	 * @param   string  $id       The id of the editor field.
	 * @param   string  $content  The content to set.
	 *
	 * @return  string  Javascript
	 */
	public function onSetContent($id, $content)
	{
		$id      = json_encode((string) $id);
		$content = json_encode((string) $content);

		return 'jQuery(' . $id . ').val(' . $content . ');';
	}

	/**
	 * Adds the editor specific insert method.
	 *
	 * @return  boolean
	 */
	public function onGetInsertMethod()
	{
		static $done = false;

		// Do this only once.
		if ($done)
		{
			return true;
		}

		$done = true;

		JFactory::getDocument()->addScriptDeclaration("
		;function jInsertEditorText(text, editor)
		{
			JJ_UIKIT_htmleditor.replaceSelection(text);
		}
		");

		return true;
	}

	/**
	 * Display the editor area.
	 *
	 * @param   string   $name     The control name.
	 * @param   string   $content  The contents of the text area.
	 * @param   string   $width    The width of the text area (px or %).
	 * @param   string   $height   The height of the text area (px or %).
	 * @param   int      $col      The number of columns for the textarea.
	 * @param   int      $row      The number of rows for the textarea.
	 * @param   boolean  $buttons  True and the editor buttons will be displayed.
	 * @param   string   $id       An optional ID for the textarea (note: since 1.6). If not supplied the name is used.
	 * @param   string   $asset    Not used.
	 * @param   object   $author   Not used.
	 * @param   array    $params   Associative array of editor parameters.
	 *
	 * @return  string  HTML
	 */
	public function onDisplay(
		$name, $content, $width, $height, $col, $row, $buttons = true, $id = null, $asset = null, $author = null, $params = array())
	{
		$id = empty($id) ? $name : $id;

		// Must pass the field id to the buttons in this editor.
		$buttons = $this->displayButtons($id, $buttons, $asset, $author);

		// Options for the CodeMirror constructor.
		$options = new stdClass;
		//$options->autofocus = (boolean) $this->params->get('autoFocus', true);

		$displayData = (object) array(
			'options' => $options,
			'params'  => $this->params,
			'name'    => $name,
			'id'      => $id,
			'cols'    => $col,
			'rows'    => $row,
			'content' => $content,
			'buttons' => $buttons
		);

		$dispatcher = JEventDispatcher::getInstance();

		// At this point, displayData can be modified by a plugin before going to the layout renderer.
		$results = $dispatcher->trigger('onUikit_HtmleditorBeforeDisplay', array(&$displayData));

		$results[] = JLayoutHelper::render('editors.uikit_htmleditor.element', $displayData, __DIR__ . '/layouts', array('debug' => JDEBUG));

		foreach ($dispatcher->trigger('onUikit_HtmleditorAfterDisplay', array(&$displayData)) as $result)
		{
			$results[] = $result;
		}

		return implode("\n", $results);
	}

	/**
	 * Displays the editor buttons.
	 *
	 * @param   string  $name     Button name.
	 * @param   mixed   $buttons  [array with button objects | boolean true to display buttons]
	 * @param   mixed   $asset    Unused.
	 * @param   mixed   $author   Unused.
	 *
	 * @return  string  HTML
	 */
	protected function displayButtons($name, $buttons, $asset, $author)
	{
		$return = '';

		$args = array(
			'name'  => $name,
			'event' => 'onGetInsertMethod'
		);

		$results = (array) $this->update($args);

		if ($results)
		{
			foreach ($results as $result)
			{
				if (is_string($result) && trim($result))
				{
					$return .= $result;
				}
			}
		}

		if (is_array($buttons) || (is_bool($buttons) && $buttons))
		{
			$buttons = $this->_subject->getButtons($name, $buttons, $asset, $author);

			$return .= JLayoutHelper::render('joomla.editors.buttons', $buttons);
		}

		return $return;
	}
}
