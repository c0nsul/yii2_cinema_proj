<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


class Showtime extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%showtime}}';
	}


	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return array(
			['movie_id', 'required'],
			['time', 'required'],
			['date', 'required'],
			['price', 'required'],
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @return ActiveQuery
	 */
	public function getMovie()
	{
		return $this->hasOne(Movie::className(), ['id' => 'movie_id']);
	}

}