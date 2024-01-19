<?php
require './src/dbConnect.php';
require './configs/global.php';

session_start();

function sortData($data) {
    $sortOrder = $_SESSION['sortOrder'] ?? 'asc';

    usort($data, function($a, $b) use ($sortOrder) {
        $a_percentage = $a['nbr_attempts'] > 0 ? $a['nbr_success'] / $a['nbr_attempts'] : 0;
        $b_percentage = $b['nbr_attempts'] > 0 ? $b['nbr_success'] / $b['nbr_attempts'] : 0;
        
        return ($sortOrder === 'asc') ? $a_percentage - $b_percentage : $b_percentage - $a_percentage;
    });

    return $data;
}

if (isset($_GET['sortOrder']) && in_array($_GET['sortOrder'], ['asc', 'desc'])) {
    $_SESSION['sortOrder'] = $_GET['sortOrder'];
}

if (isset($_POST['deleteAnswer'])) {
    $idToDelete = $_POST['id'];
    $tableName = 'answers';
    try {
        delete($tableName, $idToDelete);
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// Read and sort data
$data = read('answers');
$data = sortData($data);

$sortOrder = $_SESSION['sortOrder'] ?? 'asc';
$toggleOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
?>

<section class="w-full pt-24 px-4 lg:px-24 mx-auto space-y-4">
    <h2 class="text-2xl font-bold">Questions</h2>
    <div class='sorting-options'>
        <a href="?page=list-question&sortOrder=<?= $toggleOrder ?>"><span class="font-bold">Trier par taux de réussite
                :</span>
            <?= $toggleOrder === 'asc' ? 'croissant' : 'décroissant' ?></a>
    </div>
    <ul class="flex w-full gap-8 flex-wrap">
        <?php foreach ($data as $row) : 
            $pourcentageReussite = $row['nbr_attempts'] > 0 ? round(($row['nbr_success'] / $row['nbr_attempts']) * 100, 2) : 0;
        ?>
        <li class="list-none w-full lg:w-1/4 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900"><?= htmlspecialchars($row['answer']) ?>
            </h5>
            <p class="mb-3 font-normal text-gray-700"><span class="font-semibold">Réponse attendue:</span>
                <?= htmlspecialchars($row['response']) ?></p>
            <p class="mb-3 font-normal text-gray-700"><span class="font-semibold">Pourcentage de réussite:</span>
                <?= $pourcentageReussite ?>%</p>
            <form method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                <button type="submit" name="deleteAnswer"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Supprimer
                </button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
</section>