<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 11:45
 */

namespace app\modules\admin\controllers;

use Yii;
use app\models\Config;

class ConfigController extends BaseController
{
    /**
     * 更新网站配置
     * @return false|string
     */
    public function actionSiteInfo()
    {
        $models = Config::find()
            ->where(['type_id' => 1])
            ->all();

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('Config');
            $configs = Config::find()
                ->where(['in', 'key', array_keys($data)])
                ->all();
            foreach ($configs as $config) {
                $config->value = $data[$config->key];
                if (!$config->save()) {
                    return $this->api(422, $this->getError($config));
                }
            }
            //更新配置缓存
            Yii::$app->debris->configAll(true);
            return $this->api(200, '站点设置保存成功！');
        }
        return $this->render('site-info', [
            'models' => $models
        ]);
    }

    /**
     * 更新网站轮播
     * @return false|string
     */
    public function actionBanners()
    {
        $model = Config::find()->where(['key' => 'site_banners'])->one();

        if (Yii::$app->request->isAjax){
            $bannersArray = Yii::$app->request->post('banner-value');
            $model->value = serialize($bannersArray);
            if ($model->save()){
                //更新配置缓存
                Yii::$app->debris->configAll(true);
                return $this->api(200, '轮播保存成功！');
            }
            return $this->api(422, $this->getError($model));
        }

        return $this->render('banners', [
            'model' => $model
        ]);
    }

    /**
     * 更新OSS配置
     * @return false|string
     */
    public function actionAliyunOss()
    {
        $models = Config::find()
            ->where(['type_id' => 3])
            ->all();

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('Config');
            $configs = Config::find()
                ->where(['in', 'key', array_keys($data)])
                ->all();
            foreach ($configs as $config) {
                $config->value = $data[$config->key];
                if (!$config->save()) {
                    return $this->api(422, $this->getError($config));
                }
            }
            //更新配置缓存
            Yii::$app->debris->configAll(true);
            return $this->api(200, 'OSS配置保存成功！');
        }
        return $this->render('aliyun_oss', [
            'models' => $models
        ]);
    }

    /**
     * 清理缓存
     * @return false|string
     */
    public function actionClear()
    {
        if (Yii::$app->cache->flush()){
            return $this->api(1, '服务端清理缓存成功!');
        }
        return $this->api(0, '服务端清理缓存失败!');
    }
}