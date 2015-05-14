<?php

/**
 * This is the model class for table "floor".
 *
 * The followings are the available columns in table 'floor':
 * @property integer $floor_id
 * @property string $floor_name
 * @property integer $contain_id
 * @property string $sub_floor
 * @property string $location_code
 * @property integer $range_id
 * @property integer $status
 */
class Floor extends FloorBase
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Floor the static model class
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
		return 'floor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('floor_name, contain_id, sub_floor, location_code', 'required'),
			array('contain_id, range_id, status', 'numerical', 'integerOnly'=>true),
			array('floor_name, location_code', 'length', 'max'=>40),
			array('sub_floor', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('floor_id, floor_name, contain_id, sub_floor, location_code, range_id, status', 'safe', 'on'=>'search'),
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
                    'range' => array(self::BELONGS_TO, 'Range', 'range_id'),
                    'contain' => array(self::BELONGS_TO, 'Contain', 'contain_id'),
                    'distribute' => array(self::HAS_ONE, 'StorageDistribute', 'floor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'floor_id' => 'Floor',
			'floor_name' => 'Floor Name',
			'contain_id' => 'Contain',
			'sub_floor' => 'Sub Floor',
			'location_code' => 'Location Code',
			'range_id' => 'Range',
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

		$criteria->compare('floor_id',$this->floor_id);
		$criteria->compare('floor_name',$this->floor_name,true);
		$criteria->compare('contain_id',$this->contain_id);
		$criteria->compare('sub_floor',$this->sub_floor,true);
		$criteria->compare('location_code',$this->location_code,true);
		$criteria->compare('range_id',$this->range_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}