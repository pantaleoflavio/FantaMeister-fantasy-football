<x-filament::dropdown placement="bottom-end">
    <x-slot name="trigger">
        <x-filament::icon-button icon="heroicon-o-language" :label="__('admin.locale_switcher.label')" color="gray" />
    </x-slot>

    <x-filament::dropdown.header>
        {{ __('admin.locale_switcher.label') }}
    </x-filament::dropdown.header>

    <x-filament::dropdown.list>
        @foreach (config('admin.supported_locales') as $locale)
            <form method="POST" action="{{ route('admin.locale.update', ['locale' => $locale]) }}">
                @csrf
                <x-filament::dropdown.list.item type="submit"
                    icon="{{ app()->getLocale() === $locale ? 'heroicon-o-check' : null }}">
                    {{ __("admin.locale_switcher.locales.{$locale}") }}
                </x-filament::dropdown.list.item>
            </form>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
