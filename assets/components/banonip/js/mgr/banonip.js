var BanOnIP = function (config) {
    config = config || {};
    BanOnIP.superclass.constructor.call(this, config);
};
Ext.extend(BanOnIP, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('banonip', BanOnIP);

BanOnIP = new BanOnIP();