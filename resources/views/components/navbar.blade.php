<!-- navbar.blade.php -->

<nav class="navBargeral bg-[#333333]">
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('alunos.create')" :active="request()->routeIs('alunos.create')">
            {{ __('Criar Conta') }}
        </x-nav-link>

        <x-nav-link :href="route('alunos.index')" :active="request()->routeIs('alunos.index')">
            {{ __('Alunos') }}
        </x-nav-link>
    </div>
</nav>
