<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Movie;
use common\models\Showtime;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;


class SiteController extends Controller
{

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['login'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => [],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays admin homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		//movies counter
		$movieCounter = Movie::find()->count();

		//showtime listing
		$model = new Showtime();
		$shows = $model->find()
			->orderBy(['date' => SORT_ASC, 'time' => SORT_ASC])
			->joinWith('movie')
			->all();

		return $this->render('index', ['shows' => $shows, 'movieCounter' => $movieCounter]);
	}

	/**
	 * display movies list
	 *
	 * @return string
	 */
	public function actionMovielist()
	{

		$model = new Movie();
		$movies = $model->find()->all();

		return $this->render('movielist', ['movies' => $movies]);
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();

		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}

		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return Yii::$app->getResponse()->redirect('/admin/site/login');
	}

	/**
	 * FAT movie action
	 *
	 * @return string|\yii\console\Response|Response
	 */
	public function actionMovie($id = null)
	{
		if (!empty($id)) {
			$model = Movie::findOne($id);
			if ($model->photo) {
				$oldPhoto = $model->photo;
			}
		} else {
			$model = new Movie();
		}

		//post
		if ($model->load(Yii::$app->request->post())) {
			//upload?
			$model->photo = UploadedFile::getInstance($model, 'photo');
			//new
			if (($model->photo) && $model->upload()) {
				//YES
				// file is uploaded successfully
				if ($model->save(true)) {
					//del old img
					if ($oldPhoto && $oldPhoto != Movie::EMPTYIMG) {
						unlink('uploads/' . $oldPhoto);
					}
					return Yii::$app->getResponse()->redirect('/admin');
				} else {
					return $this->render('movie', ['model' => $model]);
				}
			} else {
				//no upload
				//update ?
				if ($model->id) {
					//YES
					if ($oldPhoto) {
						$model->photo = $oldPhoto;
					}
					$model->update();
					return Yii::$app->getResponse()->redirect('/admin');
				} else {
					//no
					//creation with empty img
					$model->photo = Movie::EMPTYIMG;
					if ($model->save(true)) {
						return Yii::$app->getResponse()->redirect('/admin');
					} else {
						return $this->render('movie', ['model' => $model]);
					}
				}
			}
		}

		if ($model->hasErrors()) {
			var_dump($model->hasErrors());
		}

		return $this->render('movie', ['model' => $model]);
	}

	/**
	 * @return string|\yii\console\Response|Response
	 */
	public function actionShowtime($id = null)
	{
		if (!empty($id)) {
			$model = Showtime::findOne($id);
		} else {
			$model = new Showtime();
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			//change format
			if ($model->date) {
				$model->date = strtotime($model->date);
			}

			if ($model->save(true)) {
				return Yii::$app->getResponse()->redirect('/admin');
			} else {
				return $this->render('showtime', ['model' => $model]);
			}
		} else {
			return $this->render('showtime', ['model' => $model]);
		}
	}

	/**
	 * @param $id
	 * @return string|\yii\console\Response|Response
	 */
	public function actionViewmovie($id)
	{
		if (!empty($id)) {
			$model = Movie::findOne($id);
			return $this->render('viewmovie', ['model' => $model]);
		} else {
			return Yii::$app->getResponse()->redirect('/admin');
		}
	}

	/**
	 * @param $id
	 * @return \yii\console\Response|Response
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionDelshow($id)
	{
		if (!empty($id)) {
			$model = Showtime::findOne($id);
			$model->delete();
		}
		return Yii::$app->getResponse()->redirect('/admin');
	}

	/**
	 * Deleting movie
	 *
	 * @param $id
	 * @return \yii\console\Response|Response
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionDelmovie($id)
	{
		if (!empty($id)) {
			//delete movie
			$model = Movie::findOne($id);
			$nameImg = $model->photo;
			$model->delete();

			//delete related Shows
			Showtime::deleteAll(['movie_id' => $id]);

			//delete images
			if ($nameImg && ($nameImg != Movie::EMPTYIMG)) {
				unlink('uploads/' . $nameImg);
			}
		}
		return Yii::$app->getResponse()->redirect('/admin');
	}
}
