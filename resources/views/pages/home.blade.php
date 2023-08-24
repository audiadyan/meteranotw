@extends('layouts.layout-public')

@section('public_layout')
    <div class="p-4 m-auto">
        <div class="p-4 border-2 border-gray-200 max-w-5xl border-dashed rounded-lg">
            <div class="p-4 rounded bg-gray-50">
                <div class="font-medium text-xl text-center border-b-2 mb-3 text-gray-500">Monitoring
                </div>
                <form action="{{ route('monitoring') }}">
                    <div class="flex items-center space-y-3 flex-col flex-wrap">
                        <div>
                            <span class="label-text">ID</span>
                            <div class="flex space-x-5">
                                <input type="text" name="id" placeholder="*****" class="input input-bordered flex-1"
                                    required />
                            </div>
                        </div>
                        <div>
                            <span class="label-text">Kode Akses</span>
                            <div class="flex space-x-5">
                                <input type="text" name="code" placeholder="*****" class="input input-bordered flex-1"
                                    required />
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="text-white bg-green-700 hover:bg-green-800 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2">Monitoring</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
