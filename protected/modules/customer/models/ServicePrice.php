<?php

/**
 * This is the model class for table "service_price".
 *
 * The followings are the available columns in table 'service_price':
 * @property integer $service_id
 * @property string $service_name
 * @property string $price
 * @property string $note
 * @property string $status
 * @property integer $cus_id
 */
class ServicePrice extends CustomerDossierBase
{
	public $count_used;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ServicePrice the static model class
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
		return 'service_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_name, price, cus_id', 'required'),
			array('cus_id', 'numerical', 'integerOnly'=>true),
			array('service_name', 'length', 'max'=>255),
			array('price', 'numerical', 'integerOnly'=>true, 'min' => 500),
			array('price', 'length', 'max'=>12),
			array('status', 'length', 'max'=>1),
			array('note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('service_id, service_name, price, note, status, cus_id', 'safe', 'on'=>'search'),
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
			'service_id' => 'Service',
			'service_name' => 'Service Name',
			'price' => 'Price',
			'note' => 'Note',
			'status' => 'Status',
			'cus_id' => 'Cus',
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

		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('cus_id',$this->cus_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}