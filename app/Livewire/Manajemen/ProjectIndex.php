<?php

namespace App\Livewire\Manajemen;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectIndex extends Component
{
    use WithPagination;
    public ProjectForm $form;
    public bool $showProjectModal = false;

    public function render(): View
    {
        return view('livewire.manajemen.project-index', [
            'projects' => Project::paginate(5),
        ]);
    }

    public function add()
    {
        $this->showProjectModal = true;
        $this->form->setCreate();
    }

    public function edit($id)
    {
        $this->showProjectModal = true;
        $project = Project::findorfail($id);
        $this->form->setUpdate($project);
    }

    public function cancel()
    {
        $this->showProjectModal = false;
        $this->form->doCancel();
    }

    public function save()
    {
        $this->form->store();
        $this->showProjectModal = false;
    }

    public function delete($id)
    {
        $this->form->doDelete($id);
    }
}
