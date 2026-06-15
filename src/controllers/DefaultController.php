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
    protected array|int|bool $allowAnonymous = false;

    /**
     * Triggers the build hook configured for the requested site.
     */
    public function actionTriggerBuild(): Response
    {
        $this->requirePostRequest();

        $siteId = $this->request->getRequiredBodyParam('siteId');
        $site = Craft::$app->sites->getSiteById((int)$siteId);

        if (!$site) {
            throw new BadRequestHttpException('Invalid site.');
        }

        $settings = Plugin::getInstance()->getSettings();
        $buildHookUrl = $settings->getParsedBuildHookUrl($site);

        if (empty($buildHookUrl)) {
            Craft::$app->session->setError(Craft::t('build-trigger', 'No build hook URL is set for {site}.', [
                'site' => $site->name,
            ]));

            return $this->redirectToPostedUrl();
        }

        try {
            $response = Craft::createGuzzleClient()->post($buildHookUrl);
            $statusCode = $response->getStatusCode();

            if ($statusCode >= 200 && $statusCode < 300) {
                Craft::$app->session->setNotice(Craft::t('build-trigger', 'Build triggered for {site}.', [
                    'site' => $site->name,
                ]));
            } else {
                Craft::$app->session->setError(Craft::t('build-trigger', 'Failed to trigger build for {site} (HTTP {code}).', [
                    'site' => $site->name,
                    'code' => $statusCode,
                ]));
            }
        } catch (GuzzleException $e) {
            Craft::error($e->getMessage(), __METHOD__);
            Craft::$app->session->setError(Craft::t('build-trigger', 'Failed to trigger build for {site}: {error}', [
                'site' => $site->name,
                'error' => $e->getMessage(),
            ]));
        }

        return $this->redirectToPostedUrl();
    }
}
