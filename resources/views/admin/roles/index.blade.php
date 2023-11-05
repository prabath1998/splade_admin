<x-admin-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-semibold p-4">Roles Index</h1>
        <div class="p-4">
            <Link href="{{ route('admin.roles.create') }}"
                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded text-white">New Role</Link>
        </div>
    </div>
    <x-splade-table :for="$roles">
        @cell('action', $role)
            <div class="space-x-2">
                <Link href="{{ route('admin.roles.edit', $role) }}"
                    class="px-3 py-2 bg-green-400 hover:bg-green-700 rounded-md text-white">Edit</Link>
                <Link confirm="Are you want to delete {{ $role->name }}?" confirm-button="Yes, delete!" cancel-button="No" method="DELETE" href="{{ route('admin.roles.destroy', $role) }}"
                    class="px-3 py-2 bg-red-400 hover:bg-red-700 rounded-md text-white">Delete</Link>
            </div>
        @endcell
    </x-splade-table>
</x-admin-layout>
