<?php

/**
 * "{{article_cat}}" 数据表模型类.
 *
 */
class ArticleCat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gl_article_cat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_name', 'required'),
			array('cat_type, show_in_nav, parent_id', 'numerical', 'integerOnly'=>true),
			array('cat_name, keywords', 'length', 'max'=>255),
			array('cat_type, show_in_nav', 'length', 'max'=>1),
			array('cat_desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cat_name, cat_type, sort_order', 'safe', 'on'=>'search'),
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
			'id' => 'id号',
			'cat_name' => '名称',
			'cat_type' => '类型:1普通分类,2系统分类,3网店信息,4帮助分类,5网店帮助',
			'keywords' => '关键字',
			'cat_desc' => '说明文字',
			'sort_order' => '显示顺序',
			'show_in_nav' => '是否在导航栏显示:1是,0否',
			'parent_id' => '父节点id',
		);
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
}
