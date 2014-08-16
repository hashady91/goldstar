<?php 
class User_IndexController extends Cl_Controller_Action_UserIndex
{
	public function init()
	{
		parent::init();
	}
	
	public function viewAction()
	{
		parent::viewAction();	
	}
	
	public function anyOtherRequestAction()
	{
		
	}    
	
	public function loginAction()
	{
	    parent::loginAction();
	    Bootstrap::$pageTitle = 'Đăng nhập GoldStar';
	}
}
