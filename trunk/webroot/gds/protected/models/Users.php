<?php

/**
 * "{{users}}" 数据表模型类.
 *
 */
class Users extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_users';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
                        array('user_name, user_passwd, captcha', 'required', 'on'=>'login'),
			array('user_name, user_email, user_passwd, captcha', 'required', 'on'=>'register'),
                        array('user_name', 'unique', 'on'=>'register'),
                        array('user_email', 'email'),
			array('captcha', 'captcha', 'allowEmpty'=>!extension_loaded('gd'), 'on'=>'login,register'),
			array('user_name, user_passwd', 'required'),
                        array('user_ico', 'safe'),
                        array('user_id, user_email, user_name, user_passwd, user_question, user_answer, user_ico, reg_time, last_login_time, last_ip, email_check, email_check_code, forgot_check_code, rank_id, locked', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
                    'userInfo'=>array(self::HAS_ONE, 'UserInfo', 'user_id'),
                    'userRank'=>array(self::BELONGS_TO, 'UserRank', 'user_id', 'foreignKey'=>'rank_id', 'alias'=>'rank'),
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => '用户id',
			'user_email' => '用户email',
			'user_name' => '用户名',
			'user_passwd' => '用户密码',
                        'user_question' => '密码找回问题',
                        'user_answer' => '密码找回答案',
                        'user_ico' => '用户头像',
                        'reg_time' => '注册时间',
                        'last_login_time' => '最后登陆时间',
                        'last_ip' => '最后登陆ip',
                        'email_check' => '邮件确认',
                        'email_check_code' => '邮件确认码',
                        'forgot_check_code' => '密码找回码',
                        'rank_id' => '用户级别',
                        'locked' => '用户锁定,1为锁定',
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
         * 用户列表
         * @type static
         * @param array $filters
         * @return CActiveRecord 
         */
        public static function getUserList()
        {
            $model = new Users;
            $criteria = new CDbCriteria();
            $criteria->select = 'user_id, user_email, user_name, reg_time, last_login_time, last_ip, email_check, rank_id, locked';
            $condition = '1';
            $user_name = trim( $_POST['filters']['user_name'] );
            $user_email = trim( $_POST['filters']['user_email'] );
            $locked = intval( $_POST['filters']['locked'] );
            $rank_id = intval( $_POST['filters']['rank_id'] );
            $begin_time = trim( $_POST['filters']['begin_time'] ).' 00:00:00';
            $end_time = trim( $_POST['filters']['end_time'] ).' 00:00:00';
            $user_name && $condition .= ' AND user_name LIKE \'%' . $user_name . '%\'';
            $user_email && $condition .= ' AND user_email LIKE \'%' . $user_email . '%\'';
            $locked && $condition .= ' AND locked= ' . $locked;
            $rank_id && $condition .= ' AND rank_id= ' . $rank_id;
            $begin_time && $condition .= ' AND reg_time >=  ' . "'$begin_time'" ;
            $end_time && $condition .= ' AND reg_time <= ' . "'$end_time'" ;
            $criteria->condition = $condition;
            $criteria->order = 'user_id DESC';
            $result = $model->findAll( $criteria );
            return $result;
        }
        
        /**
	 * 用户注册
         * @type static
         * @param array $userData
         * @return bool
	 */
	public static function registerNewUser()
	{
            $model = new Users;

            if (isset($_POST['userData'])) {
                $model->attributes = $_POST['userData'];
                $model->user_passwd = $model->hashPassword($_POST['userData']['user_passwd']);
                $model->reg_time = date('Y-m-d H:i:s', time());

                if ($model->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 用户登录
         * @type static
         * @param array $loginform
         * @return bool
	 */
	public static function userLogin()
	{
            $model=new Users;

            if(isset($_POST['LoginForm']))
            {
                $model->attributes=$_POST['LoginForm'];
                if($model->validate()){
                    $data = $model->find('user_name=:username', array(':username'=>$model->user_name));
                    if ($data === null) {
                        return '用户不存在';
                    } elseif (! $model->validatePassword($data->user_passwd)) {
                        return '密码不正确';
                    } elseif ($data->locked == 1) {
                        return '用户已经锁定，请联系管理';
                    } else {
                        $data->last_login_time = date('Y-m-d H:i:s', time());
                        return $data->save();
                    }
                }
            }
	}
        
        /**
	 * 用户编辑信息
         * @type static
         * @param int $id
         * @return bool
	 */
	public static function updateUserInfo($id)
	{
            $model=new Users;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            $data = $model->findByPk($id);
            if (isset($_POST['userData'])) {
                $password = $_POST['userData']['user_passwd'];
                if (empty($password)) 
                    $_POST['userData']['user_passwd'] = $model->user_passwd;
                else 
                    $_POST['userData']['user_passwd'] = $model->hashPassword($password);
                
                $data->attributes = $_POST['userData'];
                if ($data->save()) {
                    return true;
                }
            }
	}
        
        /**
	 * 用户状态
         * @type static
         * @param int $id, $status
         * @return bool
	 */
	public static function setUserStatus($id,$status)
	{
            $model=new Users;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            $data=$model->findByPk($id);
            if ($data) {
                $data->locked = $status;
                if ($data->save()) {
                    return true;
                }
            }
	}
        
        /**
        * 检测用户密码
        *
        * @return boolean
        */
        public function validatePassword ($password)
        {
            return $this->hashPassword($this->user_passwd) === $password;
        }

        /**
        * 密码进行加密
        * @return string password
        */
        public function hashPassword ($password,$salt='lvyou')
        {
            return md5($password.$salt);
        }
}
