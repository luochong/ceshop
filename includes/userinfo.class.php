<?php
//****************************//
//用户信息
//针对用户的相关操作方法
//****************************//

require_once("constant.include.php");

class UserInfo
{
	public $user_id;
	public $user_user;
	public $user_name;    //姓名
	public $user_pwd;
	public $user_title;   //职务职称
	public $user_unit;    //用户所在集团单位 
	public $user_dept;    //部门
    public $user_address;
    public $user_college;
	public $login_page;   //登录来源页面   
	public $login_time;
	public $login_ip;
	public $end_login_time;
}

?>
