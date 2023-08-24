@extends('layouts.layout-public')

@section('public_layout')
    <div class="p-4 lg:m-auto">
        <div class="p-4 border-2 border-gray-200 max-w-5xl border-dashed rounded-lg mt-14">
            <div class="flex justify-stretch p-4 mb-4 rounded bg-gray-50">
                <div class="basis-1/3">
                    <p class="text-md text-gray-600">{{ $data->name }}</p>
                </div>
                <div class="basis-1/3 flex justify-center items-center">
                    <p class="font-medium px-3 rounded-md bg-red-100 text-gray-700" id="status-off">Offline</p>
                    <p class="font-medium px-3 rounded-md bg-green-100 text-gray-700 hidden" id="status-on">Online</p>
                </div>
                <div class="basis-1/3 flex justify-end my-auto">
                    <p class="text-md text-gray-600">{{ $data->id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div class="p-4 flex flex-col justify-center space-y-3 rounded bg-gray-50">
                    <div class="flex justify-between">
                        <div class="text-sm text-gray-500">Update Terakhir:</div>
                        <div class="text-sm text-gray-500" id="kwh-last-update">{{ $data->updated_at }}</div>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-500">Sisa Token:</p>
                        <p class="font-medium text-2xl text-gray-600"><span id="kwh-remaining">{{ $data->kwh }}</span>
                            kWh</p>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-500">Pemakaian Hari Ini:</p>
                        <p class="font-medium text-2xl text-gray-600"><span id="kwh-used">{{ $data->kwhUsed }}</span> kWh
                        </p>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-500">Estimasi:</p>
                        <p class="text-sm text-gray-500" id="estimate">0 Hari 0 Jam 0 Menit</p>
                    </div>
                </div>
                <div class="p-4 rounded bg-gray-50">
                    <div class="text-sm text-gray-500">
                        Daya Sedang Digunakan:
                    </div>
                    <div class="w-full h-[93%] overflow-x-auto">
                        <div class="w-full h-full min-w-[450px]">
                            <canvas id="mChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="p-4 mb-4 rounded bg-gray-50">
                <div class="text-sm text-gray-500">
                    Batas kWh Alarm:
                </div>
                <div class="flex items-center space-y-3 justify-between flex-wrap">
                    <div class="flex space-x-3 items-center">
                        <input type="text" id="alarm"
                            class="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                            placeholder="5" disabled required>
                        <div class="">kWh</div>
                    </div>

                    <div class="flex">
                        <button type="button"
                            class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10">Edit</button>
                        <button type="button"
                            class="text-white bg-green-700 hover:bg-green-800 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2">Simpan</button>
                        <button type="button"
                            class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2">Batal</button>
                    </div>
                </div>

            </div> --}}

            <div class="p-4 mb-4 rounded bg-gray-50">
                <div>
                    <div class="font-medium text-xl text-center border-b-2 mb-2 text-gray-500">Riwayat
                        Pemakaian
                    </div>
                </div>
                <div class="w-full h-full overflow-x-auto">
                    <div class="flex justify-center" id="chart-loading">
                        @include('components.loading')
                    </div>
                    <div class="w-full h-full min-w-[950px] hidden" id="chart-canvas">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="p-4 mb-4 rounded bg-gray-50">
                <div>
                    <div class="font-medium text-xl text-center border-b-2 mb-2 text-gray-500">Riwayat
                        Penambahan token
                    </div>
                </div>

                <div class="flex justify-center" id="trx-loading">
                    @include('components.loading')
                </div>

                <div class="hidden" id="trx-table">
                    @include('components.history-table')
                </div>

                <nav class="flex items-center justify-center pt-4 hidden" id="next-link" aria-label="Table navigation">
                    <a onclick="getNextTrx()" class="link link-hover">Tampilkan lebih banyak</a>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('script_head')
    {{-- Chartjs --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- MQTT --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"></script>
@endsection

@section('script')
    <script>
        const currentId = "{{ $data->id }}";
        const rtoken = {{ $data->kwh }};
        var avgKwh, updateIntv, tellIntv, tellIntvAg;

        // request method ====================================================================

        function myHttpGetRequest(url) {
            return fetch(url)
                .then(response => response.json())
                .then(response => response)
        }

        // end request method ====================================================================

        // content

        const online = document.getElementById('status-on');
        const offline = document.getElementById('status-off');

        function OnlineStatusTitle(status) {
            if (status) {
                online.classList.remove("hidden");
                offline.classList.add("hidden");
            } else {
                online.classList.add("hidden");
                offline.classList.remove("hidden");
            }
        }

        function updateIntvTime() {
            updateIntv = setInterval(() => {
                OnlineStatusTitle(false);
                updateDatapoints(0);
            }, 1300);

            tellIntv = setInterval(() => {
                clearTimeout(tellIntvAg);
                tellKwhMeter();
            }, 5000);
        }

        function stopIntvTime() {
            clearInterval(updateIntv);
            clearInterval(tellIntv);
        }


        // end content

        // remaining kwh ====================================================================

        const lastUpdate = document.getElementById('kwh-last-update');
        const kwhRemaining = document.getElementById('kwh-remaining');
        const kwhUsed = document.getElementById('kwh-used');
        const estimate = document.getElementById('estimate');

        function updateRemToken(rem, used) {
            OnlineStatusTitle(true);
            stopIntvTime();

            kwhRemaining.innerHTML = rem.toFixed(3);
            kwhUsed.innerHTML = used;
            lastUpdate.innerHTML = new Date().toLocaleString('sv-SE', {
                timeZone: 'Singapore'
            });

            calEstimate(rem);
        }

        function calEstimate(kwh = rtoken) {
            if (avgKwh == null || avgKwh == 0) {
                blankEstimate();
                return;
            }

            var day = kwh / avgKwh;
            var hour = (day % 1) * 24;
            var minute = (hour % 1) * 60;

            updateEstimate(~~(day), ~~(hour), Math.round(minute));
        }

        function blankEstimate() {
            estimate.innerHTML = `Belum tersedia`;
        }

        function updateEstimate(day, hour, minute) {
            estimate.innerHTML = `${day} Hari ${hour} Jam ${minute} Menit`;
        }

        // end remaining kwh ====================================================================

        // energy chart ====================================================================

        var mchart;
        const cmtx = document.getElementById('mChart');
        const labelsm = [6, 5, 4, 3, 2, 1, "", "", "", "", ""];
        const datapointsm = [0, 0, 0, 0, 0, 0, NaN, NaN, NaN, NaN, NaN];

        function updateDatapoints(data) {
            for (let i = 0; i < 5; i++) {
                datapointsm[i] = datapointsm[i + 1];
            }
            datapointsm[5] = data;

            mchart.data.datasets.data = datapointsm;
            mchart.update();
        }

        function updateEnrChartUI() {
            const data = {
                labels: labelsm,
                datasets: [{
                    label: 'Daya',
                    data: datapointsm,
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
                                text: 'Detik (yang lalu)'
                            }
                        },
                        y: {
                            min: 0,
                            suggestedMax: 10,
                            display: true,
                            title: {
                                display: true,
                                text: 'Watt'
                            }
                        }
                    }
                },
            };

            mchart = new Chart(cmtx, config);
        }

        // end energy chart ====================================================================

        // histories chart ====================================================================

        const cloading = document.getElementById('chart-loading');
        const ccanvas = document.getElementById('chart-canvas');
        const ctx = document.getElementById('myChart');

        async function getHistories() {
            const url = "{{ route('histoken', ['kwhMeter' => 'id']) }}".replace("id", currentId);
            const result = await myHttpGetRequest(url);

            avgKwh = result.data.avg;
            calEstimate();
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
            loadingChart();
        }

        function loadingChart() {
            cloading.classList.add("hidden");
            ccanvas.classList.remove("hidden");
        }

        // end histories chart ====================================================================

        // transactions table ====================================================================

        const tloading = document.getElementById('trx-loading');
        const tdata = document.getElementById('trx-table');
        const myTable = document.getElementById('trx-body-table');
        const linkNav = document.getElementById('next-link');
        var nextLink, number = 1;

        function getTrx() {
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

            loadingtable();
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

        function showNextLink(status) {
            if (status) {
                linkNav.classList.remove("hidden")
            } else {
                linkNav.classList.add("hidden")
            }
        }

        function loadingtable() {
            tloading.classList.add("hidden");
            tdata.classList.remove("hidden");
        }

        // end transactions table ====================================================================

        updateEnrChartUI();
        getHistories();
        getTrx();

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
            // Once a connection has been made, make a subscription and send a message.
            console.log("onConnect");
            client.subscribe("kwh/data/" + currentId);
            tellKwhMeter();
            updateIntvTime();
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
            updateRemToken(msg.token, msg.energy);
            updateDatapoints(msg.power);
            updateIntvTime();
        }

        function tellKwhMeter() {
            message = new Paho.Message("{ \"mode\": 1 }");
            message.destinationName = "kwh/online/" + currentId;
            client.send(message);

            tellIntvAg = setTimeout(tellKwhMeter, 170000)
        }

        connect();

        // end mqtt ====================================================================
    </script>
@endsection
