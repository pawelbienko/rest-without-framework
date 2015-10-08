<?php

namespace Api\Model;

/**
 * Locations Model
 * 
 */
class LocationsModel extends \Api\Model\Model
{
    /*
     * Retrieves from the database one location.
     * 
     * @param int $id Location ID
     * 
     * @return array|string
     */
    public function getOne($id)
    {
        $query = $this->pdo->prepare('SELECT * from locations WHERE id=:id');
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        $item = $query->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($item)) {
            return 'Not found';
        }

        return $item;
    }

    /*
     * Searches in the database, the locations of the phrase.
     * 
     * @param string $needle Search phrase
     *
     * @return array|string 
     */
    public function findByName($needle)
    {
        $query = $this->pdo->prepare('SELECT * from locations WHERE name
                LIKE :query OR address LIKE :query ORDER By name');
        $needle = '%'.$needle.'%';
        $query->bindParam('query', $needle);
        $query->execute();
        $items = $query->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($items)) {
            return 'Not found';
        }

        return $items;
    }

    /*
     * Searches in the database, locations of a given distance from the seat home.pl.
     * 
     * @param int $distance
     * 
     * @return array|string 
     */
    public function findByDistance($distance)
    {
        $query = $this->pdo->prepare('SELECT id, name, address, lat, lng, 
                ( 6371 * acos( cos( radians(:homepl_lat) ) 
                * cos( radians( lat ) ) 
                * cos( radians( lng ) - radians(:homepl_lng) ) 
                + sin( radians(:homepl_lat) ) 
                * Sin( radians( lat ) ) ) ) 
                AS distance 
                FROM locations HAVING distance < :distance 
                ORDER BY distance LIMIT 0 , 20;');
        $query->bindValue(':homepl_lat', HOMEPL_LAT,   \PDO::PARAM_STR);
        $query->bindValue(':homepl_lng', HOMEPL_LNG,   \PDO::PARAM_STR);
        $query->bindValue(':distance', $distance,    \PDO::PARAM_STR);
        $query->execute();
        $items = $query->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($items)) {
            return 'Not found';
        }

        return $items;
    }

    /*
     * Adds a new location to the database.
     * 
     * @param array $data Params of location
     * 
     * @return bool
     */
    public function insert($data)
    {
        $ins = $this->pdo->prepare('INSERT INTO locations 
                (name, address, lat, lng) 
                VALUES (:name, :address, :lat, :lng)');
        $ins->bindValue(':name', $data['name'],    \PDO::PARAM_STR);
        $ins->bindValue(':address', $data['address'], \PDO::PARAM_STR);
        $ins->bindValue(':lat', $data['lat'],     \PDO::PARAM_STR);
        $ins->bindValue(':lng', $data['lng'],     \PDO::PARAM_STR);
        $status = $ins->execute();

        return $status;
    }

    /**
     * Remove location in database.
     *
     * @param int $id Location ID 
     * 
     * @return bool
     */
    public function delete($id)
    {
        $del = $this->pdo->prepare('DELETE FROM locations where id=:id');
        $del->bindValue(':id', $id, \PDO::PARAM_INT);
        $status = $del->execute();

        return $status;
    }

    /**
     * Update location in database.
     * 
     * @param int   $id   ID location
     * @param array $data Params to update
     * 
     * @return bool
     */
    public function update($id, $data)
    {
        $upd = $this->pdo->prepare('UPDATE locations SET 
                name=:name, address=:address, lat=:lat, lng=:lng 
                WHERE id=:id');
        $upd->bindValue(':name', $data['name'],    \PDO::PARAM_STR);
        $upd->bindValue(':address', $data['address'], \PDO::PARAM_STR);
        $upd->bindValue(':lat', $data['lat'],     \PDO::PARAM_STR);
        $upd->bindValue(':lng', $data['lng'],     \PDO::PARAM_STR);
        $upd->bindValue(':id', $id,              \PDO::PARAM_STR);
        $status = $upd->execute();

        return $status;
    }
}
