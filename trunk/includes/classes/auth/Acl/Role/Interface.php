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
 * @category   auth
 * @package    auth_Acl
 * @copyright  Copyright (c) 2005-2008 auth Technologies USA Inc. (http://www.auth.com)
 * @license    http://framework.auth.com/license/new-bsd     New BSD License
 */
interface auth_Acl_Role_Interface
{
    /**
     * Returns the string identifier of the Role
     *
     * @return string
     */
    public function getRoleId();
}
