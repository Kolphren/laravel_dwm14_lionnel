<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

use App\Models\Author;

class AuthorController extends Controller
{   /**
    * @OA\Get(
    *      path="/authors",
    *      operationId="getAllAuthor",
    *      tags={"Tests"},

    *      summary="Get of Authors",
    *      description="Returns all authors",
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AuthorCollection(Author::orderBy('name')->paginate(10));
    }

        /**
    * @OA\Post(
    *      path="/authors",
    *      operationId="AddAuthor",
    *      tags={"Tests"},

    *      summary="Add an author",
    *      description="Add an author to the library",
    *      @OA\Response(
    *          response=201,
    *          description="Created",
    *          @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *      ),
    *      @OA\Parameter(
    *        name="name",
    *        in="query",
    *        description="name",
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
        $newAuthor = Author::addAuthor($request->name);

        return response()->json($newAuthor, 201);

    }

    /**
    * @OA\Get(
    *      path="/authors/{id}",
    *      operationId="getOneAuthor",
    *      tags={"Tests"},

    *      summary="Get One Author",
    *      description="Returns one author and associated authors and genre by his ID.",
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
    *        description="search by author id",
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
        $author = Author::find($id);

        if($author) {
            return new AuthorResource($author);
        } else {
            return response()->json("Pas d'auteur trouvé", 404);
        }
    }

    /**
    * @OA\Patch(
    *      path="/authors/{id}",
    *      operationId="UpdateAuthor",
    *      tags={"Tests"},

    *      summary="Update an author by his ID",
    *      description="Update an author to the library",
    *      @OA\Response(
    *          response=201,
    *          description="Created",
    *          @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *      ),
    *      @OA\Parameter(
    *        name="id",
    *        in="path",
    *        description="id",
    *        required=true
    *      ),
    *      @OA\Parameter(
    *        name="name",
    *        in="query",
    *        description="name",
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $updateAuthor = Author::updateAuthor($author, $request->all());

        return response()->json($updateAuthor, 200);
    }

    /**
    * @OA\Delete(
    *      path="/authors/{id}",
    *      operationId="DeleteAuthor",
    *      tags={"Tests"},

    *      summary="Delete One Author",
    *      description="Delete one author by his ID.",
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
    *        description="delete author by id",
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
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json('', 204);
    }

     /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $author = Author::where('name', 'like', "%{$request->name}%")->get();

        if(count ($author)) {
            return new AuthorCollection($author);
        } else {
            return response()->json("Pas d'auteur trouvé", 404);
        }
    }
}
