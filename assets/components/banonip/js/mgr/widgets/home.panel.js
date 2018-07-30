BanOnIP.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('banonip') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            items: [{
                html: _('banonip_intro_msg'),
                cls: 'panel-desc',
            }, {
                xtype: 'banonip-grid-items',
                cls: 'main-wrapper',
            }]

        }]
    });
    BanOnIP.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(BanOnIP.panel.Home, MODx.Panel);
Ext.reg('banonip-panel-home', BanOnIP.panel.Home);
