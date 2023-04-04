<x-app-layout>
    <!-- https://docs.peopledatalabs.com/docs/company-search-api?gclid=Cj0KCQjwiZqhBhCJARIsACHHEH86kQrKaut6M1Z3x3v2P591ZWi8JEtWwUkIgebIdpVnJBzHH62DhuMaArFkEALw_wcB -->

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Your Portfolio Avg Return: {{ number_format( ($stocks['average']*100), 2) }}%
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                        data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-1" role="presentation">
                            <button
                                class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 dark:border-blue-500"
                                id="intro-tab" data-tabs-target="#intro" type="button" role="tab"
                                aria-controls="intro" aria-selected="true">Intro</button>
                        </li>
                    
                        <li class="mx-1" role="presentation">
                            <button
                                class="inline-block p-4 text-gray-500 border-b-2 border-transparent border-gray-100 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent dark:text-gray-400 dark:border-gray-700"
                                id="tabOne-tab" data-tabs-target="#tabOne" type="button" role="tab"
                                aria-controls="tabOne" aria-selected="false">{{ strtoupper($stocks['tickers'][0]) }}</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 text-gray-500 border-b-2 border-transparent border-gray-100 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent dark:text-gray-400 dark:border-gray-700"
                                id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                aria-controls="settings" aria-selected="false">{{ strtoupper($stocks['tickers'][1]) }}</button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 text-gray-500 border-b-2 border-transparent border-gray-100 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent dark:text-gray-400 dark:border-gray-700"
                                id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                                aria-controls="contacts" aria-selected="false">{{ strtoupper($stocks['tickers'][2]) }}</button>
                        </li>

                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="intro" role="tabpanel"
                        aria-labelledby="intro-tab">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Welcome to RoFF.<br>
                            Your One Step Shop for Stock Prediction and Analysis.<br>
                            Join Our Community Forum to Participate in the Latest Market related discussion.

                        </p>

                    </div>                   

                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="tabOne" role="tabpanel"
                        aria-labelledby="tabOne-tab">
                        <p class="text-sm text-gray-500 dark:text-gray-400"> 
                            Your Expected Return: {{ number_format( ($stocks['returns'][0]*100), 2) }}%
                        </p>
                    </div>

                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel"
                        aria-labelledby="settings-tab">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                        Your Expected Return: {{ number_format( ($stocks['returns'][1]*100), 2) }}%
                        </p>
                    </div>

                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel"
                        aria-labelledby="contacts-tab">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                        Your Expected Return: {{ number_format( ($stocks['returns'][2]*100), 2) }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
