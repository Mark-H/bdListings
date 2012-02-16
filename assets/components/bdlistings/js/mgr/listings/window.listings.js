
bdListings.window.Listing = function(config) {
    config = config || {};
    config.isNew = (config.isNew) ? true : false;
	config.id = Ext.id();
    Ext.applyIf(config,{
        title: _('bdlistings.listing'),
        url: bdListings.config.connector_url,
        closeAction: 'close',
        autoHeight: true,
        id: Ext.id(),
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
            anchor: '100%',
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
                    xtype: (config.isNew) ? 'hidden' : 'statictextfield',
                    fieldLabel: _('id'),
                    anchor: '100%',
                    submitValue: true
                },{
                    name: 'title',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.title')+'*',
                    allowBlank: false,
                    anchor: '100%'
                },{
                    name: 'price',
                    fieldLabel: _('bdlistings.price')+'*',
                    xtype: 'numberfield',
                    allowNegative: false,
                    anchor: '100%'
                },{
                    name: 'website',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.website'),
                    anchor: '100%',
                    listeners: {
                        change: function (field, newValue) {
                            if ((newValue != '') && (newValue.substr(0,4) != 'http') && (newValue.substr(0,2) != '[[')) {
                                field.setValue('http://'+newValue);
                            }
                        }
                    }
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
                    anchor: '100%',
                    height: 125
                },{
                    name: 'publisheduntil',
                    fieldLabel: _('bdlistings.publisheduntil'),
                    xtype: 'datefield',
                    anchor: '0 0'
                },{
                    name: 'active',
                    boxLabel: _('bdlistings.active'),
                    xtype: 'checkbox'
                },{
                    name: 'featured',
                    boxLabel: _('bdlistings.featured'),
                    xtype: 'checkbox'
                },{
                    name: 'extended',
                    boxLabel: _('bdlistings.extended'),
                    description: _('bdlistings.extended.desc'),
                    xtype: (bdListings.config.show_extended) ? 'checkbox' : 'hidden'
                }]
            },{
                title: _('bdlistings.listing.categorize'),
                layout: 'form',
                items: [{
                    name: 'category',
                    hiddenName: 'category',
                    fieldLabel: _('bdlistings.category')+'*',
                    xtype: 'bdlisting-combo-category',
                    allowNegative: false,
                    anchor: '0 0',
                    allowBlank: false,
                    id: 'bdl-win-'+config.id+'-category',
                    listeners: {
                        select: function(field, form, ri) {
                            subParent = form.store.data.items[ri].json;
                            subC = Ext.getCmp('bdl-win-'+config.id+'-subcategory');
							subC.setValue();
                            subC.store.baseParams['parent'] = subParent.id;
                            subC.store.load({parent: subParent.id});
                            subC.enable();
                        }
                    }
                },{
                    name: 'subcategory',
                    hiddenName: 'subcategory',
                    fieldLabel: _('bdlistings.subcategory'),
                    xtype: 'bdlisting-combo-category',
                    allowNegative: false,
                    anchor: '0 0',
                    id: 'bdl-win-'+config.id+'-subcategory',
                    listeners: {
                        render: function(field) {
                            var parCat =  Ext.getCmp('bdl-win-'+config.id+'-category');
                            if (typeof parCat != 'undefined') {
                                if (parCat.value > 0) {
                                    field.baseParams.parent = parCat.value;
                                    field.store.reload({parent: parCat.value});
                                } else {
                                    field.disable();
                                }
                            }
                        }
                    }
                },{
                    name: 'pricegroup',
                    hiddenName: 'pricegroup',
                    fieldLabel: _('bdlistings.pricegroup'),
                    xtype: 'bdlisting-combo-pricegroup',
                    anchor: '0 0'
                },{
                    name: 'target',
                    hiddenName: 'target',
                    fieldLabel: _('bdlistings.target'),
                    xtype: 'bdlisting-combo-targetgroup',
                    allowNegative: false,
                    anchor: '0 0'
                },{
                    name: 'keywords',
                    fieldLabel: _('bdlistings.keywords'),
                    xtype: 'textfield',
                    allowNegative: false,
                    anchor: '100%'
                }]
            },{
                title: _('bdlistings.listing.location'),
                layout: 'form',
                items: [{
                    name: 'companyname',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.companyname')+'*',
                    anchor: '100%',
                    allowBlank: false
                },{
                    name: 'contactinfo',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.contactinfo'),
                    anchor: '100%'
                },{
                    name: 'phone',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.phone'),
                    anchor: '100%'
                },{
                    name: 'email',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.email'),
                    anchor: '100%',
                    vtype: 'email'
                },{
                    name: 'address',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.address'),
                    anchor: '100%'
                },{
                    name: 'neighborhood',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.neighborhood'),
                    anchor: '100%'
                },{
                    name: 'zip',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.zip'),
                    anchor: '100%'
                },{
                    name: 'city',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.city'),
                    anchor: '100%'
                },{
                    name: 'country',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.country'),
                    anchor: '100%'
                },{
                    name: 'calclatlong',
                    xtype: 'checkbox',
                    boxLabel: _('bdlistings.calclatlong'),
                    description: _('bdlistings.calclatlong.desc')
                },{
                    name: 'latitude',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.latitude'),
                    anchor: '100%'
                },{
                    name: 'longitude',
                    xtype: 'textfield',
                    fieldLabel: _('bdlistings.longitude'),
                    anchor: '100%'
                }]
            },{
                title: _('bdlistings.listing.images'),
                tabTip: (config.isNew) ? _('bdlistings.listing.images.saverequired') : '',
                disabled: config.isNew,
                items: [{
                    xtype: 'bdlistings-grid-images',
                    listing: config.listing
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
