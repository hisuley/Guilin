<?php

/**
 * "{{imall_admin_group}}" 数据表模型类.
 *
 */
class AdminGroup extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_admin_group';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('group_name', 'required'),
                        array('id, group_name, del_flg, rights', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'adminUser'=>array(self::HAS_MANY, 'AdminUser', 'group_id'),
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '管理组id',
			'group_name' => '管理组名称',
			'del_flg' => '删除标记',
			'rights' => '管理组权限',
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
         * 管理组列表
         * @type static
         * @return CActiveRecord 
         */
        public static function getAdminGroupList()
        {
            $model = new AdminGroup;
            $result = $model->findAll();
            return $result;
        }
        
        /**
         * 添加管理组
         * @type static
         * @param array $adminGroup 
         * @return int bool
         */
        public static function addAdminGroup()
        {
            $model = new AdminGroup;
            if (isset($_POST['adminGroup'])) {
                $model->attributes = $_POST['adminGroup'];
                if ($model->save()) {
                    return true;
                }
            }
        }
        
        /**
         * 删除管理组
         * @type static
         * @param int $id
         * @return int bool 
         */
        public static function delAdminGroup($id){
            $model=new AdminGroup;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            return $model->deleteByPk($id);
        }
}
