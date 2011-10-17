
Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({ xtype: 'bdlistings-page-index'});
});

/*
Index page configuration.
 */
bdListings.page.Index = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        renderTo: 'realestatex',
        components: [{
            xtype: 'bdlistings-panel-header'
        },{
            xtype: 'modx-tabs',
            width: '98%',
            bodyStyle: 'padding: 10px 10px 10px 10px;',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                bodyStyle: 'padding: 5px 8px 5px 5px;'
            },
            items: [{
                title: _('bdlistings.estates'),
                items: [{
                    xtype: 'bdlistings-grid-estates',
                    border: false
                }]
            },{
                title: _('bdlistings.listings'),
                items: [{
                    xtype: 'bdlistings-grid-listings',
                    border: false
                }]
            }]
        }]
    });
    bdListings.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.page.Index,MODx.Component);
Ext.reg('bdlistings-page-index',bdListings.page.Index);

/*
Index page header configuration.
 */
bdListings.panel.Header = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('bdlistings')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        }]
    });
    bdListings.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.panel.Header,MODx.Panel);
Ext.reg('bdlistings-panel-header',bdListings.panel.Header);