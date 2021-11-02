<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;

class TodoController extends Controller
{
   
    public function index(Request $request)
    {
     
        $id = Auth::id();
        return Todo::where('user_id' , $id )->get();
    }

    public function store(Request $request)
    {
        $id = Auth::id();

        $todo = new Todo();
        $todo->text = $request->text;
        $todo->user_id =$id;
        $todo->save();

        return response()->json([
            'message' => 'Todo successfully created.'
        ]);
    }

    public function delete(Request $request)
    {
        $todo = Todo::find($request->get('id'));
        $todo->delete();

        return response()->json([
            'message' => 'Todo successfully deleted.'
        ]);
    }

    public function markAsDone(Request $request)
    {
        $todo = Todo::find($request->get('id'));
        $todo->done = true;
        $todo->update();

        return response()->json([
            'message' => 'Todo successfully marked as done.'
        ]);
    }

    public function markAsUnDone(Request $request)
    {
        $todo = Todo::find($request->get('id'));
        $todo->done = false;
        $todo->update();

        return response()->json([
            'message' => 'Todo successfully marked as undone.'
        ]);
    }
}
