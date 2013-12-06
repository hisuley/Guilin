<?php

/**
 * "{{imall_tag}}" 数据表模型类.
 *
 */
class Tag extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_tag';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('tag_name', 'required'),
                        array('goods_id, tag_num, shop_id, short_order', 'length', 'max'=>10),
                        array('tag_color', 'length', 'max'=>20),
			array('tag_name', 'length', 'max'=>50),
			array('is_blod, is_recommend', 'length', 'max'=>1),
                        array('tag_id, tag_name, goods_id, tag_num, shop_id, is_blod, tag_color, short_order, is_recommend', 'safe', 'on'=>'search'),
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
			'tag_id' => '标签id',
			'tag_name' => '标签名称',
			'goods_id' => '商品id',
			'tag_num' => '标签数量',
                        'shop_id' => '商铺ID',
                        'is_blod' => '是否加粗',
                        'tag_color' => '颜色',
                        'short_order' => '排序',
                        'is_recommend' => '示范推荐',
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
         * 标签列表
         * @type static
         * @param array $filters
         * @return CActiveRecord 
         */
        public static function getTagList()
        {
            $model = new GroupBuy();
            $criteria = new CDbCriteria();
            $condition = '1';
            $tag_name = trim( $_POST['filters']['tag_name'] );
            $tag_name && $condition .= ' AND tag_name LIKE \'%' . $tag_name . '%\'';
            $criteria->order = 't.tag_id DESC';
            
            $result = $model->findAll($criteria);
            if($result){
                return $result;
            }
        }
}
