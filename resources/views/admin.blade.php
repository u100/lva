@extends('layouts.app')

@section('content')
    <?php
    use App\User;
    use App\PrivilegedAccount;
    $user = User::find(Auth::id());
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading h3">Użytkownicy</div>
                    <div class="panel-body">
                    @if(Session::has('changedToAdmin'))
                        <div class="alert alert-warning card">
                            {{ Session::get('changedToAdmin') }}
                        </div>
                    @endif

                    @if(Session::has('passwordSuccessUpdated'))
                        <div class="alert alert-warning card">
                            {{ Session::get('passwordSuccessUpdated') }}
                        </div>
                    @endif

                     @if(Session::has('userLocked'))
                        <div class="alert alert-danger card">
                            {{ Session::get('userLocked') }}
                        </div>
                    @endif

                    @if(Session::has('accountDeleted'))
                        <div class="alert alert-success card">
                            {{ Session::get('accountDeleted') }}
                        </div>
                    @endif
                            <div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th>Email</th>
                                        <th>Nazwa</th>
                                        <th>Uprawnienia</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                       <?php for($i = 0; $i < count($usersList); $i++){?>
                                       <?php $privilegedAdmin = PrivilegedAccount::where('email', '=', $usersList[$i]->email)->where('admin_status', '=', 1)->first();?>
                                        <tr>
                                            <td><div class="text-center text-primary" style="margin-top: 8px">{{$usersList[$i]->email}}</div></td>
                                            <td><div class="text-center" style="margin-top: 8px">{{$usersList[$i]->name}}</div></td>

                                            <?php
                                            if(!empty($privilegedAdmin)){?>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('AdminController@changeToUser', $usersList[$i]->id) }}" class="btn btn-primary btn-block">Admin</a></div></td>
                                            <?php }else{?>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('AdminController@changeToAdmin', $usersList[$i]->id) }}" class="btn btn-info btn-block">User</a></div></td>
                                            <?php } ?>
                                            <?php
                                            $privilegedBlocked = PrivilegedAccount::where('email', '=', $usersList[$i]->email)->where('admin_status', '=', 2)->first();
                                            if(!empty($privilegedBlocked)){?>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('AdminController@unlockAccount', $usersList[$i]->id) }}" class="btn btn-danger">Zablokowany</a></div></td>
                                            <?php }else{?>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('AdminController@lockAccount', $usersList[$i]->id) }}" class="btn btn-warning">Odblokowany</a></div></td>
                                            <?php } ?>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('AdminController@changePasswordByAdmin', $usersList[$i]->id) }}" class="btn btn-success">Zmień hasło</a></div></td>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('AdminController@confirmDeleteAccountByAdmin', $usersList[$i]->id) }}" class="btn btn-danger">Usuń</a></div></td>
                                        </tr>
                                        <?php }?> 
                                    </tbody>
                                    </table>
                                    <a href="{{ URL::previous() }}" class="text-primary h4">Wróć do poprzedniej strony</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection