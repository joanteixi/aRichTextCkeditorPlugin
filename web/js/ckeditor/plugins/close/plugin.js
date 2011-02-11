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
                    editor.destroy();
                    edit ='';
                } catch ( e ) {
                    alert('Error: '+e);
                }
            }
        }
        var pluginName = 'close';
        CKEDITOR.plugins.add( pluginName,
        {
            init : function( editor )
            {
                var command = editor.addCommand( pluginName, saveCmd );
                editor.ui.addButton( 'Close',
                {
                    label : editor.lang.close,
                    command : pluginName,
                    icon: "/js/ckeditor/plugins/close/images/close.png"
            
                });
            }
        });
    })();
