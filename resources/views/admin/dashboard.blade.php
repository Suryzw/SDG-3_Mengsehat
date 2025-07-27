<x-layouts.app :title="__('Admin Dashboard')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pengguna -->
        <div class="bg-white shadow-md rounded-lg p-5">
            <h2 class="text-lg font-semibold text-gray-700">Total Pengguna</h2>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $userCount }}</p>
        </div>

        <!-- Total Setoran -->
        <div class="bg-white shadow-md rounded-lg p-5">
            <h2 class="text-lg font-semibold text-gray-700">Total Setoran</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $submissionCount }}</p>
        </div>

        <!-- Total Penukaran -->
        <div class="bg-white shadow-md rounded-lg p-5">
            <h2 class="text-lg font-semibold text-gray-700">Total Penukaran</h2>
            <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $redemptionCount }}</p>
        </div>

        <!-- Total Poin -->
        <div class="bg-white shadow-md rounded-lg p-5">
            <h2 class="text-lg font-semibold text-gray-700">Total Poin</h2>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ number_format($totalPoints) }}</p>
        </div>
    </div>
</div>
</x-layouts.app>