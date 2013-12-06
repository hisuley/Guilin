<?php

/**
 * "{{imall_brand}}" 数据表模型类.
 *
 */
class Brand extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_brand';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('brand_name', 'required'),
			array('site_url', 'length', 'max'=>255),
                        array('brand_name', 'length', 'max'=>60),
			array('brand_logo', 'length', 'max'=>80),
			array('is_show', 'length', 'max'=>1),
			array('brand_desc', 'safe'),
                        array('brand_id, brand_name, brand_logo, brand_desc, site_url, is_show', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'brandCategory'=>array(self::MANY_MANY, 'BrandCategory', 'imall_brand_category(brand_id, cat_id)'),
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'brand_id' => '品牌id',
			'brand_name' => '品牌名称',
			'brand_logo' => '品牌logo',
			'brand_desc' => '品牌介绍',
                        'site_url' => '网址',
                        'is_show' => '1为显示',
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
         * 品牌列表
         * @type static
         * @param array $filters
         * @return CActiveRecord 
         */
        public static function getBrandList()
        {
            $model = new Brand;
            $result = $model->findAll();
            if($result){
                return $result;
            }
        }
        
        /**
	 * 添加品牌
         * @type static
         * @param array $data
         * @return bool
	 */
	public static function addBrand()
	{
            $model = new Brand;

            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];

                if ($model->save()) {
                    return $model->brand_id;
                }
            }
	}
        
        /**
	 * 编辑品牌
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function updateBrand($id)
	{
            $model=new Brand;
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
	 * 删除品牌
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function delBrand($id)
	{
            $model=new Brand;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            return $model->deleteByPk($id);
	}
}
