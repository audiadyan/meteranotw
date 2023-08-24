@extends('layouts.layout-global')

@section('global_layout')
    <div class="m-auto p-10 rounded-xl shadow-lg bg-white w-3/6 h-3/6">
        <div>
            <span class="label-text">Meteran</span>
            <div class="flex space-x-5">
                <input id="id" type="number" placeholder="ID Meteran" class="input input-bordered flex-1" required />
                <input id="password" type="text" placeholder="Password" class="input input-bordered flex-1" />
                <button onclick="addKwhData()" class="btn rounded-xl">Tambah</button>
            </div>
        </div>

        <div class="mt-5">
            <span class="label-text">Set Token (kWh)</span>
            <div class="flex space-x-5">
                <input id="token" type="number" step="0.001" class="input input-bordered flex-1" placeholder="5" />
                <button onclick="setToken()" class="btn rounded-xl">Simpan</button>
            </div>
        </div>

        <div class="mt-5">
            <span class="label-text">Set Limit Buzzer (kWh)</span>
            <div class="flex space-x-5">
                <input id="limit" type="number" step="0.001" class="input input-bordered flex-1" placeholder="2" />
                <button onclick="setLimit()" class="btn rounded-xl">Simpan</button>
            </div>
        </div>

        <div class="mt-5">
            <span class="label-text">Set Max Power (Watt)</span>
            <div class="flex space-x-5">
                <input id="max" type="number" step="1" class="input input-bordered flex-1" placeholder="450" />
                <button onclick="setMax()" class="btn rounded-xl">Simpan</button>
            </div>
        </div>

        <div class="mt-5">
            <span class="label-text">Set API Server</span>
            <div class="flex space-x-5">
                <input id="server" type="text" class="input input-bordered flex-1"
                    placeholder="http://127.0.0.1:8000/api/" />
                <button onclick="setServer()" class="btn rounded-xl">Simpan</button>
            </div>
        </div>
    </div>
@endsection

@section('script_head')
    {{-- MQTT --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"></script>
@endsection

@section('script')
    <script>
        // our data

        const id = document.getElementById('id');
        const token = document.getElementById('token');
        const limit = document.getElementById('limit');
        const max = document.getElementById('max');
        const server = document.getElementById('server');

        // end our data

        // request method ====================================================================

        function myHttpPostRequest(url, data) {
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(response => response)
        }

        async function addKwhData() {
            const url = "{{ route('addKwh') }}";
            const data = {
                "id": id.value,
                "password": password.value
            };

            myHttpPostRequest(url, data);
        }


        // end request method ====================================================================

        // mqtt ====================================================================

        // mqtt configuration
        const host = "broker.hivemq.com";
        const port = 8000;
        const clientId = "clientID-" + parseInt(Math.random() * 100);

        // Create a client instance
        var client = new Paho.Client(host, Number(port), clientId);

        // set callback handlers
        client.onConnectionLost = onConnectionLost;

        // connect the client
        function connect() {
            client.connect({
                onSuccess: onConnect
            });
        }

        // called when the client connects
        function onConnect() {
            console.log("onConnect");
        }

        // called when the client loses its connection
        function onConnectionLost(responseObject) {
            if (responseObject.errorCode !== 0) {
                console.log("onConnectionLost:" + responseObject.errorMessage);

                setTimeout(function() {
                    connect();
                }, 5000);
            }
        }

        function setToken() {
            const msg = {
                token: token.value
            };

            sendMessage(msg, "kwh/set/");
        }

        function setLimit() {
            const msg = {
                max: false,
                limit: limit.value
            };

            sendMessage(msg, "kwh/limit/");
        }

        function setMax() {
            const msg = {
                max: true,
                limit: max.value
            };

            sendMessage(msg, "kwh/limit/");
        }

        function setServer() {
            const msg = {
                server: server.value
            };

            sendMessage(msg, "kwh/server/");
        }

        function sendMessage(data, topic) {
            message = new Paho.Message(JSON.stringify(data));
            message.destinationName = topic + id.value;
            client.send(message);
        }

        connect();

        // end mqtt ====================================================================
    </script>
@endsection
