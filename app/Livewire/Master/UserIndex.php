<?php

namespace App\Livewire\Master;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;


class UserIndex extends Component
{

    use WithPagination;
    public UserForm $form;
    public bool $showUserModal = false;

    public function render(): View
    {
        return view('livewire.master.user-index', [
            'users' => User::paginate(5),
        ]);
    }

    public function add()
    {
        $this->showUserModal = true;
        $this->form->setCreate();
    }

    public function edit($id)
    {
        //dd('User ID : ' . $id);
        $this->showUserModal = true;
        $user = User::findorfail($id);
        $this->form->setUpdate($user);
    }

    public function cancel()
    {
        $this->showUserModal = false;
        $this->form->doCancel();
    }

    public function save()
    {
        $this->form->store();
        $this->showUserModal = false;
    }

    public function delete($id)
    {
        $this->form->doDelete($id);
    }
}
