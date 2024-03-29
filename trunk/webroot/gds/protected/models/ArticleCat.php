<?php

/**
 * "{{imall_article_cat}}" 数据表模型类.
 *
 */
class ArticleCat extends CActiveRecord
{
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_article_cat';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('cat_name', 'required'),
			array('parent_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>255),
			array('cat_id, cat_name, parent_id, sort_order', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cat_id' => '分类id',
			'cat_name' => '分类名称',
			'parent_id' => '父id, -1为系统分类',
			'sort_order' => '分类排序',
		);
	}

	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	/**
	 * 添加新闻分类
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function addNew()
	{
            $model = new ArticleCat;
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];

                if ($model->save()) {
                    return $model->cat_id;
                } else {
                    return false;
                }
            }
	}
        
        /**
	 * 更新新闻分类
         * @type static
         * @param array $data
         * @return bool
	 */
	public static function updateInfo($id)
	{
            $model=self::loadModel($id);
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];
                if ($model->save()) {
                    return true;
                } else {
                    return false;
                }
            }
	}
        
        /**
	 * 获取新闻分类列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function getList()
	{ 
            $model = new ArticleCat();
            $result = $model->findAll();
            if($result){
                return $result;
            }
	}
        
         /**
	 * 获取文章分类名称
         * @type static
         * @param int $catid
         * @return string
	 */
	public static function getCatName()
	{ 
            $model = new ArticleCat();
            $criteria = new CDbCriteria();
            
            $criteria->condition='id=:id';
            $criteria->params=array(':id'=>intval($_POST['catid']));
            $criteria->select='cat_name';
            $result = $model->find( $criteria );
            if($result){
                return $result;
            }
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
		$model=self::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
}
