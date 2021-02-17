<?php $index = 1; ?>
<h1 class="text-5xl mb-10">Best Games</h1>

<div class="grid grid-cols-1 gap-4">
    <?php foreach ($highestScores as $game => $score): ?>
        <div class="shadow-lg rounded float-left bg-white dark:bg-gray-800 p-4">
            <div class="flex-row gap-4 flex items-center">
                <div class="flex flex-1 inline-flex">
                    <span class="px-4 py-2 inline-block hover:bg-pink-500 bg-pink-600 text-white rounded-full justify-center items-center dark:text-white rounded-full text-lg font-medium inline-block">
                        <?= $index ?>
                    </span>
                    <span class="ml-3 text-gray-600 dark:text-white text-lg font-medium inline-flex items-center">
                        <?= $game ?>
                    </span>
                    <span class="ml-3 text-gray-400 font-bold text-lg inline-flex items-center">
                        Score : <?= $score ?>
                    </span>

                </div>
            </div>
            <!--<div class="flex inline-flex">
                <span class="px-4 py-2 inline-block hover:bg-blue-500 bg-blue-400 text-white rounded-full inset-x-0"><i class="fas fa-award"></i>
            </span>
            </div>-->
        </div>
        <?php $index++ ?>
    <?php endforeach; ?>
</div>

