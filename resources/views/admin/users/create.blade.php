<x-admin-layout>
    <h1 class="text-2xl font-semibold p-4">New User</h1>
    <x-splade-form :action="route('admin.users.store')" class="p-4 bg-white rounded-md space-y-2">
        <x-splade-input name="username" label="Username" />
        <x-splade-input name="first_name" label="First name" />
        <x-splade-input name="last_name" label="Last name" />
        <x-splade-input name="email" label="Email Address" />
        <x-splade-input type="password" name="password" label="Password" />
        <x-splade-input type="password" name="password_confirmation" label="Confirm Password" />
        <x-splade-select label="Role" name="roles[]" :options="$roles" multiple relation choices />
        <x-splade-select label="Permissions" name="permissions[]" :options="$permissions" multiple relation choices />

        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
