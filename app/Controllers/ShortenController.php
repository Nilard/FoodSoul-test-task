<?php

namespace App\Controllers;

use App\Models\URL;

class ShortenController extends BaseController
{
    /**
     * Shorten a URL.
     *
     * @param array $params
     *   The params of the request.
     *
     * @return void
     */
    public function shorten($params)
    {
        $originalUrl = htmlspecialchars($params['url']);
        $url = new URL();
        $code = $url->shorten($originalUrl);
        $this->json([
            'url' => $originalUrl,
            'code' => $code,
        ]);
    }
}
