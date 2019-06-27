<?php

namespace App\Http\Controllers;

use App\Todo;
use Validator;
use Illuminate\Http\Request;
use App\Libraries\UserDataValidation;

class TodoController extends Controller
{

    public function index()
    {
        $id = auth()->user()->id;
        $todos = Todo::where('user_id', $id)->get();

        return $this->successResponse($todos, 200);
    }

    public function store(Request $request)
    {
        $validate = $this->validator($request->all());

        if(!$validate->fails()) {
            $todo = Todo::create([
                'title' => $request->title,
                'date' => $request->date,
                'time' => $request->time,
                'completed' => 0,
                'user_id' => auth()->user()->id
            ]);

            return $this->successResponse($todo, 201);
        }

        return response()->json(['success' => false, 'errors' => $validate->errors()], 422);
    }

    public function show(Todo $todo)
    {
        UserDataValidation::belongsToUser($todo->id);

        return $this->successResponse($todo, 200);
    }

    public function update(Request $request, Todo $todo)
    {
        
        $validate = Validator::make($request->all(), [
            'title' => 'sometimes|string',
            'completed' => 'sometimes|boolean',
        ]);
        
        if(!$validate->fails()) {
            UserDataValidation::belongsToUser($todo->user_id);

            $todo->title = $request->title;
            $todo->completed = $request->completed;

            $todo->save();            

            return $this->successResponse($todo, 200);
        }

        return response()->json(['success' => false, 'errors' => $validate->errors()], 422);
    }

    public function destroy(Todo $todo)
    {
        UserDataValidation::belongsToUser($todo->user_id);
        // return $todo;
        $todo->delete();

        return $this->successResponse("Todo deleted successfully", 200);
    }

    public function validator(array $array)
    {
        return Validator::make($array, [
            'title' => 'required|string',
            'date' => 'required|date',
            'time' => 'required'
        ]);
    }

    private function successResponse($response, $status) {
        $response = [
            'success' => true,
            'data' => $response
        ];

        return response()->json($response, $status);
    }
}
