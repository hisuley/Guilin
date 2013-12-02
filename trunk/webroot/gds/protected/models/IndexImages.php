<?php

/**
 * "{{imall_index_images}}" 数据表模型类.
 *
 */
class IndexImages extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_index_images';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('images_url, images_link', 'required'),
                        array('status', 'numerical', 'integerOnly'=>true),
                        array('name', 'length', 'max'=>255),
                        array('id, name, images_url, images_link, add_time, status', 'safe', 'on'=>'search'),
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
			'id' => '首页轮显图片id',
			'name' => '介绍',
			'images_url' => '图片地址',
                        'images_link' => '图片链接',
                        'add_time' => '添加时间',
                        'status' => '状态:1可用,0不可用',
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
         * 首页轮显图片列表
         * @type static
         * @return CActiveRecord  
         */
        public static function getImagesList()
        {
            $model = new IndexImages;
            $result = $model->findAll();
            if($result){
                return $result;
            }
        }

        /**
	 * 添加首页轮显图片
         * @type static
         * @param array $data
         * @return bool
	 */
	public static function addIndexImage()
	{
            $model = new IndexImages;

            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];
                $model->add_time = date("Y-m-d H:i:s", time());
                if ($model->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 编辑首页轮显图片
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function updateIndexImage($id)
	{
            $model=new IndexImages;
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
         * 删除首页轮显图片
         * @type static
         * @param int $id
         * @return bool 
         */
        public static function deleteIndexImage($id)
        {
            $model=new IndexImages;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            return $model->deleteByPk($id);
        }
        
        /**
         * 设置首页轮显图片显示
         * @type static
         * @param int $id,$status
         * @return bool
         */
        public static function setImageStatus($id, $status)
        {
            $model = new IndexImages;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            $data = $model->findByPk($id);
            if ($data) {
                $data->status = $status;
                if ($data->save()) {
                    return true;
                }
            }
        }
}
