<?php 
require_once("mysqldao.class.php");
require_once(_INCLUDE_CLASS_DIR__.'/Cache/Lite/Output.php');
class categoryDao extends MysqlDao {
	private $_cache;
	private $_cate_data = NULL;//类别树
	private $_cate_option = NULL;

	function __construct(){
		$options = array(
					'cacheDir' => _ROOT_DIR__.'/tmp/',
					'lifeTime' =>7200,//缓存的失效时间，秒为单位
					'pearErrorMode' =>CACHE_LITE_ERROR_DIE//报错模式
					);
		$this->_cache = new Cache_Lite($options);//参数设置完之后建立缓存
		parent::__construct();
	}	
	private  function setCateDataCache(){
		if($this->_cate_data) return;
		if($data = $this->_cache->get('cateData')){
			
			$this->_cate_data = unserialize($data);		
		}else{			
			$this->setCateData();
			$this->_cache->save(serialize($this->_cate_data));			
		}
	}

	public function getCateData(){
		$this->setCateDataCache();
		return $this->_cate_data;
	}
		
	public function getCateSelect(){	
	 if(!$this->_cate_option){
		$this->setCateDataCache();
		if ($data = $this->_cache->get('cateSelect')) {
			$this->_cate_option =  unserialize($data);
		} else {
			$this->createOptionArray(0,0);			
			$this->_cache->save(serialize($this->_cate_option));		
		}
	  }
	 return $this->_cate_option;		
	}

	
	public function removeCateData(){		
		$this->_cache->remove('cateSelect');
		$this->_cache->remove('cateData');
	}
	/**
	 * 获得子节点
	 *
	 * @param 节点id $id
	 * @return unknown
	 */
	
	public function getChild($id){
		$this->setCateDataCache();
		$child = array();
		$stack = array();
		$node = array();
		
		$tree = $this->_cate_data['tree'][$id];	
		if(!$tree) return false;
		foreach ($tree as $node){
			array_push($stack,$node);		
			$child[] = $node;
		}
		while ($node = array_pop($stack)) {			
			$tree = $this->_cate_data['tree'][$node['id']];
			for($i=0;$i<count($tree);$i++){
				$child[] = $node = $tree[$i];
				 array_push($stack,$node);				
			}			
		}
		return $child;	
	}

	public function getFather($id){
		$this->setCateDataCache();		
		$father = array();	
		$far_id = $id;
		while ($far_id = $this->_cate_data['node'][$far_id]['far_id']) {			
			$father[] = $this->_cate_data['node'][$far_id];
		
		}
		return $father;	
	}	
	private function setCateData(){
	
		$tempdata = $this->simpleFetchList('ce_goods_category',array('category_id','category_name','far_id'),array('have_attr' => 1));
		
		foreach ($tempdata as $value){
			$this->_cate_data['node'][$value[0]]['id'] = $value[0];
			$this->_cate_data['node'][$value[0]]['name'] = $value[1];
			$this->_cate_data['node'][$value[0]]['far_id'] = $value[2];
			$this->_cate_data['tree'][$value[2]][] = array('id'=>$value[0],'name'=>$value[1],'far_id'=>$value[2]);
		}		
	}
	private  function createOptionArray($key,$level){
		if(!is_array($this->_cate_data['tree'][$key] )) return ;
		$level++;		
		foreach($this->_cate_data['tree'][$key] as $data ){
			$space = '';
			for ($i = $level ;$i>1;$i--){
				$space  .= '-';
			}			
			$this->_cate_option[$data['id']] =  $space.$data['name'];			
			$this->createOptionArray($data['id'],$level);			
		}	
	}
	
	
}