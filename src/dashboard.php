<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include './Config/db.php';
include './Config/mongodb.php';
require_once './Classes/Games.php';

use MongoDB\BSON\UTCDateTime;

$userId = $_SESSION['user_id'];

// Instanciation de la classe Games
$db = mongo_db();
$gamesClass = new Games($db);
$games = $gamesClass->getGamesByUser($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Vault - Your Video Game Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css" />
</head>

<?php include 'header.php'; ?>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Rechercher un jeu..." 
                               class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button id="addGameBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full flex items-center">
                        <i class="fas fa-plus mr-2"></i> Ajouter
                    </button>
                </div>
            </div>
        </header>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 flex items-center">
                <div class="bg-indigo-100 p-3 rounded-full mr-4">
                    <i class="fas fa-gamepad text-indigo-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jeux Totaux</p>
                    <h3 id="totalGames" class="text-2xl font-bold">0</h3>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 flex items-center">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Completé(s)</p>
                    <h3 id="completedGames" class="text-2xl font-bold">0</h3>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-play-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">En cours</p>
                    <h3 id="playingGames" class="text-2xl font-bold">0</h3>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 flex flex-wrap items-center gap-3">
            <div class="flex items-center">
                <label for="statusFilter" class="mr-2 text-gray-600">Statut:</label>
                <select id="statusFilter" class="rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="all">Tout</option>
                    <option value="completed">Completé</option>
                    <option value="playing">En cours</option>
                    <option value="abandoned">Abandonné</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="platformFilter" class="mr-2 text-gray-600">Platforme:</label>
                <select id="platformFilter" class="rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="all">Tout</option>
                    <option value="pc">PC</option>
                    <option value="playstation">PlayStation</option>
                    <option value="xbox">Xbox</option>
                    <option value="nintendo">Nintendo</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="sortBy" class="mr-2 text-gray-600">Trié par:</label>
                <select id="sortBy" class="rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="name-asc">Nom (A-Z)</option>
                    <option value="name-desc">Nom (Z-A)</option>
                    <option value="rating-desc">Note (Plus-Moins)</option>
                    <option value="rating-asc">Note (Moins-Plus)</option>
                    <option value="date-desc">Recemment Ajouté</option>
                    <option value="date-asc">Oldest Ajouté</option>
                </select>
            </div>
        </div>

        <?php if (!empty($games)) : ?>
            <?php foreach ($games as $game) : ?>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold"><?= htmlspecialchars($game['title']) ?></h3>
                    <p class="text-sm text-gray-500">Platform: <?= htmlspecialchars($game['platform']) ?></p>
                    <p>Status: <?= htmlspecialchars($game['status']) ?></p>
                    <p>Note: <?= $game['rating'] ?? '-' ?>/10</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-gamepad text-5xl mb-4 text-gray-300"></i>
                <h3 class="text-xl font-medium">Votre collection est vide</h3>
                <p>Ajouter votre premier jeu pour commencer</p>
            </div>
        <?php endif; ?>

        <!-- Add Game Modal -->
        <div id="addGameModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b px-6 py-4">
                    <h3 class="text-xl font-semibold text-gray-800">Ajouter un jeu</h3>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <form id="gameForm">
                        <div class="mb-4">
                            <label for="gameImage" class="block text-gray-700 mb-2">Jaquette du jeu</label>
                            <div class="flex items-center">
                                <input type="file" id="gameImage" accept="image/*" class="hidden">
                                <label for="gameImage" class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-l border border-r-0 border-gray-300">
                                    <i class="fas fa-image mr-2"></i>Choose File
                                </label>
                                <div id="fileName" class="px-3 py-2 border border-gray-300 rounded-r text-sm text-gray-500 truncate flex-grow">No file chosen</div>
                            </div>
                            <div id="imagePreview" class="mt-2 hidden">
                                <img id="previewImage" src="#" alt="Preview" class="max-h-40 rounded">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="gameTitle" class="block text-gray-700 mb-2">Titre du jeu*</label>
                            <input type="text" id="gameTitle" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="gamePlatform" class="block text-gray-700 mb-2">Platforme*</label>
                            <select id="gamePlatform" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Platform</option>
                                <option value="pc">PC</option>
                                <option value="playstation">PlayStation</option>
                                <option value="xbox">Xbox</option>
                                <option value="nintendo">Nintendo</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="gameStatus" class="block text-gray-700 mb-2">Statut*</label>
                            <select id="gameStatus" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Selectionnez le Statut</option>
                                <option value="completed">Completé</option>
                                <option value="playing">En train de jouer</option>
                                <option value="abandoned">Abandonné</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="gameRating" class="block text-gray-700 mb-2">Votre Note (0-10)</label>
                            <input type="number" id="gameRating" min="0" max="10" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="gameHours" class="block text-gray-700 mb-2">Heures Joués</label>
                            <input type="number" id="gameHours" min="0" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="gameNotes" class="block text-gray-700 mb-2">Commentaire</label>
                            <textarea id="gameNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="cancelGameBtn" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Annuler</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Game Details Modal -->
        <div id="gameDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b px-6 py-4">
                    <h3 id="detailGameTitle" class="text-xl font-semibold text-gray-800">Game Details</h3>
                    <button id="closeDetailsModalBtn" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div id="detailPlatformIcon" class="platform-icon bg-gray-200 rounded-full mr-3">
                            <i class="fas fa-question text-gray-600"></i>
                        </div>
                        <div>
                            <p id="detailPlatform" class="text-gray-600">Platform</p>
                            <p id="detailStatus" class="text-sm px-2 py-1 rounded-full inline-block bg-gray-100 text-gray-700">Status</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-gray-500 text-sm">Rating</p>
                            <p id="detailRating" class="text-lg font-medium">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Hours Played</p>
                            <p id="detailHours" class="text-lg font-medium">-</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-500 text-sm mb-1">Notes</p>
                        <p id="detailNotes" class="text-gray-700 bg-gray-50 p-3 rounded">No notes added</p>
                    </div>
                    <div class="flex justify-between pt-4 border-t">
                        <button id="editGameBtn" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                        <button id="deleteGameBtn" class="text-red-600 hover:text-red-800 flex items-center">
                            <i class="fas fa-trash-alt mr-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>