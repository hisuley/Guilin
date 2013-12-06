<?php

/**
 * "{{imall_attribute}}" 数据表模型类.
 *
 */
class Attribute extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_attribute';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('attr_name, input_type, attr_values, price, sort_order', 'required'),
			array('attr_name', 'length', 'max'=>255),
                        array('cat_id, price', 'length', 'max'=>15),
			array('input_type, sort_order, selectable', 'length', 'max'=>1),
			array('attr_values', 'safe'),
                        array('attr_id, cat_id, attr_name, input_type, sort_order, attr_values, selectable, price', 'safe', 'on'=>'search'),
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
			'attr_id' => '属性id',
			'cat_id' => '分类id',
			'attr_name' => '属性名称',
			'input_type' => '属性input类型 0:text,1:select,2:radio,3:checkbox',
                        'attr_values' => '属性值 一行代表一个',
                        'sort_order' => '显示排序',
                        'selectable' => '用户选择的属性',
                        'price' => '价格',
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
         * 属性列表
         * @type static
         * @param array $filters
         * @return CActiveRecord 
         */
        public static function getAttributeList()
        {
            $model = new Attribute();
            $criteria = new CDbCriteria();
            $criteria->order = 't.attr_id DESC';
            if($_POST['filters']['cat_id']){
                $criteria->condition = 't.cat_id=:catId';
                $criteria->params = array(':catId'=>$_POST['filters']['cat_id']);
            }
            $result = $model->findAll( $criteria );
            if($result){
                return $result;
            }
        }
        
        /**
	 * 添加属性
         * @type static
         * @param array $data
         * @return bool
	 */
	public static function addAttribute()
	{
            $model = new Attribute();

            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];

                if ($model->save()) {
                    return $model->attr_id;
                }
            }
	}
        
        /**
	 * 编辑属性
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function updateAttribute($id)
	{
            $model=new Attribute();
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            $data = $model->findByPk($id);
            if (isset($_POST['data'])) {
                $data->attributes = $_POST['data'];
                if ($data->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 删除属性
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function delAttribute($id)
	{
            $model=new Attribute();
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            return $model->deleteByPk($id);
	}
}
