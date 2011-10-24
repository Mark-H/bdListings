
bdListings.grid.Clicks = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: bdListings.config.connector_url,
        id: 'grid-clicks',
        baseParams: {
            action: 'mgr/clicks/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            enableRowBody: true
        },
        tbar: [{
            xtype: 'datefield',
            id: 'bdlistings-date-start',
            emptyText: _('bdlistings.date.start'),
            listeners: {
                'select': {fn: this.filterByStart, scope: this}
            }
        },'-',{
            xtype: 'datefield',
            id: 'bdlistings-date-end',
            emptyText: _('bdlistings.date.end'),
            listeners: {
                'select': {fn: this.filterByEnd, scope: this}
            }
        },'->',{
            xtype: 'bdlisting-combo-listing',
            id: 'bdlistings-clicks-listing-filter',
            emptyText: _('bdlistings.filter_on',{what: _('bdlistings.listing')}),
            width: 200,
            listeners: {
                'select': {fn: this.filterByListing, scope: this}
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
            {name: 'listing', type: 'int'},
            {name: 'listing_title', type: 'string'},
            {name: 'clicktime', type: 'string'},
            {name: 'ipaddress', type: 'string'},
            {name: 'referrer', type: 'string'}
        ],
        columns: [{
			header: _('id'),
			dataIndex: 'id',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.title'),
			dataIndex: 'listing_title',
			sortable: true,
			width: 3
		},{
			header: _('bdlistings.clicktime'),
            dataIndex: 'clicktime',
            sortable: true,
            width: 2
		},{
			header: _('bdlistings.ipaddress'),
            dataIndex: 'ipaddress',
            sortable: true,
            width: 1
		},{
			header: _('bdlistings.referrer'),
			dataIndex: 'referrer',
			sortable: true,
			width: 3
		}]
    });
    bdListings.grid.Clicks.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.grid.Clicks,MODx.grid.Grid,{
    filterByStart: function (cb, rec, ri) {
        this.getStore().baseParams['date-start'] = rec;
        this.getBottomToolbar().changePage(1);
        this.refresh();

        graph = Ext.getCmp('bdlistings-clicks-topchart');
        graph.store.baseParams['periodstart'] = rec;
        graph.store.reload();
    },
    filterByEnd: function (cb, rec, ri) {
        this.getStore().baseParams['date-end'] = rec;
        this.getBottomToolbar().changePage(1);
        this.refresh();

        graph = Ext.getCmp('bdlistings-clicks-topchart');
        graph.store.baseParams['periodend'] = rec;
        graph.store.reload();
    },
    filterByListing: function (cb, rec, ri) {
        this.getStore().baseParams['listing'] = rec.data['id'];
        this.getBottomToolbar().changePage(1);
        this.refresh();

        graph = Ext.getCmp('bdlistings-clicks-topchart');
        graph.store.baseParams['listing'] = rec.data['id'];
        graph.store.reload();
    },
    clearFilter: function() {
        this.getStore().baseParams['listing'] = '';
        this.getStore().baseParams['date-end'] = '';
        this.getStore().baseParams['date-start'] = '';

        graph = Ext.getCmp('bdlistings-clicks-topchart');
        graph.store.baseParams['periodstart'] = '';
        graph.store.baseParams['periodend'] = '';
        graph.store.baseParams['listing'] = '';
        graph.store.reload();

        Ext.getCmp('bdlistings-date-start').reset();
        Ext.getCmp('bdlistings-date-end').reset();
        Ext.getCmp('bdlistings-clicks-listing-filter').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        /*m.push({
            text: _('bdlistings.update',{what: _('bdlistings.listing')}),
            handler: function() {
                win = new bdListings.window.Listing();
                win.setValues(d);
                win.show();
            }
        });*/

        if (m.length > 0) {
            this.addContextMenuItem(m);
        }
    }
});
Ext.reg('bdlistings-grid-clicks',bdListings.grid.Clicks);