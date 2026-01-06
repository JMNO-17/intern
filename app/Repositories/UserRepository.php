<?php

namespace App\Repositories;

use App\Helpers\MediaUploadHelper;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::latest()->get();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();
                $profileImage = MediaUploadHelper::extractImagesFromData($data, 'profile_image');
                $user = User::create($data);
                MediaUploadHelper::processImages($user, $profileImage, 'profile_image', 'user');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }
        return $user;
    }

    public function update($data, $model)
    {
        try {
            DB::beginTransaction();
                MediaUploadHelper::handleImageUpdate($model, $data, 'profile_image', 'user');
                $model->update($data);
            DB::commit();

            return $model;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User update failed', [
                'user_id' => $model->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }
    }

    public function updatePermission($data, $user)
    {
        if (count($data['permissions']) > 0) {
            $user->permissions()->sync($data['permissions']);
        }
    }

    public function softDelete($user)
    {
        $user->delete();
    }

    public function forceDelete($user)
    {
        $user->forceDelete();
    }

    public function restore($id)
    {
        $this->all()->withTrashed()->find($id)->restore();
    }

    public function restoreAll()
    {
        $this->all()->onlyTrashed()->restore();
    }

    public function assignRole($roleInputs, $user)
    {
        $roles = [];
        if (count($roleInputs) > 0) {
            foreach ($roleInputs as $key => $value) {
                array_push($roles, $value);
            }
        }
        $user->roles()->sync($roles);
    }
}
