<div class="lg:w-1/3 px-3 pb-6">
    <div class="bg-white  p-5 rounded-lg shadow dark:bg-gray-800" style="height:200px">
        <h3 class="font-normal text-xl mb-3 py-4 -ml-5 border-l-4 border-blue-300 pl-4 dark:text-white">
            <a href="{{ $project->path() }}">{{ $project->title }}</a>
        </h3>

        <div class="text-gray-400 dark:text-gray-400">
            {{ Str::limit($project->description, 100) }}
        </div>
    </div>
</div>