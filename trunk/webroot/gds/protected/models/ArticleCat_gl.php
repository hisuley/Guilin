<?php

/**
 * "{{article_cat}}" 数据表模型类.
 *
 */
class ArticleCat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gl_article_cat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_name', 'required'),
			array('cat_type, show_in_nav, parent_id', 'numerical', 'integerOnly'=>true),
			array('cat_name, keywords', 'length', 'max'=>255),
			array('cat_type, show_in_nav', 'length', 'max'=>1),
			array('cat_desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cat_name, cat_type, sort_order', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id号',
			'cat_name' => '名称',
			'cat_type' => '类型:1普通分类,2系统分类,3网店信息,4帮助分类,5网店帮助',
			'keywords' => '关键字',
			'cat_desc' => '说明文字',
			'sort_order' => '显示顺序',
			'show_in_nav' => '是否在导航栏显示:1是,0否',
			'parent_id' => '父节点id',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	/**
	 * 添加新分类
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
                    return $model->id;
                } else {
                    return false;
                }
            }
	}
        
        /**
	 * 更新文章分类
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
	 * 获取文章分类列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function getList()
	{ 
            $model = new ArticleCat();
            $criteria = new CDbCriteria();
            
            $criteria->addInCondition("t.id", intval($_POST['filters']['id'])); 
            $criteria->order = 't.id DESC';
            $result = $model->findAll( $criteria );
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
