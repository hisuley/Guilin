<?php

class TestController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}
        //测试注册前台用户
        public function actionInsertUser()
        {
            $_POST['userData'] = array('user_email'=>'test@admin.com', 'user_name'=>'usertest', 'user_passwd'=>'pass@word', 'user_ico'=>'http://test.test.test/image.jpg');
            var_dump(Users::registerNewUser());
        }
	//测试前台用户登录
        public function actionLoginUser()
        {
            $_POST['LoginForm'] = array('user_name'=>'usertesdt', 'user_passwd'=>'pass@word');
            var_dump(Users::userLogin());
        }
        //测试前台编辑用户
        public function actionUpdateUser()
        {
            $_POST['userData'] = array('user_email'=>'test@admin.com', 'user_name'=>'usertest', 'user_passwd'=>'pass@word', 'user_ico'=>'whynot!');
            var_dump(Users::updateUserInfo(3));
        }
        //测试设置前台用户状态
        public function actionSetUserStatus()
        {
            var_dump(Users::setUserStatus(3, 'ffff3'));
        }
        //测试前台用户列表
        public function actionGetUserList()
        {
            $_POST['filters'] = array('user_name'=>'', 'user_email'=>'', 'locked'=>'', 'rank_id'=>'', 'begin_time'=>'2013-11-28', 'end_time'=>'2013-11-28',);
            var_dump(Users::getUserList());
        }
        
        //测试会员等级列表
        public function actionGetRankList()
        {
            var_dump(UserRank::getRankList());
        }
        //测试添加会员等级
        public function actionAddRank()
        {
            $_POST['rankData'] = array('rank_name'=>'测试', 'privilege'=>'a:0:{}asdasdasd');
            var_dump(UserRank::addNewRank());
        }
        //测试会员等级编辑
        public function actionUpdateRank()
        {
            $_POST['rankData'] = array('rank_name'=>'测试123', 'privilege'=>'a:0:{}asdasdasd');
            var_dump(UserRank::updateUserRank(8));
        }
        //测试会员等级删除
        public function actionDeleteRank()
        {
            var_dump(UserRank::deleteUserRank(8));
        }
}