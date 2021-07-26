//{namespace name="backend/nlx_private_files/list/window"}
Ext.define('Shopware.apps.PrivateFiles.view.list.Window', {
    extend: 'Shopware.window.Listing',
    alias: 'widget.private-files-window',
    height: 450,
    title : '{s name=window_title}{/s}',

    configure: function() {
        return {
            listingGrid: 'Shopware.apps.PrivateFiles.view.list.PrivateFile',
            listingStore: 'Shopware.apps.PrivateFiles.store.PrivateFile'
        };
    }
});