<!-- Modern Data Table Component -->
<div class="modern-table-container bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Table Header -->
    @if(isset($title) || isset($actions))
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        @if(isset($title))
        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        @endif
        
        @if(isset($actions))
        <div class="flex items-center space-x-2">
            {!! $actions !!}
        </div>
        @endif
    </div>
    @endif

    <!-- Search and Filters -->
    @if(isset($searchable) && $searchable)
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <!-- Search -->
            <div class="relative">
                <input type="text" 
                       placeholder="Cari data..." 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 text-sm"
                       id="table-search">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filters -->
            @if(isset($filters))
            <div class="flex items-center space-x-2">
                {!! $filters !!}
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- Table Head -->
            <thead class="bg-gray-50">
                {{ $head }}
            </thead>
            
            <!-- Table Body -->
            <tbody class="bg-white divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($pagination))
    <div class="px-6 py-3 border-t border-gray-200 bg-gray-50">
        {{ $pagination }}
    </div>
    @endif
</div>

<!-- Table Search Script -->
@if(isset($searchable) && $searchable)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('table-search');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const shouldShow = text.includes(searchTerm);
            
            row.style.display = shouldShow ? '' : 'none';
        });
    });
});
</script>
@endif
