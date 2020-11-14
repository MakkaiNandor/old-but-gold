@extends('layouts.app')

@section('content')
    <div id="content" class="container">
        <div id="section-one" class="section">
            <div id="avatar">{{ strtoupper($user->username[0]) }}</div>
            <span>{{ $user->username }}</span>
            <p>{{ $user->email }}</p>
            <p>{{ "Registration date: " . $user->created_at }}</p>
        </div>
        <hr />
        <div class="section">
            <p>{{ "Lvl. " . $user->level }}</p>
            <p>{{ $user->experience_points . " XP" }}</p>
            <p>{{ "Played games: " . $user->played_games }}</p>
            <p>{{ "Victories: " . $user->victories }}</p>
            <p>{{ "Defeats: " . $user->defeats }}</p>
        </div>
        <hr />
        <div class="section">
            <p><a id="change-password-link" href="#">Change password</a></p>
            <p><a id="change-username-link" href="#">Change username</a></p>
            <p><a id="delete-account-link" href="#" style="color: red;">Delete account</a></p>
        </div>
    </div>

    <div id="blur" class="d-none">
        <div id="change-password" class="pop-up d-none">
            <p class="title">Change Password</p>
            <hr/>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div class="form-group row text-center">
                    <label for="old-password">Old Password:</label>
                    <div class="col-md-6">
                        <input type="password" name="old-password"/>
                        @error('old-password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="confirm-password">Confirm Password:</label>
                    <div class="col-md-6">
                        <input type="password" name="confirm-password"/>
                        @error('confirm-password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new-password">New Password:</label>
                    <div class="col-md-6">
                        <input type="password" name="new-password"/>
                        @error('new-password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Change password
                        </button>
                    </div>
                </div>

            </form>
            <button id="pwd" class="back-button btn btn-danger">Back</button>
        </div>
        <div id="change-username" class="pop-up d-none">
            <p class="title">Change Username</p>
            <button id="usr" class="back-button btn btn-danger">Back</button>
        </div>
        <div id="delete-account" class="pop-up d-none">
            <p class="title">Delete Account</p>
            <button id="acc" class="back-button btn btn-danger">Back</button>
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        #avatar {
            display: inline-block;
            width: 50px;
            height: 50px;
            border: 2px solid black;
            border-radius: 50%;
            background-color: blue;
            color: white;
            text-align: center;
            font-size: 23pt;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #section-one span {
            line-height: 50px;
            padding: 20px;
            font-size: 18pt;
        }

        .section p {
            margin-left: 40px;
        }

        #blur {
            position: absolute;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.6);
            height: 100vh;
            width: 100%;
        }

        .pop-up {
            width: 50%;
            padding: 20px;
            margin-right: auto;
            margin-left: auto;
            margin-top: 200px;
            background: white;
            border: 1px solid gray;
            border-radius: 50px;
            text-align: center;
        }

        .title {
            font-size: 18pt;
            color: blue;
        }
    </style>
@endsection

@section('page_script')
    <script>
        // var changePasswordLink, changeUsernameLink, deleteAccountLink;
        var blurBackground, changePasswordDiv, changeUsernameDiv, deleteAccountDiv;

        window.onload = function() {
            blurBackground = document.getElementById('blur');
            changePasswordDiv = document.getElementById('change-password');
            changeUsernameDiv = document.getElementById('change-username');
            deleteAccountDiv = document.getElementById('delete-account');

            // changePasswordLink = document.getElementById('change-password-link');
            // changeUsernameLink = document.getElementById('change-username-link');
            // deleteAccountLink = document.getElementById('delete-account-link');

            document.getElementById('change-password-link').addEventListener('click', onChangePassword);
            document.getElementById('change-username-link').addEventListener('click', onChangeUsername);
            document.getElementById('delete-account-link').addEventListener('click', onDeleteAccount);

            for(var backBtn of document.getElementsByClassName('back-button')){
                backBtn.addEventListener('click', onBack);
            }
        }

        function onChangePassword(event){
            blurBackground.classList.toggle('d-none');
            changePasswordDiv.classList.toggle('d-none');
        }

        function onChangeUsername(event){
            blurBackground.classList.toggle('d-none');
            changeUsernameDiv.classList.toggle('d-none');
        }

        function onDeleteAccount(event){
            blurBackground.classList.toggle('d-none');
            deleteAccountDiv.classList.toggle('d-none');
        }

        function onBack(event){
            switch(event.target.id){
                case "pwd":
                    changePasswordDiv.classList.toggle('d-none');
                    break;
                case "usr":
                    changeUsernameDiv.classList.toggle('d-none');
                    break;
                case "acc":
                    deleteAccountDiv.classList.toggle('d-none');
                    break;
                default: break;
            }
            blurBackground.classList.toggle('d-none');
        }
    </script>
@endsection