<?php

namespace App\Livewire\Master;

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerIndex extends Component
{
    use WithPagination;
    public CustomerForm $form;
    public bool $showCustomerModal = false;
    public bool $showProjectModal = false;

    public $projects;

    public function render(): View
    {
        return view('livewire.master.customer-index')
            ->with(['customers' => Customer::paginate(10)]);
    }

    public function add()
    {
        $this->showCustomerModal = true;
        $this->form->setCreate();
    }

    public function showProject($id)
    {
        //dd($id);
        $this->showProjectModal = true;
        $this->projects = DB::table('projects')
            ->where('customer_id', '=', $id)
            ->get();
    }

    public function edit($id)
    {
        $this->showCustomerModal = true;
        $customer = Customer::findorfail($id);
        $this->form->setUpdate($customer);
    }

    public function cancel()
    {
        $this->showCustomerModal = false;
        $this->form->doCancel();
    }

    public function save()
    {
        $this->form->store();
        $this->showCustomerModal = false;
    }

    public function delete($id)
    {
        $this->form->doDelete($id);
    }
}
