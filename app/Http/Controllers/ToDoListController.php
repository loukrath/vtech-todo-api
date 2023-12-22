<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDoList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try
        {
            $keyword = $request->query('keyword', '');
            $todos = ToDoList::where('todo', 'LIKE', "%{$keyword}%")
                                ->orderBy('created_at', 'asc')
                                ->get();
        }
        catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        return response()->json($todos, 200);
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {   
        $validatedData = $request->validate([
            'todo' => 'required|string|unique:to_do_lists',
            'isCompleted' => 'nullable|boolean'
        ]);

        try
        {
            $todo = ToDoList::create($validatedData);

            return response()->json($todo, 201);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try
        {
            $todo = ToDoList::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json(['error' => 'Todo not found'], 404);
        }
        catch (NotFoundHttpException $e)
        {
            return response()->json(['error' => 'Todo not found'], 404);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        // Check if the request has the key updateStatus
        if ($request->has('updateStatus'))
        {
            $validatedData = $request->validate([
                'isCompleted' => 'nullable|boolean'
            ]);
        }
        else
        {
            $validatedData = $request->validate([
                'todo' => 'required|string|unique:to_do_lists',
                'isCompleted' => 'nullable|boolean'
            ]);
        }
        
        $todo->update($validatedData);

        return response()->json($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            $todo = ToDoList::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json(['error' => 'Todo not found'], 404);
        }
        catch (NotFoundHttpException $e)
        {
            return response()->json(['error' => 'Todo not found'], 404);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        $todo->delete();
        
        return response()->json(null, 204);
    }
}