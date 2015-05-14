<?php

/**
 * This is the model class for table "dependence_price".
 *
 * The followings are the available columns in table 'dependence_price':
 * @property integer $dependence_id
 * @property integer $cus_id
 * @property integer $create_time
 * @property string $command
 * @property double $price
 * @property string $type_price
 * @property integer $tracker
 */
class DependencePriceBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DependencePriceBase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dependence_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cus_id, create_time', 'required'),
			array('cus_id, create_time, tracker', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('type_price', 'length', 'max'=>40),
			array('command', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dependence_id, cus_id, create_time, command, price, type_price, tracker', 'safe', 'on'=>'search'),
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
			'dependence_id' => 'Dependence',
			'cus_id' => 'Cus',
			'create_time' => 'Create Time',
			'command' => 'Command',
			'price' => 'Price',
			'type_price' => 'Type Price',
			'tracker' => 'Tracker',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('dependence_id',$this->dependence_id);
		$criteria->compare('cus_id',$this->cus_id);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('command',$this->command,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('type_price',$this->type_price,true);
		$criteria->compare('tracker',$this->tracker);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}