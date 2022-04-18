<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::all();
        $users = User::all();

        $headers = collect($groups->first())->keys()->map(function ($item) {
            return  ['data' => $item , 'name' => $item];
        });

        $columns = array_merge($headers->toArray(),[['data'=>'action', 'name'=>'action', 'orderable'=>'false']]);

        if ($request->ajax()) {
            return datatables()->of($groups)
                ->addColumn('action', function ($row) {
                    $html = '<a href="#" class="btnUsers btn btn-sm  btn-outline-info " user-button-line="'. $row->id .'" user-button-line-name="'. $row->title .'" data-bs-toggle="modal" data-bs-target="#modal-user">Users</a> ';
                    $html .= '<a href="#" class="btn btn-sm  btn-outline-success btn-edit" edit-line="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#modal-default">Edit</a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-sm  btn-outline-danger btn-delete">Del</button>';
                    return $html;
                })->toJson();
        }

        return view('groups.index', compact('groups', 'users', 'columns'));
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
            'title' => 'required',
            'description' => 'required',
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->getMessages()]);
        }

        Group::create($data);
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
        Group::find($id)->update(request()->all());
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
        Group::find($id)->delete();
        return ['success' => true, 'message' => 'Deleted Successfully'];
    }
}
