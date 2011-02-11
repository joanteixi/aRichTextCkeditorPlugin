<?php

class sfWidgetFormCKEditor extends sfWidgetFormTextarea {

  protected $_editor;
  protected $_finder;

  protected function configure($options = array(), $attributes = array()) {
    $this->addOption('editor', 'ck');
    $this->addOption('css', false);
    $this->addOption('tool', 'Default');
    $this->addOption('height', '225');
    $this->addOption('width', '100%');

    $path = sfConfig::get('sf_rich_text_ck_js_dir','aRichTextCkeditorPlugin/js/ckeditor');
    $php_file =  $path . DIRECTORY_SEPARATOR . 'ckeditor.php';

    if (!is_readable(sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $php_file)) {
      throw new sfConfigurationException('You must install FCKEditor to use this widget (see rich_text_fck_js_dir settings). ' . sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $php_file);
    }
    // CKEditor.php class is written with backward compatibility of PHP4.
    // This reportings are to turn off errors with public properties and already declared constructor
//    $error_reporting = error_reporting(E_ALL);

    require_once(sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $php_file);

    // turn error reporting back to your settings
//    error_reporting($error_reporting);
    $editorClass = 'CKEditor';
    if (!class_exists($editorClass)) {
      throw new sfConfigurationException(sprintf('CKEditor class not found'));
    }
    $this->_editor = new $editorClass();
    $this->_editor->basePath = sfConfig::get('app_ckeditor_basePath',$path.'/');
    $this->_editor->returnOutput = true;
    if (sfConfig::get('app_ckfinder_active', false) == 'true') {
      $finderClass = 'CKFinder';
      if (!class_exists($finderClass)) {
        throw new sfConfigurationException(sprintf('CKFinder class not found'));
      }
      $this->_finder = new $finderClass();
      $this->_finder->BasePath = sfConfig::get('app_ckfinder_basePath');
      $this->_finder->SetupCKEditorObject($this->_editor);
    }
    if (isset($options['jsoptions'])) {
      $this->addOption('jsoptions', $options['jsoptions']);
    }
    parent::configure($options, $attributes);
  }

  public function getJavascript () {
    return array('/js/ckeditor/ckeditor.js');
  }
  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    $jsoptions = $this->getOption('jsoptions');
    if ($jsoptions) {
      $this->setJSOptions($name, $value, $attributes, $errors);
    }

//    $content = $this->_editor->editor('ckeditor');
    return parent::render($name, $value, $attributes, $errors) . $this->_editor->replace($name);
  }

  protected function setJSOptions($name, $value = null, $attributes = array(), $errors = array()) {
    $jsoptions = $this->getOption('jsoptions');
    foreach ($jsoptions as $k => $v) {
      $this->_editor->config[$k] = $v;
    }
  }

  public function getEditor() {
    return $this->_editor;
  }

  public function getFinder() {
    return $this->_finder;
  }

}
