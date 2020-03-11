<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use PDF;
use Illuminate\Http\Request;

use App\Exports\TaskExport;
use Maatwebsite\Excel\Facades\Excel;


class TaskController extends Controller
{
    public function getlist(Request $req)
    {

        $name = $req->name;
        $tasks = \App\Task::orderBy('id', 'asc');
        $users = User::get();

        // untuk panggil dkt view nnti
        $input = $this->getUserList($users, 'name');
        $inputEmail = $this->getUserEmail($users, 'email');
        //for request export data ONLY specific data filtering
        $paramString = request()->getQueryString();
        // untuk filter any ayat
        $params = (object) $req->all(); 

        // User filter by name je takyah filter query
        if($req->filled('name')){
        $tasks = \App\Task::where('name', 'LIKE', "%$name%")->orderBy('id', 'asc');
        
        $name = $req->name;
        }

        if ($req->filled('user_id')){
            $tasks = Task::where('user_id', $req->user_id);
        }

        if ($req->filled('email')){
            $tasks = Task::where('user_id', $req->email);
        }
  

        $tasks = $tasks->paginate(5);
        
        return view('tasks.index', compact('tasks', 'users','params', 'input', 'inputEmail', 'paramString'));

    }

    protected function getUserList($users)
    {
        $input =[];

        $input ['']= "Please Choose";
        
        foreach ($users as $user)
        {
            $input [$user->id] = $user->name;
        }

       

        return $input;
    }

    protected function getUserEmail($users){
        $input =[];

        $input ['']= "Please Choose";

        foreach ($users as $user)
        {
            $input [$user->id] = $user->email;
        }

        return $input;

    }

    public function getCreateTask(Request $req)
    {
        //define users ni pergi model User
        $users = User::get();
        //initialize input ni go to method getUserList
        $input = $this->getUserList($users, 'name');


        return view('tasks.create',compact('users','input'));

    }

    public function postCreateTask()
    {
        $task =new Task();
        $task->name= request()->name;
        $task->content= request()->content;
        $task->user_id= request()->user_id;
        $task->save();

        return redirect()->to('/tasks')->with('status','Success');
    }

    public function getViewTask($id)
    {
        $task= Task::find($id);
        $users=User::get();
        $input= $this->getUserList($users);
        return view('tasks.view', compact('users','task','input'));
    }

    public function postDelete($id)
    {
        Task::where('id',$id)->delete();
        return redirect()->back()->with('status','Success');
    }

    public function getViewTaskPdf($id)
    {
        $task= Task::find($id);
        $users= User::get();
        $input= $this->getUserList($users);
        $pdf = PDF::loadView('tasks.view-pdf', compact('users', 'task', 'input'));
        $pdf-> setPaper('AS', 'potrait');
        return $pdf->stream();
    }

    public function getListExcel()
    {
        $tasks = \App\Task::orderBy('id', 'asc');

        if(request()->filled('name'))
        {
            $tasks = $tasks->where('name', 'like',"%". request()->name . "%");
        
        }

        if (request()->filled('user_id')){
            $tasks = $tasks->where('user_id', request()->user_id);
        }

        if (request()->filled('email')){
            $tasks = $tasks->where('user_id', request()->email);
        }
  
            $tasks= $tasks->get();
            return Excel::download(new TaskExport($tasks), 'tasks.xlsx');
        
    }

}