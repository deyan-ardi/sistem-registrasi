<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Detail;
use App\Mail\SendEmailReminder;
use App\Setting;
use App\User;
use App\Vote;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class DetailController extends Controller
{
    //

    public function index(Vote $vote)
    {
        $detail = User::where('vote_id', $vote->id)->get();
        $active = Vote::where('status', '1')->first();
        $user = User::get();
        $setting = Setting::first();
        return view('user.page.detail', ['setting'=>$setting,"detail_all" => $detail, "sidebar" => 3, 'admin' => $vote, 'user_all' => $user, 'activity' => $active]);
    }

    public function update(Vote $vote)
    {
        $user = User::get();
        if ($vote->status == 1) {
            foreach ($user as $u) {
                $u->vote_id = $vote->id;
                $u->save();
            }
            return redirect(route('management-evote', [$vote->id]))->with('success', 'Member Succesfully Synchronization ');
        } else {
            return redirect(route('management-evote', [$vote->id]))->with('error', 'Vote Activity Not Activate ');
        }
    }

    public function reminder(User $user, Vote $vote)
    {
        if ($vote->status == 1) {
            $details = [
                'title' => 'Mail from Evoting System',
                'body' => 'This is for testing email using smtp'
            ];
            if(!empty($user->email_verified_at)){
                Mail::to($user->email)->send(new SendEmailReminder($details));
                if (Mail::failures()) {
                    return redirect(route('management-evote', [$vote->id]))->with('error', 'Email Failed To Send ');
                }
                return redirect(route('management-evote', [$vote->id]))->with('success', 'Email Successfully To Send ');
            }
        } else {
            return redirect(route('management-evote', [$vote->id]))->with('error', 'Vote Activity Not Activate ');
        }
    }

    public function reminder_all(Vote $vote)
    {
        if ($vote->status == 1) {
            $details = [
                'title' => 'Mail from Evoting System',
                'body' => 'This is for testing email using smtp'
            ];
            $user = User::where('vote_id', $vote->id)->get();
            $arr_email = array();
            foreach ($user as $u) {
                if (!empty($u->email_verified_at)) {
                    array_push($arr_email, $u->email);
                }
            }
            Mail::to($arr_email)->send(new SendEmailReminder($details));
            if (Mail::failures()) {
                return redirect(route('management-evote', [$vote->id]))->with('error', 'Email Failed To Send ');
            }
            return redirect(route('management-evote', [$vote->id]))->with('success', 'Email Successfully To Send ');
        } else {
            return redirect(route('management-evote', [$vote->id]))->with('error', 'Vote Activity Not Activate ');
        }
    }

    public function activity()
    {
        $active = Vote::where('status', '1')->first();
        if (!empty($active)) {
            $all_candidate = $active->candidate->sortBy('order');
            $setting = Setting::first();
            return view('user.page.activity', ['setting'=>$setting,'all_candidate' => $all_candidate, 'sidebar' => 4, 'activity' => $active]);
        } else {
            abort(404);
        }
    }

    public function vote(Vote $vote, User $user, Candidate $candidate)
    {
        $detail_user = Detail::where('user_id',$user->id)->first();
        if ($user->status_voting == '0' && $user->vote_id == $vote->id && is_null($detail_user)) {
            if ($user->member_id == request()->member_id) {
                Detail::create([
                    'ip_address' => request()->ip(),
                    'user_id' => $user->id,
                    'vote_id' => $vote->id,
                    'candidate_id' => bcrypt($candidate->id),
                ]);
                // Set Status
                $user->status_voting = '1';
                $user->save();

                // Add Count
                $candidate->count = $candidate->count + 1;
                $candidate->save();
                $details = [
                    'title' => 'Mail from Evoting System',
                    'body' => 'This is for testing email using smtp'
                ];
                Mail::to($user->email)->send(new SendEmailReminder($details));
                if (Mail::failures()) {
                    return redirect(route('voting-activity', [$vote->id]))->with('error', 'Email Failed To Send ');
                }
                return redirect(route('voting-activity'))->with('success', 'Vote Successfully Add And Email Successfully Send');
            } else {
                if (Cookie::get('_auth_failed') > 3) {
                    Cookie::queue('_auth_allow', 1, 1);
                    Cookie::queue('_auth_failed', 0, 1);
                } else {
                    Cookie::queue('_auth_failed', Cookie::get('_auth_failed') + 1, 30);
                }
                return redirect(route('voting-activity'))->with('error', 'Wrong Member ID');
            }
        } else {
            return redirect(route('voting-activity'))->with('error', 'Can\t Vote, Activity Not Activate Or You Not Registered In This Activity');
        }
    }

    public function live(){
        $active = Vote::where('status', '1')->first();
        if (!empty($active)) {
            $sudah = User::where('status_voting','1')->where('vote_id',$active->id)->count();
            $belum = User::where('status_voting', '0')->where('vote_id', $active->id)->count();
            $candidate = Candidate::where('vote_id',$active->id)->get();
            $setting = Setting::first();
            return view('user.page.live', ['setting'=>$setting,'sidebar' => 4,'candidate'=> $candidate, 'activity' => $active,'sudah' => $sudah,'belum'=>$belum]);
        } else {
            abort(404);
        }
    }
}