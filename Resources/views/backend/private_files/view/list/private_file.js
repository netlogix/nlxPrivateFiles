//{namespace name="backend/nlx_private_files/list/private_file"}
Ext.define('Shopware.apps.PrivateFiles.view.list.PrivateFile', {
    extend: 'Shopware.grid.Panel',
    alias:  'widget.private-files-grid',
    region: 'center',

    configure: function() {
        return {
            editColumn: false,
            addButton: false,
            columns: {
                name: {
                    header: '{s name="name"}{/s}'
                },
                controllerPath: {
                    header: '{s name="controllerPath"}{/s}'
                },
            }
        };
    },

    createActionColumnItems: function () {
        var me = this,
            items = me.callParent(arguments);

        items.unshift({
            action: 'notice',
            iconCls: 'sprite-documents-stack',
            handler: function (view, rowIndex, colIndex, item, opts, record) {
                var controllerPath = record.data.controllerPath;

                if (navigator.clipboard) {
                    navigator.clipboard.writeText(controllerPath)
                } else {
                    me.fallbackCopyTextToClipboard(controllerPath);
                }
                Shopware.Notification.createGrowlMessage(undefined, '{s name="copiedMessage"}{/s}');
            }
        });
        return items;
    },

    fallbackCopyTextToClipboard: function (controllerPath) {
        var textArea = document.createElement("textarea");
        textArea.value = controllerPath;

        document.body.appendChild(textArea);

        textArea.focus();
        textArea.select();

        document.execCommand('copy');

        document.body.removeChild(textArea);
    },

    createToolbarItems: function() {
        var me = this,
            items = me.callParent(arguments);

        items = Ext.Array.insert(
            items,
            0,
            [ me.createToolbarButton() ]
        );

        return items;
    },

    createToolbarButton: function() {
        var me = this;
        return Ext.create('Shopware.app.FileUpload', {
            requestURL: '{url controller="privateFiles" action="upload"}',
            padding: '6 0 0',
            enablePreviewImage: false,
            supportsFileAPI: false,
            fileInputConfig: {
                buttonOnly: true,
                buttonText : '{s name=buttonText}{/s}',
                buttonConfig : {
                    iconCls:'sprite-plus-circle'
                }
            },
            listeners: {
                fileUploaded: function (target, response) {
                    var privateFile = me.getStore('PrivateFile');

                    if (response.success === false) {
                        Shopware.Notification.createGrowlMessage('', '{s name=failureMessage}{/s}');
                    } else {
                        Shopware.Notification.createGrowlMessage('', '{s name=successMessage}{/s}');
                    }
                    privateFile.load();
                }
            }
        });
    },
});