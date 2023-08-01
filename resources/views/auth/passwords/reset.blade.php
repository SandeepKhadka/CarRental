<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>GoodGoods | Reset Password</title>
</head>

<body>
    <section class="h-screen">
        <div class="px-6 h-full text-gray-800">
            <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
                <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
                    <h2 class="text-center mb-10 text-2xl">Reset Your Password</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Oh sorry!</strong>There were some issues with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <!-- Email input -->
                        <div class="mb-6">
                            <input id="email" name="email" type="text" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput1" placeholder="{{ __('Email Address') }}"
                                value="{{ $email ?? old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password input -->
                        <div class="mb-6">
                            <input id="password" name="password" type="password" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput2" placeholder="{{ __('New Password') }}" />
                            @error('password')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div>
                                <input type="checkbox" onclick="myFunction()" style="margin-top: 10px"> Show Password
                            </div>
                        </div>

                        <div class="mb-6">
                            <input id="password-confirm" name="password_confirmation" type="password" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput2" placeholder="{{ __('Confirm Password') }}" />
                            @error('password_confirmation')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div><input type="checkbox" onclick="myFunction1()" style="margin-top: 10px"> Show Password
                            </div>
                        </div>

                        <div class="text-center lg:text-left">
                            <button type='submit'
                                class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                {{ __('Reset password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function myFunction1() {
            var y = document.getElementById("password-confirm");
            if (y.type === "password") {
                y.type = "teyt";
            } else {
                y.type = "password";
            }
        }
    </script>
</body>

</html>
