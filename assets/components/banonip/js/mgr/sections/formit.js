Ext.ComponentMgr.onAvailable('formit-grid-forms', function () {
    Ext.override(FormIt.grid.Forms, {

        getMenu: FormIt.grid.Forms.prototype.getMenu.createSequence(function (grid, rowIndex) {

            var formItem = this;
            var data = grid.getStore().getAt(rowIndex).data;

            MODx.Ajax.request({
                url: BanOnIP_connector_url,
                params: {
                    action: 'mgr/item/getitem',
                    ip: data.ip
                },
                listeners: {
                    success: {fn:function(r) {
                            if (r.results['ban'] == true) {
                                formItem.addContextMenuItem(['-', {
                                    text: _('banonip_item_formit_unban') + ' - ' + data.ip,
                                    handler: function () {
                                        itemAction('unban', data.ip, r.results['id']);
                                    }, scope: formItem
                                }]);
                            } else{
                                formItem.addContextMenuItem(['-',{
                                    text: _('banonip_item_formit_full') + ' - ' + data.ip,
                                    handler: function () {
                                        itemAction('fullban', data.ip)
                                    }, scope: formItem
                                },{
                                    text: _('banonip_item_formit_B'),
                                    handler: function () {
                                        itemAction('B_ban', data.ip)
                                    }, scope: formItem
                                },{
                                    text: _('banonip_item_formit_C'),
                                    handler: function () {
                                        itemAction('C_ban', data.ip)
                                    }, scope: formItem
                                },{
                                    text: _('banonip_item_formit_D'),
                                    handler: function () {
                                        itemAction('D_ban', data.ip)
                                    }, scope: formItem
                                }]);
                            }
                        }
                    }
                }
            });

        })
    });

    function itemAction(method, ip, resultId){
        MODx.Ajax.request({
            url: BanOnIP_connector_url,
            params: {
                action: 'mgr/item/formit',
                ip: ip,
                method: method,
                id: resultId
            },
            listeners: {
                success: {fn:function(r) {
                        MODx.msg.status({
                            title: _('banonip'),
                            message: r.results.message,
                            dontHide: true
                        });
                    }
                }
            }
        });

    }

});
