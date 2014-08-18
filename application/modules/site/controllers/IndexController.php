<?php
class Site_IndexController extends Cl_Controller_Action_Index
{
    public function indexAction()
    {
    	//Lay tin nhanh
    	$where = array('is_hot' => 'new');
    	$cond['where'] = $where;
    	$cond['ts'] = -1;
    	$cond['limit'] = 8;
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
		$cond['limit'] = 10;
		$r = Dao_Node_New::getInstance()->find($cond);
		if($r['success']){
			$news = $r['result'];
		}
		
		//Lay tin dich vu
    	$dich_vu_iid = get_conf('dich_vu_iid','37');
    	$where = array('parent_category_iid' => $dich_vu_iid);
    	//$where = array();
    	$cond['where'] = $where;
    	$cond['limit'] = 5;
		$cond['ts'] = -1;
		$r = Dao_Node_New::getInstance()->findAll($cond);
		if($r['success']){
			$dichvu = $r['result'];
		}
		
		$this->setViewParam('is_home_page', 1);
		$this->setViewParam('tinNhanh', $tinNhanh);
		$this->setViewParam('bestNews', $bestNews);
		$this->setViewParam('videos', $videos);
		$this->setViewParam('news', $news);
		$this->setViewParam('dichvu', $dichvu);
		
        Bootstrap::$pageTitle = "Công ty cổ phần Goldstar";
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
	
	public function congTacVienAction(){
		Bootstrap::$pageTitle = "Cộng tác viên";
	}
	
	public function nhaPhanPhoiAction(){
		Bootstrap::$pageTitle = "Nhà phân phối";
	}
	
	public function datHangAction(){
		Bootstrap::$pageTitle = "Đặt hàng";
	}
	
	public function lienHeAction(){
		Bootstrap::$pageTitle = "Liên hệ";
	}
	
	public function dieuKhoanAction(){
		Bootstrap::$pageTitle = "Điều khoản";
	}
	
	public function tuyenDungAction(){
		Bootstrap::$pageTitle = "Tuyển dụng";
	}
}
