<tr class="bg-white border-b hover:bg-gray-50">
    <td scope="row" class="px-6 py-4 whitespace-nowrap">
        {{ $no }}
    </td>
    <td class="px-6 py-4">
        {{ $time }}
    </td>
    <td class="px-6 py-4">
        {{ $price }}
    </td>
    <td class="px-6 py-4">
        <div class="flex space-x-2 items-center">
            <div>
                <div class="text-green-600">{{ $kwhCurr }}</div>
                <div class="text-red-600">{{ $kwhPrev }}</div>
            </div>
            <div class="font-medium">+<span>{{ $kwhAdd }}</span></div>
        </div>
    </td>

    @switch($status)
        @case(0)
            <td class="px-6 py-4">
                <span class="text-red-600">Gagal</span>
            </td>
        @break

        @case(1)
            <td class="px-6 py-4">
                <span class="text-green-600">Sukses</span>
            </td>
        @break

        @default
            <td class="px-6 py-4">
                Diproses
            </td>
    @endswitch
</tr>
