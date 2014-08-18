<?php
/**
 * Remember you have    
 *  public $dao;
 *  public $node, $nodeUC; //node name : foo|post|item...

 * @author tran
 */ 
class New_IndexController extends Cl_Controller_Action_NodeIndex 
{
    public function init()
    {
        //$this->daoClass = "Cl_Dao_Node_New";
        //$this->commentDaoClass = "Cl_Dao_Comment_New";
        
        /**
         * Chances to check for permission here if you like
         */
        parent::init();
        /**
         * Chances to change layout if you like
         */
    }

    public function indexAction()
    {

    }

    public function newAction()
    {
    	$u = Zend_Registry::get('user');
    
    	if(has_role('sudo')){
	    	assure_perm('sudo');
	    	$this->setLayout("admin");
    	}else{
    		//Get new new
    		$list = Dao_Node_New::getInstance()->getNewByType('new', 3, $row['ts']);
    		$this->setViewParam('newNews', $list);
    			
    		//Get popular new
    		$list = Dao_Node_New::getInstance()->getNewByType('hot', 1, $row['ts']);
    		$this->setViewParam('hotNews', $list);
    	}
    	 
        $this->genericNew("New_Form_New", "Dao_Node_New", "Node");
	    if(isset($this->ajaxData)) {
            //command the form view to rediect if success
            if (isset($this->ajaxData['result'])) //success
            {
                if (is_preview())
                {
                    $this->setViewParam('row', $this->ajaxData['result']);
                    $this->setViewParam('is_preview', 1);
                    $this->_helper->viewRenderer->setNoRender(true);
                    $ret['data'] = $this->view->render('index/view.phtml');
                    $ret['success'] = true;
                    $ret['callback'] = 'populate_preview';
                    send_json($ret);
                    exit();
                }
                else 
                {
                	$this->ajaxData['callback'] = 'redirect';
                	$url = node_link('new' , $this->ajaxData['result'], 'upload');
                	
                	$this->ajaxData['data'] = array('url' => $url);
                }
            }
        }
        
        Bootstrap::$pageTitle = 'Thêm tin tức mới';
    }

    public function updateAction()
    {
    	$lu = Zend_Registry::get('user');
    	
    	$id = $this->getStrippedParam('id');
    	
    	if(has_role('sudo'))
    		$this->setLayout("admin");
    	else{
    		//Get new new
    		$list = Dao_Node_New::getInstance()->getNewByType('new', 3, $row['ts']);
    		$this->setViewParam('newNews', $list);
    		 
    		//Get popular new
    		$list = Dao_Node_New::getInstance()->getNewByType('hot', 1, $row['ts']);
    		$this->setViewParam('hotNews', $list);
    	}
        /**
         * Permission to update a node is done in 
         * $Node_Form_Update form->customPermissionFilter()
         * Do not do it here
         * @NOTE: object is already filtered in Index.php, done in Cl_Dao_Node::filterUpdatedObjectForAjax()
         */
        $this->genericUpdate("New_Form_Update", $this->daoClass ,"", "Node");
        Bootstrap::$pageTitle = 'Cập nhật tin tức';
    }

    public function searchAction()
    {
    	assure_perm('sudo');
    	$this->setLayout("admin");
        assure_perm("search_new");//by default
        $this->genericSearch("New_Form_Search", $this->daoClass, "Node");
        Bootstrap::$pageTitle = 'Quản lý tin tức';        
    }
    
    public function searchNewsAction()
    {
    	$page = $this->getStrippedParam('page',1);
    	$name = get_value('ac_name','');
    	$ac_name = ac_item($name);
    	
    	$form = new New_Form_Search();
    	$data = array(
    		'ac_name' => $ac_name,
    	);
    	 
    	$form->build($data);
    	$conditions = $form->buildSearchConditions();
    	 
    	$conditions['page'] = $page;
    	$conditions['limit'] = per_page();
    	$conditions['total'] = 1;
    	 
    	$dao = Dao_Node_New::getInstance();
    	$r = $dao->findNode($conditions, true);

    	if($r['success'] && $r['total'] > 0){
    		$news = $r['result'];
    	}else{
    		$news = array();
    	}
    	
    	$this->setViewParam('list', $news);
    	$total = ceil($r['total'] / per_page());
    	$this->setViewParam('total', $total);
    	$this->setViewParam('page', $page);
    	$this->setViewParam('ac_name', $ac_name);
    	
    	//Get new new
    	$list = Dao_Node_New::getInstance()->getNewByType('new', 2);
    	$this->setViewParam('newNews', $list);
    	
    	//Get popular new
    	$list = Dao_Node_New::getInstance()->getNewByType('hot', 1);
    	$this->setViewParam('hotNews', $list);
    	
    	Bootstrap::$pageTitle = 'Tìm kiếm cover tin tức - ' . $name;
    }
    
    public function tinMoiAction(){
    	$page = $this->getStrippedParam('page',1);
    	$data = array();
    	$form = new New_Form_Search();
    	
    	$form->build($data);
    	$conditions = $form->buildSearchConditions();
    	
    	$conditions['page'] = $page;
    	$conditions['limit'] = per_page();
    	$conditions['total'] = 1;
    	
    	$dao = Dao_Node_New::getInstance();
    	$r = $dao->findNode($conditions, true);
    	
    	if($r['success'] && $r['total'] > 0){
    		$news = $r['result'];
    	}else{
    		$news = array();
    	}
    	 
    	$this->setViewParam('news', $news);
    	$total = $r['total'];
    	$this->setViewParam('total', $total);
    	$this->setViewParam('page', $page);
    	Bootstrap::$pageTitle = "Tin tức mới";
    }
    
    public function searchCommentAction()
    {
        assure_perm("search_new");//by default
        $commentClass =$this->commentDaoClass;
        $this->genericSearch("New_Form_SearchComment", $commentClass, "");
        Bootstrap::$pageTitle = "Search " . $this->nodeUC . " Comments";        
    }
    
    public function viewAction()
    {
    	$iid = (string) $this->getStrippedParam('iid');
        //$slug = (string) $this->getStrippedParam('slug');
        if ($iid)
        	$where = array('iid' => $iid);
        //elseif ($slug)
        	//$where = array('slug' => $slug);
        	
    	$r = $this->dao->findOne($where, true /*convert id*/);
    	
    	if ($r['success'] && $r['count'] > 0)
    	{
    	     $this->setViewParam('row', $r['result']);
    	}   
    	else 
    	{
    		$this->_redirect("/");
    	}
    	
        if ($row = $this->getViewParam('row')){
        	Bootstrap::$pageTitle = $row['name'];
        	
        }else 
        	Bootstrap::$pageTitle = 'Chi tiết tin tức';
    }
    
    public function deleteNodePermissionCheck($row)
    {
        if (has_perm("delete_new"))
            return array('success' => true);
        else 
            return array('success' => false);
    }
    public function commentAction(){
    	//$this->commentScript = "index/one-comment.phtml";
    	parent::commentAction();
    }
    
    //implements parent::newCommentPermissionCheck
    public function newCommentPermissionCheck($row)
    {
    	//TODO: Implement this
    	return has_perm("new_new_comment");
    }
    public function updateCommentAction()
    {
    	//$this->commentContentScript = "index/one-comment-content.phtml";
    	parent::updateCommentAction();
    }
    
    public function delCommentAction()
    {
    	parent::delCommentAction();
    }
    
    public function bulkDeleteAction()
    {
    	assure_role('admin_new');
    	$ids = $this->getStrippedParam('ids');
    	$in = explode(',', $ids);
    	$where = array('id' => array('$in' => $in));
    	Dao_Node_New::getInstance()->delete($where);
    	$r = array('success' => true);
    	$this->handleAjaxOrMaster($r);
    }
    
    public function updateViewAction()
    {
    	Dao_Node_New::getInstance()->updateView();
    	die('oki');
    }
    
    public function updateDurationAction()
    {
    	Dao_Node_New::getInstance()->updateDuration();
    	die('oki');
    }
    
    public function tagAction()
    {
    	$tag = (string) $this->getStrippedParam('tag');
    	$where = array('slug'=>$tag);
    	$t = Dao_Node_Tag::getInstance()->findOne($where);
    	if($t['success']){
    		$this->setViewParam('tag', $t['result']);
    		
    		$where = array('tags.slug'=>$t['result']['slug']);
    		if($limit != '')
    			$cond['limit'] = $limit;
    		else
    			$cond['limit'] = per_page();
    		
    		$order = array('ts' => -1);
    		$cond['where'] = $where;
    		$cond['order'] = $order;
    		$cond['page'] = $page;
    		$cond['total'] = 1; //do count total
    		$r = Dao_Node_New::getInstance()->find($cond);
    		if($r['success']){
    			$this->setViewParam('list', $r['result']);
    		}
    		
    		//Get new new
    		$list = Dao_Node_New::getInstance()->getNewByType('new', 3);
			$this->setViewParam('newNews', $list);
			
			//Get popular new
			$list = Dao_Node_New::getInstance()->getNewByType('hot', 2);
			$this->setViewParam('hotNews', $list);
    		Bootstrap::$pageTitle = $t['result']['name'];
    	}else{
	    	Bootstrap::$pageTitle = 'Không tìm thất ' . $tag;
    	}
    }
    
    public function addPlaylistAction(){
    	$id = (string) $this->getStrippedParam('id');
    	
    	$r = Dao_Node_New::getInstance()->addPlaylist($id);
    	
    	//TODO: thong bao dang bi sai
    	return $r;
    	die();
    }
    
    public function manageNewAction()
    {
    	$lu = Zend_Registry::get('user');
    	Zend_Registry::set('viewuser', array());
    	$page = $this->getStrippedParam('page',1);
    
    	$r = Dao_Node_New::getInstance()->getNewsByUser($lu, $page);
    		
    	if($r['success'] && $r['total'] > 0){
    		$this->setViewParam('list', $r['result']);
    	}else{
    		$this->setViewParam('list', array());
    		$r['total'] = 0;
    	}
    	
    	$this->setViewParam('total', $r['total']);
    	$this->setViewParam('page', $page);
    	if($user != array()){
    		Bootstrap::$pageTitle = 'Quản lý clip - ' . $user['name'];
    	}else
    		Bootstrap::$pageTitle = 'Quản lý clip';
    }
    
    public function deleteAction()
    {
    	$lu = Zend_Registry::get('user');
    	 
    	$id = $this->getStrippedParam('id');
    	if(!has_role_new($lu, $id))
    		assure_perm('sudo');
    	
    	parent::deleteAction();
    	if ($this->ajaxData['success'])
    	{
    		$this->ajaxData['callback'] = 'reload_page';
    		$this->ajaxData['data'] = array('msg' => t('successful',1));
    	}
    }    
    
    //==============FB comment,like,share counter===========
    
    public function newFbCommentAction()
    {
    	// TODO: match this for different url schemes
    	$url = preg_replace('/#view$/', '',get_value('url'));
    	$id = get_value('id');
    	$fbc = fb_counter($url,'comment'); //fb comment
    	$daoClass = 'Dao_Node_New';
    	$step = '';
    	$obj = 'Node';
    	$dao = $daoClass::getInstance();
    
    	$where = array('id' => $id);
    	$r = $dao->findOne($where);
    
    	if ($r['success'] && $r['count'] > 0)
    	{
    		$row = $r['result'];
    		$update = array('counter.c' => $fbc);
    		
    		$update = array('$set' => $update);
    		$r = $dao->update($where, $update);
    		$dao->deleteStaticCache($row);
    	}
    	$r = array('success' => true, 'result' => 'done!');
    	$this->handleAjaxOrMaster($r);
    }
    
    public function newFbLikeAction()
    {
    	 
    	$iid = $this->getStrippedParam('iid');
    	$id = $this->getStrippedParam('id');
    	$rt = $this->getStrippedParam('rt');
    	$uiid=$this->getStrippedParam('uiid');
    	if(is_rest() && $rt==1)
    	{
    		$options = array(
    				'subject' => 'user',
    				'object' => 'new',
    		);
    		$relationDao = Cl_Dao_Relation::getInstance($options);
    		$where=array(
    				's.iid'=>(string)$uiid,
    				'o.id'=>(string)$id,
    				'r.rt'=>$rt);
    		$cond['where']=$where;
    		$r=$relationDao->find($cond);
    		if($r['count']>0)
    		{
    			$r = array('success' => false, 'result' => 'Already like FB');
    			send_json($r);
    		}
    		else { //new relation
    			$object='new';
    			$data = array(
    					's' => Zend_Registry::get('user'),
    					'o' => array('id' => $id),
    					'r' => array(
    							'rt' => $rt
    					)
    			);
    			$requestParams = array(
    					'object'=>$object,
    					'rt'=>$rt,
    					'id'=>$id
    			);
    			$dao = Cl_Dao_Util::getDaoObject($object); //comment_samx => Cl_Dao_Comment_Samx
    			$r = $dao->insertRelation($data, $options, $requestParams);
    			if (!$r['success'])
    			{
    				$r = array('success' => false, 'result' => 'Error insert database');
    				send_json($r);
    			}
    			$dao_new=Dao_Node_New::getInstance();
    			$rs=$dao_new->findOne(array('id'=>$id));
    			$iid=$rs['result']['iid'];
    		}
    	}
    	$dao_new=Dao_Node_New::getInstance();
    	$dao_new->fb_like_inc_point($iid,$rt);
    	$dao_new->deleteStaticCacheOfType('vote',1,10);
    	$dao_new->deleteStaticCacheOfType('new',1,10);
    	$r = array('success' => true, 'result' => 'done!');
    	if(is_rest())
    	{
    		send_json($r);
    	}
    	$this->handleAjaxOrMaster($r);
    }
}

