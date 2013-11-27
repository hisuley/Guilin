<?php

class ArticleController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}
        
	/**
	 * 添加文章
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function actionAddNew()
	{
            $model = new Article;
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];
                $model->add_time = date('Y-m-d');

                if ($model->save()) {
                    Yii::app()->end($model->id);
                } else {
                    Yii::app()->end('false');
                }
            }
            $this->render('addNew', array ('model' => $model ));
	}
        
        /**
	 * 更新文章
         * @type static
         * @param array $data
         * @return bool
	 */
	public static function actionUpdateInfo($id)
	{
            $model=self::loadModel($id);
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];
                if ($model->save()) {
                    Yii::app()->end('true');
                } else {
                    Yii::app()->end('false');
                }
            }
            $this->render('updateInfo', array ('model' => $model ));
	}
        
        /**
	 * 获取文章列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function actionGetList()
	{ 
            $model = new Article();
            $criteria = new CDbCriteria();
            
            $criteria->addInCondition("t.id", $_POST['filters']['id']); 
            $criteria->order = 't.id DESC';
            $criteria->with = array ( 'articleCat' );
            $result = $model->findAll( $criteria );
            var_dump($result);exit;
            $this->render( 'index', array ( 'datalist' => $result ) );
	}
        
        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public static function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function actionTestArticleInsertion()
	{
		$_POST['data'] = array('cat_id'=> 11, 'title'=>'title_test', 'content'=>'content_test', 'author'=>'author_test',
                    'author_email'=>'test@test.com', 'keywords'=>'A|B|C', 'article_type'=>2, 'is_open'=>1, 'link'=>'');
                self::actionAddNew($_POST);
	}
        
        public function actionTestArticleUpdating()
	{
		$_POST['data'] = array('id'=>1, 'cat_id'=> 21, 'title'=>'title_testupdate', 'content'=>'content_testupdate', 'author'=>'author_testupdate',
                    'author_email'=>'updatetest@test.com', 'keywords'=>'A|B|updateC', 'article_type'=>2, 'is_open'=>1, 'link'=>'');
                self::actionUpdateInfo($_POST['data']['id']);
	}
        
        public function actionTestGetArticleList()
	{
		$_POST['filters'] = array('id'=>array(1,2,3));
                self::actionGetList($_POST);
	}
}