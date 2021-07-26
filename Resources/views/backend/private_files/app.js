Ext.define('Shopware.apps.PrivateFiles', {
    extend: 'Enlight.app.SubApplication',

    name: 'Shopware.apps.PrivateFiles',

    loadPath: '{url action=load}',
    bulkLoad: true,

    controllers: [ 'Main' ],

    views: [
        'list.Window',
        'list.PrivateFile'
    ],

    models: [ 'PrivateFile' ],
    stores: [ 'PrivateFile' ],

    launch: function() {
        return this.getController('Main').mainWindow;
    }
});