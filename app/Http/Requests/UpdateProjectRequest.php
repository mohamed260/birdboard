<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required',
    
            'description' => 'sometimes|required',
    
            'notes' => 'nullable',
        ];
    }

    public function project()
    {
        return Project::findOrFail($this->route('project'));

    }

    public function save()
    {
        
        return tap($this->project())->update($this->validated());

    }
}
