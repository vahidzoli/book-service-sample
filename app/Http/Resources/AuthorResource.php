<?php

declare (strict_types=1);


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'avg'   => round($this->avg('review'),2) ?? 0,
            'count' => $this->count()
        ];
    }
}
