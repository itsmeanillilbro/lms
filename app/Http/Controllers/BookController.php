<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Models\Book;
use App\Models\User;
use App\Traits\SwaggerAnnotationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BookController extends Controller
 
{
    use SwaggerAnnotationsTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(5);
        if ($books) {
            return response()->json([
                'success' => true,
                'message' => 'Books fetched successfully',
                'data' => $books->items(),
                'meta' => [
                    'current_page' => $books->currentPage(),
                    'total' => $books->total(),
                    'per_page' => $books->perPage(),
                    'last_page' => $books->lastPage(),
                ]
            ])->setStatusCode(200);

        } else {
            return response()->json([
                'message' => 'Error Fetching books'
            ], 404);
        }

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ])->setStatusCode(401);
        }
        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'logout successful'
        ])->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {

        $book = Book::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'data' => $book,
        ])->setstatuscode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json([
            'success' => true,
            'message' => 'Book fetched successfully',
            'data' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
            'data' => $book
        ])->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully',
        ])->setStatusCode(200);
    }
}
