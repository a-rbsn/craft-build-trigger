<?php

namespace arbsn\craftbuildtrigger\controllers;

use Craft;
use craft\web\Controller;
use yii\web\Response;
use GuzzleHttp\Client;
use arbsn\craftbuildtrigger\Plugin;

class DefaultController extends Controller
{
    protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_LIVE;

    public function actionTriggerBuild(): Response
    {
        $plugin = Plugin::getInstance();
        $settings = $plugin->getSettings();
        $buildHookUrl = $settings->buildHookUrl;

        if (!empty($buildHookUrl)) {
            $client = new Client();
            $response = $client->post($buildHookUrl);

            if ($response->getStatusCode() == 200) {
                Craft::$app->session->setNotice(Craft::t('app', 'Build triggered successfully.'));
            } else {
                Craft::$app->session->setError(Craft::t('app', 'Failed to trigger build.'));
            }
        } else {
            Craft::$app->session->setError(Craft::t('app', 'Build Hook URL is not set.'));
        }

        return $this->redirectToPostedUrl();
    }
}