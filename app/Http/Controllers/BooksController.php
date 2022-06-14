<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\BookRepository;
use App\Http\Requests\BooksDetailRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Requests\BookEditRequest;
use Illuminate\Contracts\View\View;

/**
 * Class BooksController.
 *
 * @package namespace App\Http\Controllers;
 */
class BooksController extends Controller
{
    /**
     * @var BookRepository
     */
    protected $repository;

    /**
     * BooksController constructor.
     *
     * @param BookRepository $repository
     */
    public function __construct(
        BookRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $books = $this->repository->paginate();
            
            return view('books.index')->with('books', $books);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            echo $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param BooksDetailRequest $request
     *
     * @return Response
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function show(BooksDetailRequest $request)
    {
        try {
            $book = $this->repository->find($request->id);

            return view('books.detail')->with('book', $book);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $error = $e->getMessage();
            
            return view('error')->with($error);
        }
    }
    
    /**
     * Edit book
     *
     * @param BookEditRequest $request
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function edit(BookEditRequest $request)
    {
        try {
            $book = $this->repository->find($request->id);

            return view('books.edit')->with('book', $book);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $error = $e->getMessage();
            
            return view('error')->with($error);
        }
    }
    
    /**
     * Update
     *
     * @param BookUpdateRequest $request
     * @param $id
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function update(BookUpdateRequest $request, $id)
    {
        try {
            $this->repository->update($request->all(), $id);

            return redirect('/books');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            echo $e->getMessage();
        }
    }
}
