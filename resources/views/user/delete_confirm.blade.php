<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            退会確認
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="my-5">退会をすると投稿も全て削除されます。</p>
                    <p class="my-5">それでも退会をしますか？</p>
                    <div class="my-20">
                        <form method="POST" action="{{ route('user.mypage.destroy') }}">
                            @csrf
                            <x-button value="back" type="button" onclick="location.href='{{ route('user.mypage.index')}}'">
                                {{ __('マイページに戻る') }}
                            </x-button>
                            <x-button class="ml-4">
                                {{ __('退会する') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
