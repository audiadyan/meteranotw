@extends('layouts.layout-global')

@section('global_layout')
    <div class="p-4 lg:m-auto my-auto">
        <div class="p-10 border-2 border-gray-200 max-w-5xl border-dashed rounded-lg">
            <div class="text-center mb-5 font-medium text-5xl text-center border-b-2 text-gray-500">
                {{ $name }}
            </div>

            <div class="flex justify-center h-[500px]" id="accesscode-qr">
            </div>

            <div class="space-y-5 mt-5">
                <div class="text-center">
                    <div class="font-medium text-3xl text-center border-b-2 text-gray-500">
                        ID
                    </div>
                    <p class="medium text-gray-700 text-3xl" id="meter-id">{{ $id }}</p>
                </div>

                <div class="text-center">
                    <div class="font-medium text-3xl text-center border-b-2 text-gray-500">
                        Kode Akses
                    </div>
                    <p class="medium text-gray-700 text-3xl" id="generate-code">{{ $code }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_head')
    {{-- qrcodejs --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endsection

@section('script')
    <script>
        new QRCode("accesscode-qr").makeCode("{{ route('monitoring', ['id' => 'currId', 'code' => 'currCode']) }}"
            .replace("currCode", "{{ $code }}")
            .replace("currId", "{{ $id }}")
            .replace("amp;", ""));

        window.onafterprint = window.close;
        window.print();
    </script>
@endsection
