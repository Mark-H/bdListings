
bdListings.grid.Listings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: bdListings.config.connector_url,
        id: 'grid-listings',
        baseParams: {
            action: 'mgr/listings/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            enableRowBody: true
        },
        tbar: [{
            xtype: 'button',
            text: _('bdlistings.create',{ what: _('bdlistings.listing') } ),
            handler: function() {
                win = new bdListings.window.Listing();
                win.show();
            }
        },'->',{
            xtype: 'textfield',
            id: 'bdlistings-listings-search',
            emptyText: _('bdlistings.search...'),
            listeners: {
                'change': { fn:this.search, scope:this},
                'render': { fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER,
                        fn: function() {
                            this.fireEvent('change',this);
                            this.blur(); // calling blur() will make the field lose focus, which in turn prevents it from resubmitting again when you click out of the field
                            return true;
                        },
                        scope: cmp
                    });
                },scope: this}
            }
        },'-',{
            xtype: 'textfield',
            emptyText: _('bdlistings.filter_on',{what: _('bdlistings.target')}),
            id: 'bdlistings-listings-target-filter',
            width: 200,
            listeners: {
                'select': {fn: this.filterByTarget, scope: this}
            }
        },'-',{
            xtype: 'textfield',
            emptyText: _('bdlistings.filter_on',{what: _('bdlistings.pricegroup')}),
            id: 'bdlistings-listings-pricegroup-filter',
            width: 200,
            listeners: {
                'select': {fn: this.filterByPriceGroup, scope: this}
            }
        },'-',{
            xtype: 'button',
            text: _('bdlistings.clearfilter'),
            listeners: {
                'click': {fn: this.clearFilter, scope: this}
            }
        }],
        paging: true,
        primaryKey: 'id',
        remoteSort: true,
        sortBy: 'title',
        fields: [
            {name: 'id', type: 'int'},
            {name: 'title', type: 'string'},
            {name: 'description', type: 'string'},
            {name: 'keywords', type: 'string'},
            {name: 'price', type: 'float'},
            {name: 'pricegroup', type: 'int'},
            {name: 'pricegroup_name', type: 'string'},
            {name: 'image', type: 'string'},
            {name: 'category', type: 'int'},
            {name: 'subcategory', type: 'int'},
            {name: 'category_name', type: 'string'},
            {name: 'subcategory_name', type: 'string'},
            {name: 'target', type: 'int'},
            {name: 'target_name', type: 'string'},
            {name: 'createdon', type: 'date', dateFormat: MODx.config['manager_date_format']+' '+MODx.config['manager_time_format']},
            {name: 'publisheduntil', type: 'date', dateFormat: MODx.config['manager_date_format']+' '+MODx.config['manager_time_format']},
            {name: 'active', type: 'boolean'},
            {name: 'featured', type: 'boolean'},
            {name: 'companyname', type: 'string'},
            {name: 'contactinfo', type: 'string'},
            {name: 'address', type: 'string'},
            {name: 'zip', type: 'string'},
            {name: 'city', type: 'string'},
            {name: 'country', type: 'string'},
            {name: 'website', type: 'string'},
            {name: 'latitude', type: 'string'},
            {name: 'longitude', type: 'string'}
        ],
        columns: [{
			header: _('id'),
			dataIndex: 'id',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.title'),
			dataIndex: 'title',
			sortable: true,
			width: 3
		},{
			header: _('bdlistings.description'),
            dataIndex: 'description',
            sortable: true,
            width: 4,
            renderer: function(val) {
                return '<div style="white-space: normal !important;">'+ val +'</div>';
            },
            hidden: true
		},{
			header: _('bdlistings.keywords'),
            dataIndex: 'keywords',
            sortable: true,
            width: 3,
            renderer: function(val) {
                return '<div style="white-space: normal !important;">'+ val +'</div>';
            },
            hidden: true
		},{
			header: _('bdlistings.price'),
			dataIndex: 'price',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.pricegroup'),
			dataIndex: 'pricegroup_display',
			sortable: true,
			width: 2,
            hidden: true
		},{
            header: _('bdlistings.image'),
            dataIndex: 'image',
            sortable: true,
            width: 3,
            hidden: true
        },{
			header: _('bdlistings.category'),
			dataIndex: 'category_name',
			sortable: true,
			width: 2
		},{
			header: _('bdlistings.subcategory'),
			dataIndex: 'category_name',
			sortable: true,
			width: 2,
            hidden: true
		},{
			header: _('bdlistings.target'),
			dataIndex: 'target_name',
			sortable: true,
			width: 2
		},{
			header: _('bdlistings.createdon'),
			dataIndex: 'createdon',
			sortable: true,
			width: 2,
            renderer: Ext.util.Format.dateRenderer(MODx.config['manager_date_format']+' '+MODx.config['manager_time_format'])
		},{
			header: _('bdlistings.publisheduntil'),
			dataIndex: 'publisheduntil',
			sortable: true,
			width: 2,
            renderer: Ext.util.Format.dateRenderer(MODx.config['manager_date_format']+' '+MODx.config['manager_time_format']),
            hidden: true
		},{
			header: _('bdlistings.active'),
			dataIndex: 'active',
			sortable: true,
			width: 1
		},{
			header: _('bdlistings.featured'),
			dataIndex: 'featured',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.companyname'),
			dataIndex: 'companyname',
			sortable: true,
			width: 2
		},{
			header: _('bdlistings.contactinfo'),
			dataIndex: 'contactinfo',
			sortable: true,
			width: 2,
            hidden: true
		},{
			header: _('bdlistings.address'),
			dataIndex: 'address',
			sortable: true,
			width: 2,
            hidden: true
		},{
			header: _('bdlistings.zip'),
			dataIndex: 'zip',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.city'),
			dataIndex: 'city',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.country'),
			dataIndex: 'country',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.website'),
			dataIndex: 'website',
			sortable: true,
			width: 2,
            hidden: true
		},{
			header: _('bdlistings.latitude'),
			dataIndex: 'latitude',
			sortable: true,
			width: 2,
            hidden: true
		},{
			header: _('bdlistings.longitude'),
			dataIndex: 'longitude',
			sortable: true,
			width: 2,
            hidden: true
		}]
    });
    bdListings.grid.Listings.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.grid.Listings,MODx.grid.Grid,{
    filterByTarget: function (cb, rec, ri) {
        this.getStore().baseParams['target'] = rec.data['id'];
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    filterByPriceGroup: function (cb, rec, ri) {
        this.getStore().baseParams['pricegroup'] = rec.data['id'];
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    search: function(tf, nv, ov) {
        var store = this.getStore();
        store.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    clearFilter: function() {
        this.getStore().baseParams['query'] = '';
        this.getStore().baseParams['target'] = '';
        this.getStore().baseParams['pricegroup'] = '';
        Ext.getCmp('bdlistings-listings-target-filter').reset();
        Ext.getCmp('bdlistings-listings-pricegroup-filter').reset();
        Ext.getCmp('bdlistings-listings-search').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        m.push({
            text: _('bdlistings.update',{what: _('bdlistings.listing')}),
            handler: function() {
                win = new bdListings.window.Listing();
                win.setValues(d);
                win.show();
            }
        });

        /*m.push('-',{
            text: _('bdlistings.listing.viewtransactions'),
            handler: function() {
                win = new bdListings.window.ViewTransactions({
                    config: { listing: Ext.getCmp('grid-listings').getSelectionModel().getSelected().data.sub_id }
                });
                win.show();
            }
        });

        if (d.pp_profileid) {
            m.push('-',{
                text: _('bdlistings.listing.paypalprofile'),
                handler: function() {
                    win = new bdListings.window.PayPalProfile({
                        config: { pp_profileid: d.pp_profileid }
                    });
                    win.show();
                }
            });
            if (d.active) {
                m.push({
                    text: _('bdlistings.listing.cancel'),
                    handler: function() {
                        o = new MODx.Window({
                            title: _('bdlistings.listing.cancel'),
                            url: bdListings.config.connector_url,
                            baseParams: {
                                action: 'mgr/listings/cancelpp'
                            },
                            fields: [{
                                xtype: 'panel',
                                html: '<p>'+_('bdlistings.listing.confirmcancel')+'</p>',
                                bodyStyle: 'padding-bottom: 12px;'
                            },{
                                fieldLabel: _('bdlistings.product'),
                                name: 'product',
                                xtype: 'statictextfield',
                                value: d.product,
                                width: '100%'
                            },{
                                fieldLabel: _('bdlistings.listing') + ' ' + _('id'),
                                name: 'sub_id',
                                xtype: 'statictextfield',
                                value: d.sub_id,
                                submitValue: true,
                                width: '100%'
                            },{
                                fieldLabel: _('bdlistings.pp_profileid'),
                                name: 'pp_profileid',
                                xtype: 'statictextfield',
                                value: d.pp_profileid,
                                width: '100%'
                            }],
                            saveBtnText: _('bdlistings.listing.docancel'),
                            cancelBtnText: _('bdlistings.listing.cancelcancel'),
                            listeners: {
                                'success': {fn: function(r) {
                                    Ext.getCmp('grid-listings').refresh();
                                },scope: this},
                                'failure': {fn:function(r) {
                                    MODx.msg.alert(_('error'),r.message);
                                },scope: this}
                            }
                        });
                        o.show();
                    }
                });
            }
        }*/

        if (m.length > 0) {
            this.addContextMenuItem(m);
        }
    }
});
Ext.reg('bdlistings-grid-listings',bdListings.grid.Listings);