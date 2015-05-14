<?php

/**
 * This is the model class for table "dossier_track".
 *
 * The followings are the available columns in table 'dossier_track':
 * @property integer $track_id
 * @property integer $create_time
 * @property string $new_location
 * @property string $old_location
 * @property integer $status
 * @property string $command
 * @property string $user_name
 * @property integer $dossier_id
 */
class DossierTrack extends CustomerDossierBase
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DossierTrack the static model class
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
		return 'dossier_track';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, status, command', 'required'),
			array('create_time, status, dossier_id', 'numerical', 'integerOnly'=>true),
			array('new_location, old_location', 'length', 'max'=>40),
			array('user_name', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('track_id, create_time, new_location, old_location, status, command, user_name, dossier_id', 'safe', 'on'=>'search'),
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
			 'dossier' => array(self::BELONGS_TO, 'CustomerDossier', 'dossier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'track_id' => 'Track',
			'create_time' => 'Create Time',
			'new_location' => 'New Location',
			'old_location' => 'Old Location',
			'status' => 'Status',
			'command' => 'Command',
			'user_name' => 'User Name',
			'dossier_id' => 'Dossier',
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

		$criteria->compare('track_id',$this->track_id);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('new_location',$this->new_location,true);
		$criteria->compare('old_location',$this->old_location,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('command',$this->command,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('dossier_id',$this->dossier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}