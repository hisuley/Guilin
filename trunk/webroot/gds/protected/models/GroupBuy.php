<?php

/**
 * "{{imall_groupbuy}}" 数据表模型类.
 *
 */
class GroupBuy extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_groupbuy';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('group_name', 'required'),
                        array('min_quantity, recommended', 'length', 'max'=>5),
                        array('goods_id, spec_price, views, shop_id, purchase_num, order_num, all_num, one_num', 'length', 'max'=>10),
                        array('start_time, end_time', 'length', 'max'=>20),
			array('group_name', 'length', 'max'=>255),
			array('group_condition, examine', 'length', 'max'=>1),
			array('group_desc', 'safe'),
                        array('group_id, group_name, group_desc, start_time, end_time, goods_id, spec_price, min_quantity, recommended, views, shop_id, purchase_num, order_num, group_condition, all_num, one_num, examine', 'safe', 'on'=>'search'),
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
			'group_id' => '团购id',
			'group_name' => '团购名字',
			'group_desc' => '团购说明',
			'start_time' => '开始时间',
                        'end_time' => '结束时间',
                        'goods_id' => '产品id',
                        'spec_price' => '团购价',
                        'min_quantity' => '成团件数',
                        'recommended' => '商家点击完成',
                        'views' => '浏览量',
                        'shop_id' => '店铺id',
                        'purchase_num' => '订购数',
                        'order_num' => '订单数',
                        'group_condition' => '团购状态 1,未开始;0,进行中;-1,已结束',
                        'all_num' => '',
                        'one_num' => '',
                        'examine' => '审核状态 0,未审核;1,已审核',
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
         * 团购列表
         * @type static
         * @return CActiveRecord 
         */
        public static function getGroupBuyList()
        {
            $model = new GroupBuy();
            $result = $model->findAll();
            if($result){
                return $result;
            }
        }
}
