<!-- Main modal -->
<div id="defaultModal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Generate Kode Akses
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="defaultModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-x-6 flex justify-center">
                <div class="flex justify-center" id="accesscode-qr">
                </div>

                <div class="flex flex-col justify-evenly">
                    <div class="text-center">
                        <div class="font-medium text-lg text-center border-b-2 text-gray-500 dark:text-gray-500">
                            ID
                        </div>
                        <p class="medium text-gray-700" id="meter-id">000000000000</p>
                    </div>

                    <div class="text-center">
                        <div class="font-medium text-lg text-center border-b-2 text-gray-500 dark:text-gray-500">
                            Kode Akses
                        </div>
                        <p class="medium text-gray-700" id="generate-code">********</p>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                <button onclick="openLink()" type="button"
                    class="w-28 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Print</button>
                <button onclick="genAccessCode()" type="button"
                    class="w-28 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Generate</button>
            </div>
        </div>
    </div>
</div>
