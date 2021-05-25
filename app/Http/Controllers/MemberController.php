<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Mail\SendEmailReminder;
use App\Setting;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Excel;
use Illuminate\Support\Facades\Mail;

class MemberController extends Controller
{
    protected function validator(array $data)
    {
        if ($data['edit'] == 1) {
            $cariData = User::find($data['id']);
            if ($data['member_id'] == $cariData->member_id) {
                $member_id = ['required', 'integer', 'digits_between:3,20'];
            } else {
                $member_id = ['required', 'integer', 'unique:users', 'digits_between:3,20'];
            }
            if ($data['email'] == $cariData->email) {
                $email = ['nullable', 'string', 'email', 'max:255',];
            } else {
                $email = ['nullable', 'unique:users', 'string', 'email', 'max:255'];
            }
            if ($data['nik'] == $cariData->nik) {
                $nik = ['required', 'integer', 'digits_between:3,30'];
            } else {
                $nik = ['required', 'integer', 'unique:users', 'digits_between:3,30'];
            }
        } else {
            $member_id = ['required', 'integer', 'unique:users', 'digits_between:3,20'];
            $nik = ['required', 'integer', 'unique:users', 'digits_between:3,30'];
            $email = "";
        }
        return Validator::make($data, [
            'member_id' => $member_id,
            'email' => $email,
            'nik' => $nik,
            'password' => ['nullable', 'string', 'min:8', 'required_with:repassword', 'same:repassword'],
            'repassword' => ['nullable', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required'],
        ]);
    }
    public function index()
    {
        $member = User::get();
        $setting = Setting::first();
        return view('user.page.member', ['setting' => $setting, 'member_all' => $member, 'sidebar' => 2]);
    }

    public function create()
    {
        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('member'))->with('error', 'Member Failed To Added');
        } else {
            User::create(['nik' => request()->nik,
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
                User::where('id', request()->id)->update(['nik' => request()->nik,
                    'member_id' => request()->member_id,
                    'name' => request()->name,
                    'email' => request()->email,
                    'password' => Hash::make(request()->password),
                    'level' => request()->level,
                ]);
            } else if (!empty(request()->email)) {
                User::where('id', request()->id)->update(['nik' => request()->nik,
                    'member_id' => request()->member_id,
                    'name' => request()->name,
                    'email' => request()->email,
                    'level' => request()->level,
                ]);
            } else {
                User::where('id', request()->id)->update(['nik' => request()->nik,
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

    public function update_profil(User $member)
    {
        $validator = Validator::make(request()->all(), [
            'phone' => ['required', 'string', 'digits_between:9,15'],
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
            $member->name = request()->name_login;
            $member->phone = request()->phone;
            $member->image = $path;
            $member->save();
            return redirect(route('edit-profil'))->with('success', 'Your Data Successfuly Update');
        }
    }

    public function update_keamanan(User $member)
    {
        if (request()->email == $member->email) {
            $val = ['required', 'email'];
        } else {
            $val = ['required', 'email', 'unique:users'];
        }
        $validator = Validator::make(request()->all(), [
            'password_login' => ['nullable', 'string', 'min:8', 'required_with:repassword_login', 'same:repassword_login'],
            'repassword_login' => ['nullable', 'string', 'min:8'],
            'email' => $val,
        ]);
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('member'))->with('error', 'Your Data Failed To Update');
        } else {
            if (request()->email == $member->email) {
                $email = $member->email;
                $re_email = NULL;
            } else {
                $email = NULL;
                $string = "0123456789bcdfghjklmnpqrstvwxyz";
                $token = substr(str_shuffle($string), 0, 50);
                if (!empty(request()->password_login)) {
                    $password = Hash::make(request()->password_login);
                } else {
                    $password = $member->password;
                }
                $member->re_email = request()->email;
                $member->re_token = $token;
                $member->re_expired = time() + 1800;
                $member->password = $password;
                $member->save();
                $details = [
                    'link' => url(route('change-email', [$member->id, 'expired' => $member->re_expired, 'token' => $member->re_token])),
                ];
                Mail::to(request()->email)->send(new SendEmailReminder($details));
                if (Mail::failures()) {
                    return redirect()->back()->with('error', 'Email Failed To Send ');
                }
                return redirect()->back()->with('success', 'Please Check Your New Email For Verification Change Email ');
            }
            if (!empty(request()->password_login)) {
                $password = Hash::make(request()->password_login);
            } else {
                $password = $member->password;
            }
            $member->re_email = $re_email;
            $member->email = $email;
            $member->password = $password;
            $member->save();
            return redirect(route('edit-profil'))->with('success', 'Your Data Successfuly Update');
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
            $file = request()->file('import')->store('import');
            $import = new UsersImport;
            $import->import($file);
            return redirect(route('member'))->with('success', 'Your Data Successfuly To Import');
        }
    }

    public function export_excel()
    {
        return Excel::download(new UsersExport, 'data_user_aktif.xlsx');
    }

    public function show_profil()
    {
        $setting = Setting::first();
        return view('user.page.profil', ['sidebar' => 3, 'setting' => $setting]);
    }

    public function change_email(User $member)
    {
        if (!empty($member) && !empty($member->re_email) && !empty($member->re_token) && !empty($member->re_expired)) {
            if ($member->re_token == request()->token) {
                if (time() <= $member->re_expired) {
                    $member->email = $member->re_email;
                    $member->re_token = NULL;
                    $member->re_email = NULL;
                    $member->re_expired = NULL;
                    $member->save();
                    Auth::logout();
                    return redirect(route('login'))->with('success', 'Your Email Successfuly Update, Please Login Again');
                } else {
                    return abort(403, 'Expired');
                }
            } else {
                return abort(403, 'Invalid Signature');
            }
        } else {
            return abort(403, 'Invalid Signature');
        }
    }
}