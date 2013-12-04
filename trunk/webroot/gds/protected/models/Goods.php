<?php

/**
 * "{{imall_article}}" 数据表模型类.
 *
 */
class Article extends CActiveRecord
{
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_article';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('title, content', 'required'),
			array('cat_id, admin_id', 'numerical', 'integerOnly'=>true),
			array('short_order', 'length', 'max'=>10),
			array('tag_color', 'length', 'max'=>100),
			array('title, thumb, link_url,', 'length', 'max'=>255),
			array('is_link, is_show, is_blod', 'length', 'max'=>1),
			array('content', 'safe'),
			array('article_id, cat_id, title, content, thumb, admin_id, add_time, is_link, link_url, is_show, is_blod, tag_color, short_order', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'articleCat'=>array(self::BELONGS_TO, 'ArticleCat','cat_id','select'=>'cat_id,cat_name'),
                    'adminUser'=>array(self::BELONGS_TO, 'AdminUser', 'admin_id', 'select'=>'admin_id,admin_name,admin_email'),
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_id' => '文章id',
			'cat_id' => '分类id',
			'title' => '题目',
			'content' => '内容',
                        'thumb' => '图片',
                        'admin_id' => '管理员id',
                        'add_time' => '添加时间',
                        'is_link' => '0不跳转,1跳转',
                        'link_url' => '跳转url',
                        'is_show' => '1显示，0隐藏',
			'is_blod' => '是否加粗',
			'tag_color' => '标题颜色',
			'short_order' => '标题排序 ',
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
	 * 添加新闻
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function addNew()
	{
                $model = new Article;
                if (isset($_POST['data'])) {
                    $model->attributes = $_POST['data'];
                    $model->add_time = date('Y-m-d H:i:s', time());
                                        
                    if ($model->save()) {
                        return $model->article_id;
                    } else {
                        return false;
                    }
                }
	}
        
        /**
	 * 更新新闻
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
	 * 获取新闻列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function getList()
	{ 
            $model = new Article();
            $criteria = new CDbCriteria();
            $criteria->order = 't.article_id DESC';
            $criteria->with = array ( 'articleCat', 'adminUser' );
            $criteria->condition = 't.cat_id=:catId';
            $criteria->params = array(':catId'=>$_POST['filters']['cat_id']);
            $result = $model->findAll( $criteria );
            if($result){
                return $result;
            }
	}
        
        /**
         * 删除新闻
         * @type static
         * @param int $article_id
         * @return int bool
         */ 
        public static function delNew()
        {
            $model = new Article;
            if(isset($_POST['article_id'])){
                return $model->deleteByPk($_POST['article_id']);
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

