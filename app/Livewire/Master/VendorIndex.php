<?php

namespace App\Livewire\Master;

use App\Livewire\Forms\VendorForm;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class VendorIndex extends Component
{
    use WithPagination;
    public VendorForm $form;
    public bool $showVendorModal = false;

    public function render(): View
    {
        return view('livewire.master.vendor-index', [
            'vendors' => Vendor::paginate(5),
        ]);
    }

    public function add()
    {
        $this->showVendorModal = true;
        $this->form->setCreate();
    }

    public function edit($id)
    {
        $this->showVendorModal = true;
        $vendor = Vendor::findorfail($id);
        $this->form->setUpdate($vendor);
    }

    public function cancel()
    {
        $this->showVendorModal = false;
        $this->form->doCancel();
    }

    public function save()
    {
        $this->form->store();
        $this->showVendorModal = false;
    }

    public function delete($id)
    {
        $this->form->doDelete($id);
    }
}
