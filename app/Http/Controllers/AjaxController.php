<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * @group Ajax requests management
 *
 * APIs for managing ajax requests
 */
class AjaxController extends Controller
{
    /**
     * Namespace of the application.
     */
    protected $namespace;

        /**
     * AjaxController constructor.
     *
     * @param UserService $userService
     * @param AssessmentService $assessmentService
     * @param CheckListService $checkListService
     */
    public function __construct()
    {
        $this->namespace = app()->getNamespace();
    }

    /**
     * Return Content of a Model for edition.
     *
     * @bodyParam id int required
     * @bodyParam model string required
     * @bodyParam _token string required
     * @responseFile responses/any_model.json
     * @responseFile 404 responses/not_found.json
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function edit(Request $request)
    {
        /** @var Model $modelName */
        $modelName = $this->namespace.'Models\\'.$request->input('model');

        return $modelName::findOrFail($request->input('id'));
    }

        /**
     * Display a listing of users.
     *
     * @bodyParam id int required
     * @bodyParam model string required
     * @bodyParam _token string required
     * @responseFile responses/users_list.json
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function usersList(Request $request)
    {
        $modelName = $this->namespace.'Models\\'.$request->input('model');

        if (! method_exists($modelName, 'users')) {
            return response()->json([
                'message' => __('messages.NoRelationWithUsers'),
            ]);
        }

        if ($request->input('id') != 'all') {
            $users = $modelName::find($request->input('id'))->users()->get();

            return response()->json($users);
        }
        // Store All users Id by Model in a table
        $models = $modelName::all();
        foreach ($models as $model) {
            foreach ($model->users()->get() as $user) {
                $userIds[$model->id][] = $user->id;
            }
        }
        // Retrieve users Id which are used by all Models
        $usersAll = User::all();
        $users_selected = [];
        foreach ($usersAll as $user) {
            $count = 0;
            foreach ($userIds as $userId) {
                if (in_array($user->id, $userId)) {
                    $selected = $user->id;
                    $count++;
                } else {
                    $selected = 0;
                }
            }
            if ($selected != 0 && count($userIds) == $count) {
                $users_selected[] = ['id' => $selected];
            }
        }

        return response()->json($users_selected);
    }
}
