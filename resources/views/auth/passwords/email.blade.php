<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link rel="stylesheet" href="{{ asset('src/login.css') }}"> --}}
    {{-- @vite('resources/css/app.css') --}}
    <title>GoodGoods | Forgot Password</title>
</head>

<body>
    <section class="h-screen">
        <div class="px-6 h-full text-gray-800">
            <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
                <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
                    <h2 class="text-center mb-10 text-2xl">Forgot Your <span
                            class="text-blue-900 font-bold">Password</span></h2>
                    @if (session('status'))
                        <div class="alert alert-success" style="text-align: center; color: red">
                            {{ session('status') }}
                        </div>
                        <br>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <!-- Email input -->
                        <div class="mb-6">
                            <input id="email" name="email" type="text" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput1" placeholder="{{ __('Email Address') }}"
                                value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-center lg:text-left">
                            <button type='submit'
                                class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                {{ __('Send Password link') }}
                            </button>
                            <a href="{{ route('login') }}" type="submit"
                                class="inline-block px-7 py-3 bg-red-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
