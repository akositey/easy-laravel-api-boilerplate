<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Api\BaseFormRequest;
use App\Http\Requests\Api\ValidationRules\ValidationRulesInterface;

class ApiController extends Controller
{
    protected $entity;
    protected $rules;

    /**
     * Inject Model and Rules here
     *
     * @param Model $entity
     * @param ValidationRulesInterface $rules
     * @return void
     */
    public function __construct(Model $entity, ValidationRulesInterface $rules = null)
    {
        $this->entity = $entity;
        $this->rules = $rules;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Api\BaseFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(BaseFormRequest $request)
    {
        return $request->trashed === "1" ? $this->entity::onlyTrashed()->get() : $this->entity::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\BaseFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BaseFormRequest $request)
    {
        //validate if rules exists
        $this->rules ? $request->validate($this->rules->get('store')) : null;
        //create
        $createdRecord = $this->entity::create($request->all());
        //return response
        return response()->json($createdRecord, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $existingRecord = $this->entity::findOrFail($id);
        return response()->json($existingRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\BaseFormRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BaseFormRequest $request, $id)
    {
        //validate if rules exists
        $this->rules ? $request->validate($this->rules->get('update')) : null;
        //find 
        $existingRecord = $this->entity::findOrFail($id);
        //update
        $existingRecord->update($request->all());
        //return response
        return response()->json($existingRecord, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingRecord = $this->entity::findOrFail($id);
        $existingRecord->delete();
        return response()->json([], 204);
    }

    /**
     * Restores the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->entity::onlyTrashed()->where('id', $id)->restore();
        return response()->json([], 200);
    }
}