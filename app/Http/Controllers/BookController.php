<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\{Validator, Auth};

class BookController extends Controller
{
    function index(Request $request){
        $query = Book::query();

        if($request->has('category')){
            $query = $query->where('category', $request->category);
        }

        if($request->has('author')){
            $query = $query->where('author', $request->author);
        }

        if($request->has('search')){
            $query = $query->where('title', 'like', '%' . $request->search . '%');
        }

        // We search by title, author and category
        if($request->has('search')){
            $query = $query->where(function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        $query = $query->paginate($request->per_page ?? 10);

        return response()->json($query, 200);
    }

    function show($id){
        $book = Book::find($id);

        if(!$book)
            return response()->json(['error' => 'Book not found'], 404);

        return response()->json($book, 200);
    }

    function store(Request $request){
        $validator = Validator::make($request->all(), [ 
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'published_at' => 'nullable|date' 
        ]);

        if($validator->fails()){ return response()->json(['errors' => $validator->errors()], 422); }

        $book = Book::create($request->all());
    
        return response()->json($book, 201);
    }

    function update(Request $request, $id){
        $book = Book::find($id);

        if(!$book){
            return response()->json(['error' => 'Book not found'], 404);
        }

        $validator = Validator::make($request->all(), [ 
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'synopsis' => 'nullable|string', 
        ]);

        if($validator->fails()){ return response()->json(['errors' => $validator->errors()], 422); }

        $book->update($request->all());
        return response()->json($book, 200);
    }

    function destroy($id){
        $book = Book::find($id);

        if(!$book)
            return response()->json(['error' => 'Book not found'], 404);

        $book->delete();
        
        return response()->json(null, 204);
    }
}
