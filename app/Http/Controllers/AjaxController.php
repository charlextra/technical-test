<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @param CompanyService $companyService
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
}
