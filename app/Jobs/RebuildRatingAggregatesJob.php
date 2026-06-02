<?php

namespace App\Jobs;

use App\Service\AuthorStatsService;
use App\Service\RatingSummaryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RebuildRatingAggregatesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        public int $bookId,
        public int $authorId
    ) {}

    public function handle(
        RatingSummaryService $ratingSummaryService,
        AuthorStatsService $authorStatsService
    ): void {
        $ratingSummaryService->rebuildForBook($this->bookId);
        $authorStatsService->rebuildForAuthor($this->authorId);
    }
}
