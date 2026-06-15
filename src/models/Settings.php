<?php

namespace arbsn\craftbuildtrigger\models;

use craft\base\Model;
use craft\helpers\App;
use craft\models\Site;

/**
 * Build Trigger settings
 *
 * Build hook URLs are stored per site, keyed by the site's UID so the
 * mapping stays stable when site handles change.
 */
class Settings extends Model
{
    /**
     * @var array<string, string> Build hook URLs keyed by site UID.
     */
    public array $buildHookUrls = [];

    /**
     * Returns the raw (unparsed) build hook URL configured for the given site UID.
     */
    public function getBuildHookUrl(string $siteUid): string
    {
        return $this->buildHookUrls[$siteUid] ?? '';
    }

    /**
     * Returns the parsed build hook URL for a site, resolving any environment
     * variables or aliases (e.g. `$NETLIFY_BUILD_HOOK`).
     */
    public function getParsedBuildHookUrl(Site $site): string
    {
        return App::parseEnv($this->getBuildHookUrl($site->uid)) ?: '';
    }
}
