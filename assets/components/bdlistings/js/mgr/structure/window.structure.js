bdListings.window.Category = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bdlistings.category'),
        url: bdListings.config.connector_url,
        baseParams: {
            action: 'mgr/category/save'
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
            xtype: 'htmleditor',
            fieldLabel: _('bdlistings.description'),
            name: 'description',
            hiddenName: 'description',
            allowBlank: true,
            enableFont: false,
            enableFontSize: false,
            enableLinks: true,
            enableColors: false,
            enableAlignment: false,
            width: '95%',
            height: 150
        },{
            xtype: 'bdlisting-combo-category',
            fieldLabel: _('bdlistings.parent'),
            name: 'parent',
            hiddenName: 'parent',
            width: '95%'
        },{
            xtype: 'numberfield',
            fieldLabel: _('bdlistings.sortorder'),
            name: 'sortorder',
            hiddenName: 'sortorder',
            width: '95%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp('bdlistings-tree-structure').refresh();
            }
        }
    });
    bdListings.window.Category.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.window.Category,MODx.Window);
Ext.reg('bdlistings-window-category',bdListings.window.Category);