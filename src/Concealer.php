<?php

namespace Spatie\EmailConcealer;

class Concealer
{
    const REGEX = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})/i';

    /** @var string */
    protected $domain = 'example.com';

    public static function create()
    {
        return new static();
    }

    /**
     * @param string $domain
     *
     * @return $this
     */
    public function domain(string $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function conceal(string $string): string
    {
        $concealedEmails = ConcealedEmailCollection::make($this->domain)->fill(
            $this->extractEmails($string)
        );

        foreach ($concealedEmails as $original => $concealed) {
            $string = str_replace($original, $concealed, $string);
        }

        return $string;
    }

    protected function extractEmails(string $string): array
    {
        $matches = [];
        preg_match_all(static::REGEX, $string, $matches);

        if (!$matches) {
            return [];
        }

        return $matches[0] ?? [];
    }
}
