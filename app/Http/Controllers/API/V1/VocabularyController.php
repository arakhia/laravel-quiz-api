<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreVocabularyRequest;
use App\Http\Resources\V1\VocabularyResource;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #return Vocabulary::all();
        $vocabularies = Vocabulary::all();
        return VocabularyResource::collection($vocabularies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVocabularyRequest $request)
    {
        $vocabulary = Vocabulary::create([
            'vocabulary' => $request->vocabulary,
            'complexity' => $request->complexity,
            'form' => $request->form,
            'field' => $request->field,
            'usage_count' => $request->usage_count,
            'success_count' => $request->success_count,
            'failure_count' => $request->failure_count,
        ]);

        return new VocabularyResource($vocabulary);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function show(Vocabulary $vocabulary)
    {
        return new VocabularyResource($vocabulary);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function edit(Vocabulary $vocabulary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVocabularyRequest $request, Vocabulary $vocabulary)
    {
        $vocabulary->update($request->all());
        return new VocabularyResource($vocabulary);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();
        return response()->noContent();
    }
}
