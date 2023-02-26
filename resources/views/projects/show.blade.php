@extends ('layouts.app')

@section('content')

    <header class="flex items-center mb-4 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-400 text-sm font-normal">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
            <a href="{{$project->path().'/edit'}}" class="bg-blue-400 text-white rounded-lg text-sm py-2 px-5">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">

                <div class="mb-8">
                    <h3 class="text-lg text-gray-400 font-normal mb-3">Tasks</h3>

                    @foreach ($project->tasks as $task)
                        <div class="bg-white p-5 rounded-lg shadow mb-3 dark:bg-gray-800">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                <div class="flex items-center">
                                    <input name="body" type="text" value="{{$task->body}}" class="border-none w-full dark:bg-gray-800 {{ $task->completed ? 'text-gray-400 dark:text-gray-600' : '' }} dark:text-white " >
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }} class=" dark:bg-gray-800">
                                </div>
                            </form>
                        </div>
                    @endforeach



                    <div class="bg-white p-5 rounded-lg shadow mb-3 dark:bg-gray-800">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input type="text" placeholder="Add a new task . . ." class="w-full border-none dark:bg-gray-800 dark:text-white" name="body">  
                        </form>
                    </div>

                </div>

                <div>
                    <h3 class="text-lg text-gray-400 font-normal mb-3">General Notes</h3>

                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" class="bg-white p-5 rounded-lg shadow w-full mb-4 dark:bg-gray-800 dark:text-white" style="min-height: 200px;">{{ $project->notes }}</textarea>

                        <button type="submit" class="bg-blue-400 text-white rounded-lg text-sm py-2 px-5">Save</button>
                    </form>
                </div>

                @if($errors->any())
                    <div class="field mt-6 text-gray-400">
            
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
            
                    </div>
                @endif

            </div>
            <div class="lg:w-1/4 px-3 lg:py-6">
                <div class="">
                    <div class="bg-white  p-5 rounded-lg shadow dark:bg-gray-800" style="height:200px">
                        <h3 class="font-normal text-xl mb-3 py-4 -ml-5 border-l-4 border-blue-300 pl-4 dark:text-white">
                            <a href="{{ $project->path() }}">{{ $project->title }}</a>
                        </h3>
                
                        <div class="text-gray-400 dark:text-gray-400">
                            {{ Str::limit($project->description, 100) }}
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-3 p-5 rounded-lg shadow dark:bg-gray-800">
                    <ul class="text-xs list-reset">
                        @foreach ($project->activity as $activity)
                            @if($activity->description === 'created')
                                <li class="{{ $loop->last ? '' : 'mb-1' }}">
                                    You created The Project <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
                                </li>
                            @elseif($activity->description === 'created_task')
                                <li class="{{ $loop->last ? '' : 'mb-1' }}">
                                    You created a task <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
                                </li>
                            @elseif($activity->description === 'completed_task')
                                <li class="{{ $loop->last ? '' : 'mb-1' }}">
                                    You completed a task <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
                                </li>
                            @elseif($activity->description === 'incompleted_task')
                                <li class="{{ $loop->last ? '' : 'mb-1' }}">
                                    You incompleted a task <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
                                </li>
                            @else
                                <li class="{{ $loop->last ? '' : 'mb-1' }}">
                                    {{ $activity->description }} <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </main>

    


@endsection