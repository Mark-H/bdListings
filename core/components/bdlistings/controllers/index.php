<?php
/**
 * bdListings
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of bdListings, a real estate property listings component
 * for MODX Revolution.
 *
 * bdListings is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * bdListings is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * bdListings; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/
require_once dirname(dirname(__FILE__)) . '/model/bdlistings.class.php';
$bdlistings = new bdListings($modx);
$bdlistings->initialize('mgr');

$modx->regClientStartupHTMLBlock('
<script type="text/javascript">
    Ext.onReady(function() {
        bdListings.config = '.$modx->toJSON($bdlistings->config).';
    });
</script>');

$modx->regClientStartupScript($bdlistings->config['js_url'].'mgr/bdlistings.class.js');
$modx->regClientStartupScript($bdlistings->config['js_url'].'mgr/action.index.js');

/* Listings */
$modx->regClientStartupScript($bdlistings->config['js_url'].'mgr/listings/grid.listings.js');
$modx->regClientStartupScript($bdlistings->config['js_url'].'mgr/listings/window.listings.js');

return '<div id="bdlistings"></div>';
?>