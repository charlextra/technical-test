<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();

        $headers = collect($users->first())->keys()->map(function ($item) {
            return  ['data' => $item , 'name' => $item];
        });

        $columns = array_merge($headers->toArray(),[['data'=>'action', 'name'=>'action', 'orderable'=>'false']]);

        if ($request->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', function ($row) {
                    $html = '<a href="#" class="btn btn-sm btn-outline-success btn-edit" edit-line="'. $row->id .'">Edit</a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-sm btn-outline-danger btn-delete">Del</button>';
                    return $html;
                })->toJson();
        }

        return view('users.index', compact('users', 'columns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $toBeUnserialize = $request->all();        
        parse_str($toBeUnserialize['data'], $data);

        $validator = Validator::make($data,[
            'name' => 'required',
            'email' => 'required',
            'password' => ['required', 'string', 'min:8', 'regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/'],
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->getMessages()]);
        }

        User::create($data);
        return ['success' => true, 'message' => 'Inserted Successfully'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return;
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        User::find($id)->update(request()->all());
        return ['success' => true, 'message' => 'Updated Successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return ['success' => true, 'message' => 'Deleted Successfully'];
    }
}
