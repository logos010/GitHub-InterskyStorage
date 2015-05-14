<?php

/**
 * This is the model class for table "dependence_price".
 *
 * The followings are the available columns in table 'dependence_price':
 * @property integer $dependence_id
 * @property integer $create_time
 * @property double $price
 * @property string $name
 * @property integer $service_id
 * @property string $status
 */
class DependencePrice extends CustomerDossierBase
{
	public $sum;
	public $amount;
	/**
	 * Returns the static model of the specified AR class.
	 * @return DependencePrice the static model class
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
			array('create_time, service_id', 'required'),
			array('create_time, service_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('name', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dependence_id, create_time, price, name, service_id, status', 'safe', 'on'=>'search'),
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
			 'service' 	=> array(self::BELONGS_TO, 'ServicePrice', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dependence_id' => 'Dependence',
			'create_time' => 'Day use service',
			'price' => 'Price',
			'name' => 'Name',
			'service_id' => 'Service',
			'status' => 'Status',
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
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('price',$this->price);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}