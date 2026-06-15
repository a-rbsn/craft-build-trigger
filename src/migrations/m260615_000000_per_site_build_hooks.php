<?php

namespace arbsn\craftbuildtrigger\migrations;

use Craft;
use craft\db\Migration;

/**
 * Migrates the single `buildHookUrl` setting to the per-site `buildHookUrls`
 * map, assigning the existing URL to the primary site so no configuration
 * is lost on upgrade.
 */
class m260615_000000_per_site_build_hooks extends Migration
{
    public function safeUp(): bool
    {
        $projectConfig = Craft::$app->projectConfig;
        $key = 'plugins.build-trigger.settings';
        $settings = $projectConfig->get($key) ?? [];

        $oldUrl = $settings['buildHookUrl'] ?? null;

        if (!empty($oldUrl) && empty($settings['buildHookUrls'])) {
            $primarySite = Craft::$app->sites->getPrimarySite();
            $settings['buildHookUrls'] = [$primarySite->uid => $oldUrl];
        }

        unset($settings['buildHookUrl']);
        $projectConfig->set($key, $settings);

        return true;
    }

    public function safeDown(): bool
    {
        echo "m260615_000000_per_site_build_hooks cannot be reverted.\n";

        return false;
    }
}
