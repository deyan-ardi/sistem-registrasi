<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Setting;
use App\User;
use App\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Excel;

class MemberController extends Controller
{
    protected function validator(array $data)
    {
        if ($data['edit'] == 1) {
            $cariData = User::find($data['id']);
            if ($data['member_id'] == $cariData->member_id) {
                $member_id = ['required', 'integer', 'digits_between:3,11'];
            } else {
                $member_id = ['required', 'integer', 'unique:users', 'digits_between:3,11'];
            }
            if ($data['email'] == $cariData->email) {
                $email = ['nullable', 'string', 'email', 'max:255',];
            } else {
                $email = ['nullable', 'unique:users', 'string', 'email', 'max:255'];
            }
        } else {
            $member_id = ['required', 'integer', 'unique:users', 'digits_between:3,11'];
            $email = "";
        }
        return Validator::make($data, [
            'member_id' => $member_id,
            'email' => $email,
            'password' => ['nullable', 'string', 'min:8', 'required_with:repassword', 'same:repassword'],
            'repassword' => ['nullable', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required'],
        ]);
    }
    public function index()
    {
        $member = User::get();
        $active = Vote::where('status', '1')->first();
        $setting = Setting::first();
        return view('user.page.member', ['setting' => $setting, 'member_all' => $member, 'sidebar' => 2, 'activity' => $active]);
    }

    public function create()
    {
        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('member'))->with('error', 'Member Failed To Added');
        } else {
            User::create([
                'member_id' => request()->member_id,
                'name' => request()->name,
                'level' => request()->level,
            ]);
            return redirect(route('member'))->with('success', 'Member Succesfully Added');
        }
    }

    public function update()
    {
        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('member'))->with('error', 'Member Failed To Update');
        } else {
            if (!empty(request()->password) && !empty(request()->repassword)) {
                User::where('id', request()->id)->update([
                    'member_id' => request()->member_id,
                    'name' => request()->name,
                    'email' => request()->email,
                    'password' => Hash::make(request()->password),
                    'level' => request()->level,
                ]);
            } else if (!empty(request()->email)) {
                User::where('id', request()->id)->update([
                    'member_id' => request()->member_id,
                    'name' => request()->name,
                    'email' => request()->email,
                    'level' => request()->level,
                ]);
            } else {
                User::where('id', request()->id)->update([
                    'member_id' => request()->member_id,
                    'name' => request()->name,
                    'level' => request()->level,
                    'email' => null,
                    'password' => null,
                ]);
            }
            return redirect(route('member'))->with('success', 'Member Succesfully Update');
        }
    }

    public function destroy(User $member)
    {
        if ($member->id == Auth::user()->id) {
            return redirect(route('member'))->with('error', 'Can\'t Delete Yourself');
        } else {
            $member->delete();
            return redirect(route('member'))->with('success', 'Member Succesfully Delete');
        }
    }

    public function update_login(User $member)
    {
        $validator = Validator::make(request()->all(), [
            'password_login' => ['nullable', 'string', 'min:8', 'required_with:repassword_login', 'same:repassword_login'],
            'repassword_login' => ['nullable', 'string', 'min:8'],
            'name_login' => ['required', 'string', 'max:255'],
            'image' => ['mimes:jpeg,png', 'max:1024', 'image'],
        ]);
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('member'))->with('error', 'Your Data Failed To Update');
        } else {
            if (!empty($member->image)) {
                if (request()->file('image')) {
                    Storage::delete($member->image);
                    $imagePath = request()->file('image');
                    $path = $imagePath->store("user");
                } else {
                    $path = $member->image;
                }
            } else {
                if (request()->file('image')) {
                    $imagePath = request()->file('image');
                    $path = $imagePath->store("user");
                } else {
                    $path = null;
                }
            }
            if (!empty(request()->password_login)) {
                $password = Hash::make(request()->password_login);
            } else {
                $password = $member->password;
            }
            $member->name = request()->name_login;
            $member->password = $password;
            $member->image = $path;
            $member->save();
            return redirect(route('member'))->with('success', 'Your Data Successfuly Update');
        }
    }

    public function import_excel()
    {
        $validator = Validator::make(request()->all(), [
            'import' => ['mimes:xlsx', 'max:10024', 'required'],
        ]);
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('member'))->with('error', 'Your Data Failed To Import');
        } else {
            Excel::import(new UsersImport, request()->file('import'));
            return redirect(route('member'))->with('success', 'Your Data Successfuly To Import');
        }
    }

    public function export_excel()
    {
        return Excel::download(new UsersExport, 'data_user_aktif.xlsx');
    }
}