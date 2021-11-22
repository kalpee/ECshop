<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            お問い合わせ内容確認
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('user.contact.send') }}">
                        @csrf
                        <div>
                            <x-label for="name" :value="__('名前')" />
                            {{ $inputs['name'] }}
                            <x-input id="name" class="block mt-1 w-full" type="hidden" name="name" :value={{ $inputs['name'] }} />
                        </div>
                        <div class="mt-4">
                            <x-label for="email" :value="__('メールアドレス')" />
                            {{ $inputs['email'] }}
                            <x-input id="email" class="block mt-1 w-full" type="hidden" name="email" :value={{ $inputs['email'] }} />
                        </div>
                        <div class="mt-4">
                            <x-label for="title" :value="__('タイトル')" />
                            {{ $inputs['title'] }}
                            <x-input id="title" class="block mt-1 w-full" type="hidden" name="title" :value={{ $inputs['title'] }} />
                        </div>
                        <div class="mt-4">
                            <x-label for="contact" :value="__('お問い合わせ内容')" />
                            {{ $inputs['contact'] }}
                            <x-input id="contact" class="block mt-1 w-full" type="hidden" name="contact" :value={{ $inputs['contact'] }} />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4" value="back" type="button" onclick="location.href='{{ route('user.contact.index')}}'">
                                {{ __('入力画面に戻る') }}
                            </x-button>
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
