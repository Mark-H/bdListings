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
class bdlImage extends xPDOSimpleObject {
    public function get($k, $format = null, $formatTemplate= null) {
        switch ($k) {
            case 'imagepath':
                if (empty($format)) $format = array();
                $format['src'] = $this->xpdo->getOption('bdlistings.uploadpath');
                if (empty($format['src'])) $format['src'] = $this->xpdo->getOption('bdlistings.assets_path',null,$this->xpdo->getOption('assets_path').'components/bdlistings/').'uploads/';
                $format['src'] .= parent::get('image');
                $value = $format['src'];

                break;
            case 'image':
                if (empty($format)) $format = array();
                $format['src'] = $this->xpdo->getOption('bdlistings.uploadurl');
                if (empty($format['src'])) $format['src'] = $this->xpdo->getOption('bdlistings.assets_url',null,$this->xpdo->getOption('assets_url').'components/bdlistings/').'uploads/';
                $format['src'] .= parent::get('image');
                $value = $format['src'];
                break;

            default:
                $value = parent::get($k,$format,$formatTemplate);
                break;
        }
        return $value;
    }

    public function remove(array $ancestors = array()) {
        $filename = $this->get('imagepath');
        if (!empty($filename)) {
            if (!@unlink($filename)) {
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[bdListings] An error occurred while trying to remove the file at: '.$filename);
            }
        }
        return parent::remove($ancestors);
    }
}
?>