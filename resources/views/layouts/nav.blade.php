<nav class="bg-gradient-to-r from-white via-blue-100 to-blue-200 text-slate-900 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('dashboard') }}" class="font-bold text-xl flex items-center gap-2 hover:text-blue-700 transition">
                <img src="{{ asset('logo.png') }}" alt="KM Logo" class="h-8 w-8 object-contain" />
                <span class="bg-gradient-to-r from-cyan-600 to-blue-700 bg-clip-text text-transparent">Km-Automobile</span>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-white text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-blue-100 transition">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>
        </div>
    </div>
</nav>
