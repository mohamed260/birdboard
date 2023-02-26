@extends ('layouts.app')

@section('content')

    
    <header class="flex items-center mb-4 py-4">
        <div class="flex justify-between items-end w-full">
            <h3 class="text-gray-400 text-sm font-normal">My Projects</h3>
            <a href="/projects/create" class="bg-blue-400 text-white rounded-lg text-sm py-2 px-5">New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3 ">
        @forelse ($projects as $project)
           
        @include('projects.card')
        
        @empty

        <div>
            No Projects Yet.
        </div>

        @endforelse

    </main>    


@endsection
