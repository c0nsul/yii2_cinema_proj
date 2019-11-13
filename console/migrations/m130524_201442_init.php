<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%user}}', [
			'id' => $this->primaryKey(),
			'username' => $this->string()->notNull()->unique(),
			'auth_key' => $this->string(32)->notNull(),
			'password_hash' => $this->string()->notNull(),
			'password_reset_token' => $this->string()->unique(),
			'email' => $this->string()->notNull()->unique(),
			'status' => $this->smallInteger()->notNull()->defaultValue(10),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
		], $tableOptions);

		//movies
		$this->createTable('{{%movie}}', [
			'id' => $this->primaryKey(),
			'moviename' => $this->string()->notNull()->unique(),
			'desc' => $this->text()->notNull(),
			'age' => $this->string()->notNull(),
			'playtime' => $this->string()->notNull(),
			'photo' => $this->string(),
		], $tableOptions);

		//showtime
		$this->createTable('{{%showtime}}', [
			'id' => $this->primaryKey(),
			'movie_id' => $this->Integer()->notNull(),
			'date' => $this->Integer()->notNull(),
			'time' => $this->Integer()->notNull(),
			'price' => $this->Integer()->notNull(),
		], $tableOptions);

		//login: admin
		//password: password_0
		$this->insert('user', [
			'username' => 'admin',
			'auth_key' => 'HP187Mvq7Mmm3CTU80dLkGmni_FUH_lR',
			'password_hash' => '$2y$13$EjaPFBnZOQsHdGuHI.xvhuDp1fHpo8hKRSk6yshqa9c5EG8s3C3lO',
			'password_reset_token' => 'ExzkCOaYc1L8IOBs4wdTGGbgNiG3Wz1I_1402312317',
			'created_at' => '1402312317',
			'updated_at' => '1402312317',
			'email' => 'admin@server.local'
		]);
	}

	public function down()
	{
		$this->dropTable('{{%user}}');
		$this->dropTable('{{%movie}}');
		$this->dropTable('{{%showtime}}');
	}
}
