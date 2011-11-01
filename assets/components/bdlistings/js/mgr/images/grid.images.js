
bdListings.grid.Images = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: bdListings.config.connector_url,
        baseParams: {
            action: 'mgr/images/getlist',
            listing: config.listing
        },
        params: [],
        viewConfig: {
            forceFit: true,
            enableRowBody: true
        },
        tbar: [{
            xtype: 'button',
            text: _('bdlistings.create',{ what: _('bdlistings.image') } ),
            handler: function() {
                win = new bdListings.window.Images({winId: this.id});
                win.setValues({listing: config.listing});
                win.show();
            }
        }],
        paging: true,
        pageSize: 5,
        primaryKey: 'id',
        remoteSort: true,
        sortBy: 'order',
        fields: [
            {name: 'id', type: 'int'},
            {name: 'image', type: 'string'},
            {name: 'listing', type: 'int'},
            {name: 'caption', type: 'string'},
            {name: 'sortorder', type: 'int'}
        ],
        columns: [{
			header: _('id'),
			dataIndex: 'id',
			sortable: true,
			width: 1,
            hidden: true
		},{
			header: _('bdlistings.image'),
			dataIndex: 'image',
			sortable: true,
			width: 2,
            renderer: this.renderImage
		},{
			header: _('bdlistings.caption'),
			dataIndex: 'caption',
			sortable: true,
			width: 3
		},{
			header: _('bdlistings.sortorder'),
			dataIndex: 'sortorder',
			sortable: true,
			width: 1
		}]
    });
    bdListings.grid.Images.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.grid.Images,MODx.grid.Grid,{
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        m.push({
            text: _('bdlistings.update',{what: _('bdlistings.image')}),
            handler: function () {
                win = new bdListings.window.Images({winId: this.id});
                win.setValues(d);
                win.show();
            }
        },'-',{
            text: _('bdlistings.remove',{what: _('bdlistings.image')}),
            handler: function () {
                MODx.msg.confirm({
                    title: _('bdlistings.remove',{what: _('bdlistings.image')}),
                    text: _('confirm_remove'),
                    url: bdListings.config.connector_url,
                    params: {
                        action: 'mgr/images/remove',
                        id: d['id']
                    },
                    listeners: {
                        'success': { fn:function (r) {
                            this.refresh();
                        }, scope: this}
                    }
                });
            }
        });

        if (m.length > 0) {
            this.addContextMenuItem(m);
        }
    },
    renderImage: function (val) {
        if (val.length > 0)
            return '<img src="' + MODx.config.connectors_url + 'system/phpthumb.php?src=' + encodeURI(val) + '&w=100&h=100" alt="'+val+'"/>';
        return '';
    }
});
Ext.reg('bdlistings-grid-images',bdListings.grid.Images);