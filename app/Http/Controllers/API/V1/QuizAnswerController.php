<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreQuizAnswerRequest;
use App\Http\Resources\V1\QuizAnswerResource;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;

class QuizAnswerController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuizAnswer  $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(QuizAnswer $quizAnswer)
    {
        return new QuizAnswerResource($quizAnswer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizAnswer  $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuizAnswerRequest $request, QuizAnswer $quizAnswer)
    {
        $quizAnswer->update($request->only(['answer', 'duration_in_seconds']));
        return new QuizAnswerResource($quizAnswer);
    }
    
}
