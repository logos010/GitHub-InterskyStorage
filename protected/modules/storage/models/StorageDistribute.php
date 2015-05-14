<?php

/**
 * This is the model class for table "storage_distribute".
 *
 * The followings are the available columns in table 'storage_distribute':
 * @property integer $storage_id
 * @property integer $dossier_id
 * @property integer $floor_id
 * @property integer $cus_id
 */
class StorageDistribute extends StorageDistributeBase
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StorageDistribute the static model class
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
		return 'storage_distribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dossier_id, floor_id', 'required'),
			array('dossier_id, floor_id, cus_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('storage_id, dossier_id, floor_id, cus_id', 'safe', 'on'=>'search'),
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
                    'floor' => array(self::BELONGS_TO, 'Floor', 'floor_id'),
                    'customer_dossier' => array(self::HAS_ONE, 'CustomerDossier', 'dossier_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'storage_id' => 'Storage',
			'dossier_id' => 'Dossier',
			'floor_id' => 'Floor',
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

		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('dossier_id',$this->dossier_id);
		$criteria->compare('floor_id',$this->floor_id);
		$criteria->compare('cus_id',$this->cus_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}