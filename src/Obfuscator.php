<?php

namespace Spatie\ObfuscateEmails;

use Exception;

class Obfuscator
{
    const REGEX = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i';

    /** @var string */
    protected $domain;

    public function __construct(string $domain = 'example.com')
    {
        $this->domain = $domain;
    }

    public function obfuscate(string $string): string
    {
        $emails = $this->extractEmails($string);

        return ObfuscatedEmailCollection::make($this->domain, $emails)
            ->reduce(function (string $string, string $obfuscatedEmail, string $originalEmail) {
                return str_replace($originalEmail, $obfuscatedEmail, $string);
            }, $string);
    }

    protected function extractEmails(string $string): array
    {
        $matches = [];
        preg_match_all(static::REGEX, $string, $matches);

        if (! $matches) {
            return [];
        }

        return $matches[0] ?? [];
    }
}
