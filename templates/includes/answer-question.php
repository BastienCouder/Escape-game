<?php
require './src/dbConnect.php';
require './configs/global.php';

$data = read('answers');

?>
<section class="w-full pt-24 px-4 lg:px-24 mx-auto space-y-4">
    <h2 class="text-2xl font-bold">Liste des Questions</h2>
    <ul class="flex w-full gap-8 flex-wrap">
        <?php foreach ($data as $row): ?>
        <li class="list-none w-full lg:w-1/4 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
            <a href="./question?id=<?= htmlspecialchars($row['id']) ?>">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                    <?= htmlspecialchars($row['answer']) ?></h5>
                <p>Pourcentage de réussite: <?= calculateSuccessRate($row) ?>%</p>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>