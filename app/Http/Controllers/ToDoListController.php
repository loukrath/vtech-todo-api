<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDoList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ToDoListController extends Controller
{
   
    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {   
        $validatedData = $request->validate([
            'todo' => 'required|string',
            'isCompleted' => 'nullable|boolean'
        ]);

        try{
            $todo = ToDoList::create($validatedData);

            return response()->json($todo, 201);
        }catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $todo = ToDoList::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (NotFoundHttpException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        $validatedData = $request->validate([
            'todo' => 'required|string',
            'isCompleted' => 'nullable|boolean'
        ]);
        $todo->update($validatedData);
        return response()->json($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $todo = ToDoList::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (NotFoundHttpException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        $todo->delete();
        return response()->json(null, 204);
    }
}
