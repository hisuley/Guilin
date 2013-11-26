<?php

class UserController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}
        
	/**
	 * 用户注册
	 */
	public function actionReg()
	{
            $model = new User;
            if (isset($_POST['userData'])) {
                $model->attributes = $_POST['userData'];
                $model->password = $model->hashPassword($_POST['userData']['password']);
                $model->create_time = date('Y-m-d');

                if ($model->save()) {
                    $this->redirect(array ('index'));
                }
            }
            $this->render('reg', array ('model' => $model ));
	}
        
        /**
	 * 用户登录
	 */
	public function actionLogin()
	{
            $model=new User;

            if(isset($_POST['LoginForm']))
            {
                    $model->attributes=$_POST['LoginForm'];

                    if($model->validate() && $model->login())
                            $this->redirect(Yii::app()->user->returnUrl);
            }

            $this->render('login',array('model'=>$model));
	}
        
        /**
	 * 用户编辑信息
	 */
	public function actionUpdate($id)
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
                    $this->redirect(array ('index' ));
                }
            }
            $this->render('update', array ('model' => $data ));
	}
        
        /**
	 * 用户状态
	 */
	public function actionStatus($id)
	{
            $model=new User;
            if(!$id)
                throw new CHttpException(404, '记录不存在');
            
            $status = Yii::app()->request->getParam('status');
            if ($status) {
                $model->status = $status;
                if ($model->save()) {
                    $this->redirect(array ('index' ));
                }
            }
            $this->render('status', array ('model' => $model ));
	}
}