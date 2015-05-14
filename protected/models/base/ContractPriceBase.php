<?php

/**
 * This is the model class for table "contract_price".
 *
 * The followings are the available columns in table 'contract_price':
 * @property integer $contract_id
 * @property string $contract_code
 * @property integer $cus_id
 * @property double $price
 * @property integer $create_time
 * @property integer $contract_flag
 * @property string $note
 */
class ContractPriceBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContractPriceBase the static model class
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
		return 'contract_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cus_id, price, create_time, contract_flag', 'required'),
			array('cus_id, create_time, contract_flag', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('contract_code', 'length', 'max'=>100),
			array('note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contract_id, contract_code, cus_id, price, create_time, contract_flag, note', 'safe', 'on'=>'search'),
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
                    'customer' => array(self::BELONGS_TO, 'Customer', 'cus_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contract_id' => 'Contract',
			'contract_code' => 'Contract Code',
			'conpany_name' => 'Company Name',
			'cus_id' => 'Cus',
			'price' => 'Price',
			'create_time' => 'Create Time',
			'contract_flag' => 'Contract Flag',
			'note' => 'Note',
			'contract_range_fr' => 'Contract Range From'
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

		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('contract_code',$this->contract_code,true);
		$criteria->compare('cus_id',$this->cus_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('contract_flag',$this->contract_flag);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}