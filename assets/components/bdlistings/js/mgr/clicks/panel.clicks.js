bdListings.panel.Clicks = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false,
        baseCls: 'modx-panel',
        items: [{
            xtype: 'linechart',
            id: 'bdlistings-clicks-topchart',
            xField: 'period',
            yField: 'clicks',
            height: 200,
            store: new Ext.data.JsonStore({
                url: bdListings.config.connector_url
                ,baseParams: {
                    action: 'mgr/clicks/gettotal'
                }
                ,fields: ['period', 'clicks']
                ,autoLoad: true
                ,root: 'results'
            })
        }]
    });
    bdListings.panel.Clicks.superclass.constructor.call(this,config);
};
Ext.extend(bdListings.panel.Clicks,MODx.Panel);
Ext.reg('bdlistings-panel-clicks',bdListings.panel.Clicks);