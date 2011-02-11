/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
     config.extraPlugins = "ajaxsave,close,MediaEmbed";
     config.height = 500,
    config.toolbar =
    [
    ['Source','-','AjaxSave','Close','Cut','Copy','Paste','PasteText','PasteFromWord'],
    ['Undo','Redo','SelectAll','RemoveFormat','-','Replace'],
    ['Bold','Italic','Underline','Strike','-'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Flash','MediaEmbed','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']
    ];
    config.fontSize_sizes = 'Petita/0.8em;Normal/1em;Gran/1.3em;Més gran/1.5em;Extra/2em';
    config.font_names = 'Verdana;Trebuchet MS;Arial;Georgia;';
    config.stylesCombo_stylesSet = [
         { name : 'Imatge amb marge', element : 'img', attributes : { 'class' : 'marge' } },
         { name : 'Marker: Yellow', element : 'span', styles : { 'background-color' : 'Yellow' } }


    ];


};
