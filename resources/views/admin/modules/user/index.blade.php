@extends('admin.layouts.app')
@section('content')
<div class="row mx-0 mb-3">
    <div class="col-6">
        <h1 class="page-title"><?php echo __('user.pagetitle'); ?></h1>
    </div>
    <div class="top-btn-box col-6" id="normal_btns">
        <div class="top-btn-box d-flex justify-content-end align-items-center h-100">
            <a tabindex="2" href="{{route('user.create')}}" class="btn btn-primary addnew-btn btn-sm" id="add-btn">
                <i class="icon-addnew top-icon"></i>
                <span class="btn-title">{{ __('common.add') }}</span>
            </a>
        </div>
    </div>
</div>
@if ($errors->has('email'))
<div class="row mb-4 mt-2">
    <div class="col-md-12">
        <center class="error">
            <div class="errormessage">{{ $errors->first('email') }}</div>
        </center>
    </div>
</div>
@endif
        <div class="col-12 photos-main">
            <section id="wrapper">
                    @csrf
                    <input type="hidden" name="bulk-action" value="">
                    <table data-orders="4" data-target="3" class="admintable table table-hover mb-0" width="100%">
                        <thead>
                            <tr>
                                <th class="hide" scope="col">
                                </th>
                                <th class="active-box status-column" scope="col">
                                    <i class="sort"></i>
                                </th>
                                </th>
                                <th scope="col" class="control nosort">
                                </th>
                                <th scope="col">
                                    <div>
                                        <span>
                                            {{ __('user.name') }}
                                        </span>
                                    </div>
                                </th>
                                <th scope="col">
                                    <div>
                                        <span>
                                            {{ __('user.email') }}
                                        </span>
                                    </div>
                                </th>
                                <th scope="col">
                                    <div>
                                        <span>
                                            {{ __('user.created_at') }}
                                        </span>
                                    </div>
                                </th>
                                <th class="text-right nosort" scope="col">{{__('common.edit')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="active-box hide">
                                    <i style="display:none">{{ $user->fullname }}</i>
                                </td>
                                <td class="active-box">
                                    <i style="display:none">{{$user->status==2?0:$user->status}}</i>
                                        <span class="sort {{ $user->status == 1 ? 'active' : 'inactive' }} "></span>
                                </td>
                                <td>

                                </td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>

                                <td>
                                    <div class="email-add"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    </div>
                                </td>
                                <td data-sort="{{ \Carbon\Carbon::parse( $user->created_at)->format('Y/m/d H:i:s') }}">
                                {{ \Carbon\Carbon::parse( $user->created_at)->format('Y/m/d H:i:s') }}</td>
                                <td class="text-right">
                                    <a href="{{ route('user.edit', $user->id) }}"><i
                                            class="icon-edit-icon left"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @if ($users->total() == 0)
                            <tr class="noreocrd">
                                <td colspan="10" class="text-center">
                                    {{ __('user.no_result') }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
            </section>
        </div>
    </div>
</div>
@endsection
