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
        
        //测试咨询管理添加新闻
        public function actionAddArticle(){
            $_POST['data'] = array('cat_id'=>4, 'title'=>'testarticle_title', 'content'=>'testarticle_content', 'thumb'=>'http://test.test.com/10755583382,jpg', 'admin_id'=>2, 'tag_color'=>'test_color', 'short_order'=>1);
            var_dump(Article::addNew());
        }
        //测试咨询管理编辑新闻
        public function actionUpdateArticle(){
            $_POST['data'] = array('cat_id'=>4, 'title'=>'123testarticle_title', 'content'=>'123testarticle_content', 'thumb'=>'h123ttp://test.test.com/10755583382,jpg', 'admin_id'=>2, 'tag_color'=>'t123est_color', 'short_order'=>1);
            var_dump(Article::updateInfo(38));
        }
        //测试咨询管理新闻列表
        public function actionGetArticleList(){
            $_POST['filters'] = array('cat_id'=>4);
            var_dump(Article::getList());
        }
        //测试咨询管理删除新闻
        public function actionDelArticle(){
            $_POST['article_id'] = 37;
            var_dump(Article::delNew());
        }
        
        //测试咨询管理添加新闻分类
        public function actionAddArticleCat(){
            $_POST['data'] = array('cat_name'=>'test_lvyou', 'parent_id'=>0, 'sort_order'=>'');
            var_dump(ArticleCat::addNew());
        }
        //测试咨询管理编辑新闻分类
        public function actionUpdateArticleCat(){
            $_POST['data'] = array('cat_name'=>'123test_lvyou', 'parent_id'=>2, 'sort_order'=>'12');
            var_dump(ArticleCat::updateInfo(12));
        }
        //测试咨询管理获取新闻列表
        public function actionGetArticleCatList(){
            var_dump(ArticleCat::getList());
        }
        
        //测试首页轮显图片列表
        public function actionGetIndexImages(){
            var_dump(IndexImages::getImagesList());
        }
        //测试添加首页轮显图片
        public function actionAddIndexImages(){
            $_POST['data'] = array('name'=>'test_介绍', 'images_url'=>'http://www.baidu.com/12312312test.jpg', 'images_link'=>'http://www.baidu.com/12312312test.jpg');
            var_dump(IndexImages::addIndexImage());
        }
        //测试编辑首页轮显图片
        public function actionUpdateIndexImages(){
            $_POST['data'] = array('name'=>'123test_介绍', 'images_url'=>'ht123tp://www.baidu.com/12312312test.jpg', 'images_link'=>'http123://www.baidu.com/12312312test.jpg');
            var_dump(IndexImages::updateIndexImage(33));
        }
        //测试删除首页轮显图片
        public function actionDelIndexImages(){
            var_dump(IndexImages::deleteIndexImage(33));
        }
        //测试设置首页轮显图片显示/隐藏
        public function actionSetIndexImages(){
            var_dump(IndexImages::setImageStatus(37, 1));
        }
        
        //测试企业列表
        public function actionGetShopList(){
            $_POST['filters'] = array('shop_name'=>'', 'lock_flg'=>'', 'shop_categories'=>'', 'begin_time'=>'2013-11-26', 'end_time'=>'');
            var_dump(ShopInfo::getShopList());
        }
        //测试添加店铺
        public function actionAddShop(){
            $_POST['data'] = array('user_id'=>2, 'shop_name'=>'test', 'shop_categories'=>3, 'shop_country'=>'中国', 'shop_province'=>'河北', 'shop_city'=>'怀来', 'shop_district'=>'沙城', 'shop_address'=>'试试', 'shop_management'=>'的萨芬', 'shop_intro'=>'text_desc');
            var_dump(ShopInfo::addShop());
        }
        //测试编辑店铺
        public function actionUpdateShop(){
            $_POST['data'] = array('user_id'=>2, 'shop_name'=>'123test', 'shop_categories'=>3, 'shop_country'=>'中国', 'shop_province'=>'河北', 'shop_city'=>'怀来', 'shop_district'=>'沙城', 'shop_address'=>'试试', 'shop_management'=>'333的萨芬', 'shop_intro'=>'333111text_desc');
            var_dump(ShopInfo::updateShop(3));
        }
        //测试设置店铺状态
        public function actionSetShop(){
            var_dump(ShopInfo::setShopStatus(3, 1));
        }
        
        //测试添加企业
        public function actionAddShopRequest(){
            $_POST['data'] = array('user_id'=>'3', 'company_name'=>'test_qiye', 'person_name'=>'dave', 'credit_type'=>'idcard', 'credit_num'=>'130730199005201837', 'credit_commercial'=>'yingyezhizhao', 'company_area'=>'BJ', 'company_address'=>'河北省1231231231', 'zipcode'=>'100100', 'mobile'=>'13358675532', 'telphone'=>'010-62233535');
            var_dump(ShopRequest::addNew());
        }
        //测试编辑企业
        public function actionUpdateShopRequest(){
            $_POST['data'] = array('user_id'=>'3', 'company_name'=>'123test_qiye', 'person_name'=>'da123ve', 'credit_type'=>'idca123rd', 'credit_num'=>'130730199005201837', 'credit_commercial'=>'yi333ngyezhizhao', 'company_area'=>'BJ', 'company_address'=>'河北省1233331231231', 'zipcode'=>'100100', 'mobile'=>'13358675532', 'telphone'=>'010-62233535');
            var_dump(ShopRequest::updateInfo(3));
        }
        //测试未审核企业列表
        public function actionGetShopRequestList(){
            var_dump(ShopRequest::getList());
        }
        
        //测试添加企业分类
        public function actionAddShopCat(){
            $_POST['data'] = array('cat_name'=>'test_shopcatname', 'parent_id'=>0, 'sort_order'=>2);
            var_dump(ShopCategories::addShopCat());
        }
        //测试编辑企业分类
        public function actionUpdateShopCat(){
            $_POST['data'] = array('cat_name'=>'123test_shopcatname', 'parent_id'=>0, 'sort_order'=>1);
            var_dump(ShopCategories::updateInfo(5));
        }
        //测试获取企业分类列表
        public function actionGetShopCatList(){
            var_dump(ShopCategories::getList());
        }
        //测试删除企业分类
        public function actionDelShopCat(){
            var_dump(ShopCategories::delShopCat(4));
        }
        //测试导出企业列表
        public function actionExportShopCat(){
            var_dump(ShopCategories::exportShopCat('test'));
        }
        
        //测试添加企业信用等级
        public function actionAddIntegral(){
            $_POST['data'] = array('int_grade'=>6, 'int_min'=>401, 'int_max'=>500, 'int_img'=>'www/www/www.jpg' );
            var_dump(Integral::addIntegral());
        }
        //测试修改企业信用等级
        public function actionUpdateIntegral(){
            $_POST['data'] = array('int_grade'=>7, 'int_min'=>40122, 'int_max'=>555, 'int_img'=>'www/w213ww/www.jpg' );
            var_dump(Integral::updateIntegral(10));
        }
        //测试删除企业信用等级
        public function actionDelIntegral(){
            var_dump(Integral::delIntegral(10));
        }
        
}