<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* OutlookUser File
* PHP version 7
*
* @category  Library
* @package   Microsoft.Graph
* @copyright 2016 Microsoft Corporation
* @license   https://opensource.org/licenses/MIT MIT License
* @version   GIT: 0.1.0
* @link      https://graph.microsoft.io/
*/
namespace Microsoft\Graph\Model;

/**
* OutlookUser class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright 2016 Microsoft Corporation
* @license   https://opensource.org/licenses/MIT MIT License
* @version   Release: 0.1.0
* @link      https://graph.microsoft.io/
*/
class OutlookUser extends Entity
{

     /** 
     * Gets the masterCategories
     *
     * @return array The masterCategories
     */
    public function getMasterCategories()
    {
        if (array_key_exists("masterCategories", $this->_propDict)) {
           return $this->_propDict["masterCategories"];
        } else {
            return null;
        }
    }
    
    /** 
    * Sets the masterCategories
    *
    * @param OutlookCategory $val The masterCategories
    *
    * @return OutlookUser
    */
    public function setMasterCategories($val)
    {
		$this->_propDict["masterCategories"] = $val;
        return $this;
    }
    
}