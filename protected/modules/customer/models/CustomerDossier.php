<?php

/**
 * This is the model class for table "customer_dossier".
 *
 * The followings are the available columns in table 'customer_dossier':
 * @property integer $dossier_id
 * @property string $barcode
 * @property string $dossier_name
 * @property string $dossier_no
 * @property integer $seal_no
 * @property integer $storage_id
 * @property string $floor_id
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 * @property integer $destruction_time
 * @property string $note
 * @property integer $cus_id
 */
class CustomerDossier extends CActiveRecord
{
	public $floor_name;
    public $withdrew_dossier;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CustomerDossier the static model class
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
			array('dossier_name, dossier_no, storage_id, floor_id, create_time, destruction_time, seal_no', 'required'),
			array('dossier_no, seal_no', 'distinct'),
			array('storage_id, update_time, status, cus_id', 'numerical', 'integerOnly'=>true),
			array('barcode, dossier_name', 'length', 'max'=>255),
			array('floor_id', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dossier_id, barcode, dossier_name, storage_id, floor_id, create_time, update_time, status, destruction_time, note, cus_id', 'safe', 'on'=>'search'),
		);
	}
	public function distinct($attr, $param) {
		if ($this->isNewRecord) {
			$arrLabel = self::attributeLabels();
			$check = $this->exists($attr . " = :no AND status = 1", array(':no' => $this->$attr));
			if ($check) {return $this->addError($attr, $arrLabel[$attr] . ' "' . $this->$attr . '" already exists.');}
		}
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
                    'storage_distribute' => array(self::HAS_MANY, 'StorageDistribute', 'dossier_id'),
                    'floor' => array(self::BELONGS_TO, 'Floor', 'floor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dossier_id' 		=> 'Box',
			'barcode' 			=> 'Barcode',
			'dossier_name' 		=> 'Box Name',
			'dossier_no' 		=> 'Box ID',
			'seal_no'			=> 'Seal No',
			'storage_id' 		=> 'Storage',
			'floor_id' 			=> 'Floor',
			'create_time' 		=> 'Create Time',
			'update_time' 		=> 'Update Time',
			'status' 			=> 'Status',
			'destruction_time' 	=> 'Destruction Time',
			'note' 				=> 'Note',
			'cus_id' 			=> 'Cus',
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
		$criteria->compare('dossier_no',$this->dossier_no,true);
		$criteria->compare('seal_no',$this->seal_no,true);
		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('floor_id',$this->floor_id,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('status',$this->status);
		$criteria->compare('destruction_time',$this->destruction_time);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('cus_id',$this->cus_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}