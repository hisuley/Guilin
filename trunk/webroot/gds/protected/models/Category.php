<?php

/**
 * "{{imall_category}}" 数据表模型类.
 *
 */
class Category extends CActiveRecord
{
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_category';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('cat_name, parent_id, sort_order', 'required'),
			array('parent_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('parent_id, goods_num, sort_order', 'length', 'max'=>10),
			array('cat_id, cat_name, parent_id, sort_order, goods_num', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'brand'=>array(self::MANY_MANY, 'Brand', 'imall_brand_category(brand_id, cat_id)'),
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
			'parent_id' => '父分类id:0为根分类',
			'sort_order' => '分类排序',
                        'goods_num' => '产品数量,需要定时更新',
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
	 * 添加分类
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function addNew()
	{
                $model = new Category;
                if (isset($_POST['data'])) {
                    $model->attributes = $_POST['data'];
                                        
                    if ($model->save()) {
                        Yii::app()->db->createCommand("INSERT INTO `imall_brand_category`(brand_id, cat_id) VALUES('".$_POST['data']['brand_id']."', '".$model->cat_id."')")->execute();
                        return $model->cat_id;
                    } else {
                        return false;
                    }
                }
	}
        
        /**
	 * 编辑分类
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
                        Yii::app()->db->createCommand("UPDATE `imall_brand_category` SET brand_id =".$_POST['data']['brand_id']." WHERE id = ".$_POST['data']['id'])->execute();
                        return true;
                    } else {
                        return false;
                    }
                }
	}
        
        /**
	 * 获取分类列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function getList()
	{ 
            $model = new Category();
            $criteria = new CDbCriteria();
            $criteria->select = 'cat_id, parent_id, cat_name, sort_order, goods_num';
            $result = $model->findAll( $criteria );
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

