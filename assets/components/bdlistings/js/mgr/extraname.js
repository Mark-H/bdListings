var bdListings = function(config) {
    config = config || {};
    bdListings.superclass.constructor.call(this,config);
};
Ext.extend(bdListings,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('bdlistings',bdListings);
bdListings = new bdListings();