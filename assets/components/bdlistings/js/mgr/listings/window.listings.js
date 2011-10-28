
bdListings.window.Listing = function(config) {
    config = config || {};
    this.id = Ext.id();
    Ext.applyIf(config,{
        title: _('bdlistings.listing'),
        url: bdListings.config.connector_url,
        closeAction: 'close',
        autoHeight: true,
        baseParams: {
            action: 'mgr/listings/save'
        },
        width: 600,
        fields: [{
            xtype: 'modx-tabs',
            hideMode: 'offsets',
            autoHeight: true,
            deferredRender: false,
            forceLayout: true,
            width: '98%',
            bodyStyle: 'padding: 10px 10px 10px 10px;',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                bodyStyle: 'padding: 5px 8px 5px 5px;',
                layout: 'form',
                deferredRender: false,
                forceLayout: true
            },
            items: [{
                title: _('bdlistings.listing.details'),
                layout: 'form',
                items: [{
                    name: 'id',
                    xtype: 'statictextfield',
                    fieldLabel: _('id'),
                    width: '98%',
                    submitValue: true
                },{
                    name: 'title',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.title')+'*',
                    allowBlank: false,
                    width: '98%'
                },{
                    name: 'price',
                    fieldLabel: _('bdlistings.price')+'*',
                    xtype: 'numberfield',
                    allowNegative: false,
                    width: '98%',
                    allowBlank: false
                },{
                    name: 'website',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.website'),
                    width: '98%'
                },{
                    name: 'description',
                    hiddenName: 'description',
                    fieldLabel: _('bdlistings.description'),
                    xtype: 'htmleditor',
                    allowBlank: true,
                    enableFont: false,
                    enableFontSize: false,
                    enableLinks: true,
                    enableColors: false,
                    enableAlignment: false,
                    width: '99%',
                    height: 125
                },{
                    name: 'image',
                    fieldLabel: _('bdlistings.image'),
                    xtype: 'modx-combo-browser',
                    width: '95%',
                    hideFiles: true,
                    anchor: '0 0'
                },{
                    name: 'publisheduntil',
                    fieldLabel: _('bdlistings.publisheduntil'),
                    xtype: 'datefield',
                    anchor: '0 0'
                },{
                    name: 'active',
                    fieldLabel: _('bdlistings.active'),
                    xtype: 'checkbox'
                },{
                    name: 'featured',
                    fieldLabel: _('bdlistings.featured'),
                    xtype: 'checkbox'
                }]
            },{
                title: _('bdlistings.listing.categorize'),
                layout: 'form',
                items: [{
                    name: 'pricegroup',
                    hiddenName: 'pricegroup',
                    fieldLabel: _('bdlistings.pricegroup')+'*',
                    xtype: 'bdlisting-combo-pricegroup',
                    width: '92%',
                    anchor: '0 0',
                    allowBlank: false
                },{
                    name: 'category',
                    hiddenName: 'category',
                    fieldLabel: _('bdlistings.category')+'*',
                    xtype: 'bdlisting-combo-category',
                    allowNegative: false,
                    width: '92%',
                    anchor: '0 0',
                    allowBlank: false,
                    id: 'bdl-win-'+this.id+'-category',
                    listeners: {
                        select: function(field, form, ri) {
                            subParent = form.store.data.items[ri].json;
                            subC = Ext.getCmp('bdl-win-'+this.id+'-subcategory');
                            subC.store.baseParams['parent'] = subParent.id;
                            subC.store.reload({parent: subParent.id});
                        }, scope: this
                    }
                },{
                    name: 'subcategory',
                    hiddenName: 'subcategory',
                    fieldLabel: _('bdlistings.subcategory'),
                    xtype: 'bdlisting-combo-category',
                    allowNegative: false,
                    width: '92%',
                    anchor: '0 0',
                    id: 'bdl-win-'+this.id+'-subcategory',
                    listeners: {
                        render: function(field, form, ri) {
                            parCat =  Ext.getCmp('bdl-win-'+this.id+'-category');
                            if (typeof parCat != 'undefined') {
                                Ext.getCmp('bdl-win-'+this.id+'-subcategory').store.reload({parent: parCat.value});
                            }
                        }, scope: this
                    }
                },{
                    name: 'target',
                    hiddenName: 'target',
                    fieldLabel: _('bdlistings.target'),
                    xtype: 'bdlisting-combo-targetgroup',
                    allowNegative: false,
                    width: '92%',
                    anchor: '0 0'
                },{
                    name: 'keywords',
                    fieldLabel: _('bdlistings.keywords'),
                    xtype: 'textfield',
                    allowNegative: false,
                    width: '98%'
                }]
            },{
                title: _('bdlistings.listing.location'),
                layout: 'form',
                items: [{
                    name: 'companyname',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.companyname')+'*',
                    width: '98%',
                    allowBlank: false
                },{
                    name: 'contactinfo',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.contactinfo'),
                    width: '98%'
                },{
                    name: 'address',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.address'),
                    width: '98%'
                },{
                    name: 'neighborhood',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.neighborhood'),
                    width: '98%'
                },{
                    name: 'zip',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.zip'),
                    width: '98%'
                },{
                    name: 'city',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.city'),
                    width: '98%'
                },{
                    name: 'country',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.country'),
                    width: '98%'
                },{
                    name: 'calclatlong',
                    xtype: 'checkbox',
                    fieldLabel: _('bdlistings.calclatlong')
                },{
                    name: 'latitude',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.latitude'),
                    width: '98%'
                },{
                    name: 'longitude',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.longitude'),
                    width: '98%'
                }]
            }],
            listeners: {
                'tabchange': function() {
                    this.syncSize();
                },
                scope: this
            }
        }],
        listeners: {
            'success': function() {
                Ext.getCmp('grid-listings').refresh();
            }
        }
    });
    bdListings.window.Listing.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.window.Listing,MODx.Window);
Ext.reg('bdlisting-window-listings',bdListings.window.Listing);