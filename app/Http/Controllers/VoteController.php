<?php

namespace App\Http\Controllers;

use App\Setting;
use App\User;
use App\Vote;
use DateTime;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{

    public function index()
    {
        $vote = Vote::get();
        $active = Vote::where('status', '1')->first();
        $setting = Setting::first();
        return view('user.page.vote', ['setting' => $setting, 'vote_all' => $vote, 'sidebar' => 3, 'activity' => $active]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'deskripsi' => 'required',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
        ]);
    }

    public function create()
    {
        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('vote'))->with('error', 'Something Wrong, Please Check Your Input');
        } else {
            if (strtotime(request()->end) - strtotime(request()->start) < 0) {
                return redirect(route('vote'))->with('error', 'Something Wrong, Please Check Your Datetime Input');
            } else {
                Vote::create([
                    'name' => request()->name,
                    'deskripsi' => request()->deskripsi,
                    'start' => request()->start,
                    'end' => request()->end,
                ]);
                return redirect(route('vote'))->with('success', 'Vote Activity Succesfully Added');
            }
        }
    }

    public function update()
    {
        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('vote'))->with('error', 'Something Wrong, Please Check Your Input');
        } else {
            if (strtotime(request()->end) - strtotime(request()->start) < 0) {
                return redirect(route('vote'))->with('error', 'Something Wrong, Please Check Your Datetime Input');
            } else {
                Vote::where('id', request()->id)->update([
                    'name' => request()->name,
                    'deskripsi' => request()->deskripsi,
                    'start' => request()->start,
                    'end' => request()->end,
                ]);
                return redirect(route('vote'))->with('success', 'Vote Activity Succesfully Update');
            }
        }
    }

    public function destroy(Vote $vote)
    {
        $activate = Vote::find($vote->id);
        if ($activate->status == 1) {
            return redirect(route('vote'))->with('error', 'Vote Activity Can\'t Be Deleted');
        } else {
            $activate->delete();
            return redirect(route('vote'))->with('success', 'Vote Activity Succesfully Delete');
        }
    }

    public function activate(Vote $vote)
    {
        $check_vote = Vote::where('status', '1')->count();
        if ($check_vote > 0) {
            return redirect(route('vote'))->with('error', 'Can\'t Activate Vote Activity, Disable Activate Activity First');
        } else {
            Vote::where('id', $vote->id)->update([
                'status' => '1',
            ]);
            $all_member = User::get();
            foreach ($all_member as $all) {
                $all->vote_id = $vote->id;
                $all->save();
            }
            return redirect(route('vote'))->with('success', 'Vote Activity Status Succesfully Update');
        }
    }

    public function disable(Vote $vote)
    {
        Vote::where('id', $vote->id)->update([
            'status' => '0',
        ]);
        $all_member = User::get();
        foreach ($all_member as $all) {
            $all->vote_id = 0;
            $all->save();
        }
        return redirect(route('vote'))->with('success', 'Vote Activity Status Succesfully Update');
    }

    public function administrator(Vote $vote)
    {
        $admin = Vote::find($vote->id);
        $vote_count = User::where('vote_id', $vote->id)->where('status_voting', '1')->count();
        $not_vote_count = User::where('vote_id', $vote->id)->where('status_voting', '1')->count();
        $setting = Setting::first();
        return view('user.page.admin', ['setting' => $setting, 'admin' => $admin, 'vote' => $vote_count, 'not_vote' => $not_vote_count, 'sidebar' => 3]);
    }
}