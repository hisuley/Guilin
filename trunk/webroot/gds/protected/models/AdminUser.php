<?php

/**
 * "{{imall_admin_user}}" 数据表模型类.
 *
 */
class AdminUser extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_admin_user';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('admin_name, admin_password', 'required'),
                        array('admin_email', 'email'),
                        array('admin_id, admin_name, admin_email, admin_password, add_time, last_login, last_ip, group_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'adminLog'=>array(self::HAS_MANY, 'AdminLog', 'admin_id'),
                    'adminGroup'=>array(self::BELONGS_TO, 'AdminGroup', 'admin_id', 'foreignKey'=>'group_id', 'alias'=>'ag', 'select'=>'group_name'),
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'admin_id' => '管理员id',
			'admin_name' => '管理员用户名',
			'admin_email' => '管理员email',
			'admin_password' => '管理员密码',
                        'add_time' => '添加时间',
                        'last_login' => '最后登陆时间',
                        'last_ip' => '最后登陆ip',
                        'group_id' => '管理组',
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
         * 管理员列表
         * @type static
         * @return CActiveRecord 
         */
        public static function getAdminUserList()
        {
            $model = new AdminUser;
            $criteria = new CDbCriteria();
            $criteria->with = array('adminGroup');
            $criteria->order = 'admin_id DESC';
            $result = $model->findAll( $criteria );
            return $result;
        }
        
        /**
	 * 添加管理员
         * @type static
         * @param array $adminData
         * @return bool
	 */
	public static function addAdminUser()
	{
            $model = new AdminUser;

            if (isset($_POST['adminData'])) {
                $model->attributes = $_POST['adminData'];
                $model->admin_password = $model->hashPassword($_POST['adminData']['admin_password']);
                $model->add_time = date('Y-m-d H:i:s', time());

                if ($model->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 管理员登录
         * @type static
         * @param array $loginform
         * @return bool
	 */
	public static function adminUserLogin()
	{
            $model=new AdminUser;

            if(isset($_POST['adminForm']))
            {
                $model->attributes=$_POST['adminForm'];
                if($model->validate()){
                    $data = $model->find('admin_name=:admin_name', array(':admin_name'=>$model->admin_name));
                    if ($data === null) {
                        return '用户不存在';
                    } elseif (! $model->validatePassword($data->admin_password)) {
                        return '密码不正确';
                    } else {
                        $data->last_login = date('Y-m-d H:i:s', time());
                        $data->last_ip = self::getClientIP();
                        return $data->save();
                    }
                }
            }
	}
        
        /**
	 * 修改管理员密码
         * @type static
         * @param array $adminData
         * @return bool
	 */
	public static function updateAdminUserPass()
	{
            $model=new AdminUser;
            if (isset($_POST['adminData'])) {
                $data = $model->findByPk($_POST['adminData']['admin_id']);
                $model->admin_password = $_POST['adminData']['admin_password'];
                if(! $model->validatePassword($data->admin_password)) {
                    return '旧密码不正确';
                }
                $password = $_POST['adminData']['newpassword'];
                $respassword = $_POST['adminData']['respassword'];
                if (empty($password)) {
                    return '新密码不能为空!';
                } elseif($password != $respassword) {
                    return '确认密码有误!';
                } else {
                    $data->admin_password = $model->hashPassword($password);
                }
                if ($data->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 删除管理员
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function delAdminUser($id)
	{
            $model=new AdminUser;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            return $model->deleteByPk($id);
	}
        
        /**
        * 检测用户密码
        *
        * @return boolean
        */
        public function validatePassword ($password)
        {
            return $this->hashPassword($this->admin_password) === $password;
        }

        /**
        * 密码进行加密
        * @return string password
        */
        public function hashPassword ($password,$salt='lvyou')
        {
            return md5($password.$salt);
        }
        
        /**
        * 获取客户端IP地址
        */
        static public function getClientIP() {
            static $ip = NULL;
            if ( $ip !== NULL )
                return $ip;
            if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
                $arr = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
                $pos = array_search( 'unknown', $arr );
                if ( false !== $pos )
                    unset( $arr[$pos] );
                $ip = trim( $arr[0] );
            } elseif ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            // IP地址合法验证
            $ip = ( false !== ip2long( $ip ) ) ? $ip : '0.0.0.0';
            return $ip;
        }
}
