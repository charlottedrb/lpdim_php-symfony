<h1 class="text-5xl">Best Games</h1>

<div class="grid grid-cols-5 gap-4">
    <?php foreach ($bestGames as $game): ?>
        <div class="shadow-lg rounded float-left bg-white dark:bg-gray-800 p-4">
            <div class="flex-row gap-4 flex justify-center items-center">
                <div class=" flex flex-col">
                    <span class="text-gray-600 dark:text-white text-lg font-medium">
                        <?= $game->getName(); ?>
                    </span>
                    <span class="text-gray-400 text-xs">
                        <?= $game->getName(); ?>
                    </span>
                    <span class="text-gray-400 text-xs">

                        <a class="hover:text-gray-600" href="/games/show?id=<?= $game->getId(); ?>">
                            <i class="fas fa-eye"></i>
                        </a>
                    </span>

                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>

