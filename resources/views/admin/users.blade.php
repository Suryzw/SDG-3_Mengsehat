<x-layouts.app :title="__('Admin Waste Category')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('List of Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:modal.trigger name="add-users">
        <flux:button variant="primary">Add User</flux:button>
    </flux:modal.trigger>

    <flux:modal name="add-users" class="md:w-96">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <flux:heading size="lg">Add User</flux:heading>
                <flux:text class="mt-2">Enter the details of the new user.</flux:text>
            </div>

                <flux:input name="name" label="User Name" placeholder="Your Name" required />
                <flux:input name="email" label="User Email" type="email" placeholder="e.g. user@example.com" required />
                <flux:input name="password" label="User Password" type="password" placeholder="Your Password" required />
                <flux:radio.group name="role" label="Select role for user" required>
                    <flux:radio value="admin" label="Admin" />
                    <flux:radio value="user" label="User" />
                </flux:radio.group>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save User</flux:button>
            </div>
        </form>
    </flux:modal>

    <div class="container mx-auto mt-5 px-4 py-6">
    <div class="overflow-x-auto rounded-2xl shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Role</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class=" divide-y divide-gray-100">
                @foreach ($users as $index => $category)
                    <tr class="hover:bg-accent-content transition">
                        <td class="px-6 py-4 text-sm">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $category->email }}</td>
                        <td class="px-6 py-4 text-sm">{{ $category->role }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-wrap gap-2 justify-center">
                                <!-- Edit Trigger -->
                                <flux:modal.trigger name="edit-profile-{{ $category->id }}">
                                    <flux:button size="sm" variant="primary">Edit</flux:button>
                                </flux:modal.trigger>

                                <!-- Modal Edit -->
                                <flux:modal name="edit-profile-{{ $category->id }}" class="md:w-96">
                                    <form action="{{ route('admin.users.update', $category->id) }}" method="POST" class="space-y-6">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div>
                                            <flux:heading size="lg">Edit User</flux:heading>
                                            <flux:text class="mt-2">Modify the details of the user.</flux:text>
                                        </div>

                                        <flux:input name="name" label="User Name" placeholder="Your Name" required value="{{ $category->name }}" />
                                        <flux:input name="email" label="User Email" type="email" placeholder="e.g. user@example.com" required value="{{ $category->email }}" />
                                        
                                        <flux:radio.group name="role" label="Select role for user">
                                            <flux:radio value="admin" label="Admin" :checked="$category->role === 'admin'" />
                                            <flux:radio value="user" label="User" :checked="$category->role === 'user'" />
                                        </flux:radio.group>
                                        
                                        <flux:input name="points" label="User Points" type="number" placeholder="User Points" value="{{ $category->points }}" required />

                                        <div class="flex justify-end">
                                            <flux:button type="submit" variant="primary">Update User</flux:button>
                                        </div>
                                    </form>
                                </flux:modal>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.users.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="danger" size="sm">Delete</flux:button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-layouts.app>