<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 21.09.2015
 */
namespace skeeks\cms\usersubscribe;
use skeeks\cms\filters\CmsAccessControl;
use skeeks\cms\helpers\RequestResponse;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Class SubscribeController
 * @package skeeks\cms\usersubscribe
 */
class SubscribeController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'access' => [

                'class'         => CmsAccessControl::className(),
                'only'          => ['create', 'delete'],
                'rules' =>
                [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create'  => ['post'],
                    'delete'    => ['post'],
                ],
            ],
        ]);
    }

    public function actionCreate()
    {
        $rr = new RequestResponse();

        $cms_user_subscribe_id = \Yii::$app->request->post('userId');
        if (!$cms_user_subscribe_id)
        {
            $rr->success = false;
            $rr->message = 'error';
            return $rr;
        }

        if (
                CmsUserSubscribe::find()->where([
                    'cms_user_id' => \Yii::$app->user->id
                ])->andWhere([
                    'cms_user_subscribe_id' => $cms_user_subscribe_id
                ])->one()
        )
        {
            $rr->success = true;
            $rr->message = 'success';
            return $rr;
        }

        $model = new CmsUserSubscribe();

        $model->cms_user_id             = \Yii::$app->user->id;
        $model->cms_user_subscribe_id   = $cms_user_subscribe_id;

        if ($model->save())
        {
            $rr->success = true;
            $rr->message = 'success';
        } else
        {
            $rr->success = true;
            $rr->message = 'error';
        }

        return $rr;
    }

    public function actionDelete()
    {

    }
}

