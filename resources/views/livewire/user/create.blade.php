@php
    $label = __('New User');
@endphp
<div>
    <x-mary-button class="btn-primary btn-sm" :label="$label" wire:click="$toggle('showModal')"/>

    @if($showModal)
        <x-mary-modal wire:model="showModal" persistent>
            <x-user.form :title="$label"/>
        </x-mary-modal>
    @endif
</div>
