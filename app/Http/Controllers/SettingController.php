<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Vote;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $active = Vote::where('status', '1')->first();
        $setting_all = Setting::get();
        $setting = Setting::first();
        return view('user.page.setting', ['setting_all' => $setting_all,'setting' => $setting,'sidebar' => 5, 'activity' => $active]);
    }

    protected function validator(array $data)
    {
        if ($data['edit'] == 1) {
            $image = 'mimes:jpeg,png|max:1024|image';
        } else {
            $image = 'required|mimes:jpeg,png|max:1024|image';
        }
        return Validator::make($data, [
            'image' => $image,
            'name' => 'required',
            'email' => 'required',
        ]);
    }

    public function update(Setting $setting)
    {
        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('setting', [request()->id_kegiatan]))->with('error', 'Something Wrong, Please Check Your Input');
        } else {
            if (!empty($setting->image_system)) {
                if (request()->file('image')) {
                    Storage::delete($setting->image_system);
                    $imagePath = request()->file('image');
                    $path = $imagePath->store("system");
                } else {
                    $path = $setting->image_system;
                }
            } else {
                if (request()->file('image')) {
                    $imagePath = request()->file('image');
                    $path = $imagePath->store("system");
                } else {
                    $path = null;
                }
            }
            $setting->name_system = request()->name;
            $setting->image_system = $path;
            $setting->name_comunity = request()->comunity;
            $setting->type_email = request()->email;
            $setting->save();
            return redirect(route('setting', [request()->id_kegiatan]))->with('success', 'Setting Successfully Update ');
        }
    }

    public function info(){
        $setting = Setting::first();
        $active = Vote::where('status', '1')->first();
        return view('user.page.info',['sidebar' => 6,'activity' => $active,'setting' => $setting]);
    }
}