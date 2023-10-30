<?php

namespace App\Console\Commands\RabbitMQ\Publish;

use App\Http\Resources\Book\BookWithoutAuthorsResource;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\Iterators\BookWithoutAuthorsIterator;
use Bschmitt\Amqp\Facades\Amqp;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class GetDataFromOldBooksTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rmq:get-old-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private const BOOK_REMOVE_KEY = 'book-remove';
    private const LIMIT = 100;

    public const QUEUE_NAME = 'book-remove';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(BookRepository $repository)
    {
        if (Redis::exists(self::BOOK_REMOVE_KEY) === 0) {
            Redis::set(self::BOOK_REMOVE_KEY, 0);
        }

        $lastId = (int)Redis::get(self::BOOK_REMOVE_KEY);
        $data = $repository->getData($lastId, self::LIMIT);
        $books = BookWithoutAuthorsResource::collection($data->getIterator()->getArrayCopy());

        /** @var BookWithoutAuthorsIterator $book */
        foreach ($books as $book) {
            Amqp::publish(self::QUEUE_NAME, json_encode($book), [
                'queue' => self::QUEUE_NAME
            ]);
            $checkingBookId = $book->getId();
            Redis::set(self::BOOK_REMOVE_KEY, $checkingBookId);
        }
    }
}
