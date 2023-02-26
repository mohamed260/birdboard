@extends ('layouts.app')

@section('content')
<div class="w-full bg-white mx-auto rounded-lg py-16 px-8 lg:w-1/2 dark:bg-gray-800">
    <h1 class="text-center text-4xl mb-10 dark:text-white">Let's Create Something New!!</h1>

    <form method="POST" action="/projects">

        @include('projects.form', [
        'project' => new App\Models\Project,
        'buttonText' => 'Create Project'
        ])

    </form>
</div>
 
@endsection