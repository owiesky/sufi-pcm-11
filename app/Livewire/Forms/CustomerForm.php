<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{
    public ?Customer $customer = null;
    public string $id = '';

    #[Validate()]
    public string $name = '';
    #[Validate()]
    public string $description = '';

    public bool $isAdd = false;
    public bool $isEdit = false;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:5',
                Rule::unique('customers', 'name')->ignore($this->customer),
            ],
            'description' => ['required', 'min:5'],
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

    public function setUpdate(Customer $customer = null): void
    {
        $this->isAdd = false;
        $this->isEdit = true;

        //$this->id = $customer->id;
        $this->customer = $customer;
        $this->name = $customer->name;
        $this->description = $customer->description;
        //dd($this->name);
    }

    public function doDelete($id): void
    {
        try {
            Customer::find($id)->delete();
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
                //dd('doCreate');
                Customer::create($validated);
                $this->reset();
                $this->isAdd = false;
                session()->flash('success', 'Data baru tersimpan.');
            } catch (\Exception $ex) {
                session()->flash('error', 'Terjadi kesalahan.');
            }
        } elseif ($this->isEdit === true) {
            try {
                //dd('doUpdate');
                $this->customer->update($validated);
                $this->reset();
                $this->isEdit = false;
                session()->flash('success', 'Data perubahan tersimpan.');
            } catch (\Exception $ex) {
                session()->flash('error', 'Terjadi kesalahan.');
            }
        }
        $this->reset();
    }
}
