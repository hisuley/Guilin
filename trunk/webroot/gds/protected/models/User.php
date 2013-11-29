<?php

/**
 * "{{user}}" 数据表模型类.
 *
 */
class User extends CActiveRecord
{
        public $username;
	public $password;

	private $_identity;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gl_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('username, password, realname, phone, birthday_year, birthday_month, birthday_day', 'required', 'on'=>'reg'),
			array('username, password', 'required'),
			array('username, password', 'length', 'max'=>128),
			array('username, password', 'authenticate', 'on'=>'login'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '用户ID',
			'username' => '用户名',
			'password' => '密码',
			'realname' => '真实姓名',
                        'phone' => '电话',
                        'birthday_year' => '生日年份',
                        'birthday_month' => '生日月份',
                        'birthday_day' => '生日',
                        'status' => '状态',
                        'careate_time' => '创建时间',
		);
	}

	
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','错误的用户名或密码.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($this->_identity,0);
			return true;
		}
		else
			return false;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * 用户注册
         * @type static
         * @param array $userData
         * @return bool
	 */
	public static function registerNewUser()
	{
            $model = new User;

            if (isset($_POST['userData'])) {
                $model->attributes = $_POST['userData'];
                $model->password = $model->hashPassword($_POST['userData']['password']);
                $model->create_time = date('Y-m-d');

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
            $model=new User;

            if(isset($_POST['LoginForm']))
            {
                    $model->attributes=$_POST['LoginForm'];
                    if($model->validate() && $model->login())
                            return true;
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
            $model=new User;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            $data = $model->findByPk($id);
            if (isset($_POST['userData'])) {
                $password = $_POST['userData']['password'];
                if (empty($password)) 
                    $_POST['userData']['password'] = $model->password;
                else 
                    $_POST['userData']['password'] = $model->hashPassword($password);

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
            $model=new User;
            if(!$id)
                throw new CHttpException(404, '记录不存在');

            if ($status) {
                $model->status = $status;
                if ($model->save()) {
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
            return $this->hashPassword($this->password) === $password;
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
