Ext.define('Shopware.apps.PrivateFiles.model.PrivateFile', {
    extend: 'Shopware.data.Model',

    configure: function() {
        return {
            controller: 'PrivateFiles'
        };
    },

    fields: [
        { name : 'id', type: 'string', useNull: true },
        { name : 'name', type: 'string' },
        { name : 'controllerPath', type: 'string'}
    ]
});