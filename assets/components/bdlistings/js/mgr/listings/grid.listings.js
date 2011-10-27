
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
                win.setValues({calclatlong: true});
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
            xtype: 'bdlisting-combo-targetgroup',
            emptyText: _('bdlistings.filter_on',{what: _('bdlistings.target')}),
            id: 'bdlistings-listings-target-filter',
            width: 200,
            listeners: {
                'select': {fn: this.filterByTarget, scope: this}
            }
        },'-',{
            xtype: 'bdlisting-combo-pricegroup',
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
            {name: 'pricegroup_display', type: 'string'},
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
            {name: 'neighborhood', type: 'string'},
            {name: 'zip', type: 'string'},
            {name: 'city', type: 'string'},
            {name: 'country', type: 'string'},
            {name: 'website', type: 'string'},
            {name: 'latitude', type: 'string'},
            {name: 'longitude', type: 'string'},
            {name: 'clicks', type: 'int'}
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
			header: _('bdlistings.neighborhood'),
			dataIndex: 'neighborhood',
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
		},{
			header: _('bdlistings.clicks'),
			dataIndex: 'clicks',
			sortable: true,
			width: 1
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
            handler: function () {
                win = new bdListings.window.Listing();
                win.setValues(d);
                win.show();
            }
        },'-',{
            text: _('bdlistings.remove',{what: _('bdlistings.listing')}),
            handler: function () {
                MODx.msg.confirm({
                    title: _('bdlistings.remove',{what: _('bdlistings.listing')}),
                    text: _('confirm_remove'),
                    url: bdListings.config.connector_url,
                    params: {
                        action: 'mgr/listings/remove',
                        id: d['id']
                    },
                    listeners: {
                        'success': { fn:function (r) {
                            Ext.getCmp('grid-listings').refresh();
                        }, scope: true}
                    }
                });
            }
        });

        if (m.length > 0) {
            this.addContextMenuItem(m);
        }
    }
});
Ext.reg('bdlistings-grid-listings',bdListings.grid.Listings);