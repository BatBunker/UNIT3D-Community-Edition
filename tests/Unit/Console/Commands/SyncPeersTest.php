<?php

namespace Tests\Unit\Console\Commands;

use Tests\TestCase;

/**
 * @see \src\Commands\SyncPeers
 */
class SyncPeersTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_successfully(): void
    {
        $this->artisan('auto:sync_peers')
            ->expectsOutput('Torrent Peer Syncing Command Complete')
            ->assertExitCode(0)
            ->run();
    }
}
