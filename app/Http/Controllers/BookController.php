<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $books = Book::with(['category', 'authors'])
        ->where('stock', '>', 0)

        // search by title
        ->when($request->title, function ($q) use ($request) {
            $q->where('title', 'like', "%{$request->title}%");
        })

        // search by category
        ->when($request->category_id, function ($q) use ($request) {
            $q->where('category_id', $request->category_id);
        })

        // search by author name
        ->when($request->author, function ($q) use ($request) {
            $q->whereHas('authors', function ($q2) use ($request) {
                $q2->where('name', 'like', "%{$request->author}%");
            });
        })

        ->get();

    return apiSuccess("Books fetched successfully", $books);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        //    return $request->all()ook;
        $data = $request->validated();
        if ($request->hasFile('cover')) {
            $filename = "$request->ISBN." .  $request->file('cover')->extension();
            $request->file('cover')->storeAs('book-images', $filename);
            $data['cover'] = $filename;
        }

        $book = Book::create(
            $data
        );

        if ($request->has('authors')) {
            $book->authors()->attach($request->authors);
        }
        return apiSuccess(data: $book, code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book = $book->load('category', 'authors');
        $book = new BookResource($book);
        return apiSuccess(data: $book);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validated();
        if ($request->hasfile('cover')) {
            if ($book->cover)
                Storage::delete("book-images/$book->cover");
            $filename = "$request->ISBN." .  $request->file('cover')->extension();
            $request->file('cover')->storeAs('book-images', $filename);
            $data['cover'] = $filename;
        }
        $book->update($data);
        if ($request->has('authors')){
            // $book->authors()->detach($book->authors);
            // $book->authors()->attach($request->authors);
            $book->authors()->sync($request->authors);
        }
        return apiSuccess('book updated sucessfully' , $book->load('authors'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
       if ($book->cover) {
        Storage::delete("book-images/{$book->cover}");
    }

    $book->authors()->detach();

    $book->delete();

    return apiSuccess("Book deleted successfully");  
    }
}
