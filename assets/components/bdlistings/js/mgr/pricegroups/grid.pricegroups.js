
bdListings.grid.PriceGroups = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: bdListings.config.connector_url,
        id: 'grid-pricegroups',
        baseParams: {
            action: 'mgr/pricegroups/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            enableRowBody: true
        },
        tbar: [{
            xtype: 'button',
            text: _('bdlistings.create',{ what: _('bdlistings.pricegroup') } ),
            handler: function() {
                win = new bdListings.window.PriceGroups();
                win.show();
            }
        }],
        paging: true,
        primaryKey: 'id',
        remoteSort: true,
        sortBy: 'order',
        fields: [
            {name: 'id', type: 'int'},
            {name: 'display', type: 'string'},
            {name: 'sortorder', type: 'int'}
        ],
        columns: [{
			header: _('id'),
			dataIndex: 'id',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.display'),
			dataIndex: 'display',
			sortable: true,
			width: 3
		},{
			header: _('bdlistings.sortorder'),
			dataIndex: 'sortorder',
			sortable: true,
			width: 1
		}]
    });
    bdListings.grid.PriceGroups.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.grid.PriceGroups,MODx.grid.Grid,{
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        m.push({
            text: _('bdlistings.update',{what: _('bdlistings.pricegroup')}),
            handler: function () {
                win = new bdListings.window.PriceGroups();
                win.setValues(d);
                win.show();
            }
        },'-',{
            text: _('bdlistings.remove',{what: _('bdlistings.pricegroup')}),
            handler: function () {
                MODx.msg.confirm({
                    title: _('bdlistings.remove',{what: _('bdlistings.pricegroup')}),
                    text: _('confirm_remove'),
                    url: bdListings.config.connector_url,
                    params: {
                        action: 'mgr/pricegroups/remove',
                        id: d['id']
                    },
                    listeners: {
                        'success': { fn:function (r) {
                            Ext.getCmp('grid-pricegroups').refresh();
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
Ext.reg('bdlistings-grid-pricegroups',bdListings.grid.PriceGroups);