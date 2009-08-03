<?php 
require_once("mysqldao.class.php");
require_once(_INCLUDE_CLASS_DIR__.'/Cache/Lite/Output.php');
/*仿照网易的评论系统*/
/* 
comment_id int(10)  user_id int(10) from_id int(10)   from_type varchar(6) comment_content text   support_no int(8)  fight_no int(10)        
is_report int(5)  publish_time datetime   far_id int(10)
*/

/**
 * 
 * 
 * 使用说明
 * 
 * $this->setFrom();
 * $this->
 * $this->getCommentData();
 *
 */
class commentDao extends MysqlDao {
	private $pageno = 0;
	private $pagesize = 5;	
	protected  $from;
		
	protected $from_all = array('sgoods','cgoods','goods','store','sstore',);
	protected $from_id;
	private $_cache;
	protected $comment_data = NULL;
	
	
	function __construct(){
		
		$options = array(
					'cacheDir' => _ROOT_DIR__.'/tmp/',
					'lifeTime' =>2,//缓存的失效时间，秒为单位
					'pearErrorMode' =>CACHE_LITE_ERROR_DIE//报错模式
					);
		$this->_cache = new Cache_Lite($options);//参数设置完之后建立缓存
		parent::__construct();
	}	
/**
 * 设置评论来自哪里
 *
 * @param 评论来源 $from_name
 * @param 针对的事物 $from_id
 */
	public  function setFrom($from_name,$from_id,$pageno = 0){
		$this->setTableName('ce_comment');
		in_array($from_name,$this->from_all)||die('没有这个类型的评论');
		$this->from = $from_name;		
		$this->from_id = $from_id;
		$this->pageno = $pageno;
		
	}	
	
	private function getCommentDataForDB(){
		$sql = 'select * from ce_comment where from_type = ? and from_id = ? order by publish_time DESC';
		$temp = $this->executeQueryA($sql,array($this->from,$this->from_id),$this->pagesize,$this->pageno);	
		foreach ($temp as $v){			
			$this->comment_data[$v['comment_id']] = $v;				
		}
				
	}
	
	public function countComment(){
		$sql = 'select count(*) from ce_comment where from_type = ? and from_id = ? ';
	
		$temp = $this->executeQuery($sql,array($this->from,$this->from_id));	
		return $temp[0][0];
	}

	public function getCommentData(){
		if(empty($this->comment_data)){
			if($data = $this->_cache->get(md5($this->from.$this->from_id.$this->pagesize.$this->pageno))){			
				$this->comment_data = unserialize($data);		
			}else{			
				$this->getCommentDataForDB();
				$this->_cache->save(serialize($this->comment_data));			
			}
		}
		return $this->comment_data;	
		
	}
	
	public function getFather($id){
		$this->getCommentData();		
		$father = array();	
		$far_id = $id;
		while ($far_id = $this->comment_data[$far_id]['far_id']) {			
			$father[] = $this->comment_data[$far_id];		
		}
		return $father;	
	}
	
	/******************事件*****************************/
	/**
	 * 添加评论
	 *
	 * @param 内容 $content
	 * @param 回复id $far_id
	 */
	public function insertComment($content,$far_id = 0){		
		$data['user_id']   = 1;//$_SESSION['user_id'];
		$data['user_name'] = 'lc';//$_SESSION['user_name'];
		$data['from_type'] = $this->from;
		$data['from_id']   = $this->from_id;
		$data['comment_content'] = $content;
		$data['support_no']= 0;
		$data['fight_no']  = 0;
		$data['is_report'] = 0;
		$data['publish_time'] = Globals::getNowDateTime();		
		$this->insert($data);		
	}
	

	/* 支持 反对  举报*/
	public function support($id){
		$sql = 'update ce_comment set support_no = support_no + 1 where comment_id = ? ';
		$this->executeNonQuery($sql,array($id));		
	}
	
	public function against($id){
		$sql = 'update ce_comment set fight_no = fight_no + 1 where comment_id = ? ';
		$this->executeNonQuery($sql,array($id));
	}
	public function report($id){
		$sql = 'update ce_comment set is_report = is_report + 1 where comment_id = ? ';
		$this->executeNonQuery($sql,array($id));
	}
	
	/* 删除 评论 */
	public function deleteComment($id){
		$this->delete(array('comment_id' => $id));		
	}
	
	/*查询 */
	
	public function GetReportComment(){
		return $this->selectA(NULL,0,0,'is_report DESC');		
	}

	/**
	 * 如果arg为 null 查询本主题 ， 为all 所以主题 
	 *
	 * @param unknown_type $arg
	 * @param unknown_type $limit
	 */
	public function GetHotComment($arg=NUll,$limit){
				
		if($arg == NULL){
			$data['from_type'] = $this->from;
			$data['from_id']   = $this->from_id;
			$arg = $data;	;			
		}elseif($arg == 'all'){
			$cont = '';
		}
		if(is_array($arg)){
				foreach ($arg as $key => $v){
				$cont.=" AND $key = ?";
				$a[] = $v;
				}
		}
		
		$sql ='	SELECT * FROM `ce_comment` WHERE 1 '.$cont.' order by `support_no`+`fight_no` DESC';
		
		return $this->executeQueryA($sql,$a,$limit,0);
		
	}
	
	

	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}