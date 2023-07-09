<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'player' => $this->player_id,
            'creation_type' => $this->creation_type,
            'duration_in_seconds' => $this->duration_in_seconds,
            'result' => $this->result,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'created_at' => $this->created_at->diffForHumans(),
            'vocabularies' => VocabularyResource::collection($this->whenLoaded('vocabularies')),
            'answers' => QuizAnswerResource::collection($this->whenLoaded('answers'))
        ];
    }
}
