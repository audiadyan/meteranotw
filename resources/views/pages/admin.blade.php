@extends('layouts.layout-admin')

@section('admin_layout')
    <div class="p-4 md:ml-64" id="blank-section">
        <div class="h-[90vh] p-4 flex items-center border-2 border-gray-200 max-w-5xl border-dashed rounded-lg mt-14">
            <img src="{{ asset('images/logo.png') }}" class="mx-auto w-3/6" alt="">
        </div>
    </div>

    <div class="p-4 md:ml-64 hidden" id="select-section">
        <div class="p-4 border-2 border-gray-200 max-w-5xl border-dashed rounded-lg mt-14">
            <div class="flex justify-stretch p-4 rounded-t bg-gray-50 dark:bg-gray-800">
                <div class="basis-1/3">
                    <p class="text-md text-gray-600 dark:text-gray-500" id="meter-name">Meteran</p>
                </div>
                <div class="basis-1/3 flex justify-center items-center">
                    <button data-modal-target="defaultModal" data-modal-toggle="defaultModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-qr-code" viewBox="0 0 16 16">
                            <path d="M2 2h2v2H2V2Z" />
                            <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z" />
                            <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z" />
                            <path
                                d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z" />
                            <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z" />
                        </svg>
                    </button>
                </div>
                <div class="basis-1/3 flex justify-end my-auto">
                    <p class="text-md text-gray-600 dark:text-gray-500" id="meter-id">000000000000</p>
                </div>
            </div>

            <div class="mb-4">
                <button type="button" onclick="switchStatus()" id="off-button"
                    class="hidden w-full text-white bg-red-700 font-medium rounded-b text-sm px-5 py-2.5 text-center mr-2 mb-2 opacity-50 hover:opacity-100">Matikan</button>
                <button type="button" onclick="switchStatus()" id="on-button"
                    class="hidden w-full text-white bg-green-700 font-medium rounded-b text-sm px-5 py-2.5 text-center mr-2 mb-2 opacity-50 hover:opacity-100">Nyalakan</button>
            </div>

            <div class="p-4 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                <div class="font-medium text-xl text-center border-b-2 mb-2 text-gray-500 dark:text-gray-500">Tambah limit
                    token
                </div>
                <div class="flex items-center space-y-3 justify-between flex-wrap">
                    <div class="flex items-center flex-wrap">
                        <div class="mr-3">
                            <span class="label-text">Harga Jual (Rp)</span>
                            <div class="flex space-x-5">
                                <input id="token-sell" onkeyup="updateGetToken()" onchange="updateGetToken()" type="number"
                                    step="1" placeholder="Rp 500" class="input input-bordered flex-1" value="500"
                                    required />
                            </div>
                        </div>
                        <div class="mr-3">
                            <span class="label-text">Harga Beli (Rp)</span>
                            <div class="flex space-x-5">
                                <input id="token-buy" onkeyup="updateGetToken()" onchange="updateGetToken()" type="number"
                                    step="1000" placeholder="Rp 5000" class="input input-bordered flex-1" required />
                            </div>
                        </div>
                        <div class="mr-3">
                            <span class="label-text">Token didapat (kWh)</span>
                            <div class="flex space-x-5">
                                <input id="token-get" type="number" placeholder="0" class="input input-bordered flex-1"
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="button" onclick="addToken()" id="token-add-button"
                            class="text-white bg-green-700 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>Tambah</button>
                    </div>
                </div>

            </div>

            <div class="p-4 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                <div>
                    <div class="font-medium text-xl text-center border-b-2 mb-2 text-gray-500 dark:text-gray-500">Riwayat
                        Pemakaian
                    </div>
                </div>
                <div class="w-full h-full overflow-x-auto">
                    <div class="flex justify-center hidden" id="chart-loading">
                        @include('components.loading')
                    </div>
                    <div class="w-full h-full min-w-[950px]" id="chart-canvas">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="p-4 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                <div>
                    <div class="font-medium text-xl text-center border-b-2 mb-2 text-gray-500 dark:text-gray-500">Riwayat
                        Penambahan token
                    </div>
                </div>

                <div class="flex justify-center hidden" id="trx-loading">
                    @include('components.loading')
                </div>

                <div id="trx-table">
                    @include('components.history-table')
                </div>

                <nav class="flex items-center justify-center pt-4 hidden" id="next-link" aria-label="Table navigation">
                    <a onclick="getNextTrx()" class="link link-hover">Tampilkan lebih banyak</a>
                </nav>
            </div>
        </div>
    </div>

    @include('components.generate-modal')
@endsection

@section('script_head')
    {{-- Chartjs --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- qrcodejs --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    {{-- MQTT --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"></script>
@endsection

@section('script')
    <script>
        var currentId = "";
        var currentACode = "";

        // request method ====================================================================

        function myHttpGetRequest(url) {
            return fetch(url)
                .then(response => response.json())
                .then(response => response)
        }

        function myHttpPostRequest(url, data) {
            return myHttpPutPostRequest(url, data, 'POST');
        }

        function myHttpPutRequest(url, data = "") {
            return myHttpPutPostRequest(url, data, 'PUT');
        }

        function myHttpPutPostRequest(url, data, rmethod) {
            return fetch(url, {
                    method: rmethod,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(response => response)
        }

        function myHttpDeleteRequest(url) {
            return fetch(url, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(response => response)
        }

        // end request method ====================================================================

        // meter list ====================================================================================

        const lmeter = document.getElementById('meter-loading');
        const meterList = document.getElementById('meter-list');

        async function getMeterList() {
            const url = "{{ route('userkwhlist', ['id' => Auth::user()->id]) }}";
            const result = await myHttpGetRequest(url);
            updateMeterList(result.data);
        }

        function generateCard(meter) {
            return `
                @include('components.kwh-card', [
                    'name' => '${meter.name}',
                    'id' => '${meter.id}',
                ])
            `;
        }

        async function addMeterList() {
            const id = document.getElementById('meteran-id');
            const name = document.getElementById('meteran-name');
            const pass = document.getElementById('meteran-password');
            document.getElementById('add-modal-exit').click();

            const url = "{{ route('addkwhlist') }}";
            const data = {
                "id": id.value,
                "name": name.value,
                "user_id": "{{ Auth::user()->id }}",
                "password": pass.value
            };

            id.value = "";
            name.value = "";
            pass.value = "";

            await myHttpPostRequest(url, data);

            getMeterList();
        }

        function updateMeterList(data) {
            let myList = '';

            data.forEach(item => {
                myList += generateCard(item);
            });
            meterList.innerHTML = myList;

            loadingMeter();
        }

        async function deleteMeterList(id) {
            if (confirm("Hapus Meteran?") == true) {
                const url = "{{ route('deletekwhlist', ['kwhMeter' => 'id']) }}".replace("id", id);
                const result = await myHttpDeleteRequest(url);
                getMeterList();
            }
        }

        function loadingMeter() {
            lmeter.classList.add("hidden");
        }

        getMeterList();

        // end meter list =========================================================================

        // on off section ====================================================================

        const onButton = document.getElementById('on-button');
        const offButton = document.getElementById('off-button');

        function switchStatus() {
            if (confirm("Apakah anda yakin?") == true) {
                switchMeterStatus();
            }
        }

        function switchStatusUI(status) {
            if (status) {
                onButton.classList.remove("hidden");
                offButton.classList.add("hidden");
            } else {
                offButton.classList.remove("hidden");
                onButton.classList.add("hidden");
            }
        }

        function rstOnOff() {
            onButton.classList.add("hidden");
            offButton.classList.add("hidden");
        }

        // end on off section ====================================================================

        // content ====================================================================

        const idContent = document.querySelectorAll('#meter-id');
        const nameContent = document.getElementById('meter-name');
        var genQr = new QRCode("accesscode-qr");
        const genCode = document.getElementById('generate-code');
        const blank = document.getElementById('blank-section');
        const content = document.getElementById('select-section');

        async function getContentData() {
            const url = "{{ route('getMeter', ['kwhMeter' => 'id']) }}".replace("id", currentId);
            const result = await myHttpGetRequest(url);

            currentACode = result.data.accessCode;
            updateGenInfo();
        }

        function showContentData(id, name) {
            if (content.classList.contains("hidden")) {
                blank.classList.add("hidden");
                content.classList.remove("hidden");
            }

            if (currentId != id) {
                subscribeMqttClient(id);

                currentId = id;

                updateContentInfo(id, name);
                resetContent();

                getContentData();
                getHistories();
                getTrx();
            }
        }

        async function genAccessCode() {
            const url = "{{ route('genToken', ['kwhMeter' => 'id']) }}".replace("id", currentId);
            const result = await myHttpPutRequest(url);

            currentACode = result.data.accessCode;
            updateGenInfo();
        }

        function openLink() {
            window.open("{{ route('print', ['kwhMeter' => 'id']) }}".replace("id", currentId), "_blank");
        }

        function updateContentInfo(id, name) {
            for (const item of idContent) {
                item.innerHTML = id;
            }
            nameContent.innerHTML = name;
        }

        function updateGenInfo() {
            genCode.innerHTML = currentACode;
            genQr.makeCode("{{ route('monitoring', ['id' => 'currId', 'code' => 'currCode']) }}"
                .replace("currCode", currentACode)
                .replace("currId", currentId)
                .replace("amp;", ""));
        }

        function resetContent() {
            loadingChart(true);
            loadingtable(true);

            rstOnOff();
            rstTokenSection();
            rstHisChart();
        }

        // end content ====================================================================


        // add token section ====================================================================

        const sellToken = document.getElementById('token-sell');
        const buyToken = document.getElementById('token-buy');
        const getToken = document.getElementById('token-get');
        const btnToken = document.getElementById('token-add-button');

        function updateGetToken() {
            getToken.value = (buyToken.value / sellToken.value).toFixed(3);

            if (getToken.value > 0) {
                btnToken.disabled = false;
            } else {
                btnToken.disabled = true;
            }
        }

        async function addToken() {
            const url = "{{ route('buyToken') }}";
            const data = {
                "kwhAdd": getToken.value,
                "price": buyToken.value,
                "meter_id": currentId
            };

            rstTokenSection();
            const result = await myHttpPostRequest(url, data);
            console.log(result);

            getTrx();
            setTimeout(function() {
                getTrx();
            }, 10000);
        }

        function rstTokenSection() {
            sellToken.value = 500;
            buyToken.value = 0;
            getToken.value = 0;
            btnToken.disabled = true;
        }

        // end add token section ====================================================================

        // histories chart ====================================================================

        const cloading = document.getElementById('chart-loading');
        const ccanvas = document.getElementById('chart-canvas');
        const ctx = document.getElementById('myChart');

        async function getHistories() {
            const url = "{{ route('histoken', ['kwhMeter' => 'id']) }}".replace("id", currentId);
            const result = await myHttpGetRequest(url);
            updateHisChart(result.data.list);
        }

        function updateHisChart(data) {
            const datapoints = [];
            const labels = [];

            data.reverse();
            data.forEach((item) => {
                datapoints.push(item.kwh)
                labels.push(getDayMounth(item.time));
            });

            updateChartUI(labels, datapoints);
        }

        function getDayMounth(data) {
            return new Date(data).toLocaleDateString('id-id', {
                month: "short",
                day: "numeric"
            });
        }

        function updateChartUI(labels, datapoints) {
            const data = {
                labels: labels,
                datasets: [{
                    label: 'kWh',
                    data: datapoints,
                    fill: false,
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        },
                        y: {
                            min: 0,
                            display: true,
                            title: {
                                display: true,
                                text: 'kWh'
                            }
                        }
                    }
                },
            };

            new Chart(ctx, config);
            loadingChart(false);
        }

        function rstHisChart() {
            let chartStatus = Chart.getChart("myChart");
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }
        }

        function loadingChart(loading) {
            if (loading) {
                cloading.classList.remove("hidden");
                ccanvas.classList.add("hidden");
            } else {
                cloading.classList.add("hidden");
                ccanvas.classList.remove("hidden");
            }
        }

        // end histories chart ====================================================================

        // transactions table ====================================================================

        const tloading = document.getElementById('trx-loading');
        const tdata = document.getElementById('trx-table');
        const myTable = document.getElementById('trx-body-table');
        const linkNav = document.getElementById('next-link');
        var nextLink, number = 1;

        function getTrx() {
            rstTrxTable();
            getTransactions("{{ route('trxlist', ['kwhMeter' => 'id']) }}".replace("id", currentId));
        }

        async function getTransactions(url) {
            const result = await myHttpGetRequest(url);

            showNextLink(false);

            updateTrxList(result.data.data);

            if (result.data.next_page_url != null) {
                number++;
                nextLink = result.data.next_page_url
                showNextLink(true);
            }

            loadingtable(false);
        }

        function getNextTrx() {
            getTransactions(nextLink);
        }

        function updateTrxList(data) {
            let myTrx = '';

            var no = 1;
            if (number > 1) {
                no = (number - 1) * 5 + 1;
            }

            data.forEach(item => {
                myTrx += generateTrxItem(no++, item);
            });
            myTable.innerHTML += myTrx;
        }

        function generateTrxItem(index, trx) {
            if (trx.status == 0 && (new Date().getTime() - new Date(trx.time).getTime()) / 1000 <= 10) {
                trx.status = 2;
            }

            switch (trx.status) {
                case 0:
                    return `
                        @include('components.transaction-item', [
                            'no' => '${index}',
                            'time' => '${trx.time}',
                            'price' => '${trx.price}',
                            'kwhCurr' => '${trx.kwhCurr}',
                            'kwhPrev' => '${trx.kwhPrev}',
                            'kwhAdd' => '${trx.kwhAdd}',
                            'status' => 0,
                        ])
                    `;

                case 1:
                    return `
                        @include('components.transaction-item', [
                            'no' => '${index}',
                            'time' => '${trx.time}',
                            'price' => '${trx.price}',
                            'kwhCurr' => '${trx.kwhCurr}',
                            'kwhPrev' => '${trx.kwhPrev}',
                            'kwhAdd' => '${trx.kwhAdd}',
                            'status' => 1,
                        ])
                    `;

                default:
                    return `
                        @include('components.transaction-item', [
                            'no' => '${index}',
                            'time' => '${trx.time}',
                            'price' => '${trx.price}',
                            'kwhCurr' => '${trx.kwhCurr}',
                            'kwhPrev' => '${trx.kwhPrev}',
                            'kwhAdd' => '${trx.kwhAdd}',
                            'status' => 2,
                        ])
                    `;
            }
        }

        function rstTrxTable() {
            number = 1;
            myTable.innerHTML = "";
        }

        function showNextLink(status) {
            if (status) {
                linkNav.classList.remove("hidden")
            } else {
                linkNav.classList.add("hidden")
            }
        }

        function loadingtable(loading) {
            if (loading) {
                tloading.classList.remove("hidden");
                tdata.classList.add("hidden");
            } else {
                tloading.classList.add("hidden");
                tdata.classList.remove("hidden");
            }
        }

        // end transactions table ====================================================================

        // mqtt ====================================================================

        // mqtt configuration
        const host = "broker.hivemq.com";
        const port = 8000;
        const clientId = "clientID-" + parseInt(Math.random() * 100);

        // Create a client instance
        var client = new Paho.Client(host, Number(port), clientId);

        // set callback handlers
        client.onConnectionLost = onConnectionLost;
        client.onMessageArrived = onMessageArrived;

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

        // called when a message arrives
        function onMessageArrived(message) {
            var msg = JSON.parse(message.payloadString);
            switchStatusUI(msg.status);
        }

        function subscribeMqttClient(newId) {
            client.unsubscribe("kwh/status/" + currentId);
            client.subscribe("kwh/status/" + newId);
            tellKwhMeter(newId);
        }

        function tellKwhMeter(newId) {
            message = new Paho.Message("{ \"mode\": 2 }");
            message.destinationName = "kwh/online/" + newId;
            client.send(message);
        }

        function switchMeterStatus() {
            message = new Paho.Message("");
            message.destinationName = "kwh/switch/" + currentId;
            client.send(message);
        }

        connect();

        // end mqtt ====================================================================
    </script>
@endsection
