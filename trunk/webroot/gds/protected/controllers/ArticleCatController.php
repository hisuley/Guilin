<?php

class ArticleCatController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}
        
	/**
	 * 添加新分类
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function actionAddNew()
	{
            $model = new ArticleCat;
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];

                if ($model->save()) {
                    Yii::app()->end($model->id);
                } else {
                    Yii::app()->end('false');
                }
            }
            $this->render('addNew', array ('model' => $model ));
	}
        
        /**
	 * 更新文章分类
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
	 * 获取文章分类列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function actionGetList()
	{ 
            $model = new ArticleCat();
            $criteria = new CDbCriteria();
            
            $criteria->addInCondition("t.id", $_POST['filters']['id']); 
            $criteria->order = 't.id DESC';
            $result = $model->findAll( $criteria );
            var_dump($result);exit;
            $this->render( 'index', array ( 'datalist' => $result ) );
	}
        
         /**
	 * 获取文章分类名称
         * @type static
         * @param int $catid
         * @return string
	 */
	public static function actionGetCatName()
	{ 
            $model = new ArticleCat();
            $criteria = new CDbCriteria();
            
            $criteria->condition='id=:id';
            $criteria->params=array(':id'=>$_POST['catid']);
            $criteria->select='cat_name';
            $result = $model->find( $criteria );
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
		$model=ArticleCat::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function actionTestArticleCatInsertion()
	{
		$_POST['data'] = array('cat_name'=>'catname_test', 'cat_desc'=>'catdesc_test', 'parent_id'=>2,
                   'keywords'=>'cat|B|C', 'cat_type'=>2, 'sort_order'=>1, 'show_in_nav'=>1);
                self::actionAddNew($_POST);
	}
        
        public function actionTestArticleCatUpdating()
	{
		$_POST['data'] = array('id'=>1, 'cat_name'=>'catname_testUpdating', 'cat_desc'=>'catdesc_testUpdating', 'parent_id'=>2,
                   'keywords'=>'cat|UpdatingB|C', 'cat_type'=>2, 'sort_order'=>1, 'show_in_nav'=>1);
                self::actionUpdateInfo($_POST['data']['id']);
	}
        
        public function actionTestGetArticleCatList()
	{
		$_POST['filters'] = array('id'=>array(1,2,3));
                self::actionGetList($_POST);
	}
        
        public function actionTestGetArticleCatName()
	{
		$_POST = array('catid'=>2);
                self::actionGetCatName($_POST);
	}
}