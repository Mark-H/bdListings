<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$corePath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/');
$modx->getService('bdlistings','bdListings',$corePath.'model/');

$defaults = include $corePath.'elements/snippets/bdRedirect.properties.php';

$p = array_merge($defaults,$scriptProperties);

$id = (int)$modx->getOption('lid',$_REQUEST,0);
if ($id > 0) {
    /* @var bdlListing $obj */
    $obj = $modx->getObject('bdlListing',$id);
    if (!($obj instanceof bdlListing)) return $modx->sendErrorPage();

    $url = $obj->get('website');
    if (!empty($url)) {
        /* Register a new click */
        /* @var bdlClicks $click */
        $click = $modx->newObject('bdlClicks');
        $click->set('listing',$obj->get('id'));
        $click->set('clicktime',date('Y-m-d H:i:s'));
        $click->set('ipaddress',$_SERVER['REMOTE_ADDR']);
        $click->set('referrer',$_SERVER['HTTP_REFERER']);
        $click->save();

        /* Redirect the user */
        return $modx->sendRedirect($url);
    }
}
return $modx->sendErrorPage();

?>