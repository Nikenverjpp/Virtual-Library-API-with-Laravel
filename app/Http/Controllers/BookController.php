<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\{Validator, Auth};

class BookController extends Controller
{
    // List all books with optional filters for category, author, and search terms
    function index(Request $request){
        // Initialize query builder for the Book model
        $query = Book::query();

        // Apply category filter if present in the request
        if($request->has('category')){
            $query = $query->where('category', $request->category);
        }

        // Apply author filter if present in the request
        if($request->has('author')){
            $query = $query->where('author', $request->author);
        }

        // Apply search filter for title, author, and category if present in the request
        if($request->has('search')){
            $search = $request->search;
            $query = $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results, defaulting to 10 items per page if not specified
        $query = $query->paginate($request->per_page ?? 10);

        // Return the paginated results as a JSON response
        return response()->json($query, 200);
    }

    // Show the details of a specific book by ID
    function show($id){
        // Find the book by its ID
        $book = Book::find($id);

        // If the book is not found, return a 404 error
        if(!$book)
            return response()->json(['error' => 'Book not found'], 404);

        // Return the book details as a JSON response
        return response()->json($book, 200);
    }

    // Store a new book in the database
    function store(Request $request){
        // Validate the request data
        $validator = Validator::make($request->all(), [ 
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'published_at' => 'nullable|date' 
        ]);

        // If validation fails, return a 422 error with the validation errors
        if($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422); 

        // Create the book with the validated data
        $book = Book::create($request->all());
    
        // Return the newly created book as a JSON response with a 201 status code
        return response()->json($book, 201);
    }

    // Update an existing book by ID
    function update(Request $request, $id){
        // Find the book by its ID
        $book = Book::find($id);

        // If the book is not found, return a 404 error
        if(!$book){
            return response()->json(['error' => 'Book not found'], 404);
        }

        // Validate the request data, allowing partial updates
        $validator = Validator::make($request->all(), [ 
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'synopsis' => 'nullable|string', 
        ]);

        // If validation fails, return a 422 error with the validation errors
        if($validator->fails()){ 
            return response()->json(['errors' => $validator->errors()], 422); 
        }

        // Update the book with the validated data
        $book->update($request->all());

        // Return the updated book as a JSON response
        return response()->json($book, 200);
    }

    // Delete a specific book by ID
    function destroy($id){
        // Find the book by its ID
        $book = Book::find($id);

        // If the book is not found, return a 404 error
        if(!$book)
            return response()->json(['error' => 'Book not found'], 404);

        // Delete the book from the database
        $book->delete();

        // Return a 204 No Content response to indicate successful deletion
        return response()->json(null, 204);
    }
}
