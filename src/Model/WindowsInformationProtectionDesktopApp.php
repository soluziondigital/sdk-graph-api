<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* WindowsInformationProtectionDesktopApp File
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
* WindowsInformationProtectionDesktopApp class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright 2016 Microsoft Corporation
* @license   https://opensource.org/licenses/MIT MIT License
* @version   Release: 0.1.0
* @link      https://graph.microsoft.io/
*/
class WindowsInformationProtectionDesktopApp extends WindowsInformationProtectionApp
{
    /**
    * Gets the binaryName
    * The binary name.
    *
    * @return string The binaryName
    */
    public function getBinaryName()
    {
        if (array_key_exists("binaryName", $this->_propDict)) {
            return $this->_propDict["binaryName"];
        } else {
            return null;
        }
    }

    /**
    * Sets the binaryName
    * The binary name.
    *
    * @param string $val The value of the binaryName
    *
    * @return WindowsInformationProtectionDesktopApp
    */
    public function setBinaryName($val)
    {
        $this->_propDict["binaryName"] = $val;
        return $this;
    }
    /**
    * Gets the binaryVersionLow
    * The lower binary version.
    *
    * @return string The binaryVersionLow
    */
    public function getBinaryVersionLow()
    {
        if (array_key_exists("binaryVersionLow", $this->_propDict)) {
            return $this->_propDict["binaryVersionLow"];
        } else {
            return null;
        }
    }

    /**
    * Sets the binaryVersionLow
    * The lower binary version.
    *
    * @param string $val The value of the binaryVersionLow
    *
    * @return WindowsInformationProtectionDesktopApp
    */
    public function setBinaryVersionLow($val)
    {
        $this->_propDict["binaryVersionLow"] = $val;
        return $this;
    }
    /**
    * Gets the binaryVersionHigh
    * The high binary version.
    *
    * @return string The binaryVersionHigh
    */
    public function getBinaryVersionHigh()
    {
        if (array_key_exists("binaryVersionHigh", $this->_propDict)) {
            return $this->_propDict["binaryVersionHigh"];
        } else {
            return null;
        }
    }

    /**
    * Sets the binaryVersionHigh
    * The high binary version.
    *
    * @param string $val The value of the binaryVersionHigh
    *
    * @return WindowsInformationProtectionDesktopApp
    */
    public function setBinaryVersionHigh($val)
    {
        $this->_propDict["binaryVersionHigh"] = $val;
        return $this;
    }
}
