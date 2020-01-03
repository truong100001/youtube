@extends('master')

@section('content')
    @if(session('message'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Thông báo',
                text:"{{session('message')}}",
            });
        </script>
    @endif
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="public_admin/images/icon/logo-tovi.png" alt="CoolAdmin">
                        </a>
                    </div>
                    <div class="login-form">
                        <form action="{{asset('/login')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                @if($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                @if($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection