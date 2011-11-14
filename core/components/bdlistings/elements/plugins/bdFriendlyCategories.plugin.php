<?php
/* @var modX $modx */
$search = $_SERVER['REQUEST_URI'];
$base_url = $modx->getOption('base_url');

if ($base_url != '/') {
    $search = str_replace($base_url,'',$search);
}
$search = trim($search, '/');

$blog = $modx->getOption('bdlistings.categoryresource',null);
if ($blog < 1) { $modx->log(modX::LOG_LEVEL_ERROR,'[bdListings] bdlistings.categoryresource system setting not set, required for friendly category urls.'); return; }
$blogurl = $modx->makeUrl($blog);
$blogurl = trim($blogurl,'/');
$bloglen = strlen($blogurl);

if (substr($search,0,$bloglen) == $blogurl) {
    $cat = trim(substr($search,$bloglen),'/');
    $modx->setPlaceholder('category',urldecode($cat));
    $modx->sendForward($blog);
}