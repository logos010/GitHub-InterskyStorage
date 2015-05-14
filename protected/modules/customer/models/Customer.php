<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $cus_id
 * @property string $company_name
 * @property string $tax_code
 * @property string $comp_phone
 * @property string $comp_email
 * @property string $comp_fax
 * @property string $comp_address
 * @property string $comp_contact_info
 * @property string $status
 * @property string $contract_code
 * @property integer $contract_time
 */
class Customer extends CustomerDossierBase
{
	public $count_contract;
	public $count_service;
	public $count_box;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Customer the static model class
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
		return 'customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, comp_phone, comp_email, comp_address, contract_code, contract_time', 'required'),
			array('contract_time', 'numerical', 'integerOnly'=>true),
			array('company_name, contract_code', 'length', 'max'=>40),
			array('tax_code, comp_phone', 'length', 'max'=>15),
			array('comp_email', 'email'),
			array('comp_phone, comp_fax', 'numerical'),
			array('comp_phone', 'length', 'max'=>15, 'min'=>7),
			array('comp_address', 'length', 'max'=>255),
			array('comp_fax', 'length', 'max'=>20),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cus_id, company_name, tax_code, comp_phone, comp_email, comp_fax, comp_address, comp_contact_info, status, contract_code', 'safe', 'on'=>'search'),
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
		 	'service' => array(self::HAS_MANY, 'ServicePrice', 'cus_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cus_id' => 'Cus',
			'company_name' => 'Company Name',
			'tax_code' => 'Tax Code',
			'comp_phone' => 'Phone',
			'comp_email' => 'Email',
			'comp_fax' => 'Fax',
			'comp_address' => 'Address',
			'comp_contact_info' => 'Comp Contact Info',
			'status' => 'Status',
			'contract_code' => 'Contract Code',
			'contract_time' => 'Create Date'
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

		$criteria->compare('cus_id',$this->cus_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('tax_code',$this->tax_code,true);
		$criteria->compare('comp_phone',$this->comp_phone,true);
		$criteria->compare('comp_email',$this->comp_email,true);
		$criteria->compare('comp_fax',$this->comp_fax,true);
		$criteria->compare('comp_address',$this->comp_address,true);
		$criteria->compare('comp_contact_info',$this->comp_contact_info,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('contract_code',$this->contract_code,true);
		$criteria->compare('contract_time',$this->contract_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}