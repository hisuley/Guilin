<?php

/**
 * "{{imall_keywords_count}}" 数据表模型类.
 *
 */
class KeywordsCount extends CActiveRecord
{

	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return 'imall_keywords_count';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('keywords', 'required'),
			array('keywords', 'length', 'max'=>255),
			array('count, day, week, month, dataline', 'length', 'max'=>11),
                        array('id, keywords, count, day, week, month, dataline', 'safe', 'on'=>'search'),
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
			'id' => '关键字id',
			'keywords' => '关键字',
			'count' => '总搜索次数',
			'day' => '当天',
                        'week' => '本周',
                        'month' => '本月',
                        'dataline' => '最后更新时间',
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
         * 关键字列表
         * @type static
         * @param array $filters
         * @return CActiveRecord 
         */
        public static function getKeywordsList()
        {
            $model = new KeywordsCount;
            $criteria = new CDbCriteria;
            $condition = '1';
            $keywords = trim( $_POST['filters']['keywords'] );
            $count = trim( $_POST['filters']['count'] );
            $keywords && $condition .= ' AND keywords LIKE \'%' . $keywords . '%\'';
            $count && $condition .= ' AND count= ' . $count;
            $criteria->condition = $condition;
            $criteria->order = 'id DESC';
            $result = $model->findAll($criteria);
            if($result){
                return $result;
            }
        }
}
