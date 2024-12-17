<?php

namespace arbsn\craftbuildtrigger\models;

use Craft;
use craft\base\Model;

/**
 * Build Trigger settings
 */
class Settings extends Model
{
    public string $buildHookUrl = '';

    public function defineRules(): array
    {
        return [
            [['buildHookUrl'], 'required'],
        ];
    }
}