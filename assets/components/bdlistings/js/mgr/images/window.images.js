bdListings.window.Images = function(config) {
    config = config || {};
    config.listing = config.listing || 0;
    Ext.applyIf(config,{
        title: _('bdlistings.image'),
        url: bdListings.config.connector_url,
        fileUpload: true,
        closeAction: 'close',
        baseParams: {
            action: 'mgr/images/save'
        },
        fields: [{
            xtype: 'statictextfield',
            name: 'id',
            fieldLabel: _('id'),
            submitValue: true,
            hidden: true
        },{
            xtype: 'statictextfield',
            name: 'listing',
            fieldLabel: _('bdlistings.listing'),
            submitValue: true,
            hidden: true
        },{
            xtype: 'textfield',
            inputType: 'file',
            fieldLabel: _('bdlistings.image'),
            name: 'image',
            width: '95%'
        },{
            xtype: 'textfield',
            fieldLabel: _('bdlistings.caption'),
            name: 'caption',
            width: '95%'
        },{
            xtype: 'numberfield',
            fieldLabel: _('bdlistings.sortorder'),
            name: 'sortorder',
            width: '95%'
        },{
            xtype: 'checkbox',
            fieldLabel: _('bdlistings.primary'),
            name: 'primary',
            width: '95%'
        }],
        listeners: {
            success: function() {
                Ext.getCmp(config.winId).refresh();
            }
        }
    });
    bdListings.window.Images.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.window.Images,MODx.Window);
Ext.reg('bdlistings-window-images',bdListings.window.Images);