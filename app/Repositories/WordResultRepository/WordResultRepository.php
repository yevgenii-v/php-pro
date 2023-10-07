<?php

namespace App\Repositories\WordResultRepository;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class WordResultRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('word_result');
    }

    /**
     * @param WordResultStoreDTO $DTO
     * @return bool
     */
    public function insert(WordResultStoreDTO $DTO): bool
    {
        return $this->query->insert([
            'word' => $DTO->getWord(),
            'result' => $DTO->getResult(),
        ]);
    }
}
