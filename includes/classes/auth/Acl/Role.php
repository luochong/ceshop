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
 * @version    $Id: Role.php 8861 2008-03-16 14:30:18Z thomas $
 */


/**
 * @see auth_Acl_Role_Interface
 */
require_once 'auth/Acl/Role/Interface.php';


/**
 * @category   auth
 * @package    auth_Acl
 * @copyright  Copyright (c) 2005-2008 auth Technologies USA Inc. (http://www.auth.com)
 * @license    http://framework.auth.com/license/new-bsd     New BSD License
 */
class auth_Acl_Role implements auth_Acl_Role_Interface
{
    /**
     * Unique id of Role
     *
     * @var string
     */
    protected $_roleId;

    /**
     * Sets the Role identifier
     *
     * @param  string $id
     * @return void
     */
    public function __construct($roleId)
    {
        $this->_roleId = (string) $roleId;
    }

    /**
     * Defined by auth_Acl_Role_Interface; returns the Role identifier
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }

}
