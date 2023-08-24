<li class="relative">
    <button onclick='deleteMeterList("{{ $id }}")'
        class="absolute right-[-5px] top-[-5px] px-2 text-sm font-medium text-red-800 bg-red-100 hover:bg-red-200 rounded-md">X</button>
    <a onclick='showContentData("{{ $id }}", "{{ $name }}")'
        class="flex justify-between items-center p-2 border-2 shadow-md text-gray-900 rounded-lg hover:bg-gray-100 hover:cursor-pointer">
        <div class="flex flex-col flex-1">
            <span>{{ $name }}</span>
            <span class="text-md text-gray-600 text-end">{{ $id }}</span>
        </div>
    </a>
</li>
