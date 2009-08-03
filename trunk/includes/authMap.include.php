<?php


require_once(_INCLUDE_CLASS_DIR__.'/auth/Acl.php');
require_once(_INCLUDE_CLASS_DIR__.'/auth/Acl/Role.php');
require_once(_INCLUDE_CLASS_DIR__.'/auth/Acl/Resource.php');
require_once(_INCLUDE_ROOT_DIR__.'/registry.include.php');
require_once(_INCLUDE_CLASS_DIR__.'/Cache/Lite.php');

$options = array(
    'cacheDir' =>  _INCLUDE_ROOT_DIR__."/cache/",
    'lifeTime' => 100,//10秒失效时间
    'pearErrorMode' => CACHE_LITE_ERROR_DIE
);
$cache = new Cache_Lite($options);
Registry::set('cache',$cache);
$cache_id = 'authMap';
if ($data = $cache->get($cache_id)) {

   Registry::set('acl', unserialize($data));
 
} else {     
	
	
	$acl = new auth_Acl();
	/*$roleGuest = new auth_Acl_Role('guest');
	$acl->addRole($roleGuest);
	$acl->addRole(new auth_Acl_Role('staff'), $roleGuest);
	$acl->addRole(new auth_Acl_Role('editor'), 'staff');
	$acl->addRole(new auth_Acl_Role('administrator'));
			// Guest 只可以浏览内容
	$acl->allow($roleGuest, null, 'view');
			//另外, 上面也可写为：$acl->allow('guest', null, 'view');
			// Staff 从 guest 继承浏览权限，但也要另外的权限
	$acl->allow('staff', null, array('edit', 'submit', 'revise'));
			// Editor 从 Staff 继承 view, edit, submit 和 revise 权限
			// 但也要另外的权限
	$acl->allow('editor', null, array('publish', 'archive', 'delete'));
			// Administrator 不需要继承任何权限，它拥有所有的权限
	$acl->allow('administrator');
	$acl->add(new auth_Acl_Resource('group'));
	$acl->allow('guest','group','view');			
	*/	
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 权限设置区
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	
	
	//test资源定义
	/**/
	$operate = array('testmysql','test02');
	//添加资源、操作
	$acl->add(new auth_Acl_Resource('test'),$operate);
	
	//test权限设置	
	$acl->addRole(new auth_Acl_Role('guest'));
	$acl->addRole(new auth_Acl_Role('admin'),'guest');
	$acl->allow('guest','test','testmysql');	
	$acl->allow('admin','test','test02');	
	Registry::set('acl',$acl);
	$cache->save(serialize($acl));    
}

?>