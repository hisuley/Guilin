<?php

/**
 * "{{imall_shop_info}}" 数据表模型类.
 *
 */
class ShopInfo extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_shop_info';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('shop_name, shop_categories, shop_country, shop_province, shop_city, shop_district, shop_address, shop_management', 'required'),
			array('user_id, shop_categories, count_imgsize, shop_commend', 'numerical', 'integerOnly'=>true),
			array('shop_country, shop_province, shop_city, shop_district, goods_num, map_zoom', 'length', 'max'=>10),
			array('shop_template, shop_creat_time, map_x, map_y, shop_domain', 'length', 'max'=>20),
			array('shop_address, shop_images, shop_template_img, shop_logo, shop_management', 'length', 'max'=>255),
			array('shop_name', 'length', 'max'=>50),
			array('open_flg, lock_flg', 'length', 'max'=>1),
			array('shop_intro, shop_notice, shop_address', 'safe'),
                        array('shop_id, user_id, shop_name, shop_country, shop_province, shop_city, shop_district, shop_address, shop_images, shop_logo, shop_template_img, shop_template, shop_management, shop_intro, shop_notice, shop_creat_time, goods_num, open_flg, lock_flg, map_x, map_y, map_zoom, count_imgsize, shop_categories, shop_domain', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'users'=>array(self::BELONGS_TO, 'Users', 'user_id', 'select'=>'user_name, rank_id', 'alias'=>'users'),
                    'userRank'=>array(self::BELONGS_TO, 'UserRank', '', 'on'=>'users.rank_id=UserRank.rank_id'),
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shop_id' => '店铺id',
			'user_id' => '用户id',
			'shop_name' => '店铺名称',
			'shop_country' => '店铺所在国家',
                        'shop_province' => '店铺所在省份',
                        'shop_city' => '店铺所在城市',
                        'shop_district' => '店铺所在区',
                        'shop_address' => '店铺所在详细地址',
                        'shop_images' => '店铺介绍中的图片',
                        'shop_logo' => '店铺logo',
                        'shop_template_img' => '店铺模板大图',
                        'shop_template' => '店铺模板',
                        'shop_management' => '店铺主营',
                        'shop_intro' => '店铺介绍',
                        'shop_notice' => '店铺公告',
                        'shop_creat_time' => '店铺创建时间',
                        'goods_num' => '店铺产品数量',
                        'open_flg' => '店铺关闭,1为关闭',
                        'lock_flg' => '店铺锁定,1为锁定',
                        'map_x' => '地图经线坐标',
                        'map_y' => '地图纬线坐标',
                        'map_zoom' => '地图比例',
                        'count_imgsize' => '图片总大小',
                        'shop_categories' => '店铺最后分类',
                        'shop_domain' => '商店二级域名',
                        'shop_commend' => '店铺推荐',
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
         * 店铺列表
         * @type static
         * @param array $filters
         * @return CActiveRecord 
         */
        public static function getShopList()
        {
            $condition = '1';
            $shop_name = trim( $_POST['filters']['shop_name'] );
            $locked = intval( $_POST['filters']['lock_flg'] );
            $cat_id = intval( $_POST['filters']['shop_categories'] );
            $begin_time = trim( $_POST['filters']['begin_time'] );
            $end_time = trim( $_POST['filters']['end_time'] );
            $shop_name && $condition .= ' AND s.shop_name LIKE \'%' . $shop_name . '%\'';
            $locked && $condition .= ' AND s.lock_flg= ' . $locked;
            $cat_id && $condition .= ' AND s.shop_categories= ' . $cat_id;
            $begin_time && $condition .= ' s.AND shop_creat_time >=  ' . "'$begin_time 00:00:00'" ;
            $end_time && $condition .= ' s.AND shop_creat_time <= ' . "'$end_time 00:00:00'" ;
            
            $sql = "SELECT s.shop_id, s.shop_name, s.shop_country, s.shop_province, s.shop_city, s.shop_management, s.lock_flg, s.shop_commend, s.shop_creat_time, u.user_name, r.rank_name FROM imall_shop_info s LEFT JOIN imall_users u ON s.user_id=u.user_id LEFT JOIN imall_user_rank r ON u.rank_id=r.rank_id WHERE ".$condition;
            $command = Yii::app()->db->createCommand($sql);
            $rows = $command->queryAll();
            
            return $rows;
        }
        
        /**
	 * 添加店铺
         * @type static
         * @param array $data
         * @return bool
	 */
	public static function addShop()
	{
            $model = new ShopInfo;

            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];
                $model->shop_creat_time = date('Y-m-d H:i:s', time());

                if ($model->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 店铺编辑信息
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function updateShop($id)
	{
            $model=new ShopInfo;
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
	 * 设置店铺状态
         * @type static
         * @param int $id, $status
         * @return bool
	 */
	public static function setShopStatus($id,$status)
	{
            $model=new ShopInfo;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            $data=$model->findByPk($id);
            if ($data) {
                $data->lock_flg = $status;
                if ($data->save()) {
                    return true;
                }
            }
	}
}
