<?php
require './src/dbConnect.php';
require './configs/global.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $question = readSpecificQuestion($id); // Assurez-vous que cette fonction est définie pour récupérer une question spécifique

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userAnswer = $_POST['answer'];
        $isCorrect = ($userAnswer === $question['expected_answer']); // Vérifiez la réponse

        if ($isCorrect) {
            $message = $question['success_message'];
            $showForm = false;
        } else {
            $message = $question['failure_message'];
            $showForm = true;
        }
    } else {
        $showForm = true;
    }
} else {
    header('Location: index.php'); // Redirige vers la liste des questions si aucun ID n'est spécifié
    exit;
}
?>
<section class="w-full pt-24 px-4 lg:px-24 mx-auto space-y-4">
    <h2 class="text-2xl font-bold"><?= htmlspecialchars($question['question']) ?></h2>
    <p>Pourcentage de réussite: <?= calculateSuccessRate($question) ?>%</p>

    <?php if ($showForm): ?>
    <form method="post">
        <input type="text" name="answer" placeholder="Votre réponse">
        <button type="submit">Valider</button>
    </form>
    <?php else: ?>
    <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</section>