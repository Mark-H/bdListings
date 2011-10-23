bdListings.combo.Category = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'name',
        tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item">{name}</div></tpl>'),
        valueField: 'id',
        fields: ['id','name'],
        url: bdListings.config.connector_url,
        baseParams: {
            action: 'mgr/category/getcombo'
        },
        pageSize: 10
    });
    bdListings.combo.Category.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.combo.Category,MODx.combo.ComboBox);
Ext.reg('bdlisting-combo-category',bdListings.combo.Category);

bdListings.combo.TargetGroup = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'name',
        tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item">{name}</div></tpl>'),
        valueField: 'id',
        fields: ['id','name'],
        url: bdListings.config.connector_url,
        baseParams: {
            action: 'mgr/listings/gettargetgroups'
        },
        pageSize: 10
    });
    bdListings.combo.TargetGroup.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.combo.TargetGroup,MODx.combo.ComboBox);
Ext.reg('bdlisting-combo-targetgroup',bdListings.combo.TargetGroup);