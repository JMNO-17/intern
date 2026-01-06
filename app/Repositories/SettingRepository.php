<?php

namespace App\Repositories;

use App\Helpers\common;
use App\Models\Setting;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use Exception;
use File;
use Illuminate\Support\Facades\DB;

class SettingRepository implements SettingRepositoryInterface
{
    public function all()
    {
        return Setting::all();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        return Setting::create($data);
    }

    public function update($data)
    {
        try {
            DB::beginTransaction();
            unset($data['content']['_method']);
            unset($data['content']['_token']);
            foreach ($data['content'] as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                $setting->update(['value' => $value]);
            }

            foreach ($data['files'] as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                if ($setting->value != Setting::DEFAULT['favicon'] && $setting->value != Setting::DEFAULT['site_logo']) {
                    if (! is_null($setting->value) && File::exists(explode('/', $setting->value, 2)[1])) {
                        File::delete(explode('/', $setting->value, 2)[1]);
                    }
                }

                $featureImagePath = common::storeImage(Setting::IMAGE_PATH, $value);
                $setting->value = $featureImagePath;
                $setting->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }

        return true;
    }

    public function removeImage($data)
    {
        $setting = Setting::where('key', $data->key)->first();
        $setting->value = Setting::DEFAULT[$data->key];
        $setting->save();

        return $setting;
    }
}
