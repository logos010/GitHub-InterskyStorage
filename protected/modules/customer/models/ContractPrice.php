<?php

/**
 * This is the model class for table "contract_price".
 *
 * The followings are the available columns in table 'contract_price':
 * @property integer $contract_id
 * @property integer $cus_id
 * @property string $price
 * @property integer $create_time
 * @property integer $contract_flag
 * @property string $note
 * @property string $contract_range
 */
class ContractPrice extends CustomerDossierBase
{
	public $contract_range_fr;
	public $contract_range_to;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContractPrice the static model class
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
		return 'contract_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cus_id, price, create_time, contract_flag, contract_range_fr', 'required'),
			array('cus_id, create_time, contract_flag, contract_range_fr', 'numerical', 'integerOnly'=>true),
			array('contract_range_to', 'required'),
			array('contract_range_to', 'numerical', 'integerOnly'=>true),
			array('contract_range_fr', 'checkRange', $this->contract_range_fr, $this->contract_range_to, $this->contract_id, $this->cus_id),
			array('contract_range_fr', 'compareRange', $this->contract_range_fr, $this->contract_range_to),
			array('price', 'numerical', 'integerOnly'=>true, 'min' => 500),
			array('price', 'length', 'max'=>12),
			array('note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contract_id, cus_id, price, create_time, contract_flag, note, contract_range', 'safe', 'on'=>'search'),
		);
	}

	public function compareRange($rangefr, $value) {
		if (!array_key_exists('contract_range_fr', $this->errors) && intval($value[0]) >= intval($value[1])) {
			return $this->addError('contract_range_to', 'Contract Range To must be greater than Contract Range From.');
		}
	}
	public function checkRange($rangefr, $value) {
		if (!array_key_exists('contract_range_fr', $this->errors)) {
			// Get variable
			$rangeFr	= intval($value[0]);
			$rangeTo	= intval($value[1]);
			$id			= intval($value[2]);
			$cid		= intval($value[3]);

			// Check range existe
			$criteria = new CDbCriteria();
			$criteria->select 		= "contract_range";
			$criteria->condition 	= "((SUBSTRING_INDEX(t.contract_range, ' - ', 1) >= :rangefr1 AND SUBSTRING_INDEX(t.contract_range, ' - ', 1) <= :rangeto1 )
					OR (SUBSTRING_INDEX(t.contract_range, ' - ', -1) >= :rangefr2 AND SUBSTRING_INDEX(t.contract_range, ' - ', -1) <= :rangeto2))
					AND contract_id != :id AND cus_id = :cid";
			$criteria->params = array(
				':rangefr1'	=> $rangeFr,
				':rangefr2' => $rangeFr,
				':rangeto1' => $rangeTo,
				':rangeto2'	=> $rangeTo,
				':id' 		=> $id,
				':cid' 		=> $cid
			);
			$aRange = $this->findAll($criteria);

			if (count($aRange) > 0) {
				$strRange = "";
				foreach ($aRange as $range) {
					$strRange .= $range->contract_range . ",";
				}
				$strRange = mb_substr($strRange, 0, -1);
				return $this->addError('contract_range', 'Contract Range already exists : ' . $strRange);
			}
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contract_id' => 'Contract',
			'cus_id' => 'Cus',
			'price' => 'Contract Price',
			'create_time' => 'Create Time',
			'contract_flag' => 'Contract Flag',
			'note' => 'Note',
			'contract_range' => 'Contract Range',
			'contract_range_fr' => 'Contract Range From',
			'contract_range_to' => 'Contract Range To',
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

		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('cus_id',$this->cus_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('contract_flag',$this->contract_flag);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('contract_range',$this->contract_range,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}