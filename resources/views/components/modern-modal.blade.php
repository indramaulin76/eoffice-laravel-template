<!-- Modern Modal Component -->
<div x-data="{ open: false }" 
     x-show="open" 
     x-cloak
     @open-modal.window="open = true"
     @close-modal.window="open = false"
     @keydown.escape.window="open = false"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    
    <!-- Backdrop -->
    <div x-show="open" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50"
         @click="open = false"></div>
    
    <!-- Modal -->
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="flex items-center justify-center min-h-screen p-4">
        
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-screen overflow-y-auto">
            <!-- Modal Header -->
            @if(isset($title))
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                <button type="button" 
                        @click="open = false"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif
            
            <!-- Modal Body -->
            <div class="px-6 py-4">
                {{ $slot }}
            </div>
            
            <!-- Modal Footer -->
            @if(isset($footer))
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3">
                {!! $footer !!}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Trigger Example -->
<!--
<button type="button" 
        @click="$dispatch('open-modal')"
        class="btn btn-primary">
    Open Modal
</button>
-->
