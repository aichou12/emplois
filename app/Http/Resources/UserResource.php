<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userdata = $this->userdata ?? null;

        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => trim(($this->firstname ?? '') . ' ' . ($this->lastname ?? '')),
            'username' => $this->username,
            'email' => $this->email,
            'numberid' => $this->numberid,
            'enabled' => (bool) $this->enabled,
            'recruted' => (bool) $this->recruted,
            'date_inscription' => $this->date_inscription ? $this->date_inscription->format('Y-m-d H:i:s') : null,
            'last_login' => $this->last_login ? $this->last_login->format('Y-m-d H:i:s') : null,
            'has_profile' => $userdata !== null,
            'userdata_id' => $userdata ? $userdata->id : null,
            'photo_profil' => ($userdata && $userdata->photo_profil) ? asset($userdata->photo_profil) : asset('images/images.png'),
        ];
    }
}
