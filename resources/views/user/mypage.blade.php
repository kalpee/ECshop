<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    マイページ
                </h2>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>その他メニュー</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                            <x-dropdown-link :href="route('user.terms.index')"
                            :active="request()->routeIs('user.terms.index')">
                                利用規約
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('user.faq.index')"
                            :active="request()->routeIs('user.faq.index')">
                                よくある質問
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('user.privacy.index')"
                            :active="request()->routeIs('user.privacy.index')">
                                プライバシーポリシー
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('user.tokushoho.index')"
                            :active="request()->routeIs('user.tokushoho.index')">
                                特定商取引法に基づく表記
                            </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            登録情報
                        </h3>
                        
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    名前
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div>{{ Auth::user()->name }}</div>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    メールアドレス
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div>{{ Auth::user()->email }}</div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>
    