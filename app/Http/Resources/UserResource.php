<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{ 
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array 
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'users',
                'user_id' => $this->id,
                'attributes' => [
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'cedula' => $this->cedula,
                    'correo' => $this->correo,
                    'telefono' => $this->telefono,
                ]
            ]
        ];
    }
}
