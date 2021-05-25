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
        $setting_all = Setting::get();
        $setting = Setting::first();
        return view('user.page.setting', ['setting_all' => $setting_all, 'setting' => $setting, 'sidebar' => 5]);
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
            'image_landing' => $image,
            'image_sidebar' => $image,
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
            if (!empty($setting->image_dashboard)) {
                if (request()->file('image')) {
                    Storage::delete($setting->image_dashboard);
                    $imagePath = request()->file('image');
                    $path_dash = $imagePath->store("system");
                } else {
                    $path_dash = $setting->image_dashboard;
                }
            } else {
                if (request()->file('image')) {
                    $imagePath = request()->file('image');
                    $path_dash = $imagePath->store("system");
                } else {
                    $path_dash = null;
                }
            }
            if (!empty($setting->image_login)) {
                if (request()->file('image')) {
                    Storage::delete($setting->image_login);
                    $imagePath = request()->file('image_landing');
                    $path_landing = $imagePath->store("system");
                } else {
                    $path_landing = $setting->image_login;
                }
            } else {
                if (request()->file('image_landing')) {
                    $imagePath = request()->file('image_landing');
                    $path_landing = $imagePath->store("system");
                } else {
                    $path_landing = null;
                }
            }
            if (!empty($setting->image_sidebar)) {
                if (request()->file('image')) {
                    Storage::delete($setting->image_sidebar);
                    $imagePath = request()->file('image_sidebar');
                    $path_sidebar = $imagePath->store("system");
                } else {
                    $path_sidebar = $setting->image_sidebar;
                }
            } else {
                if (request()->file('image_sidebar')) {
                    $imagePath = request()->file('image_sidebar');
                    $path_sidebar = $imagePath->store("system");
                } else {
                    $path_sidebar = null;
                }
            }
            $setting->name_system = request()->name;
            $setting->image_dashboard = $path_dash;
            $setting->image_login = $path_landing;
            $setting->image_sidebar = $path_sidebar;
            $setting->name_comunity = request()->comunity;
            $setting->type_email = request()->email;
            $setting->save();
            return redirect(route('setting', [request()->id_kegiatan]))->with('success', 'Setting Successfully Update ');
        }
    }

    public function info(){
        $setting = Setting::first();
        return view('user.page.info', ['sidebar' => 6, 'setting' => $setting]);
    }
}