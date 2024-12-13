<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Todo API",
 *     version="1.0.0",
 *     description="API endpoints for managing todos"
 * )
 */
class TodoController extends Controller
{
    /**
     * Display a listing of todos with optional filtering and sorting.
     * 
     * @OA\Get(
     *     path="/api/todos",
     *     summary="List all todos with filtering and sorting",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for title and details",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status (completed, in-progress, not-started)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"completed", "in-progress", "not-started"})
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         @OA\Schema(type="string", enum={"title", "created_at", "status"})
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Sort order",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of todos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="todos", type="array", @OA\Items(ref="#/components/schemas/Todo"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Todo::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by title or details
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('details', 'like', "%{$searchTerm}%");
            });
        }

        // Sort by title or created_at
        $sortField = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('order', 'desc');
        
        if (in_array($sortField, ['title', 'created_at', 'status'])) {
            $query->orderBy($sortField, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        $todos = $query->get();

        return response()->json(['todos' => $todos]);
    }

    /**
     * Store a newly created todo.
     * 
     * @OA\Post(
     *     path="/api/todos",
     *     summary="Create a new todo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TodoRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Todo created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="todo", ref="#/components/schemas/Todo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(TodoRequest $request)
    {
        $todo = Todo::create($request->validated());

        return response()->json([
            'message' => 'Todo created successfully',
            'todo' => $todo
        ], 201);
    }

    /**
     * Display the specified todo.
     * 
     * @OA\Get(
     *     path="/api/todos/{todo}",
     *     summary="Get a specific todo",
     *     @OA\Parameter(
     *         name="todo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="todo", ref="#/components/schemas/Todo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     )
     * )
     */
    public function show(Todo $todo)
    {
        return response()->json(['todo' => $todo]);
    }

    /**
     * Update the specified todo.
     * 
     * @OA\Put(
     *     path="/api/todos/{todo}",
     *     summary="Update a todo",
     *     @OA\Parameter(
     *         name="todo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TodoRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="todo", ref="#/components/schemas/Todo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());

        return response()->json([
            'message' => 'Todo updated successfully',
            'todo' => $todo
        ]);
    }

    /**
     * Remove the specified todo.
     * 
     * @OA\Delete(
     *     path="/api/todos/{todo}",
     *     summary="Delete a todo",
     *     @OA\Parameter(
     *         name="todo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     )
     * )
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json([
            'message' => 'Todo deleted successfully'
        ]);
    }
}
