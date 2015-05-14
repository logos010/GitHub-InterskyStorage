<?php

/**
 * This is the model class for table "customer_dossier".
 *
 * The followings are the available columns in table 'customer_dossier':
 * @property integer $dossier_id
 * @property string $barcode
 * @property string $dossier_name
 * @property integer $storage_id
 * @property string $floor_id
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 * @property integer $destruction_time
 * @property integer $contract_id
 * @property string $note
 */
class CustomerDossierBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CustomerDossierBase the static model class
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
		return 'customer_dossier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dossier_name, storage_id, floor_id, create_time, status, note', 'required'),
			array('storage_id, create_time, update_time, status, destruction_time, contract_id', 'numerical', 'integerOnly'=>true),
			array('barcode, dossier_name', 'length', 'max'=>255),
			array('floor_id', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dossier_id, barcode, dossier_name, storage_id, floor_id, create_time, update_time, status, destruction_time, contract_id, note', 'safe', 'on'=>'search'),
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
			'dossier_id' => 'Dossier',
			'barcode' => 'Barcode',
			'dossier_name' => 'Dossier Name',
			'storage_id' => 'Storage',
			'floor_id' => 'Floor',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'status' => 'Status',
			'destruction_time' => 'Destruction Time',
			'contract_id' => 'Contract',
			'note' => 'Note',
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

		$criteria->compare('dossier_id',$this->dossier_id);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('dossier_name',$this->dossier_name,true);
		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('floor_id',$this->floor_id,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('status',$this->status);
		$criteria->compare('destruction_time',$this->destruction_time);
		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}