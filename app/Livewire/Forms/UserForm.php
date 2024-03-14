<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;
    public string $id = '';

    #[Validate()]
    public string $name = '';
    #[Validate()]
    public string $username = '';
    #[Validate()]
    public string $phone = '';
    #[Validate()]
    public string $email = '';
    #[Validate()]
    public string $password = '';

    public bool $isAdd = false;
    public bool $isEdit = false;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:5',
                Rule::unique('users', 'name')->ignore($this->user),
            ],
            'username' => [
                'required', 'min:4',
                Rule::unique('users', 'username')->ignore($this->user),
            ],
            'phone' => [
                'required', 'min_digits:11', 'numeric',
                Rule::unique('users', 'phone')->ignore($this->user),
            ],
            'email' => [
                'required', 'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'password' => [
                'required', 'min:6',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib di-isi',
            'name.min' => 'Minimal 5 karakter',
            'username.required' => 'Deskripsi wajib di-isi',
            'username.min' => 'Minimal 4 karakter',
            'phone.required' => 'Nomor Handphone wajib di-isi',
            'phone.min_digits' => 'Minimal 11 karakter',
            'phone.numeric' => 'Harus angka',
            'email.required' => 'Email wajib di-isi',
            'password.required' => 'Password wajib di-isi',
        ];
    }

    public function setCreate(): void
    {
        $this->isAdd = true;
        $this->isEdit = false;
    }

    public function setUpdate(User $user = null): void
    {
        $this->isAdd = false;
        $this->isEdit = true;

        //$this->id = $user->id;
        $this->user = $user;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->password = $user->password;
        //dd($this->name);
    }

    public function doDelete($id): void
    {
        try {
            User::find($id)->delete();
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
                User::create($validated);
                $this->reset();
                $this->isAdd = false;
                session()->flash('success', 'Data baru tersimpan.');
            } catch (\Exception $ex) {
                session()->flash('error', 'Terjadi kesalahan.' . $ex);
            }
        } elseif ($this->isEdit === true) {
            try {
                //dd('doUpdate');
                $this->user->update($validated);
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
