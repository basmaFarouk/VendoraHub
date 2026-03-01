<?php

namespace  App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService {

    function getSettings()
    {
        return Cache::rememberForever('settings', function() {
            return Setting::pluck('value', 'key')->toArray(); // output ['key' => 'value'] //pluck means get only these two columns from the database and return them as an array
        });
    }

    function setSettings()
    {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    function clearCashedSettings()
    {
        Cache::forget('settings');
    }
}
