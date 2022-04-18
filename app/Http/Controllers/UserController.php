<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Validator;
use Arr;
use Str;

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
                $html = '<a href="#" class="btn btn-sm btn-outline-success btn-edit" edit-line="'. $row->id .'"  data-bs-toggle="modal" data-bs-target="#modal-default">Edit</a> ';
                $html .= '<button data-rowid="' . $row->id . '" class="btn btn-sm btn-outline-danger btn-delete">Delete</button>';
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

        /**
     * Sync assignments.
     *
     * @param Request $request
     *
     * @bodyParam model string required
     * @bodyParam model_id integer required
     * @bodyParam users array
     * @bodyParam assignments array required
     * @bodyParam entity_ids array required
     * @bodyParam entity_ids.* integer required
     * @responseFile responses/created.json
     *
     * @return JsonResponse|RedirectResponse
     * @throws App\Exceptions\AssignUserException
     */
        public function assignments(Request $request)
        {
        $appPrefix = 'App\Models';
        $modelName = $appPrefix.'\\'.$request->input('model');

        $filtered = Arr::except($request->all(), ['_token', 'dataTable2_length', 'model_id', 'model', 'assignments']);
        [$keys, $values] = Arr::divide($filtered);
        $assignments = [];
        foreach ($keys as $assignment) {
            $assignments[] = Str::replaceArray('user_', [''], $assignment);
        }

        $model = $modelName::find($request->input('model_id'));
        $model->users()->sync(Arr::flatten($assignments));

            return redirect()->back()->with(['success' => true, 'message' => 'Successfully Assigned']);
        }
    }
