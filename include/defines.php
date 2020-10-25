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
 * Constant definitions that are programming specific rather than
 * module or language specific
 *
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @copyright (c) 2004 Ashley Kitson, Great Britain
 */

/**
 * Constants for paths to cdm objects
 *
 * cannot use dirname as it doesn't nest
 * <code>
 * define('CDM_DIR', $xoopsModule->dirname());
 * </code>
 */

/**
 * The CDM module directory name
 */
define('CDM_DIR', 'cdm');
/**
 * Full file path to CDM directory
 */
define('CDM_PATH', XOOPS_ROOT_PATH . '/modules/' . CDM_DIR);
/**
 * URL to CDM
 */
define('CDM_URL', XOOPS_URL . '/modules/' . CDM_DIR);

/**
 * Constants used to describe row status of object
 */
/**
 * object is active and useable
 */
define('CDM_RSTAT_ACT', 'Active');
/**
 * object is permanently suspended and not useable
 */
define('CDM_RSTAT_DEF', 'Defunct');
/**
 * object is temporarily suspended from use
 */
define('CDM_RSTAT_SUS', 'Suspended');

/**
 * Constants used to define code and code_value data types
 */
/**
 * Integer
 */
define('CDM_OBJTYPE_INT', 'INTEGER');
/**
 * Bigint
 */
define('CDM_OBJTYPE_BIG', 'BIGINT');
/**
 * Char
 */
define('CDM_OBJTYPE_CHR', 'CHAR');
/**
 * Varchar
 */
define('CDM_OBJTYPE_VAR', 'VARCHAR');

/**
 * Other constants
 */
/**
 * default language for a code
 */
define('CDM_DEF_LANG', 'EN');
/**
 * default codeset for a code
 */
define('CDM_DEF_SET', 'BASE');

/**
 * Constant defs for tables used by CDM
 */
/**
 * code table
 */
define('CDM_TBL_CODE', 'cdm_code');
/**
 * meta table
 */
define('CDM_TBL_META', 'cdm_meta');
