<?php

namespace arbsn\craftbuildtrigger;

use Craft;
use arbsn\craftbuildtrigger\models\Settings;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;

/**
 * Build Trigger plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author Andrew Robinson <hello@andrew.rip>
 * @copyright Andrew Robinson
 * @license https://craftcms.github.io/license/ Craft License
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSection = true;
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public function init(): void
    {
        $this->controllerNamespace = 'arbsn\craftbuildtrigger\controllers';
        parent::init();
        $this->attachEventHandlers();

        Craft::$app->onInit(function() {
            
        });

        
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('build-trigger/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
    }
}
