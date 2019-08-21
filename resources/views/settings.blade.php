@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading h3">Sekcja ustawień konta</div>
                    <div class="panel-body">

                        @if(Session::has('nameSuccessUpdated'))
                            <div class="alert alert-success card">
                                {{ Session::get('nameSuccessUpdated') }}
                            </div>
                        @endif

                        @if(Session::has('emailSuccessUpdated'))
                            <div class="alert alert-success card">
                                {{ Session::get('emailSuccessUpdated') }}
                            </div>
                        @endif

                        @if(Session::has('passwordSuccessUpdated'))
                            <div class="alert alert-success card">
                                {{ Session::get('passwordSuccessUpdated') }}
                            </div>
                        @endif

                            <div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td><div class="text-center h4" style="margin-top: 8px"><a href="{{ action('SettingsController@editName') }}">Edytuj nazwę</a></div></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td><div class="text-center h4" style="margin-top: 8px"><a href="{{ action('SettingsController@changeEmail') }}">Zmień adres email</a></div></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td><div class="text-center h4" style="margin-top: 8px"><a href="{{ action('SettingsController@changePassword') }}">Zmień hasło</a></div></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td><div class="text-center h4" style="margin-top: 8px"><a href="{{ action('SettingsController@confirmDeleteAccount') }}">Usuń konto</a></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection