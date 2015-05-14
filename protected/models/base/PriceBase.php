<?php

/**
 * This is the model class for table "price".
 *
 * The followings are the available columns in table 'price':
 * @property integer $price_id
 * @property string $price_name
 * @property double $value
 * @property integer $status
 * @property string $type_price
 * @property string $description
 * @property integer $contract_id
 */
class PriceBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PriceBase the static model class
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
		return 'price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price_name, value, status, contract_id', 'required'),
			array('status, contract_id', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('price_name, type_price', 'length', 'max'=>40),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('price_id, price_name, value, status, type_price, description, contract_id', 'safe', 'on'=>'search'),
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
			'price_id' => 'Price',
			'price_name' => 'Price Name',
			'value' => 'Value',
			'status' => 'Status',
			'type_price' => 'Type Price',
			'description' => 'Description',
			'contract_id' => 'Contract',
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

		$criteria->compare('price_id',$this->price_id);
		$criteria->compare('price_name',$this->price_name,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('status',$this->status);
		$criteria->compare('type_price',$this->type_price,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('contract_id',$this->contract_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}