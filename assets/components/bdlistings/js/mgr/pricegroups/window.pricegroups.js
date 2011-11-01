bdListings.window.PriceGroups = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bdlistings.pricegroup'),
        url: bdListings.config.connector_url,
        baseParams: {
            action: 'mgr/pricegroups/save'
        },
        fields: [{
            xtype: 'statictextfield',
            name: 'id',
            fieldLabel: _('id'),
            submitValue: true
        },{
            xtype: 'textfield',
            fieldLabel: _('bdlistings.display'),
            name: 'display',
            allowBlank: false,
            width: '95%'
        },{
            xtype: 'numberfield',
            fieldLabel: _('bdlistings.sortorder'),
            name: 'sortorder',
            width: '95%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp('grid-pricegroups').refresh();
            }
        }
    });
    bdListings.window.PriceGroups.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.window.PriceGroups,MODx.Window);
Ext.reg('bdlistings-window-pricegroups',bdListings.window.PriceGroups);