<div class="navbar bg-base-200 border-b border-base-300">
    <div class="navbar-start">
        {{-- Mobile menu toggle --}}
        <label for="sidebar-toggle" class="btn btn-square btn-ghost lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
    </div>

    <div class="navbar-center">
        @if($contact)
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="w-10 rounded-full">
                        <img src="https://ui-avatars.com/api/?name={{ $contact->name }}" alt="{{ $contact->name }}" />
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold">{{ $contact->name }}</h3>
                    <p class="text-sm text-base-content/70">
                        {{-- Simple online status - can be enhanced with real-time presence --}}
                        Online
                    </p>
                </div>
            </div>
        @else
            <div class="text-center">
                <h3 class="font-semibold">Artisan Talk</h3>
            </div>
        @endif
    </div>

    <div class="navbar-end">
        <div class="flex gap-2">
            {{-- Search Button --}}
            <button class="btn btn-ghost btn-circle" title="Search">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>

            {{-- Menu Button --}}
            <button class="btn btn-ghost btn-circle" title="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
