<div class="bg-white px-4 py-12 sm:px-6 lg:px-8">
    <form wire:submit="save" onkeydown="return event.key != 'Enter';">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">New User</h2>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-full">
                        <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                            <input type="text" wire:model="form.name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <div class="mt-1">
                            @error('form.name') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="sm:col-span-full">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">E-mail</label>
                        <div class="mt-2">
                            <input type="email" wire:model="form.email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <div class="mt-1">
                            @error('form.email') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="sm:col-span-full">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input type="password" wire:model="form.password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <div class="mt-1">
                            @error('form.password') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button wire:click="$dispatch('closeModal')">Close</button>
                <button wire:submit
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Save
                </button>
            </div>
    </form>
</div>
