<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;

class BookController extends Controller
{   /**
    * @OA\Get(
    *      path="/books",
    *      operationId="getAllBooks",
    *      tags={"Tests"},

    *      summary="Get List Of Books",
    *      description="Returns all books and associated authors and genre.",
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    * @OA\Response(
    *      response=400,
    *      description="Bad Request"
    *   ),
    * @OA\Response(
    *      response=404,
    *      description="not found"
    *   ),
    *  )
    */

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->query->get('genre');
        if ($filter) {
            $books = Book::whereHas('genres', function($i) use ($filter){
                $i->where('genres.id', '=', $filter);
            });
            return new BookCollection($books->get());
        } else {
            return new BookCollection(Book::orderBy('title')->paginate(10));
        }
    }

    /**
    * @OA\Post(
    *      path="/books",
    *      operationId="AddBook",
    *      tags={"Tests"},

    *      summary="Add a book",
    *      description="Add a book to the library",
    *      @OA\Response(
    *          response=201,
    *          description="Created",
    *          @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *      ),
    *      @OA\Parameter(
    *        name="title",
    *        in="query",
    *        description="Title",
    *        required=true
    *      ),
        *      @OA\Parameter(
    *        name="description",
    *        in="query",
    *        description="Description",
    *        required=true
    *      ),
        *      @OA\Parameter(
    *        name="author_id",
    *        in="query",
    *        description="author id",
    *        required=true
    *      ),
        *      @OA\Parameter(
    *        name="publication_year",
    *        in="query",
    *        description="publication year",
    *        required=true
    *      ),
        *      @OA\Parameter(
    *        name="pages_nb",
    *        in="query",
    *        description="number of pages",
    *        required=true
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    * @OA\Response(
    *      response=400,
    *      description="Bad Request"
    *   ),
    * @OA\Response(
    *      response=404,
    *      description="not found"
    *   ),
    *  )
    */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newBook = Book::addBook($request);

        return response()->json($newBook, 201);
    }

    /**
    * @OA\Get(
    *      path="/books/{id}",
    *      operationId="getOneBook",
    *      tags={"Tests"},

    *      summary="Get One Book",
    *      description="Returns one book and associated authors and genre by his ID.",
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *      ),
    *      @OA\Parameter(
    *        name="id",
    *        in="path",
    *        description="search by book id",
    *        required=true
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    * @OA\Response(
    *      response=400,
    *      description="Bad Request"
    *   ),
    * @OA\Response(
    *      response=404,
    *      description="not found"
    *   ),
    *  )
    */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        if($book) {
            return new BookResource($book);
        } else {
            return response()->json('Pas de livre trouvé', 404);
        }
    }

    /**
    * @OA\Patch(
    *      path="/books/{id}",
    *      operationId="updateBook",
    *      tags={"Tests"},

    *      summary="Update one book",
    *      description="Update a book by his ID",
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *      ),
        *      @OA\Parameter(
    *        name="id",
    *        in="path",
    *        description="search by book id",
    *        required=true
    *      ),
        *      @OA\Parameter(
    *        name="title",
    *        in="query",
    *        description="Title",
    *        required=false
    *      ),
        *      @OA\Parameter(
    *        name="description",
    *        in="query",
    *        description="Description",
    *        required=false
    *      ),
        *      @OA\Parameter(
    *        name="author_id",
    *        in="query",
    *        description="author id",
    *        required=false
    *      ),
        *      @OA\Parameter(
    *        name="publication_year",
    *        in="query",
    *        description="publication year",
    *        required=false
    *      ),
        *      @OA\Parameter(
    *        name="pages_nb",
    *        in="query",
    *        description="number of pages",
    *        required=false
    *      ),

    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    * @OA\Response(
    *      response=400,
    *      description="Bad Request"
    *   ),
    * @OA\Response(
    *      response=404,
    *      description="not found"
    *   ),
    *  )
    */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $updateBook = Book::updateBook($book, $request->all());

        return response()->json($updateBook, 200);
    }

    /**
    * @OA\Delete(
    *      path="/books/{id}",
    *      operationId="deleteBook",
    *      tags={"Tests"},

    *      summary="Delete One Book",
    *      description="Delete a book by is ID",
    *      @OA\Response(
    *          response=204,
    *          description="No content",
    *          @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *      ),
    *      @OA\Parameter(
    *        name="id",
    *        in="path",
    *        description="delete book by id",
    *        required=true
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    * @OA\Response(
    *      response=400,
    *      description="Bad Request"
    *   ),
    * @OA\Response(
    *      response=404,
    *      description="not found"
    *   ),
    *  )
    */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->genres()->detach();
        $book->delete();

        return response()->json('', 204);
    }

        /**
     * Display the specified resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $book = Book::where('title', 'like', "%{$request->title}%")->get();

        if($book) {
            return new BookCollection($book);
        } else {
            return response()->json('Pas de livre trouvé', 404);
        }
    }    

}





