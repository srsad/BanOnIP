BanOnIP.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'banonip-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('banonip_item_create'),
        width: 400,
        autoHeight: true,
        url: BanOnIP.config.connector_url,
        action: 'mgr/item/create',
        fields: getItems(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    BanOnIP.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(BanOnIP.window.CreateItem, MODx.Window);
Ext.reg('banonip-item-window-create', BanOnIP.window.CreateItem);

BanOnIP.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'banonip-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('banonip_item_update'),
        width: 400,
        autoHeight: true,
        url: BanOnIP.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    BanOnIP.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(BanOnIP.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, getItems(config)];
    },

});
Ext.reg('banonip-item-window-update', BanOnIP.window.UpdateItem);

function getItems (config){
    return [{
            xtype: 'textfield',
            fieldLabel: _('banonip_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            fieldLabel: _('banonip_item_desc_masc'),
            layout: 'column',
            items: [{
                columnWidth: .15,
                xtype: 'xcheckbox',
                boxLabel: _('banonip_item_a'),
                name: 'a',
                id: config.id + '-a',
                checked: false,
                disabled: true
            }, {
                columnWidth: .15,
                xtype: 'xcheckbox',
                boxLabel: _('banonip_item_b'),
                name: 'b',
                id: config.id + '-b',
                handler: function(field, value){
                    if (value == true) {
                        Ext.getCmp(config.id + '-c').setValue(true);
                        Ext.getCmp(config.id + '-d').setValue(true);
                    }
                }
            }, {
                columnWidth: .15,
                xtype: 'xcheckbox',
                boxLabel: _('banonip_item_c'),
                name: 'c',
                id: config.id + '-c',
                handler: function(field, value){
                    if (value == true) {
                        Ext.getCmp(config.id + '-d').setValue(true);
                    }else{
                        Ext.getCmp(config.id + '-b').setValue(false);
                    }
                }
            }, {
                columnWidth: .3,
                xtype: 'xcheckbox',
                boxLabel: _('banonip_item_d'),
                name: 'd',
                id: config.id + '-d',
                handler: function(field, value){
                    if (value == false) {
                        Ext.getCmp(config.id + '-b').setValue(false);
                        Ext.getCmp(config.id + '-c').setValue(false);
                    }
                }
            },{
                columnWidth: .15,
                style: 'text-align: right',
                xtype: 'xcheckbox',
                boxLabel: _('banonip_item_active'),
                name: 'active',
                id: config.id + '-active',
            }]
        }, {
            xtype: 'textarea',
            fieldLabel: _('banonip_item_description'),
            name: 'description',
            id: config.id + '-description',
            height: 80,
            anchor: '99%'
        }];
};