<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use DataTables;

class SettingController extends Controller
{
    public function index(Request $request) {
        $setting = Setting::where('id', 1)->first();
        $model_ai = array("gpt-32k-0613", "gpt-4-32k", "gpt-4-0613", "gpt-4", "gpt-3.5-turbo", "gpt-3.5-turbo-16k", "gpt-3.5-turbo-0613", "gpt-3.5-turbo-16k-0613", "text-davinci-003", "text-davinci-002", "code-davinci-002", "text-curie-001", "text-babbage-001", "text-ada-001", "davinci", "curie", "babbage", "ada");

        return view('setting.setting', ['setting' => $setting, 'model_ai' => $model_ai]);
    }

    public function storeSetting(Request $request) {
        $validator = $this->validate(
            $request,
            [
                'temperature' => 'required',
                'max_token' => 'required',
                'system_context' => 'required',
            ]
        );

        $setting = Setting::updateOrCreate(
            ['id' => 1],
            [
                'ai_model' => $request->ai_model,
                'temperature' => $request->temperature,
                'max_token' => $request->max_token,
                'system_context' => $request->system_context
            ]
        );

        return response()->json(['response' => $setting]);
    }
}
