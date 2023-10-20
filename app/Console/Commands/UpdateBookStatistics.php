<?php

namespace App\Console\Commands;

use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStatisticsCounterDTO;
use App\Services\Books\Storages\BookCommentsCounterStorage;
use App\Services\Books\Storages\BookViewsCounterStorage;
use Illuminate\Console\Command;

class UpdateBookStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:update-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count comments & views of book(s) per hour';

    public function __construct(
        protected BookCommentsCounterStorage $commentsStorage,
        protected BookViewsCounterStorage $viewsStorage,
        protected BookRepository $bookRepository,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $views = json_decode($this->viewsStorage->get());
        $comments = json_decode($this->commentsStorage->get());


        foreach ($views as $key => $value) {
            $dto = new BookStatisticsCounterDTO(
                $key,
                $value,
            );
            $this->bookRepository->storeViewsPerHour($dto);
        }


        foreach ($comments as $key => $value) {
            $dto = new BookStatisticsCounterDTO(
                $key,
                $value,
            );
            $this->bookRepository->storeCommentsPerHour($dto);
        }
    }
}
