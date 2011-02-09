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

    $editorClass = 'CKEditor';
    if (!class_exists($editorClass)) {
      throw new sfConfigurationException(sprintf('CKEditor class not found'));
    }
    $this->_editor = new $editorClass();
    $this->_editor->basePath = sfConfig::get('app_ckeditor_basePath','/js/ckeditor/');
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