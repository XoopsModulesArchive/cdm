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
// $Id: cdmformselectcountry.php,v 1.0 2004/11/02 01:24:08 akitson Exp $

/**
 * Classes used by Code Data Management system to present form data
 *
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @copyright (c) 2004 Ashley Kitson, Great Britain
 */

/**
 * Xoops form objects
 */
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
/**
 * CDM Base objects
 */
//require_once CDM_PATH."/class/class.cdm.base.php";

/**
 * Extends XoopsFormSelect to provide CDM functionality
 *
 * Returns only codes that are not defunct
 */
class CDMFormSelect extends XoopsFormSelect
{
    /**
     * Constructor
     *
     * @param string $setName Name of code set to create select list from
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $lang    The language set for the returned codes, defaults to CDM_DEF_LANG (normally ENL)
     */
    public function __construct($setName, $caption, $name, $value = null, $size = 1, $lang = CDM_DEF_LANG)
    {
        $this->XoopsFormSelect($caption, $name, $value, $size);

        $setHandler = xoops_getModuleHandler('CDMSet', CDM_DIR);

        $set = $setHandler->get($setName, $lang);

        $arr = $set->getAbrevCodeList();  //get the data

        //sort the result

        foreach ($arr as $key => $row) {
            $cd_value[$key] = $row['cd_value'];
        }

        array_multisort($cd_value, SORT_ASC, $arr);

        //set up the select list

        $res = [];

        foreach ($arr as $v) {
            $res[$v['cd']] = $v['cd_value'];
        }

        $this->addOptionArray($res);
    }
}

/**
 * Extends XoopsFormSelect to provide CDM functionality
 *
 * Returns all codes (even defunct ones). Suffixes Suspended and Defunct codes
 */
class CDMFormSelectAll extends XoopsFormSelect
{
    /**
     * Constructor
     *
     * @param string $setName Name of code set to create select list from
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $lang    The language set for the returned codes, defaults to CDM_DEF_LANG (normally ENL)
     */
    public function __construct($setName, $caption, $name, $value = null, $size = 1, $lang = CDM_DEF_LANG)
    {
        $this->XoopsFormSelect($caption, $name, $value, $size);

        $setHandler = xoops_getModuleHandler('CDMSet', CDM_DIR);

        $set = &$setHandler->getall($setName, null, null, $lang);

        $arr = $set->getAbrevCodeList();  //get the data

        //sort the result

        foreach ($arr as $key => $row) {
            $cd_value[$key] = $row['cd_value'];
        }

        array_multisort($cd_value, SORT_ASC, $arr);

        //set up the select list and include row_stat indicator

        $res = [];

        foreach ($arr as $v) {
            switch ($v['cd_value']) {
                case CDM_RSTAT_DEF:
                    $v['cd_value'] .= ' (' . CDM_RSTAT_DEF . ')';
                    break;
                case CDM_RSTAT_SUS:
                    $v['cd_value'] .= ' (' . CDM_RSTAT_SUS . ')';
                    break;
                default:
                    break;
            }

            $res[$v['cd']] = $v['cd_value'];
        }

        $this->addOptionArray($res);
    }
}

/**
 * Create a Country selection list
 */
class CDMFormSelectCountry extends CDMFormSelect
{
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $lang    The language set for the returned codes, defaults to CDM_DEF_LANG (normally ENL)
     */
    public function __construct($caption, $name, $value = null, $size = 1, $lang = CDM_DEF_LANG)
    {
        parent::__construct('COUNTRY', $caption, $name, $value, $size, $lang);
    }
}

/**
 * Create a Currency selection list
 */
class CDMFormSelectCurrency extends CDMFormSelect
{
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $lang    The language set for the returned codes, defaults to CDM_DEF_LANG (normally ENL)
     */
    public function __construct($caption, $name, $value = null, $size = 1, $lang = CDM_DEF_LANG)
    {
        parent::__construct('CURRENCY', $caption, $name, $value, $size, $lang);
    }
}

/**
 * Create a language selection list
 */
class CDMFormSelectLanguage extends CDMFormSelect
{
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $lang    The language set for the returned codes, defaults to CDM_DEF_LANG (normally ENL)
     */
    public function __construct($caption, $name, $value = null, $size = 1, $lang = CDM_DEF_LANG)
    {
        parent::__construct('LANGUAGE', $caption, $name, $value, $size, $lang);
    }
}

/**
 * Create a Row Status selection list
 */
class CDMFormSelectRstat extends XoopsFormSelect
{
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $curstat Default CDM_RSTAT_ACT. If set to CDM_RSTAT_DEF, only CDM_RSTAT_DEF will be returned in the list of options, as once a record is defuncted, it stays defuncted.
     */
    public function __construct($caption, $name, $value = null, $size = 1, $curstat = CDM_RSTAT_ACT)
    {
        $this->XoopsFormSelect($caption, $name, $value, $size);

        if (CDM_RSTAT_DEF != $curstat) {
            $this->addOption(CDM_RSTAT_ACT, CDM_RSTAT_ACT);

            $this->addOption(CDM_RSTAT_SUS, CDM_RSTAT_SUS);
        }

        $this->addOption(CDM_RSTAT_DEF, CDM_RSTAT_DEF);
    }
}

/**
 * Create a field type selection list
 *
 * Generally only for use by CDM itself to allow user to select code data type
 * Data types allowable are INT, BIGINT, CHAR and VARCHAR
 */
class CDMFormSelectFldType extends XoopsFormSelect
{
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     */
    public function __construct($caption, $name, $value = null, $size = 1)
    {
        $this->XoopsFormSelect($caption, $name, $value, $size);

        $this->addOption(CDM_OBJTYPE_INT, CDM_OBJTYPE_INT);

        $this->addOption(CDM_OBJTYPE_BIG, CDM_OBJTYPE_BIG);

        $this->addOption(CDM_OBJTYPE_CHR, CDM_OBJTYPE_CHR);

        $this->addOption(CDM_OBJTYPE_VAR, CDM_OBJTYPE_VAR);
    }
}//end class

/**
 * Extends XoopsFormSelect to provide CDM functionality
 *
 * Returns only codes that are not defunct
 * Presents a tree hiearchy select box based on child/parent relationships
 * of codes
 */
class CDMFormTreeSelect extends XoopsFormSelect
{
    /**
     * Constructor
     *
     * example: $cd_lang = new CDMFormTreeSelect('LANGUAGE',_MD_CDM_CEF3,'cd_lang',CDM_DEF_LANG,1,CDM_DEF_LANG,'cd_desc');
     *
     * @param string $setName Name of code set to create select list from
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $lang    The language set for the returned codes, defaults to CDM_DEF_LANG (normally EN)
     * @param string $dispStr The name of the variable to display to user in select list.  By default this is 'cd_value' but you may wish to use 'cd_desc' instead
     */
    public function __construct($setName, $caption, $name, $value = null, $size = 1, $lang = CDM_DEF_LANG, $dispStr = 'cd_value')
    {
        $this->XoopsFormSelect($caption, $name, $value, $size);

        $setHandler = xoops_getModuleHandler('CDMSet', CDM_DIR);

        $set = $setHandler->get($setName, $lang);

        $tree = $set->getSelTreeList($dispStr);

        $this->addOptionArray($tree);
    }

    //end function
}//end class
