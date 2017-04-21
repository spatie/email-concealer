<?php

namespace Spatie\EmailConcealer\Test;

use PHPUnit\Framework\TestCase;
use Spatie\EmailConcealer\Concealer;
use Spatie\Snapshots\MatchesSnapshots;

class ObfuscatorTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_returns_the_same_string_if_nothing_needs_to_be_concealed()
    {
        $this->assertConcealsTo('Hello', 'Hello');
    }

    /** @test */
    public function it_can_replace_an_email_address_domain_with_example_dot_com()
    {
        $this->assertConcealsTo('hello@example.com', 'hello@spatie.be');
    }

    /** @test */
    public function it_can_replace_multiple_email_address_domain_with_example_dot_com()
    {
        $this->assertConcealsTo(
            'foo@example.com bar@example.com',
            'foo@spatie.be bar@spatie.be'
        );

        $this->assertConcealsTo(
            "'foo@example.com','bar@example.com'",
            "'foo@spatie.be','bar@spatie.be'"
        );
    }

    /** @test */
    public function it_makes_emails_with_the_same_local_part_and_a_different_domain_unique()
    {
        $this->assertConcealsTo(
            'foo@example.com foo-1@example.com',
            'foo@spatie.be foo@github.com'
        );

        $this->assertConcealsTo(
            'foo@example.com foo-1@example.com foo-2@example.com foo@example.com',
            'foo@spatie.be foo@github.com foo@google.com foo@spatie.be'
        );
    }

    /** @test */
    public function it_doesnt_make_emails_with_the_same_local_part_and_the_same_domain_unique()
    {
        $this->assertConcealsTo(
            'foo@example.com foo@example.com',
            'foo@spatie.be foo@spatie.be'
        );
    }

    /** @test */
    public function it_can_conceal_emails_in_a_complex_file()
    {
        $concealer = new Concealer();

        $this->assertMatchesSnapshot(
            $concealer->conceal(file_get_contents(__DIR__.'/fixtures/mysqldump.sql'))
        );
    }

    private function assertConcealsTo(string $expected, string $input)
    {
        $concealer = new Concealer();

        $this->assertEquals($expected, $concealer->conceal($input));
    }
}
