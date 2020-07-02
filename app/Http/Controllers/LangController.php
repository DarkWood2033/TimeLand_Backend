<?php

namespace App\Http\Controllers;

use App\Services\Localization\LangService;

class LangController extends Controller
{
    public function load(LangService $langService)
    {
        $data = $langService->load();

        return response('window.i18n='.json_encode($data).';')
            ->header('Content-Type', 'text/javascript');
    }
}
