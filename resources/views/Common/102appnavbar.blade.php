<div class="w-full flex items-center justify-between px-8 py-4 bg-white border-b shadow-sm">

    <!-- Left Menu -->
    <nav class="flex space-x-8 text-sm font-medium">

        <a href="{{ route('dashboard') }}"
           class="text-gray-700 hover:text-blue-700 transition">
            Dashboard
        </a>

        <a href="/positions"
           class="text-gray-700 hover:text-blue-700 transition">
            Positions
        </a>

        <a href="/incumbents"
           class="text-gray-700 hover:text-blue-700 transition">
            Incumbents
        </a>

        <a href="/reports"
           class="text-gray-700 hover:text-blue-700 transition">
            Reports
        </a>

        <a href="{{ route('setup.show') }}"
           class="text-gray-700 hover:text-blue-700 transition">
            Setup
        </a>

    </nav>

    <!-- Right Side: Title + Logo -->
    <div class="flex items-center space-x-4">
        <h1 class="text-3xl font-bold tracking-tight text-gray-800">
            PowerPCS
        </h1>

        <img src="{{ asset('/images/PowerArmImageV2_Transp.png') }}"
             class="w-14 h-20 object-contain">
    </div>

</div>
