<?php

/**
 * "{{article}}" 数据表模型类.
 *
 */
class Article extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gl_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content', 'required'),
			array('cat_id', 'numerical', 'integerOnly'=>true),
			array('add_time', 'length', 'max'=>10),
			array('author, author_email', 'length', 'max'=>100),
			array('title, keywords, link', 'length', 'max'=>255),
			array('article_type, is_open', 'length', 'max'=>1),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cat_id, author, title, add_time', 'safe', 'on'=>'search'),
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
                    'articleCat'=>array(self::BELONGS_TO, 'ArticleCat','cat_id','select'=>'id,cat_name'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id号',
			'cat_id' => '分类id',
			'title' => '题目',
			'content' => '内容',
			'author' => '作者',
			'author_email' => '作者的email',
			'keywords' => '关键字 ',
			'article_type' => '类型',
			'is_open' => '是否显示:1显示;0不显示',
			'add_time' => '添加时间',
			'link' => '外链',
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
	 * 添加文章
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function addNew()
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
	public static function updateInfo($id)
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
	public static function getList()
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
		$model=self::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
}
