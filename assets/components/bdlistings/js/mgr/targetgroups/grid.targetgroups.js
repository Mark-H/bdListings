
bdListings.grid.TargetGroups = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: bdListings.config.connector_url,
        id: 'grid-targetgroups',
        baseParams: {
            action: 'mgr/targetgroups/getlist'
        },
        params: [],
        viewConfig: {
            forceFit: true,
            enableRowBody: true
        },
        tbar: [{
            xtype: 'button',
            text: _('bdlistings.create',{ what: _('bdlistings.target') } ),
            handler: function() {
                win = new bdListings.window.TargetGroups();
                win.show();
            }
        }],
        paging: true,
        primaryKey: 'id',
        remoteSort: true,
        sortBy: 'name',
        fields: [
            {name: 'id', type: 'int'},
            {name: 'name', type: 'string'}
        ],
        columns: [{
			header: _('id'),
			dataIndex: 'id',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.name'),
			dataIndex: 'name',
			sortable: true,
			width: 3
		}]
    });
    bdListings.grid.TargetGroups.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.grid.TargetGroups,MODx.grid.Grid,{
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        m.push({
            text: _('bdlistings.update',{what: _('bdlistings.target')}),
            handler: function () {
                win = new bdListings.window.TargetGroups();
                win.setValues(d);
                win.show();
            }
        },'-',{
            text: _('bdlistings.remove',{what: _('bdlistings.target')}),
            handler: function () {
                MODx.msg.confirm({
                    title: _('bdlistings.remove',{what: _('bdlistings.target')}),
                    text: _('confirm_remove'),
                    url: bdListings.config.connector_url,
                    params: {
                        action: 'mgr/targetgroups/remove',
                        id: d['id']
                    },
                    listeners: {
                        'success': { fn:function (r) {
                            Ext.getCmp('grid-targetgroups').refresh();
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
Ext.reg('bdlistings-grid-targetgroups',bdListings.grid.TargetGroups);