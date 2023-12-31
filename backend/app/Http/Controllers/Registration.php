<?php

namespace App\Http\Controllers;

use App\Dto\RegistrationDto;
use App\Models\User;
use Illuminate\Http\Request;
use \Hash;
use \Illuminate\Support\Str;

trait Registration
{
    /**
     * @param  Request  $request
     * @param  int      $externalId
     * @param  int      $datasourceId
     * @return RegistrationDto
     */
    public function registerUser(Request $request, int $externalId, int $datasourceId = 1): RegistrationDto
    {
        $validatedData = $request->safe()->only(['name', 'email', 'phone']);
        $password = Str::password(10);

        $user = User::create([
            'name' => $validatedData['name'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
            'email' => $validatedData['email'],
            'password' => Hash::make($password),
            'external_id' => $externalId,
            'datasource_id' => $datasourceId
        ]);
        $registrationDto = new RegistrationDto();
        $registrationDto->user = $user;
        $registrationDto->password = $password;
        $registrationDto->token = $user->createToken('auth_token');

        return $registrationDto;
    }
}