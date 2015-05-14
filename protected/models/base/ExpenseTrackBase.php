<?php

/**
 * This is the model class for table "expense_track".
 *
 * The followings are the available columns in table 'expense_track':
 * @property integer $expense_id
 * @property integer $cus_id
 * @property integer $price_id
 * @property integer $create_time
 * @property string $note
 * @property integer $tracker
 */
class ExpenseTrackBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ExpenseTrackBase the static model class
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
		return 'expense_track';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cus_id, price_id, create_time, note, tracker', 'required'),
			array('cus_id, price_id, create_time, tracker', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('expense_id, cus_id, price_id, create_time, note, tracker', 'safe', 'on'=>'search'),
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
			'expense_id' => 'Expense',
			'cus_id' => 'Cus',
			'price_id' => 'Price',
			'create_time' => 'Create Time',
			'note' => 'Note',
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

		$criteria->compare('expense_id',$this->expense_id);
		$criteria->compare('cus_id',$this->cus_id);
		$criteria->compare('price_id',$this->price_id);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('tracker',$this->tracker);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}