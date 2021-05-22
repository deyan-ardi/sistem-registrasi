<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Setting;
use App\Vote;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{

    public function index(Vote $vote)
    {
        $candidate = Candidate::where('vote_id',$vote->id)->orderBy('order','ASC')->get();
        $active = Vote::where('status', '1')->first();
        $setting = Setting::first();
        return view('user.page.candidate', ['setting'=>$setting,'candidate_all' => $candidate, 'sidebar' => 3, 'admin' => $vote,'activity' => $active]);
    }

    protected function validator(array $data)
    {
        if($data['edit'] == 1){
            $image = 'mimes:jpeg,png|max:1024|image';
        }else{
            $image = 'required|mimes:jpeg,png|max:1024|image';
        }
        return Validator::make($data, [
            'image' => $image,
            'order' => 'required|integer',
            'name' => 'required',
            'description' => 'required',
        ]);
    }

    public function create()
    {
        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('management-candidate', [request()->id_kegiatan]))->with('error', 'Something Wrong, Please Check Your Input');
        } else {
            $cekKegiatan = Vote::find(request()->id_kegiatan);
            if(!empty($cekKegiatan) && $cekKegiatan->status == '1'){
                $imagePath = request()->file('image');
                $path = $imagePath->store("candidate");
                Candidate::create([
                    'vote_id' => request()->id_kegiatan,
                    'order' => request()->order,
                    'name' => request()->name,
                    'description' => request()->description,
                    'image' => $path,
                ]);
                return redirect(route('management-candidate', [request()->id_kegiatan]))->with('success', 'Candidate Successfully Add ');
            }else{
                return redirect(route('management-candidate', [request()->id_kegiatan]))->with('error', 'Can\'t Add Candidate To Non Activate Vote Activity');
            }
        }
    }

    public function update(Candidate $candidate){

        $validator = $this->validator(request()->all());
        if ($validator->fails()) {
            $validator->validate();
            return redirect(route('management-candidate', [request()->id_kegiatan]))->with('error', 'Something Wrong, Please Check Your Input');
        } else {
            $cekKegiatan = Vote::find(request()->id_kegiatan);
            if (!empty($cekKegiatan) && $cekKegiatan->status == '1') {
                if(request()->file('image')){
                    Storage::delete($candidate->image);
                    $imagePath = request()->file('image');
                    $path = $imagePath->store("candidate");
                }else{
                    $path = $candidate->image;
                }
                
                Candidate::find($candidate->id)->update([
                    'order' => request()->order,
                    'name' => request()->name,
                    'description' => request()->description,
                    'image' => $path,
                ]);
                return redirect(route('management-candidate', [request()->id_kegiatan]))->with('success', 'Candidate Successfully Update ');
            } else {
                return redirect(route('management-candidate', [request()->id_kegiatan]))->with('error', 'Can\'t Add Candidate To Non Activate Vote Activity');
            }
        }
    }

    public function destroy(Candidate $candidate,Vote $vote){
        if($vote->status == '1' && $candidate->vote_id == $vote->id){
            Storage::delete($candidate->image);
            $candidate->delete();
            return redirect(route('management-candidate', [$vote->id]))->with('success', 'Candidate Successfully Delete ');
        }else{
            return redirect(route('management-candidate', [$vote->id]))->with('error', 'Can\'t Delete Candidate In Non Activate Vote Activity');
        }
    }
}