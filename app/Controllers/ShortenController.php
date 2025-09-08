<?php

namespace App\Controllers;

use App\Models\URL;
use App\Controllers\BaseController;

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
        if (empty($params['url'])) {
            $this->json([
                'error' => 'URL is required',
            ], self::CODE_BAD_REQUEST);
            exit;
        }

        $originalUrl = htmlspecialchars($params['url']);
        $url = new URL();
        $code = $url->shorten($originalUrl);
        $this->json([
            'url' => $originalUrl,
            'code' => $code,
        ]);
    }
}
