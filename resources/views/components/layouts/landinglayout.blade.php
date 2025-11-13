<x-format>
    <x-navbar />
    <main class="flex-1">
        {{ $slot }}
    </main>
    <footer class="text-center py-4 bg-main text-page text-sm">
        Copyright © Learnfinity Inc.
    </footer>
</x-format>