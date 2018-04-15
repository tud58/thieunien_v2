<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Profile;
use app\modules\user\models\UserToken;
use app\modules\user\models\UserAuth;
use app\modules\user\models\search\UserSearch;
use app\models\Log;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\helper\Functions;

/**
 * AdminController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    /**
     * @var \app\modules\user\Module
     * @inheritdoc
     */
    public $module;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
            throw new \yii\web\HttpException(403, 'You are not allowed to perform this action.');
        }  
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * List all User models
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->title = "Quản lý người dùng";

        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if($page <= 0){
            $page = 1;
        }
        $searchData = [];
        $searchData['id'] = $request->get('id', '');
        $searchData['username'] = $request->get('username', '');
        $searchData['status'] = $request->get('status', '');
        $searchData['email'] = $request->get('email', '');
        $searchData['role_id'] = $request->get('role_id', '');

        $where = [];
        $andWhere = [];
        $params = [];

        if($searchData['status'] != ''){
            $where['status'] = $searchData['status'];
        }
        if($searchData['username'] != ''){
            $andWhere = ['LIKE', 'username', $searchData['username']];
        }
        if($searchData['email'] != ''){
            $where['email'] = $searchData['email'];
        }

        if($searchData['id'] > 0){
            $where['id'] = $searchData['id'];
        }
        if($searchData['role_id'] > 0){
            $where['role_id'] = $searchData['role_id'];
        }



        $userList 		= User::find()->where($where)->andWhere($andWhere)->addParams($params)->limit(ADMIN_ROW_PER_PAGE)->offset(ADMIN_ROW_PER_PAGE * ($page - 1))->orderBy(['id' => SORT_DESC])->all();
        $count_items 	= User::find()->where($where)->andWhere($andWhere)->addParams($params)->count();
		$page_count = ceil($count_items/ADMIN_ROW_PER_PAGE);

        
        $userIds = [];
        foreach($userList as $user){
            $userIds[] = $user->id;
        }
        $profileList = [];
        if(count($userIds) > 0){
            $profileData = Profile::find()->where(['user_id' => $userIds])->all();
            foreach($profileData as $p){
                $profileList[$p->user_id] = $p;
            }
        }    
        
    
        return $this->render("index", [
            'userList' => $userList,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/user?'.Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,
            'profileList' => $profileList,
        ]);
    }

    /**
     * Display a single User model
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'user' => $this->findModel($id),
        ]);
    }

    /**
     * Create a new User model. If creation is successful, the browser will
     * be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var \app\modules\user\models\User $user */
        /** @var \app\modules\user\models\Profile $profile */

        $user = \Yii::$app->getModule('user')->model("User");
        $user->setScenario("admin");
        $profile = \Yii::$app->getModule('user')->model("Profile");

        $post = Yii::$app->request->post();
        $userLoaded = $user->load($post);
        $profile->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user, $profile);
        }

        if ($userLoaded && $user->validate() && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
            
            $logData = [
                'action_id' => 401,
                'reference_id' => $user->id,
                'reference_name' => $user->username,
                'reference_type' => 'user',

            ];
            Log::saveLog($logData);        
            
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('create', compact('user', 'profile'));
    }

    /**
     * Update an existing User model. If update is successful, the browser
     * will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // set up user and profile
        $user = $this->findModel($id);
        $user->setScenario("admin");
        $profile = $user->profile;

        $post = Yii::$app->request->post();
        $userLoaded = $user->load($post);
        $profile->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user, $profile);
        }

        // load post data and validate
        if ($userLoaded && $user->validate() && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
            
            $logData = [
                'action_id' => 402,
                'reference_id' => $user->id,
                'reference_name' => $user->username,
                'reference_type' => 'user',

            ];
            Log::saveLog($logData);
             
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('update', compact('user', 'profile'));
    }

    /**
     * Delete an existing User model. If deletion is successful, the browser
     * will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        exit;
        // delete profile and userTokens first to handle foreign key constraint
        $user = $this->findModel($id);
        $profile = $user->profile;
        UserToken::deleteAll(['user_id' => $user->id]);
        UserAuth::deleteAll(['user_id' => $user->id]);
        $profile->delete();
        $user->delete();

        return $this->redirect(['index']);
    }

    /**
     * Find the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var \app\modules\user\models\User $user */
        $user = \Yii::$app->getModule('user')->model("User");
        $user = $user::findOne($id);
        if ($user) {
            return $user;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
