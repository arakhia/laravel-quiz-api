<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class VocabularyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'vocabulary' => $this->vocabulary,
            'complexity' => $this->complexity,
            'form' => $this->form,
            'field' => $this->field,
            'usage_count' => $this->usage_count,
            'success_count' => $this->success_count,
            'failure_count' => $this->failure_count,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
