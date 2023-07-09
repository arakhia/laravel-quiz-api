<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePlayerRequest;
use App\Http\Resources\V1\PlayerResource;
use App\Http\Resources\V1\QuizResource;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Barryvdh\DomPDF\Facade\Pdf;

class PlayerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['can:view,player'], ['only' => ['quizzes']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Player::all();
        return PlayerResource::collection($quizzes);
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
    public function store(StorePlayerRequest $request)
    {
        $player = Player::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'score' => $request->score,
            'last_game_at' => $request->last_game_at,
            'games_count' => $request->games_count,
        ]);
        
        return new PlayerResource($player);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return new PlayerResource($player);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(StorePlayerRequest $request, Player $player)
    {
        $player->update($request->all());
        return new PlayerResource($player);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        $player->delete();
        return response()->noContent();
    }

    /**
     * Display Player's Quizzes.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function quizzes(Player $player)
    {
        return QuizResource::collection($player->quizzes()->paginate(Config::get('api.paginate')));
    }

    /**
     * Display Player's Vocabularies.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function vocabularies(Player $player)
    {
        $vocabularies = $player->quizzes()->with('vocabularies')->get()->pluck('vocabularies')->flatten()->toArray();
        $data = [
            'vocabularies' => $vocabularies
        ];
        
        $pdf = Pdf::loadView('pdf.player_vocabularies', $data);
        return $pdf->download('my_vocabularies.pdf');
        //dd($vocabularies);
        //return json_encode($vocabularies);
    }
}
