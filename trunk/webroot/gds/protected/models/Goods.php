<?php

/**
 * "{{imall_goods}}" 数据表模型类.
 *
 */
class Goods extends CActiveRecord
{
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_goods';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('goods_name', 'required'),
			array('shop_id, cat_id, ucat_id, brand_id, type_id, goods_number, transport_template_id, pv, favpv', 'numerical', 'integerOnly'=>true),
			array('goods_price, transport_price, transport_template_price', 'length', 'max'=>10),
			array('goods_name, keyword, goods_thumb,', 'length', 'max'=>255),
			array('is_delete, is_best, is_new, is_hot, is_promote, is_admin_promote, is_on_sale, is_set_image, sort_order, lock_flg, is_transport_template', 'length', 'max'=>1),
			array('goods_intro, goods_wholesale', 'safe'),
			array('goods_id, shop_id, goods_name, cat_id, ucat_id, brand_id, type_id, goods_intro, goods_wholesale, goods_number, goods_price, transport_price, keyword, is_delete, is_best, is_new, is_hot, is_promote, is_admin_promote, is_on_sale, is_set_image, goods_thumb, pv, favpv, sort_order, add_time, last_update_time, lock_flg, is_transport_template, transport_template_id, transport_template_price', 'safe', 'on'=>'search'),
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
			'goods_id' => '商品id',
			'shop_id' => '店铺id',
			'goods_name' => '商品名称',
			'cat_id' => '分类id',
                        'ucat_id' => '用户自定义分类id',
                        'brand_id' => '品牌id',
                        'type_id' => '属性类型id',
                        'goods_intro' => '商品详情',
                        'goods_wholesale' => '批发说明',
                        'goods_number' => '库存量',
			'goods_price' => '商品价格',
			'transport_price' => '运费',
			'keyword' => '关键字',
                        'is_delete' => '0为已删除',
                        'is_best' => '1为精品',
                        'is_new' => '1为新品',
                        'is_hot' => '1为热销',
                        'is_promote' => '1为特价',
                        'is_admin_promote' => '1为管理推销的',
                        'is_on_sale' => '0为下架,1为上架',
                        'is_set_image' => '是否已设置图片 ',
                        'goods_thumb' => '缩略图 ',
                        'pv' => '关注度',
                        'favpv' => '被收藏次数',
                        'sort_order' => '排序',
                        'add_time' => '添加时间',
                        'last_update_time' => '最后修改时间',
                        'lock_flg' => '锁定,1为锁定',
                        'is_transport_template' => '是否启用邮费模版',
                        'transport_template_id' => '邮费模版id',
                        'transport_template_price' => '认默模板运费',
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
	 * 添加商品
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function addNew()
	{
                $model = new Goods;
                if (isset($_POST['data'])) {
                    $model->attributes = $_POST['data'];
                    $model->add_time = date('Y-m-d H:i:s', time());
                                        
                    if ($model->save()) {
                        return $model->goods_id;
                    } else {
                        return false;
                    }
                }
	}
        
        /**
	 * 更新商品
         * @type static
         * @param array $data
         * @return bool
	 */
	public static function updateInfo($id)
	{
                $model=self::loadModel($id);
                if (isset($_POST['data'])) {
                    $model->attributes = $_POST['data'];
                    $model->last_update_time = date("Y-m-d H:i:s", time());
                    if ($model->save()) {
                         return true;
                    } else {
                         return false;
                    }
                }
	}
        
        /**
	 * 获取商品列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function getList()
	{ 
            $model = new Goods();
            $criteria = new CDbCriteria();
            $criteria->select = 'goods_id, goods_name, goods_price, transport_price, goods_number, is_promote, is_on_sale, pv, add_time';
            $condition = '1';
            $goods_name = trim( $_POST['filters']['goods_name'] );
            $is_promote = trim( $_POST['filters']['is_promote'] );
            $is_on_sale = intval( $_POST['filters']['is_on_sale'] );
            $goods_name && $condition .= ' AND goods_name LIKE \'%' . $goods_name . '%\'';
            $is_promote && $condition .= ' AND is_promote= ' . $is_promote;
            $is_on_sale && $condition .= ' AND is_on_sale= ' . $is_on_sale;
            $criteria->condition = $condition;
            $criteria->order = 'goods_id DESC';
            $result = $model->findAll( $criteria );
            if($result){
                return $result;
            }
	}
        
        /**
         * 锁定商品
         * @type static
         * @param int $goods_id
         * @return int bool
         */ 
        public static function lockGoods($goods_id,$lock)
        {
            $model = new Goods;
             return $model->updateByPk($goods_id, array('lock_flg'=>$lock));
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

