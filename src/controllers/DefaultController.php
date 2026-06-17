<?php

namespace arbsn\craftbuildtrigger\controllers;

use arbsn\craftbuildtrigger\Plugin;
use Craft;
use craft\web\Controller;
use GuzzleHttp\Exception\GuzzleException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    protected array|int|bool $allowAnonymous = [];

    public function actionTriggerBuild(): Response
    {
        $this->requireCpRequest();
        $this->requireLogin();
        $this->requirePostRequest();

        $site = Craft::$app->sites->getSiteById((int)$this->request->getRequiredBodyParam('siteId'))
            ?? throw new BadRequestHttpException('Invalid site.');

        $session = Craft::$app->session;
        $hookUrl = Plugin::getInstance()->getSettings()->getParsedHookUrl($site);

        if (!$hookUrl) {
            $session->setError(Craft::t('build-trigger', 'No build hook URL is set for {site}.', ['site' => $site->name]));
            return $this->redirectToPostedUrl();
        }

        if (!preg_match('#^https?://#i', $hookUrl)) {
            $session->setError(Craft::t('build-trigger', 'The build hook URL for {site} must be an absolute http or https URL.', ['site' => $site->name]));
            return $this->redirectToPostedUrl();
        }

        try {
            $status = Craft::createGuzzleClient()->post($hookUrl, ['http_errors' => false])->getStatusCode();

            if ($status >= 200 && $status < 300) {
                $session->setNotice(Craft::t('build-trigger', 'Build triggered for {site}.', ['site' => $site->name]));
            } else {
                $session->setError(Craft::t('build-trigger', 'Build hook for {site} returned HTTP {status}.', ['site' => $site->name, 'status' => $status]));
            }
        } catch (GuzzleException $e) {
            Craft::error($e->getMessage(), __METHOD__);
            $session->setError(Craft::t('build-trigger', 'Could not reach the build hook for {site}.', ['site' => $site->name]));
        }

        return $this->redirectToPostedUrl();
    }
}
