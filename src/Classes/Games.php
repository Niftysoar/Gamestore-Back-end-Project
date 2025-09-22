<?php
class Games {
    private $collection;

    public function __construct($db) {
        $this->collection = $db->user_games; // collection "user_games"
    }

    // Ajouter un jeu
    public function addGame($userId, $image, $title, $platform, $status, $rating = null, $hours = 0, $notes = '') {
        $game = [
            "user_id" => $userId,
            "image" => $image,
            "title" => $title,
            "platform" => $platform,
            "status" => $status,
            "rating" => $rating,
            "hours_played" => $hours,
            "notes" => $notes,
            "created_at" => new MongoDB\BSON\UTCDateTime()
        ];

        $this->collection->insertOne($game);
        return true;
    }

    // Récupérer les jeux d’un utilisateur
    public function getGamesByUser($userId) {
        return $this->collection->find(
            ["user_id" => (int) $userId],
            ["sort" => ["created_at" => -1]]
        );
    }

    // Supprimer un jeu
    public function deleteGame($id) {
        try {
            $result = $this->collection->deleteOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)]
            );
            return $result->getDeletedCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // Compter les jeux
    public function countGamesByUser($userId) {
        $pipeline = [
            ['$match' => ['user_id' => (int)$userId]],
            [
                '$group' => [
                    '_id' => '$status',
                    'count' => ['$sum' => 1]
                ]
            ]
        ];

        $result = $this->collection->aggregate($pipeline);

        $counts = [
            'total' => 0,
            'completé' => 0,
            'en-cours' => 0
        ];

        foreach ($result as $doc) {
            $counts['total'] += $doc['count'];

            if ($doc['_id'] === 'completé') {
                $counts['completé'] = $doc['count'];
            } elseif ($doc['_id'] === 'en cours') {
                $counts['en-cours'] = $doc['count'];
            }
        }

        return $counts;
    }

}