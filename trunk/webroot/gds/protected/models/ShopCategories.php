<?php

/**
 * "{{imall_shop_categories}}" 数据表模型类.
 *
 */
class ShopCategories extends CActiveRecord
{
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_shop_categories';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('cat_name, parent_id, sort_order', 'required'),
			array('parent_id, sort_order, shops_num', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>255),
			array('cat_id, cat_name, parent_id, sort_order, shops_num', 'safe', 'on'=>'search'),
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
			'cat_id' => '分类id',
			'cat_name' => '分类名称',
			'parent_id' => '父分类id: 0为根分类',
			'sort_order' => '分类排序',
                        'shops_num' => '店铺数量',
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
	 * 添加企业分类
         * @type static
         * @param array $data
         * @return bool|int
	 */
	public static function addShopCat()
	{
            $model = new ShopCategories;
            if (isset($_POST['data'])) {
                $model->attributes = $_POST['data'];

                if ($model->save()) {
                    return $model->cat_id;
                } else {
                    return false;
                }
            }
	}
        
        /**
	 * 更新企业分类
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
	 * 获取企业分类列表
         * @type static
         * @param array $filters
         * @return CActiveRecord
	 */
	public static function getList()
	{ 
            $model = new ShopCategories();
            $result = $model->findAll();
            if($result){
                return $result;
            }
	}
        
         /**
	 * 获取企业分类名称
         * @type static
         * @param int $catid
         * @return string
	 */
	public static function getCatName()
	{ 
            $model = new ShopCategories();
            $criteria = new CDbCriteria();
            
            $criteria->condition='id=:id';
            $criteria->params=array(':id'=>intval($_POST['catid']));
            $criteria->select='cat_name';
            $result = $model->find( $criteria );
            if($result){
                return $result;
            }
	}
        
        /**
         * 删除企业分类
         * @type static
         * @param int $id
         * @return bool 
         */
        public static function delShopCat($id){
            $model = new ShopCategories;
            return $model->deleteByPk($id);
        }

        /** 
         * 导出企业分类列表
         * @type static
         * @param string $filename
         * @return cvs
         */
        public static function exportShopCat($filename){
            
            $model = new ShopCategories;
            header("Content-Type: application/vnd.ms-execl");
            header("Content-Disposition: attachment; filename=$filename.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data = $model->findAll();
            if($data){
               $cvs= '<html xmlns:o="urn:schemas-microsoft-com:office:office"
                    xmlns:x="urn:schemas-microsoft-com:office:excel"
                    xmlns="http://www.w3.org/TR/REC-html40">
                    <head>
                    <meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
                    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
                    <!--[if gte mso 9]><xml>
                    <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                    <x:Name></x:Name>
                    <x:WorksheetOptions>
                    <x:DisplayGridlines/>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->

                    </head>'; 
               $cvs.= "<table border='1' cellpadding='1' cellspacing='1'>\t";
               $cvs.= "<tr>\t";
               $cvs.= "<td>企业分类ID</td>"."\t";
               $cvs.= "<td>企业分类名称</td>"."\t";
               $cvs.= "<td>父级分类ID</td>"."\t";
               $cvs.= "<td>排序</td>"."\t";
               $cvs.= "<td>企业数量</td>"."\t";
               $cvs.= "</tr>\t";
               foreach ($data as $v){
                   $cvs.= "<tr>\t";
                   $cvs.= "<td>".$v->attributes['cat_id']."</td>\t";
                   $cvs.= "<td>".$v->attributes['cat_name']."</td>\t";
                   $cvs.= "<td>".$v->attributes['parent_id']."</td>\t";
                   $cvs.= "<td>".$v->attributes['sort_order']."</td>\t";
                   $cvs.= "<td>".$v->attributes['shops_num']."</td>\t";
                   $cvs.= "</tr>\t";
               }
               $cvs.= "</table>\t";
               return $cvs;
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
