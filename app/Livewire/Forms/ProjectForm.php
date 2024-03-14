<?php

namespace App\Livewire\Forms;

use App\Models\Project;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProjectForm extends Form
{
    public ?Project $project = null;
    public string $id = '';

    #[Validate()]
    public string $name = '';
    #[Validate()]
    public string $description = '';
    #[Validate()]
    public $selectedCustomer;

    public bool $isAdd = false;
    public bool $isEdit = false;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:5',
                Rule::unique('projects', 'name')->ignore($this->project),
            ],
            'description' => ['required', 'min:5'],
            //'customer_id' => ['numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib di-isi',
            'name.min' => 'Minimal 5 karakter',
            'description.required' => 'Deskripsi wajib di-isi',
            'description.min' => 'Minimal 5 karakter',
        ];
    }

    public function setCreate(): void
    {
        $this->isAdd = true;
        $this->isEdit = false;
    }

    public function setUpdate(Project $project = null): void
    {
        $this->isAdd = false;
        $this->isEdit = true;

        //$this->id = $project->id;
        $this->project = $project;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->selectedCustomer = $project->customer_id;
        //dd($this->name);
    }

    public function doDelete($id): void
    {
        try {
            Project::find($id)->delete();
            session()->flash('success', "Berhasil dihapus");
        } catch (\Exception $e) {
            session()->flash('error', "Gagal dihapus");
        }
    }

    public function doCancel(): void
    {
        //dd('doCancel');
        $this->reset();
    }

    public function store(): void
    {
        $validated = $this->validate();
        if ($this->isAdd === true) {
            try {
                //dd('doCreate : ' . $this->selectedCustomer);
                $project = new Project;
                $project->name = $this->name;
                $project->description = $this->description;
                $project->customer_id = $this->selectedCustomer;

                $project->save();
                $this->reset();
                $this->isAdd = false;
                session()->flash('success', 'Data baru tersimpan.');
            } catch (\Exception $ex) {
                session()->flash('error', 'Terjadi kesalahan.' . $ex);
            }
        } elseif ($this->isEdit === true) {
            try {
                //dd('doUpdate : ' . $this->selectedCustomer);
                $this->project->name = $this->name;
                $this->project->description = $this->description;
                $this->project->customer_id = $this->selectedCustomer;
                $this->project->save();
                $this->reset();
                $this->isEdit = false;
                session()->flash('success', 'Data perubahan tersimpan.');
            } catch (\Exception $ex) {
                session()->flash('error', 'Terjadi kesalahan.' . $ex);
            }
        }
        $this->reset();
    }
}
