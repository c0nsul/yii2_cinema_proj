<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


class Movie extends ActiveRecord
{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%movie}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id]);
	}

	/**
	 * Finds movie by name
	 *
	 * @param string $movieName
	 * @return static|null
	 */
	public static function findByMovieName($movieName)
	{
		return static::findOne(['moviename' => $movieName]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return array(
			['moviename', 'required'],
			['desc', 'required'],
			['age', 'required'],
			['age', 'integer'],
			['playtime', 'required'],
			['playtime', 'integer'],
			[
				['photo'],
				'file',
				'extensions' => 'jpg, png',
				'skipOnEmpty' => false,
				'maxSize' => 2000000,
				'minSize' => 5000,
				'on' => 'upload',
				'mimeTypes' => 'image/jpeg, image/png',
			]
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
	 * @return bool
	 */
	public function upload()
	{
		if ($this->validate()) {
			$this->photo->saveAs('uploads/' . $this->photo->baseName . '.' . $this->photo->extension);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return ActiveQuery
	 */
	public function getShows()
	{
		return $this->hasMany(Showtime::className(), ['movie_id' => 'id']);
	}


}