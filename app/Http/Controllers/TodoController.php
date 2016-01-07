<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class TodoController extends Controller
{
    public $restful = true;

    public function getIndex()
    {
        $todos = Todo::all();
        return view('welcome', compact('todos'));
    }

    public function postAdd()
    {
        if (Request::ajax()) {
            $todo = new Todo();
            $todo->title = Input::get("title");
            $todo->save();
            $last_todo = $todo->id;
            $todos = Todo::whereId($last_todo)->get();
            return view('ajaxData', compact('todos'));
        }
    }

    public function postUpdate($id){
        if(Request::ajax()){
            $task = Todo::find($id);
            $task->title = Input::get("title");
            $task->save();
            return "OK";
        }
    }

    public function getDelete($id){
        if(Request::ajax()){
            $todo = Todo::whereId($id)->first();
            $todo->delete();
            return "OK";
        }
    }

    public function getDone($id){
        if(Request::ajax()){
            $task = Todo::find($id);
            $task->status = 1;
            $task->save();
            return "OK";
        }
    }
}