<?php

namespace Api\Controller;

use Api\Model;

/*
 * Locations Controller.
 */
class LocationsController
{
    /*
     * Function gets one location.
     * 
     * @return string|array
     */
    public function getOneAction()
    {
        if (filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT)) {
            $id = $_GET['id'];
            $model = new Model\LocationsModel();
            $result = $model->getOne($id);
            header('HTTP/1.1 200 OK');
        } else {
            header('HTTP/1.1 405 => Method Not Allowed');
            $result = 'Wrong parameter';
        }
        
        return $result;
    }

    /*
     * Function searches for a list of locations by name.
     * 
     * @return string|array
     */
    public function searchByNameAction()
    {
        if (filter_var($_GET['query'], FILTER_SANITIZE_STRING)) {
            $query = $_GET['query'];
            $model = new Model\LocationsModel();
            $result = $model->findByName($query);
            header('HTTP/1.1 200 OK');
        } else {
            header('HTTP/1.1 405 => Method Not Allowed');
            $result = 'Wrong parameter';
        }

        return $result;
    }

    /*
     * Searches for a list of locations within a certain 
     * distance from the seat home.pl.
     * 
     * @return string|array
     */
    public function searchByDistanceAction()
    {
        if (!empty($_GET['distance'])) {
            $distance = filter_var($_GET['distance'], FILTER_SANITIZE_STRING);
            $model = new Model\LocationsModel();
            $result = $model->findByDistance($distance);
            foreach ($result as $key => &$value) {
                unset($value['distance']);
            }
            header('HTTP/1.1 200 OK');
        } else {
            header('HTTP/1.1 405 => Method Not Allowed');
            $result = 'Wrong parameter';
        }

        return $result;
    }

    /*
     * Function adds new locations to the database.
     * 
     * @return string
     */
    public function postAction()
    {
        if (is_array($_POST)) {
            $model = new Model\LocationsModel();
            $result = $model->insert($_POST);
            if ($result == true) {
                header('HTTP/1.1 201 Created');
                $result = 'Success';
            } else {
                header('HTTP/1.1 400 Bad Request');
                $result = 'Error';
            }
        } else {
            header('HTTP/1.1 405 => Method Not Allowed');
            $result = 'Wrong parameter';
        }

        return $result;
    }

    /*
     * Function updates the location parameters in the database.
     * 
     * @return string
     */
    public function putAction()
    {
        if (filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT)) {
            $id = $_GET['id'];
            $file = file_get_contents('php://input');
            $data = (array) json_decode($file);
            if (empty($data)) {
                header('HTTP/1.1 405 => Method Not Allowed');
                $result = 'Wrong parameters';

                return $result;
            }
            $model = new Model\LocationsModel();
            $result = $model->update($id, $data);

            if ($result == true) {
                header('HTTP/1.1 200 OK');
                $result = 'Success';
            } else {
                header('HTTP/1.1 400 Bad Request');
                $result = 'Error';
            }
        } else {
            header('HTTP/1.1 405 => Method Not Allowed');
            $result = 'Wrong parameter';
        }

        return $result;
    }

    /*
     * Function removes a location database.
     * 
     * @return string
     */
    public function deleteAction()
    {
        if (filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT)) {
            $id = $_GET['id'];
            $model = new Model\LocationsModel();
            $result = $model->delete($id);
            if ($result == true) {
                header('HTTP/1.1 200 OK');
                $result = 'Success';
            } else {
                header('HTTP/1.1 400 Bad Request');
                $result = 'Error';
            }
        } else {
            header('HTTP/1.1 405 => Method Not Allowed');
            $result = 'Wrong parameter';
        }

        return $result;
    }
}
