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
 */
class CustomerBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CustomerBase the static model class
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
			array('company_name, comp_phone, comp_email, comp_fax, comp_address, comp_contact_info', 'required'),
			array('company_name', 'length', 'max'=>40),
			array('tax_code, comp_phone', 'length', 'max'=>15),
			array('comp_email, comp_address', 'length', 'max'=>255),
			array('comp_fax', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cus_id, company_name, tax_code, comp_phone, comp_email, comp_fax, comp_address, comp_contact_info', 'safe', 'on'=>'search'),
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
			'cus_id' => 'Cus',
			'company_name' => 'Company Name',
			'tax_code' => 'Tax Code',
			'comp_phone' => 'Comp Phone',
			'comp_email' => 'Comp Email',
			'comp_fax' => 'Comp Fax',
			'comp_address' => 'Comp Address',
			'comp_contact_info' => 'Comp Contact Info',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}