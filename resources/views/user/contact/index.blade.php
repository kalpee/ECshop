<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            お問い合わせ
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('user.contact.confirm') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('名前')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            @if ($errors->has('name'))
                                <p class="error-message">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('メールアドレス')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            @if ($errors->has('email'))
                                <p class="error-message">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="title" :value="__('タイトル')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            @if ($errors->has('title'))
                                <p class="error-message">{{ $errors->first('title') }}</p>
                            @endif
                        </div>

                        <!-- contact -->
                        <div class="mt-4">
                            <x-label for="contact" :value="__('お問い合わせ内容')" />

                            <x-textarea id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')" required />
                            @if ($errors->has('contact'))
                                <p class="error-message">{{ $errors->first('contact') }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('送信') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
