<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return $settings;
    }

    public function update(Request $request)
    {
        $request->validate(
            ['value' => 'nullable|url:http,https']
        );
        $setting = Setting::where('key', $request->key);
        $setting->update(['value' => $request->value]);
        
        return response()->json(['success' => true], 200);
    }
}
