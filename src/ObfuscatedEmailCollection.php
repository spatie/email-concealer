<?php

namespace Spatie\EmailObfuscator;

class ObfuscatedEmailCollection
{
    /** @var string */
    private $domain;

    /** @var array */
    private $dictionary = [];

    public function __construct(string $domain, array $emails)
    {
        $this->domain = $domain;

        $this->fill($emails);
    }

    public static function make(string $domain, array $emails): self
    {
        return new self($domain, $emails);
    }

    public function reduce(callable $callback, $initial)
    {
        $emails = array_map(function ($obfuscated, $original) {
            return compact('obfuscated', 'original');
        }, $this->dictionary, array_keys($this->dictionary));

        return array_reduce($emails, function ($accumulator, $email) use ($callback) {
            return $callback($accumulator, $email['obfuscated'], $email['original']);
        }, $initial);
    }

    private function fill(array $emails): self
    {
        foreach ($emails as $email) {
            $this->push($email);
        }

        return $this;
    }

    private function push(string $email)
    {
        if (array_key_exists($email, $this->dictionary)) {
            return;
        }

        [$localPart] = explode('@', $email);

        while (in_array($localPart.'@'.$this->domain, $this->dictionary)) {
            $localPart = $this->increment($localPart);
        }

        $this->dictionary[$email] = $localPart.'@'.$this->domain;
    }

    private function increment(string $string): string
    {
        $pattern = '/-(\d+$)/';
        $matches = [];

        if (! preg_match($pattern, $string, $matches)) {
            return $string.'-1';
        }

        return preg_replace($pattern, '-'.($matches[1] + 1), $string);
    }
}
