<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'nama_buku' => $this->nama_buku,
            'penulis_buku_id' => $this->whenLoaded('penulisBuku', fn() => [
                'id' => $this->penulisBuku->id,
                'nama_penulis' => $this->penulisBuku->nama_penulis,
            ]),
            'isbn' => $this->isbn,
            'publisher_id' => $this->whenLoaded('publisherBuku', fn() => [
                'id' => $this->publisherBuku->id,
                'nama_publisher' => $this->publisherBuku->nama_publisher
            ]),
            'status_buku' => $this->status_buku,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
