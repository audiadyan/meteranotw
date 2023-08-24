<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="font-medium">
            <li>
                <div data-modal-target="add-modal" data-modal-toggle="add-modal"
                    class="flex items-center justify-center rounded bg-gray-100 h-14 hover:cursor-pointer hover:bg-gray-200">
                    <p class="text-2xl text-gray-600 select-none">+</p>
                </div>
            </li>

            <div class="mt-3 flex justify-center" id="meter-loading">
                @include('components.loading')
            </div>

            <div class="mt-3 space-y-3" id="meter-list">

            </div>
        </ul>
    </div>
</aside>

@include('components.add-modal')
