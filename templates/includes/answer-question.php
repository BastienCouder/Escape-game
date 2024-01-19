<?php
require './src/dbConnect.php';
require './configs/global.php';

$data = read('answers');
?>
<section class="w-full pt-44 md:pt-24 px-4 lg:px-24 mx-auto space-y-4">
    <h2 class="text-2xl font-bold">Liste des Questions</h2>
    <ul class="flex w-full gap-8 flex-wrap">
        <?php foreach ($data as $index => $row): ?>
        <li
            class="list-none w-full lg:w-1/4 flex flex-col justify-center items-center max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
            <a href="./?page=question&id=<?= htmlspecialchars($row['id']) ?>" class='flex items-center space-x-4'>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                    Question <?= $index + 1 ?></h5>
                <div class="border-2 border-black py-1 px-3 rounded-full -mt-2">
                    <i class="fa-solid fa-question"></i>
                </div>
            </a>
            <h6><?= htmlspecialchars($row['answer']) ?></h6>
        </li>
        <?php endforeach; ?>
    </ul>
</section>