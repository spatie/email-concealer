<?php

namespace Spatie\ObfuscateEmails\Test;

use PHPUnit\Framework\TestCase;
use Spatie\ObfuscateEmails\Obfuscator;

class ObfuscatorTest extends TestCase
{
    /** @test */
    public function it_returns_the_same_string_if_nothing_needs_to_be_obfuscated()
    {
        $this->assertObfuscatesTo('Hello', 'Hello');
    }

    /** @test */
    public function it_can_replace_an_email_address_domain_with_example_dot_com()
    {
        $this->assertObfuscatesTo('hello@example.com', 'hello@spatie.be');
    }

    /** @test */
    public function it_can_replace_multiple_email_address_domain_with_example_dot_com()
    {
        $this->assertObfuscatesTo(
            'foo@example.com bar@example.com',
            'foo@spatie.be bar@spatie.be'
        );

        $this->assertObfuscatesTo(
            "'foo@example.com','bar@example.com'",
            "'foo@spatie.be','bar@spatie.be'"
        );
    }

    /** @test */
    public function it_makes_emails_with_the_same_local_part_and_a_different_domain_unique()
    {
        $this->assertObfuscatesTo(
            'foo@example.com foo-1@example.com',
            'foo@spatie.be foo@github.com'
        );

        $this->assertObfuscatesTo(
            'foo@example.com foo-1@example.com foo-2@example.com foo@example.com',
            'foo@spatie.be foo@github.com foo@google.com foo@spatie.be'
        );
    }

    /** @test */
    public function it_doesnt_make_emails_with_the_same_local_part_and_the_same_domain_unique()
    {
        $this->assertObfuscatesTo(
            'foo@example.com foo@example.com',
            'foo@spatie.be foo@spatie.be'
        );
    }

    /** @test */
    public function it_can_obfusticate_emails_in_a_complex_file()
    {
        $this->assertObfuscatesTo(
            file_get_contents(__DIR__.'/fixtures/obfuscated.sql'),
            file_get_contents(__DIR__.'/fixtures/original.sql')
        );
    }

    private function assertObfuscatesTo(string $expected, string $input)
    {
        $obfuscator = new Obfuscator();

        $this->assertEquals($expected, $obfuscator->obfuscate($input));
    }
}
