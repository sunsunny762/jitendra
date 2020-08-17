<?php

namespace App\Http\Controllers;

use App\User;
use App\Notification\EmailNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = new User;
        $users = $users->getResult($request);
        return view('admin.modules.user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.modules.user.addedit')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $request = $this->stripHtmlTags($request, User::$notStripTags);
        $rules = [
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->whereNull('deleted_at')],
            'first_name' => 'required',
        ];
        $this->validate($request, $rules);

        $user = User::withTrashed()->where('email', $request->get('email'))->first();

        if (!empty($user->id)) {
            // Restore user account if already exist
            $user->restore();

            // Update user data.
            $data = $request->all();
            $password = str_random(8);
            $data['deleted_at'] = null;
            $data['password'] = Hash::make($password);
            $data['status'] = 0;
            $data['user_type_id'] = 2;
            $user->fill($data);
            $user->save();
            $message = 'user.restored_success';
            $user->notify(new EmailNotification($password));
        } else {
            // Save the User Data
            $user = new User;
            $user->fill($request->all());
            $user->save();
            $message = 'user.create_success';
        }

        if ($request->get('btnsave') == 'savecontinue') {
            return redirect()->route('user.edit', ['id' => $user->id])->with("success", __($message, ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name')]));
        } elseif ($request->get('btnsave') == 'save') {
            return redirect()->route('user.index')->with("success", __($message, ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name')]));
        } else {
            return redirect()->route('user.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.modules.user.addedit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request = $this->stripHtmlTags($request, User::$notStripTags);
        $id = $user->id;
        $rules = [
            'email' => "required|email:rfc,dns|unique:users,email,{$id},id,deleted_at,NULL",
            'first_name' => 'required'
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        unset($data['email']);
        $validate = 'yes';

        if ($validate == 'not') {
            \Session::flash('success', __('user.update_status_not_valid', ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name')]));
        } else {
            \Session::flash('success', __('user.update_success', ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name')]));
        }
        // Save the User Data
        $user->fill($data);
        $user->save();

        if ($request->get('btnsave') == 'savecontinue') {
            return redirect()->back();
        } elseif ($request->get('btnsave') == 'save') {
            return redirect()->route('user.index');
        } else {
            return redirect()->route('user.index');
        }
    }
}
