<?php

class ArticleController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionTestArticleInsertion()
	{
		$_POST['data'] = array('cat_id'=> 11, 'title'=>'title_test', 'content'=>'content_test', 'author'=>'author_test',
                    'author_email'=>'test@test.com', 'keywords'=>'A|B|C', 'article_type'=>2, 'is_open'=>1, 'link'=>'');
                Article::addNew($_POST);
	}
        
        public function actionTestArticleUpdating()
	{
		$_POST['data'] = array('id'=>1, 'cat_id'=> 21, 'title'=>'title_testupdate', 'content'=>'content_testupdate', 'author'=>'author_testupdate',
                    'author_email'=>'updatetest@test.com', 'keywords'=>'A|B|updateC', 'article_type'=>2, 'is_open'=>1, 'link'=>'');
                Article::updateInfo($_POST['data']['id']);
	}
        
        public function actionTestGetArticleList()
	{
		$_POST['filters'] = array('id'=>array(1,2,3));
                Article::getList($_POST);
	}
}