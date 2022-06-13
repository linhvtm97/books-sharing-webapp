<?php

namespace App\Repositories;

use App\Models\Book;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class BookRepository.
 *
 * @package namespace App\Repositories;
 */
class BookRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @return array
     */
    public function boot()
    {
        //
    }
}
