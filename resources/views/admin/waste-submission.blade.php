<x-layouts.app :title="__('Admin Waste Submission')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Waste Submission') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @php
        $pendingSubmissions = $submissions->where('status', 'pending');
    @endphp
    <div class="container px-5 w-full">
        <div class="flex flex-col gap-y-4">
            @if ($pendingSubmissions->count() > 0)
            @foreach ($pendingSubmissions as $index => $submission)
            <div class="flex flex-col lg:flex-row gap-4 py-6 px-4 border rounded-md shadow-sm items-start lg:items-center">
                    <div class="flex flex-col w-full lg:w-1/6">
                        <flux:heading size="lg" class="mb-1">Submission {{ $submission->id }}</flux:heading>
                    </div>
                    <flux:separator vertical />
                    <div class="flex flex-col w-full lg:w-1/4 space-y-1">
                        <flux:text class="text-sm md:text-base">{{ $submission->user->name }}</flux:text>
                        <flux:text class="text-sm md:text-base">{{ $submission->wasteCategory->name }}</flux:text>
                        <flux:text class="text-sm md:text-base">{{ $submission->weight }} kg</flux:text>
                    </div>
                    <flux:separator vertical />
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center w-full lg:w-2/5">
                        <flux:heading size="lg" class="mb-1 lg:mb-0">Total Point : </flux:heading>
                        <flux:heading size="xl">{{$submission->total_point}}</flux:heading>
                    </div>
                    <flux:separator vertical />
                    <div class="flex w-full justify-end lg:justify-center lg:w-2/12">
                        <flux:dropdown placement="top-start lg:bottom-start" class="w-20">
                            <flux:button icon:trailing="chevron-down">Verify</flux:button>
                            <flux:menu class="max-w-10">
                                <form action="{{ route('admin.waste-submission.update', $submission->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <flux:badge
                                        as="button"
                                        name="action" 
                                        value="approve" 
                                        type="submit"
                                        color="green"
                                        icon="check"
                                        class="w-full mx-auto justify-self-center mt-2 mb-1 px-4 py-2 rounded-md  hover:bg-accent transition text-center">
                                        Approve
                                    </flux:badge>
                                    <flux:badge
                                        as="button" 
                                        name="action" 
                                        value="reject" 
                                        type="submit"
                                        color="red"
                                        icon="x-circle"
                                        class="w-full mt-1 mb-2 px-4 py-2 rounded-md  hover:bg-red-500 transition">
                                        Reject
                                    </flux:badge> 
                                </form>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
            </div>
            @endforeach
            @else
            <div class="flex flex-col items-center justify-center p-6 bg-green-50 border border-green-300 rounded-xl shadow-md">
                <svg class="w-12 h-12 text-green-500 mb-3" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2l4 -4m5 0a9 9 0 1 1 -18 0a9 9 0 0 1 18 0z" />
                </svg>
                <h3 class="text-lg font-bold text-green-700 mb-1">Semua data telah diverifikasi</h3>
                <p class="text-gray-600 text-sm">Tidak ada submission yang menunggu persetujuan saat ini.</p>
            </div>
            @endif
            
            
        </div>
    </div>
    
</x-layouts.app>