<x-layouts.app :title="__('Admin Recommendation Activity')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Recommendation Activity') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Tambahkan rekomendasi aktivitas ke user berdasarkan cuaca') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Trigger Modal -->
    <flux:modal.trigger name="add-category">
        <flux:button variant="primary">Add Recommendation</flux:button>
    </flux:modal.trigger>

    <!-- Modal for Adding Waste Category -->
    <flux:modal name="add-category" class="md:w-96">
        <form action="{{ route('admin.recommendations.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <flux:heading size="lg">Add Recommendation Activities</flux:heading>
                <flux:text class="mt-2">Enter the details of the new recommendation.</flux:text>
            </div>

            <flux:select name="weather_code" label="Weather Code" required>
                <option value="" disabled selected>-- Pilih Jenis Cuaca --</option>
                <option value="thunderstorm">Thunderstorm</option>
                <option value="drizzle">Drizzle</option>
                <option value="rain">Rain</option>
                <option value="snow">Snow</option>
                <option value="atmosphere">Atmosphere</option>
                <option value="clear">Clear</option>
                <option value="clouds">Clouds</option>
            </flux:select>

            <flux:input name="recommendation" label="Recommendation Desc." required />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save Recommendation</flux:button>
            </div>
        </form>
    </flux:modal>

   <div class="container mx-auto mt-5 px-4 py-6">
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Weather Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold ">Recommendation</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold ">Created At</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold ">Actions</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-gray-200">
                    @foreach ($categories as $index => $category)
                        <tr class="hover:bg-accent-content transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm ">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm ">{{ $category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm ">{{ $category->point_per_kg }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm ">{{ $category->created_at->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2 flex items-center justify-center flex-wrap">
                                <!-- Edit Button -->
                                <flux:modal.trigger name="edit-profile-{{ $category->id }}">
                                    <flux:button variant="primary" size="sm">Edit</flux:button>
                                </flux:modal.trigger>

                                <!-- Modal Edit -->
                                <flux:modal name="edit-profile-{{ $category->id }}" class="md:w-96">
                                    <form action="{{ route('admin.waste-category.update', $category->id) }}" method="POST" class="space-y-6">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <flux:heading size="lg">Edit Waste Category</flux:heading>
                                            <flux:text class="mt-2">Modify the details of the waste category.</flux:text>
                                        </div>

                                        <flux:input name="name" label="Category Name" placeholder="e.g. Plastic" value="{{ $category->name }}" required />
                                        <flux:input name="point_per_kg" label="Points per Kilogram" type="number" placeholder="e.g. 50" value="{{ $category->point_per_kg }}" required />

                                        <div class="flex justify-end">
                                            <flux:button type="submit" variant="primary">Save Category</flux:button>
                                        </div>
                                    </form>
                                </flux:modal>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.waste-category.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="danger" size="sm">Delete</flux:button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>