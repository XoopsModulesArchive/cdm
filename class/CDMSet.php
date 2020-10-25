<?php

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author:    Ashley Kitson                                                  //
// Copyright: (c) 2004, Ashley Kitson
// URL:       http://akitson.bbcb.co.uk                                      //
// Project:   The XOOPS Project (https://www.xoops.org/)                      //
// Module:    Code Data Management (CDM)                                     //
// ------------------------------------------------------------------------- //
/**
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @copyright (c) 2004 Ashley Kitson, Great Britain
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit('Call to include CDMMeta.php failed as XOOPS_ROOT_PATH not defined');
}

/**
 * CDM base classes
 */
require_once CDM_PATH . '/class/class.cdm.base.php';
/**
 * CDM Meta data class
 */
require_once CDM_PATH . '/class/CDMMeta.php';
/**
 * CDM Code data classs
 */
require_once CDM_PATH . '/class/CDMCode.php';

/**
 * Object handler for CDMSet
 */
class CdmCDMSetHandler extends CDMBaseHandler
{
    /**
     * Constructor
     *
     * @param xoopsDB &$db Handle to xoopsDb object
     */
    public function __construct($db)
    {
        parent::__construct($db); //call ancestor constructor
        $this->classname = 'cdmset';  //set name of object that this handler handles
    }

    /**
     * Create a new set of codes, including meta data and codes
     *
     * @return  CDMSet object
     */
    public function &_create()
    {
        $obj = new CDMSet();

        return $obj;
    }

    //end function _create

    /**
     * Retrieve a set of data
     *
     * Although you can use this method, it is better to use get() as it ensures you only
     * retrieve 'Active' data.
     *
     * @param string     $set           The code set to load
     * @param null       $meta_row_flag Option(CDM_RSTAT_ACT, ..SUS, ..DEF)  Applies only to the meta data
     * @param null       $code_row_flag Option(CDM_RSTAT_ACT, ..SUS, ..DEF)  Applies to the code data
     * @param null|mixed $lang
     * @return  object CDMSet if OK, else FALSE on failure
     */
    public function getall($set, $meta_row_flag = null, $code_row_flag = null, $lang = null)
    {
        if (!empty($set)) {
            $codeset = $this->create(false);

            if ($codeset) {
                $metaHandler = xoops_getModuleHandler('CDMMeta', CDM_DIR);

                $meta = &$metaHandler->getall($set, $meta_row_flag);

                if ($meta) {
                    // store the Meta data

                    $codeset->assignVar('meta', $meta);

                    // Now get all the codes and store them in the 'code' array

                    $sql = 'select id from ' . $this->db->prefix(CDM_TBL_CODE);

                    $sql .= ' where cd_set = ' . $this->db->quoteString($set);

                    $sql .= (empty($code_row_flag) || '' == $code_row_flag ? '' : ' and row_flag = ' . $this->db->quoteString($code_row_flag));

                    $sql .= (empty($lang) ? '' : ' and cd_lang = ' . $this->db->quoteString($lang));

                    $sql .= ' order by id';

                    $result = $this->db->query($sql);

                    if ($result) {
                        //check that we have some rows

                        if ($this->db->getRowsNum($result) > 0) {
                            //retrieve the code ids and create objects to store in our code array
                            $codeHandler = xoops_getModuleHandler('CDMCode', CDM_DIR); //get the code handler
                            $count = 0;

                            $arr = [];

                            while (false !== ($row = $this->db->fetchRow($result))) {
                                $arr[$count++] = &$codeHandler->getall($row[0], $code_row_flag);
                            }

                            $codeset->assignVar('code', $arr);

                            return $codeset;
                        }   //set error code no data returned

                        $this->setError(-1, sprintf(_MD_CDM_ERR_1, (string)$set));

                    // end if number of codes > 0
                    } else { //set database error code
                        $this->setError($this->db->errno(), $this->db->error());
                    }//end if $result
                } else { //set error code unable to instantiate Meta
                    $this->setError(-1, sprintf(_MD_CDM_ERR_2, 'CDMMeta'));
                }//end if $meta
            } else { //set error code unable to instantiate CDMCode
                $this->setError(-1, sprintf(_MD_CDM_ERR_2, 'CDMCode'));
            }//end if $code
        } else { //set error code $set not valid
            $this->setError(-1, _MD_CDM_ERR_4);
        }//end if !empty(set)

        return false;
    }

    //end function &getall

    /**
     * Safe data get
     *
     * @param string $set  name of code set to retrieve
     * @param string $lang language set to use. Default CDM_DEF_LANG
     * @return false|object
     * @return false|object
     */
    public function get($set, $lang = CDM_DEF_LANG)
    {
        return $this->getall($set, CDM_RSTAT_ACT, CDM_RSTAT_ACT, $lang);
    }

    //end function get

    public function &getkey($set, $lang = CDM_DEF_LANG)
    {
        return $this->get($set, $lang);
    }

    //end function getkey

    /**
     * Function reload  - overwrite ancestor.  Does nothing
     *
     * @return false
     */
    public function reload()
    {
        return false;
    }

    /**
     * Function insert - Does nothing.  Use getCode and getMeta to instantiate CDM objects and then
     * insert (save) them individually
     *
     * @return false
     */
    public function insert()
    {
        return false;
    }

    //end function insert
} //end class CDMSetHandler
