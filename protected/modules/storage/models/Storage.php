<?php

/**
 * This is the model class for table "storage".
 *
 * The followings are the available columns in table 'storage':
 * @property integer $storage_id
 * @property string $st_name
 * @property string $st_address
 * @property string $map
 * @property string $st_phone
 * @property string $contact_peolpe
 */
class Storage extends StorageBase
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Storage the static model class
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
		return 'storage';
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
			'storage_id' => 'Storage',
			'st_name' => 'Storage Name',
			'st_address' => 'Storage Address',
			'map' => 'Map',
			'st_phone' => 'Storage Phone',
			'contact_peolpe' => 'Contact Peolpe',
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

		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('st_name',$this->st_name,true);
		$criteria->compare('st_address',$this->st_address,true);
		$criteria->compare('map',$this->map,true);
		$criteria->compare('st_phone',$this->st_phone,true);
		$criteria->compare('contact_peolpe',$this->contact_peolpe,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}