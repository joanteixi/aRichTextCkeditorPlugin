(function()
    {
        var saveCmd =
        {
            modes : {
                wysiwyg:1,
                source:1
            },
            exec : function( editor )
            {

                try
                {
                    editor.updateElement();
                    data = editor.getData();
                    r = $(document.createElement('div'))
                    r.addClass('saving')
                    r.html('<img src="/images/icons/ajax-loader.gif" alt="Grabant..." /');
                    $('#'+editor.element.getId()).before(r);
                    $.post(editor.config.ajaxsave_url,{
                        'id' : editor.config.ajaxsave_url_param_id,
                        'html' : data
                    },function()
                    {
                        r.remove();
                        editor.destroy();
                        edit ='';

                    });
                    
                } catch ( e ) {
                    alert('Error: '+e);
                }
            }
        }
        var pluginName = 'ajaxsave';
        CKEDITOR.plugins.add( pluginName,
        {
            init : function( editor )
            {
                var command = editor.addCommand( pluginName, saveCmd );
                //        command.modes = { wysiwyg : !!( editor.element.$.form ) };
                editor.ui.addButton( 'AjaxSave',
                {
                    label : editor.lang.save,
                    command : pluginName,
                    icon: "/js/ckeditor/plugins/ajaxsave/images/save.png"
            
                });
            }
        });
    })();
