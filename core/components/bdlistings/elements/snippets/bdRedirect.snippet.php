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
    /* @var bdlListing $listing */
    $listing = $modx->getObject('bdlListing',$id);
    if (!($listing instanceof bdlListing)) return $modx->sendErrorPage();

    $url = $listing->get('website');
    if (!empty($url)) {
        $listing->registerClick();

        /* Redirect the user */
        return $modx->sendRedirect($url);
    }
}
return $modx->sendErrorPage();

?>
