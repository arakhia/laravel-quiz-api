<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreQuizRequest;
use App\Models\Quiz;
use App\Http\Resources\V1\QuizResource;
use App\Models\Vocabulary;
use App\Notifications\QuizCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    // 
    private $safeIncludes = ['vocabularies', 'answers'];

    public function __construct()
    {
        $this->middleware(['can:viewAny,App\Models\Quiz'], ['only' => ['index']]);
        $this->middleware(['can:view,quiz'], ['only' => ['show']]);
        $this->middleware(['can:delete,quiz'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $filter = new QuizFilter();
        $queryItems = $filter->transform($request);

        $quizzes = Quiz::where($queryItems);
        
        $quizzes = load_query_include_parm_local_helper(request()->query('include'), $this->safeIncludes, $quizzes, $filter);
        
        return QuizResource::collection($quizzes->paginate(Config::get('api.paginate')));
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
     * @param  \App\Http\Requests\StoreQuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizRequest $request)
    {
        $quiz = DB::transaction(function () use($request) {
            $quiz = Quiz::create([
                'name' => $request->name,
                'player_id' => auth('sanctum')->user()->id,
                'creation_type' => $request->creation_type,
                'duration_in_seconds' => $request->duration_in_seconds,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'result' => $request->result,
            ]);
    
            // handle QuizAnswers creation
            $vocabularyIds = null;
    
            if($quiz->creation_type == "random"){
                $vocabularyIds = Vocabulary::all()->random(5)->pluck('id')->toArray();
            } else if($quiz->creation_type == "selected"){
                $vocabularyIds = $request->vocabularies;
            }
    
            foreach($vocabularyIds as $vocabulary){
                $quiz->answers()->create(
                    [
                        'vocabulary_id' => $vocabulary
                    ]
                );
            }

            return $quiz;
        });
        
        $quiz->player->notify(new QuizCreated($quiz));
        
        return new QuizResource($quiz);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //$this->authorize('view', $quiz);

        $quiz = load_query_include_parm_local_helper(request()->query('include'), $this->safeIncludes, $quiz);

        return new QuizResource($quiz);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuizRequest  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->all());
        return new QuizResource($quiz);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->noContent();
    }
}
