<?php
require './src/dbConnect.php';
require './configs/global.php';
$url = json_decode(file_get_contents('./config.json'), true);


if (isset($_POST['answer'], $_POST['response'], $_POST['success_msg'], $_POST['failure_msg'])) {
  $tableName = 'answers';  
  $newData = [
    'answer' => $_POST['answer'],
    'response' => $_POST['response'],
    'success_msg' => $_POST['success_msg'],
    'failure_msg' => $_POST['failure_msg'],  
  ];
 create($tableName, $newData);
 
   echo    
   "<div class='absolute px-8 py-4 bg-white flex flex-col top-1/2 border border-green-500 -translate-x-2/4 -translate-y-2/4 left-1/2 justify-center items-center text-black drop-shadow-lg'>
   Question ajoutée avec succès !
   </div>";    
}


?>

<section class="w-full lg:w-1/2 pt-44 pb-12 md:pt-16 px-4 lg:px-24 mx-auto">

    <h2 class="my-4 text-xl font-bold text-gray-900">Ajouter une question</h2>
    <form action="#" method="post">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-2">
                <label for="answer"
                    class="first-letter:uppercase block mb-2 text-sm font-medium text-gray-900">question</label>
                <input type="text" name="answer" id="answer"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    required="">
            </div>
            <div class="sm:col-span-2">
                <label for="response"
                    class="first-letter:uppercase block mb-2 text-sm font-medium text-gray-900">reponse</label>
                <textarea name="response" id="response" rows="8"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                    required=""></textarea>
            </div>
            <div class="sm:col-span-2">
                <label for="success_msg"
                    class="first-letter:uppercase block mb-2 text-sm font-medium text-gray-900">message de
                    succès</label>
                <input type="text" name="success_msg" id="success_msg"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    required="">
            </div>
            <div class="sm:col-span-2">
                <label for="failure_msg"
                    class="first-letter:uppercase block mb-2 text-sm font-medium text-gray-900">message d'erreur</label>
                <input type="text" name="failure_msg" id="failure_msg"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    required="">
            </div>
        </div>
        <input type="submit" value="Ajouter Question"
            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-zinc-700 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">

    </form>

</section>