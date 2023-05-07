<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
