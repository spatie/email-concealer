<?php

namespace Spatie\EmailConcealer;

use ArrayIterator;
use IteratorAggregate;

class ConcealedEmailCollection implements IteratorAggregate
{
    /** @var string */
    private $domain;

    /** @var array */
    private $dictionary = [];

    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    public static function make(string $domain): self
    {
        return new self($domain);
    }

    public function fill(array $emails): self
    {
        foreach ($emails as $email) {
            $this->add($email);
        }

        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->dictionary);
    }

    private function add(string $email)
    {
        if (array_key_exists($email, $this->dictionary)) {
            return;
        }

        list($localPart) = explode('@', $email);

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