

    @csrf

    <div class="field">
        <label class="dark:text-white" for="title">Title</label>

        <div class="control">
            <input class="bg-white p-5 rounded-lg shadow w-full mb-4 dark:bg-gray-800 dark:text-white" type="text" class="input" name="title" placeholder="title" required value="{{ $project->title }}">
        </div>
    </div>

    <div class="field">
        <label class="dark:text-white" for="description">Description</label>

        <div class="control">
            <textarea class="bg-white p-5 rounded-lg shadow w-full mb-4 dark:bg-gray-800 dark:text-white" name="description" required class="textarea">{{ $project->description }}</textarea>
        </div>
    </div>

    <div class="field">

        <div class="control">
            <button type="submit" class="bg-blue-400 text-white rounded-lg text-sm py-2 px-5">{{ $buttonText }}</button>
            <a class="dark:text-white" href="{{ $project->path() }}">Cancel</a>
        </div>
    </div>
    @if($errors->any())
        <div class="field mt-6 text-gray-400">
            
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            
        </div>
    @endif


   
