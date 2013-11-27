<?php

class ArticleCatController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionTestArticleCatInsertion()
	{
		$_POST['data'] = array('cat_name'=>'catname_test', 'cat_desc'=>'catdesc_test', 'parent_id'=>2,
                   'keywords'=>'cat|B|C', 'cat_type'=>2, 'sort_order'=>1, 'show_in_nav'=>1);
               ArticleCat::addNew($_POST);
	}
        
        public function actionTestArticleCatUpdating()
	{
		$_POST['data'] = array('id'=>1, 'cat_name'=>'catname_testUpdating', 'cat_desc'=>'catdesc_testUpdating', 'parent_id'=>2,
                   'keywords'=>'cat|UpdatingB|C', 'cat_type'=>2, 'sort_order'=>1, 'show_in_nav'=>1);
                ArticleCat::updateInfo($_POST['data']['id']);
	}
        
        public function actionTestGetArticleCatList()
	{
		$_POST['filters'] = array('id'=>array(1,2,3));
                ArticleCat::getList($_POST);
	}
        
        public function actionTestGetArticleCatName()
	{
		$_POST = array('catid'=>2);
                ArticleCat::getCatName($_POST);
	}
}