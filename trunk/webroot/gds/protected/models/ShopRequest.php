<?php

/**
 * "{{imall_shop_request}}" 数据表模型类.
 *
 */
class ShopRequest extends CActiveRecord
{
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_shop_request';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('company_name, person_name, credit_type, credit_num, credit_commercial, company_area, company_address, zipcode, mobile, telphone', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
                        array('mobile, telphone', 'length', 'max'=>50),
			array('company_name, person_name, credit_type, credit_num, credit_commercial, company_area, company_address', 'length', 'max'=>255),
                        array('status', 'length', 'max'=>1),
			array('request_id, user_id, company_name, person_name, credit_type, credit_num, credit_commercial, company_area, company_address, zipcode, mobile, telphone, add_time, status', 'safe', 'on'=>'search'),
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
			'request_id' => '申请id',
			'user_id' => '用户id',
			'company_name' => '企业名称',
			'person_name' => '法人代表姓名',
                        'credit_type' => '证件类型',
                        'credit_num' => '证件号码',
                        'credit_commercial' => '营业执照',
                        'company_area' => '公司所在地',
                        'company_address' => '详细通讯地址',
                        'zipcode' => '邮编',
                        'mobile' => '手机号码',
                        'telphone' => '联系电话',
                        'add_time' => '提交时间',
                        'status' => '状态：0等待审核,1审核通过,2审核失败',
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
	 * 添加企业
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function addNew()
	{
            $model = new ShopRequest;
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];
                $model->add_time = date("Y-m-d H:i:s", time());
                if ($model->save()) {
                    return $model->request_id;
                } else {
                    return false;
                }
            }
	}
        
        /**
	 * 更新企业
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
	 * 获取企业列表
         * @type static
         * @return CActiveRecord
	 */
	public static function getList()
	{ 
            $model = new ShopRequest();
            $result = $model->findAll('status=:status', array(':status'=>0));
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
