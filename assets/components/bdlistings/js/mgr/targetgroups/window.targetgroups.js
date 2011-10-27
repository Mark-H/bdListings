bdListings.window.TargetGroups = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bdlistings.target'),
        url: bdListings.config.connector_url,
        baseParams: {
            action: 'mgr/targetgroups/save'
        },
        fields: [{
            xtype: 'statictextfield',
            name: 'id',
            fieldLabel: _('id'),
            submitValue: true
        },{
            xtype: 'textfield',
            fieldLabel: _('bdlistings.name'),
            name: 'name',
            allowBlank: false,
            width: '95%'
        },{
            xtype: 'numberfield',
            fieldLabel: _('bdlistings.sortorder'),
            name: 'sortorder',
            allowBlank: false,
            width: '95%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp('grid-targetgroups').refresh();
            }
        }
    });
    bdListings.window.TargetGroups.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.window.TargetGroups,MODx.Window);
Ext.reg('bdlistings-window-targetgroups',bdListings.window.TargetGroups);