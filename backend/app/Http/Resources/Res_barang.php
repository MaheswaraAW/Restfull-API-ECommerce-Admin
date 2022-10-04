<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Res_barang extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // return [
        //     'id' =>$this->id,
        //     'nama' =>$this->nama,
        //     'deskripsi' =>$this->deskripsi,
        //     'harga' =>$this->harga-1000,
        //     'stok' =>$this->stok,
        //     'gambar' =>$this->gambar,
        // ];
    }
}
