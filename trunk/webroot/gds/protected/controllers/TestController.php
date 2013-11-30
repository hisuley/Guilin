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
            $_POST['filters'] = array('user_name'=>'', 'user_email'=>'', 'locked'=>'', 'rank_id'=>'', 'begin_time'=>'2013-11-28', 'end_time'=>'',);
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
        
        //测试添加后台管理员
        public function actionInsertAdminUser()
        {
            $_POST['adminData'] = array('admin_name'=>'liuyawei', 'admin_email'=>'liu@yawei.com', 'admin_password'=>'liuyawei', 'group_id'=>'1');
            var_dump(AdminUser::addAdminUser());
        }
	//测试后台管理员登录
        public function actionAdminUserLogin()
        {
            $_POST['adminForm'] = array('admin_name'=>'liuyawei', 'admin_password'=>'liuyawei');
            var_dump(AdminUser::adminUserLogin());
        }
        //测试修改管理员密码
        public function actionUpdateAdminUser()
        {
            $_POST['adminData'] = array('admin_id'=>2, 'admin_password'=>'liuyawei', 'newpassword'=>'123123', 'respassword'=>'123123');
            var_dump(AdminUser::updateAdminUserPass());
        }
        //测试后台管理员列表
        public function actionGetAdminUserList()
        {
            var_dump(AdminUser::getAdminUserList());
        }
        
        //测试管理员组列表
        public function actionGetAdminGroupList()
        {
            var_dump(AdminGroup::getAdminGroupList());
        }
        //测试添加管理员组
        public function actionAddAdminGroup()
        {
            $_POST['adminGroup'] = array('group_name'=>'测试',);
            var_dump(AdminGroup::addAdminGroup());
        }
}