<?php
// original class from sfCkEditorPlugin

class sfWidgetFormCKEditor extends sfWidgetFormTextarea {

  protected $_editor;
  protected $_finder;

  protected function configure($options = array(), $attributes = array()) {


    $this->addOption('editor', 'ck');
    $this->addOption('css', false);
    $this->addOption('toolbar', 'basic');
    $this->addOption('height', '225');
    $this->addOption('width', '100%');
    $this->addOption('jsoptions', null);

    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    $path = sfConfig::get('sf_rich_text_ck_js_dir', 'aRichTextCkeditorPlugin/js/ckeditor');
    $php_file = $path . DIRECTORY_SEPARATOR . 'ckeditor.php';

    if (!is_readable(sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $php_file)) {
      throw new sfConfigurationException('You must install CKEditor to use this widget (see rich_text_ck_js_dir settings). ' . sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $php_file);
    }
    // CKEditor.php class is written with backward compatibility of PHP4.
    // This reportings are to turn off errors with public properties and already declared constructor
    $error_reporting = error_reporting(E_ALL);
    require_once(sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $php_file);
    // turn error reporting back to your settings
    error_reporting($error_reporting);

    $editorClass = 'CKEditor';
    if (!class_exists($editorClass)) {
      throw new sfConfigurationException(sprintf('CKEditor class not found'));
    }

    $this->_editor = new $editorClass();
    $this->_editor->basePath = sfContext::getInstance()->getRequest()->getRelativeUrlRoot() . DIRECTORY_SEPARATOR . sfConfig::get('app_ckeditor_basePath', $path . '/');
    $this->_editor->returnOutput = true;

    // Joan Teixidó: i didn't test if CKFinder can run here
    if (sfConfig::get('app_ckfinder_active', false) == 'true') {
      $finderClass = 'CKFinder';
      if (!class_exists($finderClass)) {
        throw new sfConfigurationException(sprintf('CKFinder class not found'));
      }
      $this->_finder = new $finderClass();
      $this->_finder->BasePath = sfConfig::get('app_ckfinder_basePath');
      $this->_finder->SetupCKEditorObject($this->_editor);
    }

    // witch toolbar render.

    $this->configure_options = array();
    $this->configure_options['toolbar'] = $this->getToolbar($this->getOption('toolbar'));

    if ($jsoptions = $this->getOption('jsoptions')) {
      foreach ($jsoptions as $k => $v) {
        $this->_editor->config[$k] = $v;
      }
    }
    return parent::render($name, $value, $attributes, $errors) . $this->_editor->replace($name, $this->configure_options);
  }


  public function getEditor() {
    return $this->_editor;
  }

  public function getFinder() {
    return $this->_finder;
  }

  /**
   * This function returns an array of options that define the toolbar.
   * Maybe it'll be better to load js file (see documentation of ckEditor)
   *
   * @param String $type
   * @return array
   */
  protected function getToolbar($type) {
    switch ($type) {
      case 'full':
        $r = array(
            array('Source', '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'),
            array('Undo', 'Redo', 'SelectAll', 'RemoveFormat', '-', 'Replace'),
            array('Bold', 'Italic', 'Underline', 'Strike', '-'),
            array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'),
            array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
            array('Link', 'Unlink', 'Anchor'),
            array('Image', 'Flash', 'MediaEmbed', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'),
            array('Styles', 'Format', 'Font', 'FontSize'),
            array('TextColor', 'BGColor'),
            array('Maximize', 'ShowBlocks', '-', 'About')
        );
        return $r;
        break;


      default:
        $r = array(
            array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
            array('Link', 'Unlink', 'Anchor')
        );
        return $r;
        break;
    }
  }

}
