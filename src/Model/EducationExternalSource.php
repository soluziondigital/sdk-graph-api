<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* EducationExternalSource File
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

use Microsoft\Graph\Core\Enum;

/**
* EducationExternalSource class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright 2016 Microsoft Corporation
* @license   https://opensource.org/licenses/MIT MIT License
* @version   Release: 0.1.0
* @link      https://graph.microsoft.io/
*/
class EducationExternalSource extends Enum
{
    /**
    * The Enum EducationExternalSource
    */
    const SIS = "sis";
    const MANUAL = "manual";
    const UNKNOWN_FUTURE_VALUE = "unknownFutureValue";
}