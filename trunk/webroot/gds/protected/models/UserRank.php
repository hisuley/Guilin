<?php

/**
 * "{{imall_user_rank}}" 数据表模型类.
 *
 */
class UserRank extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_user_rank';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('rank_name, privilege', 'required'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'users'=>array(self::HAS_MANY, 'Users', 'rank_id'),
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rank_id' => '会员级别id',
			'rank_name' => '会员级别名称',
			'privilege' => '会员级别权限',
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
         * 会员等级列表
         * @type static
         * @return CActiveRecord  
         */
        public static function getRankList()
        {
            $model = new UserRank;
            $result = $model->findAll();
            if($result){
                return $result;
            }
        }

        /**
	 * 会员等级添加
         * @type static
         * @param array $rankData
         * @return bool
	 */
	public static function addNewRank()
	{
            $model = new UserRank;

            if (isset($_POST['rankData'])) {
                $model->attributes = $_POST['rankData'];

                if ($model->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 会员等级编辑
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function updateUserRank($id)
	{
            $model=new UserRank;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            $data = $model->findByPk($id);
            if (isset($_POST['rankData'])) {

                $data->attributes = $_POST['rankData'];

                if ($data->save()) {
                    return true;
                }
            }
	}
        
        /**
         * 会员等级删除
         * @type static
         * @param int $id
         * @return bool 
         */
        public static function deleteUserRank($id)
        {
            $model=new UserRank;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            return $model->deleteByPk($id);
        }
}
