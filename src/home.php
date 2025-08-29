<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <i class="fas fa-gamepad text-4xl text-indigo-600 mr-3"></i>
                    <h1 class="text-3xl font-bold text-gray-800">Game Vault</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search games..." 
                               class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button id="addGameBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Game
                    </button>
                </div>
            </div>
        </header>
        
    <!-- Add Game Modal -->
        <div id="addGameModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b px-6 py-4">
                    <h3 class="text-xl font-semibold text-gray-800">Add New Game</h3>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <form id="gameForm">
                        <div class="mb-4">
                            <label for="gameImage" class="block text-gray-700 mb-2">Game Cover Image</label>
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
                            <label for="gameTitle" class="block text-gray-700 mb-2">Game Title*</label>
                            <input type="text" id="gameTitle" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="gamePlatform" class="block text-gray-700 mb-2">Platform*</label>
                            <select id="gamePlatform" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Platform</option>
                                <option value="pc">PC</option>
                                <option value="playstation">PlayStation</option>
                                <option value="xbox">Xbox</option>
                                <option value="nintendo">Nintendo</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="gameStatus" class="block text-gray-700 mb-2">Status*</label>
                            <select id="gameStatus" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Status</option>
                                <option value="completed">Completed</option>
                                <option value="playing">Currently Playing</option>
                                <option value="backlog">Backlog</option>
                                <option value="abandoned">Abandoned</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="gameRating" class="block text-gray-700 mb-2">Your Rating (0-10)</label>
                            <input type="number" id="gameRating" min="0" max="10" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="gameHours" class="block text-gray-700 mb-2">Hours Played</label>
                            <input type="number" id="gameHours" min="0" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="gameNotes" class="block text-gray-700 mb-2">Notes</label>
                            <textarea id="gameNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="cancelGameBtn" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Game</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>
</html>