<x-admin-layout>
    <h1 class="text-2xl font-semibold p-4">Users Index</h1>
    <x-splade-table :for="$users">
        @cell('action', $user)
            <Link href="{{ route('admin.users.edit', $user) }}" class="px-3 py-2 bg-green-400 hover:bg-green-700 rounded-md text-white">Edit</Link>
        @endcell
    </x-splade-table>
</x-admin-layout>
