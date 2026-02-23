<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use Illuminate\Http\Resources\Json\JsonResource;


class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_penulis' => $this->penulis_buku,
            'buku' => BookResource::collection($this->whenLoaded('produkBuku')),
            'stats' => $this->whenLoaded('stats', fn() => [
                'popularity_score' => $this->stats->popularity_score,
                'total_voters' => $this->stats->total_voters,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
