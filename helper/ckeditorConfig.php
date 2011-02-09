<?php

class ckeditorConfig {

  public static function getBasic($options = array()) {
    $default = array(
        'extraPlugins' => "ajaxsave,close,MediaEmbed",
        'toolbar' => array(
            array('Source', '-', 'AjaxSave', 'Close', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'),
            array('Undo', 'Redo', 'SelectAll', 'RemoveFormat'),
            array('Bold', 'Italic', 'Underline', 'Strike', '-'),
            array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'),
            array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
            array('Link', 'Unlink', 'Anchor'),
            array('Image', 'Flash', 'MediaEmbed', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'),
            array('Styles', 'Format', 'FontSize'),
            array('TextColor', 'BGColor'),
            array('Maximize', 'ShowBlocks', '-', 'About')
        ),
        'filebrowserBrowseUrl' => sfContext::getInstance()->getController()->genUrl('sfAsset/list?popup=4')
    );


    $default_options = array();
    $default_options['jsoptions'] = array_merge($default, $options);
    return $default_options;
  }

  public static function getBackendEditor($options = array()) {
    $default = array(
    'extraPlugins' => "MediaEmbed",
    'toolbar' => array(
    array('Source', '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'),
    array('Undo', 'Redo', 'SelectAll', 'RemoveFormat'),
    array('Bold', 'Italic', 'Underline', 'Strike', '-'),
    array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'),
    array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
    array('Link', 'Unlink', 'Anchor'),
    array('Image', 'Flash', 'MediaEmbed', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'),
    array('Styles', 'Format', 'FontSize'),
    array('TextColor', 'BGColor'),
    array('Maximize', 'ShowBlocks', '-', 'About')
    ),
    'internal_links_url' => sfContext::getInstance()->getController()->genUrl('@iog_apartat_admin_list_links'),
    'filebrowserImageBrowseUrl' => sfContext::getInstance()->getController()->genUrl('sfAsset/list?popup=4'),
    'filebrowserBrowseUrl' => sfContext::getInstance()->getController()->genUrl('sfAsset/list?popup=6'),
    'stylesCombo_stylesSet' => array(
    array('name' => 'Normal', 'element' => 'p', 'attributes' => array('class' => '')),
    array('name' => 'Destacat', 'element' => 'p', 'attributes' => array('class' => 'destacat')),
    array('name' => 'Esquerra', 'element' => 'img', 'attributes' => array('class' => 'alinear_left')),
    array('name' => 'Dreta', 'element' => 'img', 'attributes' => array('class' => 'alinear_right')),
    )
    );


    $default_options = array();
    $default_options['jsoptions'] = array_merge($default, $options);
    return $default_options;
  }

}