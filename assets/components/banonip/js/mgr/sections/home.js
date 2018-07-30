BanOnIP.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'banonip-panel-home',
            renderTo: 'banonip-panel-home-div'
        }]
    });
    BanOnIP.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(BanOnIP.page.Home, MODx.Component);
Ext.reg('banonip-page-home', BanOnIP.page.Home);