<?php

namespace arbsn\craftbuildtrigger\migrations;

use Craft;
use craft\db\Migration;

/**
 * Moves the single `buildHookUrl` setting onto the primary site in the new
 * per-site `buildHookUrls` map, so no configuration is lost on upgrade.
 */
class m260615_000000_per_site_build_hooks extends Migration
{
    public function safeUp(): bool
    {
        $key = 'plugins.build-trigger.settings';
        $projectConfig = Craft::$app->projectConfig;
        $settings = $projectConfig->get($key) ?? [];

        if (!empty($settings['buildHookUrl']) && empty($settings['buildHookUrls'])) {
            $uid = Craft::$app->sites->getPrimarySite()->uid;
            $settings['buildHookUrls'] = [$uid => $settings['buildHookUrl']];
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
