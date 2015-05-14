<?php

/**
 * This is the model class for table "range".
 *
 * The followings are the available columns in table 'range':
 * @property integer $range_id
 * @property string $range_name
 * @property integer $storage_id
 * @property integer $floor
 * @property integer $range_column
 * @property integer $pressed_wall
 */
class RangeBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RangeBase the static model class
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
		return 'range';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('range_name, storage_id, range_column, pressed_wall', 'required'),
			array('storage_id, floor, range_column, pressed_wall', 'numerical', 'integerOnly'=>true),
			array('range_name', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('range_id, range_name, storage_id, floor, range_column, pressed_wall', 'safe', 'on'=>'search'),
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
			'range_id' => 'Range',
			'range_name' => 'Range Name',
			'storage_id' => 'Storage',
			'floor' => 'Floor',
			'range_column' => 'Range Column',
			'pressed_wall' => 'Pressed Wall',
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

		$criteria->compare('range_id',$this->range_id);
		$criteria->compare('range_name',$this->range_name,true);
		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('floor',$this->floor);
		$criteria->compare('range_column',$this->range_column);
		$criteria->compare('pressed_wall',$this->pressed_wall);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}