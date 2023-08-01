<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>GoodGoods | Seller Register</title>
    <style>
        ::title="required" placeholder {
            color: red;
        }
    </style>
</head>

<body>
    <section class="h-screen">
        <div class="px-6 h-full text-gray-800">
            <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
                <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
                    <!-- <?php if (isset($_SESSION['error'])) { ?> -->
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3"
                        id="warningMsg" role="alert">
                        <span class="block sm:inline">
                            <!-- <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            // session_destroy();
                            ?> -->
                        </span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" id="toggle"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                            </svg>
                        </span>
                    </div>

                    <script>
                        const targetDiv = document.getElementById("warningMsg");
                        const btn = document.getElementById("toggle");
                        btn.onclick = function() {
                            if (targetDiv.style.display !== "none") {
                                targetDiv.style.display = "none";
                            } else {
                                targetDiv.style.display = "block";
                            }
                        };
                    </script>
                    <!-- <?php } ?> -->
                    <h2 class="text-center mb-10 text-2xl">Create Your <a href="{{ route('front.home') }}"
                            class="text-blue-900 font-bold">GoodGoods</a> Seller Account</h2>
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
                    <form method="POST" action="{{ route('seller.register.store') }}">
                        @csrf
                        <!-- Account type input -->
                        <div class="mb-6">
                            <select name="shop_type" id="shop_type"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                <option value="" disabled selected class="text-gray-700 bg-white"
                                    title="required">--Select
                                    Account type-- *</option>
                                <option value="business">Business</option>
                            </select>
                            @error('shop_type')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Store Based In input -->
                        <div class="mb-6">
                            <select name="based_in" id="based_in"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                <option value="" disabled selected class="text-gray-700 bg-white"
                                    title="required">--Select
                                    Shop Based In-- *</option>
                                <option value="Nepal">Nepal</option>
                            </select>
                            @error('based_in')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Shop Name input -->
                        <div class="mb-6">
                            <input id="full_name" name="full_name" type="text" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput1" title="required" placeholder="{{ __('Full Name') }} *" />
                            @error('full_name')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Phone Number input -->
                        <div class="mb-6">
                            <input id="phone" name="phone" type="number" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput1" title="required" placeholder="{{ __('Phone Number') }} *" />
                            @error('phone')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email input -->
                        <div class="mb-6">
                            <input id="email" name="email" type="text" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput1" title="required"
                                placeholder="{{ __('Email Address') }} *" />
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
                                title="required" placeholder="{{ __('Password') }} *" />
                            @error('password')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password input -->
                        <div class="mb-6">
                            <input id="password-confirm" type="password" name="password_confirmation" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                title="required" placeholder="{{ __('Confirm Password') }} *" />
                            @error('password_confirmation')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <!-- Shop Name input -->
                        <div class="mb-6">
                            <input id="shop_name" name="shop_name" type="text" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlInput1" title="required"
                                placeholder="{{ __('Shop Name') }} *" />
                            @error('shop_name')
                                <span class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Address input -->
                        {{-- <div class="mb-6">
                            <input id="address" type="address" name="address" required
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                title="required" placeholder="{{ __('Shop Address') }}" />
                        </div> --}}

                        <div class="text-center lg:text-left">
                            <button type='submit'
                                class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
