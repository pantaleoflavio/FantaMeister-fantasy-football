<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

final class CompetitionConfigTest extends TestCase
{
    public function test_supported_league_modes_are_defined(): void
    {
        $config = require __DIR__ . '/../../config/competition.php';

        $this->assertSame(
            ['classic', 'formula_one', 'head_to_head'],
            $config['league_modes']
        );
    }
}