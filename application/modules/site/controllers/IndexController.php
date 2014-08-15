<?php
class Site_IndexController extends Cl_Controller_Action_Index
{
    public function indexAction()
    {
    	//Lay tin nhanh
    	$where = array();
    	$cond['where'] = $where;
    	$cond['ts'] = -1;
		$r = Dao_Node_New::getInstance()->findAll($cond);
		$tinNhanh = array();
		if($r['success']){
			$tinNhanh = $r['result'];
		}
    	
    	//Lay tin noi bat
		$where = array();
		$cond['where'] = $where;//TODO: is_hot = hot
		$cond['ts'] = -1;
		$r = Dao_Node_New::getInstance()->findAll($cond);
		$bestNews = array();
		if($r['success']){
			$bestNews = $r['result'];
		}
		
    	//Lay video 
		$where = array();
		$cond['where'] = $where;//TODO: is_hot = hot
		$cond['ts'] = -1;
		$r = Dao_Node_Video::getInstance()->findAll($cond);
		$videos = array();
		if($r['success']){
			$videos = $r['result'];
		}
		
    	//Get news 
		$where = array();
		$cond['where'] = $where;//TODO: is_hot = hot
		$cond['ts'] = -1;
		$r = Dao_Node_New::getInstance()->findAll($cond);
		if($r['success']){
			$news = $r['result'];
		}
		
		//Lay tin dich vu
    	$where = array();
		$cond['where'] = $where;//TODO: is_hot = hot
		$cond['ts'] = -1;
		$r = Dao_Node_New::getInstance()->findAll($cond);
		if($r['success']){
			$dichvu = $r['result'];
		}
		
		$this->setViewParam('tinNhanh', $tinNhanh);
		$this->setViewParam('bestNews', $bestNews);
		$this->setViewParam('videos', $videos);
		$this->setViewParam('news', $news);
		$this->setViewParam('dichvu', $dichvu);
		
        Bootstrap::$pageTitle = "Site";
    }
	public function errorAction()
	{
		
	}
    //==========================ADMIN==================================
    public function installAction()
    {
    	assure_perm('sudo');
    	$this->setLayout("admin");
    	if ($this->isSubmitted())
    	{
    		Cl_Dao_Util::getUserDao()->installSite();
    	}
    }
    
    public function adminAction()
    {
        assure_perm('sudo');
        $this->setLayout("admin");
        Bootstrap::$pageTitle = "Admin Panel";
    }
    
	public function giaTriCotLoiAction(){
		Bootstrap::$pageTitle = "Giá trị cốt lõi";
	}
	
	public function tamNhinMucTieuAction(){
		Bootstrap::$pageTitle = "Tầm nhìn mục tiêu";
	}
	
	public function hinhAnhHoatDongAction(){
		Bootstrap::$pageTitle = "Hình ảnh hoạt động";
	}
    
}
