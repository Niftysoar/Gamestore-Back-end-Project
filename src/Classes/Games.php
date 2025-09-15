<?php
class Games {
    private $collection;

    public function __construct($db) {
        $this->collection = $db->Games;
    }

    public function getGamesByUser($userId) {
        return $this->collection
            ->find(['user_id' => (int)$userId])
            ->toArray();
    }

    public function addGame($userId, $data) {
        $data['user_id'] = (int)$userId;
        $data['created_at'] = new MongoDB\BSON\UTCDateTime();
        return $this->collection->insertOne($data);
    }

    public function deleteGame($gameId, $userId) {
        return $this->collection->deleteOne([
            '_id' => new MongoDB\BSON\ObjectId($gameId),
            'user_id' => (int)$userId
        ]);
    }
}