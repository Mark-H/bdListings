
bdListings.tree.Structure = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bdlistings-tree-structure',
        url: bdListings.config.connector_url,
        action: 'mgr/structure/getnodes',
        tbar: [{
            text: _('bdlistings.create',{what: _('bdlistings.category')}),
            handler: this.createCategory,
            scope: this
        },'-',{
            text: _('ext_refresh'),
            handler: this.refresh,
            scope: this
        }],
        sortAction: 'mgr/structure/sort',
        rootVisible: true,
        rootName: _('bdlistings.categories')
    });
    bdListings.tree.Structure.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.tree.Structure,MODx.tree.Tree,{
    windows: {}
    ,_handleDrag: function(dropEvent) {
        var encNodes = this.encode();
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                data: encNodes
                ,action: this.config.sortAction
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.refresh();
                },scope:this}
                ,'failure': {fn:function(r) {
                    MODx.form.Handler.errorJSON(r);
                    this.refresh();
                    return false;
                },scope:this}
            }
        });
    }
    ,_handleDrop: function(e) {
        var target = e.target;
        var source = e.dropNode;

        var ap = true;
        return target.getDepth() <= source.getDepth() && ap;
    },
    _showContextMenu: function(n,e) {
        e.preventDefault();
        var node = n.attributes.type;
        var m = this.cm;
        m.removeAll();
        if (node == 'category') {
            m.add({
                text: _('bdlistings.create_here',{what: _('bdlistings.subcategory')}),
                handler: this.createSubCategory,
                scope: this
            },{
                text: _('bdlistings.update',{what: _('bdlistings.category')}),
                handler: this.updateCategory,
                scope: this
            },'-',{
                text: _('bdlistings.remove',{what: _('bdlistings.category')}),
                handler: this.removeCategory,
                scope: this
            });
        }
        if (node == 'subcategory') {
            m.add({
                text: _('bdlistings.update',{what: _('bdlistings.subcategory')}),
                handler: this.updateCategory,
                scope: this
            },'-',{
                text: _('bdlistings.remove',{what: _('bdlistings.subcategory')}),
                handler: this.removeCategory,
                scope: this
            });
        }
        m.showAt(e.getXY());
        m.activeNode = n;
    },
    createCategory: function() {
        win = new bdListings.window.Category();
        win.show();
    },
    createSubCategory: function() {
        var an = this.cm.activeNode;
        win = new bdListings.window.Category();
        win.setValues({'parent':an.id});
        win.show();
    },
    updateCategory: function() {
        var an = this.cm.activeNode;
        if (an) {
            var anid = an.id;
            MODx.Ajax.request({
                url: bdListings.config.connector_url,
                params: {
                    action: 'mgr/category/get',
                    id: anid
                },
                listeners: {
                    success: {fn: function(response, opts) {
                        win = new bdListings.window.Category({
                            record: response.object
                        });
                        win.show();
                    },scope: this},
                    failure: {fn: function(response, opts) {
                    },scope: this}
                }
            });
        }
    },
    removeCategory: function() {
        var an = this.cm.activeNode;
        if (an) {
            var anid = an.id;
            MODx.msg.confirm({
                title: _('bdlistings.remove.confirm',{what: _('bdlistings.category')}),
                text: _('bdlistings.remove.confirm.text',{what: _('bdlistings.category')}),
                url: bdListings.config.connector_url,
                params: {
                    action: 'mgr/category/remove',
                    id: anid
                },
                listeners: {
                    'success':{fn: function(r) {
                         Ext.getCmp('bdlistings-tree-structure').refresh();
                    },scope:this}
                }
            });
        }
    }
});
Ext.reg('bdlistings-tree-structure',bdListings.tree.Structure);
