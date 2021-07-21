Ext.define('Shopware.apps.PrivateFiles.store.PrivateFile', {
    extend:'Shopware.store.Listing',

    configure: function() {
        return {
            controller: 'PrivateFiles'
        };
    },
    model: 'Shopware.apps.PrivateFiles.model.PrivateFile'
});