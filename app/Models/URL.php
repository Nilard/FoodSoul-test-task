<?php

namespace App\Models;

use App\Models\Entity;

class URL extends Entity
{
    /**
     * The length of the code.
     */
    const CODE_LENGTH = 6;

    /**
     * The characters of the code.
     */
    const CODE_CHARS = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';

    /**
     * The URL to shorten.
     *
     * @var string
     */
    public string $url;

    /**
     * The name of the entity.
     *
     * @var string
     */
    protected string $entityName = 'url';

    /**
     * The fields of the entity.
     *
     * @var array
     */
    protected array $fields = [
        'url' => 'VARCHAR(2000)',
        'code' => 'VARCHAR(10)',
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $entityName = '', array $fields = [])
    {
        parent::__construct($this->entityName, $this->fields);
    }

    /**
     * Shorten the URL.
     *
     * @param string $url
     *   The URL to shorten.
     *
     * @return string
     *   The shortened code.
     *
     * @throws \Exception
     *   If the code is not generated after some attempts.
     */
    public function shorten(string $url): string
    {
        $exists = $this->getBy(['url' => $url]);
        if (!empty($exists)) {
            return $exists[0]['code'];
        }

        $attempts = 0;
        $maxAttempts = 1000;

        do {
            $code = $this->generateCode();
            $codeExists = $this->getBy(['code' => $code]);
            $attempts++;
        } while (!empty($codeExists) && $attempts < $maxAttempts);

        if ($attempts >= $maxAttempts) {
            throw new \Exception("Unable to generate unique code after {$maxAttempts} attempts");
        }

        $this->create([
            'url' => $url,
            'code' => $code,
        ]);
        return $code;
    }

    /**
     * Generate the code.
     *
     * @return string
     *   The generated code.
     */
    public function generateCode(): string
    {
        $chars = self::CODE_CHARS;
        $code = '';

        for ($i = 0; $i < self::CODE_LENGTH; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $code;
    }
}
