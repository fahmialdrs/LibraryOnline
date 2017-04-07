<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreMemberRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UpdateMemberRequest;


class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if($request->ajax()) {
            $members = Role::where('name', 'member')->first()->users;
            return Datatables::of($members)
            ->addColumn('name', function($member){
                return '<a href="'.route('member.show', $member->id).'">'.$member->name.'</a>';
            })
            ->addColumn('action', function($member){
                return view('datatable._action', [
                    'model' => $member,
                    'form_url' => route('member.destroy', $member->id),
                    'edit_url' => route('member.edit', $member->id),
                    'confirm_message' => 'Are you sure want to delete' . $member->name . '?'
                    ]);
            })->make(true);
        }

        $html = $htmlBuilder
        ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Name'])
        ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false, 'searchable' => false]);
        return view('members.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        $password = str_random(6);
        $data = $request->all();
        $data['password'] = bcrypt($password);

        // bypass verifikasi
        $data['is_verified'] = 1;

        $member = User::create($data);

        // set role
        $memberRole = Role::where('name', 'member')->first();
        $member->attachRole($memberRole);

        // kirim email
        Mail::send('auth.email.invite', compact('member', 'password'), function ($m) use ($member) {
            $m->to($member->email, $member->name)->subject('You already registered in Online Library');
        });

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Store Member " . "<strong>" . $data['email'] ."</strong>" . " Password <strong>" . $password . "</strong>" 
            ]);
        return redirect()->route('member.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = User::find($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $member = User::find($id);
       return view('members.edit')->with(compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $member = User::find($id);
        $member->update($request->only('name','email'));

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Member $member->name updated!"
            ]);

        return redirect()->route('member.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = User::find($id);
        if($member->hasRole('member')) {
            $member->delete();

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Member $member->name has been deleted"
                ]);
        }

        return redirect()->route('member.index');
    }
}
