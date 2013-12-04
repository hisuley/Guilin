<?php

/**
 * "{{imall_integral}}" 数据表模型类.
 *
 */
class Integral extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_integral';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('int_grade, int_min, int_max, int_img', 'required'),
                        array('int_grade, int_min, int_max', 'numerical', 'integerOnly'=>true),
			array('int_img', 'length', 'max'=>255),
                        array('int_id, int_min, int_max, int_grade, int_img', 'safe', 'on'=>'search'),
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
			'int_id' => '信用等级id',
			'int_min' => '最小信用值',
			'int_max' => '最大信用值',
			'int_grade' => '信用级别',
                        'int_img' => '等级图显',
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
         * 企业信用等级列表
         * @type static
         * @return CActiveRecord 
         */
        public static function getIntegralList()
        {
            $model = new Integral;
            $result = $model->findAll();
            return $result;
        }
        
        /**
         * 添加信用等级
         * @type static
         * @param array $data 
         * @return int bool
         */
        public static function addIntegral()
        {
            $model = new Integral;
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];
                if ($model->save()) {
                    return true;
                }
            }
        }
        
        /**
         * 修改信用等级
         * @type static
         * @param int $id
         * @return int bool
         */
        public static function updateIntegral($id){
            $model = new Integral;
            $data = $model->findByPk($id);
            if(isset($_POST['data'])){
                $data->attributes = $_POST['data'];
                if($data->save()){
                    return true;
                } else {
                    return false;
                }
            }
        }
        /**
         * 删除信用等级
         * @type static
         * @param int $id
         * @return int bool 
         */
        public static function delIntegral($id){
            $model=new Integral;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            return $model->deleteByPk($id);
        }
}
