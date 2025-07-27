<x-layouts.app :title="__('Waste Submission')">
    <div class="flex flex-col">
        <div class="relative mb-6 w-full">
            <flux:heading size="xl" level="1">{{ __('Waste Submission') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
            <flux:separator variant="subtle" />
        </div>
    
        <div>
            <form action="{{ route('submission.store') }}" method="POST">
                @csrf

                <!-- User ID sebagai hidden input -->
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="w-full md:w-3/4 lg:w-1/2">
                    <flux:text size="lg" class="my-4">Masukkan jenis/kategori sampah</flux:text>
                    <flux:select class="border border-accent-content" name="waste_category_id" placeholder="Choose waste category..." id="categorySelect">
                        @foreach($categories as $category)
                            <flux:select.option 
                                class="text-black" 
                                value="{{ $category->id }}" 
                                data-point="{{ $category->point_per_kg }}">
                                {{ $loop->iteration }}. {{ $category->name }} -- {{ $category->point_per_kg }} point/kg
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('waste_category_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror

                    <flux:field class="my-4">
                        <flux:label class="text-lg">Masukkan berat</flux:label>
                        <flux:description>Dalam satuan kg</flux:description>
                        <flux:input name="weight" id="weightInput" type="number" step="0.1" min="0" />
                        <flux:error name="weight" />
                    </flux:field>

                    <flux:field class="my-4">
                        <flux:label class="text-lg">Jumlah poin yang diterima</flux:label>
                        <flux:input id="pointOutput" name="point_display" disabled />
                    </flux:field>

                    <input type="hidden" name="point" id="pointHidden" />

                    <flux:button type="submit" variant="primary" class="mt-4">Kirim Setoran</flux:button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div 
                id="toast-success"
                class="fixed top-5 right-5 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg shadow-lg flex items-start gap-2 z-50 transition-opacity duration-300"
                role="alert"
            >
                <svg class="w-6 h-6 text-green-500 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <strong class="font-semibold">Berhasil!</strong>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('toast-success').remove()" class="ml-4 text-green-500 hover:text-green-700">
                    ✕
                </button>
            </div>

            <script>
                // Auto-hide after 3 seconds
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if (toast) {
                        toast.classList.add('opacity-0');
                        setTimeout(() => toast.remove(), 300); // delay for fade-out
                    }
                }, 3000);
            </script>
        @endif
        <div class="relative mb-8 mt-16 w-full">
            <flux:separator variant="subtle" class="mb-6"/>
            <flux:heading size="xl" level="1">{{ __('History Submission') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
        </div>
        
        <div class="container px-5 my-6 w-full">
        <div class="flex flex-col max-h-[500px] overflow-y-auto gap-y-4">
            @foreach ($submissions as $index => $submission)
            <div class="flex flex-col lg:flex-row gap-4 py-6 px-4 border rounded-md shadow-sm items-start lg:items-center">
                <!-- Info Submission ID -->
                <div class="flex flex-col w-full lg:w-1/6">
                    <flux:heading size="lg" class="mb-1">Submission {{ $submission->id }}</flux:heading>
                </div>

                <!-- Info User & Kategori -->
                <div class="flex flex-col w-full lg:w-1/4 space-y-1">
                    <flux:text class="text-sm md:text-base">{{ $submission->user->name }}</flux:text>
                    <flux:text class="text-sm md:text-base">{{ $submission->wasteCategory->name }}</flux:text>
                    <flux:text class="text-sm md:text-base">{{ $submission->weight }} kg</flux:text>
                </div>

                <!-- Total Point -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center w-full lg:w-2/5">
                    <flux:heading size="lg" class="mb-1 lg:mb-0">Total Point:</flux:heading>
                    <flux:heading size="xl">{{ $submission->total_point }}</flux:heading>
                </div>

                <!-- Status Badge -->
                <div class="lg:flex w-full lg:justify-center lg:w-2/12">
                    @if ($submission->status === 'pending')
                        <flux:badge size="lg" class="w-full lg:w-auto" icon="clock" color="yellow">Pending</flux:badge>
                    @elseif ($submission->status === 'accepted')
                        <flux:badge size="lg" class="w-full lg:w-auto" icon="check-circle" color="green">Accepted</flux:badge>
                    @elseif ($submission->status === 'rejected')
                        <flux:badge size="lg" class="w-full lg:w-auto" icon="x-circle" color="red">Rejected</flux:badge>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const weightInput = document.getElementById('weightInput');
        const pointOutput = document.getElementById('pointOutput');
        const pointHidden = document.getElementById('pointHidden');
        const categorySelect = document.getElementById('categorySelect');

        function updatePoints() {
            const weight = parseFloat(weightInput.value) || 0;
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const pointPerKg = parseFloat(selectedOption.dataset.point) || 0;
            const totalPoints = weight * pointPerKg;
            pointOutput.value = totalPoints.toFixed(2);
            pointHidden.value = totalPoints.toFixed(2);
        }

        weightInput.addEventListener('input', updatePoints);
        categorySelect.addEventListener('change', updatePoints);
    });
</script>



</x-layouts.app>
