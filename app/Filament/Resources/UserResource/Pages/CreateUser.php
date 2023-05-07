<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);

        if ($data['middle_name'] !== null) {
            $data['full_name'] = sprintf(
                '%s %s %s',
                $data['first_name'],
                $data['last_name'],
                $data['middle_name']
            );
        } else {
            $data['full_name'] = sprintf(
                '%s %s',
                $data['first_name'],
                $data['last_name']
            );
        }

        return $data;
    }
}
