<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Cabang') }}
            </h2>
            <a href="{{ route('branches.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                + Tambah Cabang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b dark:border-gray-700">
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama Cabang</th>
                                <th class="px-4 py-2">Alamat</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($branches as $index => $branch)
                                <tr
                                    class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 font-bold text-blue-600 dark:text-blue-400">
                                        {{ $branch->branch_name }}
                                    </td>
                                    <td class="px-4 py-2">{{ $branch->address ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center flex justify-center gap-2">
                                        <a href="{{ route('branches.edit', $branch->id) }}"
                                            class="text-yellow-500 hover:text-yellow-700 font-bold">Edit</a>

                                        <form action="{{ route('branches.destroy', $branch->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin mau hapus cabang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        Belum ada data cabang. Silakan tambah data baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
