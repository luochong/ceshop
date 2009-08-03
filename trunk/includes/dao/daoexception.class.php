<?php
//******************************************//
///		错误处理
///     www.cardii.com
//******************************************//


class DaoException extends Exception
{
	function __construct($message, $code = 0)
	{
		/*switch ($code)
		{
			case 1062 : $message .= "���Ѿ�������ͬ�ļ�¼��"; break;
			case 1406 : $message .= "����ݵĳ��ȳ�������ݿ�����ơ�"; break;
			default :   break;
		}*/		
		parent::__construct($message, $code);
	}
	
}

?>
