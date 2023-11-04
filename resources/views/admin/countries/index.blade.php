<x-admin-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-semibold p-4">Countries Index</h1>
        <div class="p-4">
            <Link href="{{ route('admin.countries.create') }}"
                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded text-white">New Country</Link>
        </div>
    </div>
    <x-splade-table :for="$countries">
        @cell('action', $country)
            <div class="space-x-2">
                <Link href="{{ route('admin.countries.edit', $country) }}"
                    class="px-3 py-2 bg-green-400 hover:bg-green-700 rounded-md text-white">Edit</Link>
                <Link confirm="Are you want to delete?" confirm-button="Yes, delete!" cancel-button="No" method="DELETE" href="{{ route('admin.countries.destroy', $country) }}"
                    class="px-3 py-2 bg-red-400 hover:bg-red-700 rounded-md text-white">Delete</Link>
            </div>
        @endcell
    </x-splade-table>
</x-admin-layout>
