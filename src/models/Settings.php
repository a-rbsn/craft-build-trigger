<?php

namespace arbsn\craftbuildtrigger\models;

use craft\base\Model;
use craft\helpers\App;
use craft\models\Site;

/**
 * Build Trigger settings.
 */
class Settings extends Model
{
    /** @var array<string, string> Build hook URLs, keyed by site UID. */
    public array $buildHookUrls = [];

    public function getHookUrl(Site $site): string
    {
        return $this->buildHookUrls[$site->uid] ?? '';
    }

    public function getParsedHookUrl(Site $site): string
    {
        return App::parseEnv($this->getHookUrl($site)) ?: '';
    }
}
