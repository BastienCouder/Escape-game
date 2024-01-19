<?php
require './src/dbConnect.php';
require './configs/global.php';

$answerId = $_GET['id'] ?? null;
$showForm = true;
$message = '';
$isCorrect = false;
$userAnswer = $_POST['answer'] ?? ''; 

if ($answerId) {
    $answer = readById('answers', $answerId);
    $successRate = calculateSuccessRate($answer);
} else {
    header("Location: /");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userAnswer = $_POST['answer'];
    $updatedData = ['nbr_attempts' => $answer['nbr_attempts'] + 1];

    if ($userAnswer === $answer['response']) {
        $updatedData['nbr_success'] = $answer['nbr_success'] + 1;
        $message = $answer['success_msg'];
        $isCorrect = true;
        $showForm = false;
    } else {
        $message = $answer['failure_msg'];
    }

    update('answers', $answerId, $updatedData);
    $showErrorMessage = !$isCorrect;
}
?>

<section class="w-full pt-24 px-4 lg:px-24 space-y-4 flex justify-center items-center">
    <div class="w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow space-y-4">
        <h2 class="text-2xl font-bold"><?= htmlspecialchars($answer['answer']) ?></h2>
        <p>Pourcentage de réussite: <?= $successRate ?>%</p>

        <?php if ($showForm): ?>
        <form method="post" class="flex flex-col gap-4">
            <input type="text" name="answer"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                required placeholder="Votre réponse">
            <button type="submit"
                class="w-44 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Valider</button>
        </form>
        <?php if (isset($showErrorMessage) && $showErrorMessage): ?>
        <div class="mt-2">
            <p class="text-sm font-medium text-red-700 dark:text-red-500">Mauvaise réponse</p>
            <small><?= htmlspecialchars($message) ?></small>
        </div>
        <?php endif; ?>
        <?php elseif ($isCorrect): ?>
        <div class="mb-5">
            <p class="text-sm font-medium text-green-700 dark:text-green-500">Bonne réponse</p>
            <small><?= htmlspecialchars($message) ?></small>
        </div>
        <?php endif; ?>
    </div>
</section>