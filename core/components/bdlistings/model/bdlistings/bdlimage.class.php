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
    /**
     * Overrides xPDOSimpleObject's get method for specific image url/path handling.
     *
     * @param $k Key
     * @param $format
     * @param $formatTemplate
     * @return string Resulting value
     */
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

    /**
     * @inherit xPDOObject::remove
     * @param array $ancestors
     * @return boolean
     */
    public function remove(array $ancestors = array()) {
        $filename = $this->get('imagepath');
        if (!empty($filename)) {
            if (!@unlink($filename)) {
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[bdListings] An error occurred while trying to remove the file at: '.$filename);
            }
        }
        return parent::remove($ancestors);
    }

    /**
     * Takes an array with name, tmp_name, size, error and type (the regular file post ;) ) and a listing ID to upload the file.
     *
     * @param array $file
     * @param int $listing
     * @return array|string
     */
    public function handleUpload (array $file = array(), $listing = 0) {
        $exts = $this->xpdo->getOption('bdlistings.allowed_extensions',null,'jpg,jpeg,png,gif,ico');
        $exts = explode(',',$exts);
        $filesize = (int)$this->xpdo->getOption('bdlistings.maxfilesize',null,4194304);

        if ($file['size'] > $filesize) return array('error' => $this->xpdo->lexicon('bdlistings.error.filetoobig'));
        $extension = pathinfo($file['name'],PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension),$exts)) return array('error' => $this->xpdo->lexicon('bdlistings.error.invalidext',array('ext' => $extension)));

        if ($file['error'] > 0) { return array('error' => $this->xpdo->lexicon('bdlistings.error.file.'.$file['error'])); }

        /* New file upload */
        $uploadPath = $this->xpdo->getOption('bdlistings.uploadpath');
        if (empty($uploadPath)) $uploadPath = $this->xpdo->getOption('bdlistings.assets_path',null,$this->xpdo->getOption('assets_path').'components/bdlistings/').'uploads/';

        $this->xpdo->getService('fileHandler','modFileHandler');

        $uploadDirObj = $this->xpdo->fileHandler->make($uploadPath);
        if (!$uploadDirObj->isWritable()) {
            return array('error' => 'Main upload dir '.$uploadPath.' is not writable.');
        }

        /* Object Directory */
        $objectDirPath = $uploadDirObj->getPath().$listing;
        $objectDirObj = $this->xpdo->fileHandler->make($objectDirPath,array(),'modDirectory');
        if (!$objectDirObj->exists()) {
            if ($objectDirObj->create() !== true)
                return array('error' => 'Error creating object directory.');
        }
        if (!$objectDirObj->isWritable()) {
            return array('error' => 'Object Directory is not writable.');
        }

        $rand = rand(0,99999);
        $fileDir = $objectDirObj->getPath().'/'.$rand.'-'.$file['name'];
        $fileUrl = $listing.'/'.$rand.'-'.$file['name'];

        if (move_uploaded_file($file['tmp_name'],$fileDir)) {
            return $fileUrl;
        } else {
            $this->xpdo->log(modX::LOG_LEVEL_ERROR,'Error uploading file '.$file['tmp_name'].' to '.$fileDir);
            return array('error' => 'Error uploading file.');
        }
    }
}
?>