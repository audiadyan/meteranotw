<div class="min-h-screen py-6 flex flex-col justify-center overflow-hidden bg-cover sm:py-12"
    style="background-image: url('{{ asset('images/default-login.jpg') }}');">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div
            class="absolute inset-0 bg-gradient-to-r from-blue-300 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
        </div>
        <div class="relative px-4 py-10 bg-white shadow-lg sm:w-[500px] sm:rounded-3xl sm:p-14">
            <div class="max-w-md mx-auto">
                <div class="text-center">
                    <h1 class="text-4xl font-medium capitalize">{{ $status }}</h1>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        <form action="{{ $action }}" method="post">
                            @csrf

                            <div class="relative mb-6">
                                <input autocomplete="off" id="username" name="username" type="text"
                                    class="bg-white peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600"
                                    placeholder="username" value="{{ old('username') }}" autofocus required />
                                <label for="username"
                                    class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Username</label>
                            </div>

                            <div class="relative mb-2">
                                <input autocomplete="off" id="password" name="password" type="password"
                                    class="bg-white peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600"
                                    placeholder="password" required />
                                <label for="password"
                                    class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                            </div>

                            <div class="relative text-center mt-5">
                                <button type="submit"
                                    class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                    {{ $status }}
                                </button>

                                <p class="text-sm font-semibold mt-2 pt-1 mb-0 text-left">
                                    {{ $note }}
                                    <a href="{{ route($act . 'page') }}"
                                        class="text-red-600 capitalize hover:text-red-700 focus:text-red-700 transition duration-200 ease-in-out">
                                        {{ $act }}
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
