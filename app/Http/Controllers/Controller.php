<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if (\Auth::check() && \Auth::user()->status == 0) {
            \Auth::logout();
        }
    }

    public function stripHtmlTags(Request $request, array $notStripTags = [])
    {
        $requestParams = $request->all();

        foreach ($requestParams as $key=>$value) {
            if (!in_array($key, $notStripTags)) {
                $requestParams[$key]=strip_tags($value);
            }
        }
        $request->replace($requestParams);

        return $request;
    }
}


