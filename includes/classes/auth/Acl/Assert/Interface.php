<?php
/**
 * auth Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.auth.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@auth.com so we can send you a copy immediately.
 *
 * @category   auth
 * @package    auth_Acl
 * @copyright  Copyright (c) 2005-2008 auth Technologies USA Inc. (http://www.auth.com)
 * @license    http://framework.auth.com/license/new-bsd     New BSD License
 * @version    $Id: Interface.php 8861 2008-03-16 14:30:18Z thomas $
 */


/**
 * @see auth_Acl
 */
require_once 'auth/Acl.php';


/**
 * @see auth_Acl_Role_Interface
 */
require_once 'auth/Acl/Role/Interface.php';


/**
 * @see auth_Acl_Resource_Interface
 */
require_once 'auth/Acl/Resource/Interface.php';


/**
 * @category   auth
 * @package    auth_Acl
 * @copyright  Copyright (c) 2005-2008 auth Technologies USA Inc. (http://www.auth.com)
 * @license    http://framework.auth.com/license/new-bsd     New BSD License
 */
interface auth_Acl_Assert_Interface
{
    /**
     * Returns true if and only if the assertion conditions are met
     *
     * This method is passed the ACL, Role, Resource, and privilege to which the authorization query applies. If the
     * $role, $resource, or $privilege parameters are null, it means that the query applies to all Roles, Resources, or
     * privileges, respectively.
     *
     * @param  auth_Acl                    $acl
     * @param  auth_Acl_Role_Interface     $role
     * @param  auth_Acl_Resource_Interface $resource
     * @param  string                      $privilege
     * @return boolean
     */
    public function assert(auth_Acl $acl, auth_Acl_Role_Interface $role = null, auth_Acl_Resource_Interface $resource = null,
                           $privilege = null);
}
