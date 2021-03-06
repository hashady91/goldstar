<?php
class Video_Form_Helper extends Cl_Form_NodeHelper
{
    public function getStatus()
    {
    	$ret = array('approved' => 'approved', 'queued' => 'queued');
    	return array('success' =>true, 'result' => $ret);
    }
    
    public function getOriginal()
    {
    	$ret = array('cover' => 'Cover', 'original' => 'Bản gốc');
    	return array('success' =>true, 'result' => $ret);
    }
    
    public function getParentCategoryList()
    {
    	$where = array('level' => 2);
    	$isMenuWhere = array('is_menu' => 'not_show');
    	$cond['where'] = array('$or' => array($where, $isMenuWhere));
    	$r = Dao_Node_Category::getInstance()->findAll($cond);
    	$cates = array();
    	if($r['success']){
    		foreach ($r['result'] as $ca){
    			$cate = array($ca['iid'] => $ca['name']);
    			array_push($cates, $cate);
    		}
    		 
    		return array('success' =>true, 'result' => $cates);
    	}else{
    		return array('success' =>true, 'result' => array());
    	}
    }
    
    public function getCountry()
    {
    	$ret = array('domestic' => 'Trong nước', 'foreign' => 'Nước ngoài');
    	return array('success' =>true, 'result' => $ret);
    }
    
    /*
    public function getItemsPerPageList($params)
    {
    	$ret = array(
    	    '-1' => "All",
    		'10' => "10/page",
    		'20' => "20/page",
    		'30' => "30/page",	
    		'50' => "50/page");
    	return array('success' => true, 'result' => $ret);
    }
    */
}
