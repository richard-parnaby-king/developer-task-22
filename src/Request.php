<?php
/**
 * Service package to retrieve user data from a remote api.
 */
namespace RichardParnabyKing\DeveloperTask22;

use RichardParnabyKing\DeveloperTask22\Model\User;

class Request {
    protected $baseUrl = 'https://reqres.in/api';
    
    protected $curl;
    
    /**
     * Construct curl object.
     * @param Mixed $curl OPTIONAL Allow, eg, PHPUNIT to submit mock objects.
     */
    public function __construct($curl = null) {
        if(is_null($curl)) {
            $curl = new \Curl\Curl();
        }
        $this->curl = $curl;
    }
    
    /**
     * Retrieve a single user by ID 
     * @param int $userId
     * @return User|Null
     */
    public function getUser($userId) {
        $this->curl->get(sprintf('%s/users/%s', $this->baseUrl, $userId));
        if($this->curl->isSuccess()) {
            $response = $this->curl->response;
            $data = json_decode($response, true);
            /* @var User $user */
            $user = $this->populateUser($data['data']);
            return $user;
        }
        
        //User not found.
        return null;
    }
    
    /**
     * Retrieve a paginated list of users
     * @param int $page OPTIONAL
     * @return Array
     */
    public function getUsers($page = 1) {
        $this->curl->get(sprintf('%s/users', $this->baseUrl), [
            'page' => $page,
        ]);
        
        $results = [];
        
        if($this->curl->isSuccess()) {
            $response = $this->curl->response;
            $data = json_decode($response, true);
            
            //Exceeded total pages, return empty result set.
            if($data['total_pages'] < $page) {
                return $results;
            }
            
            //Create an array of User objects.
            if(count($data['data'])) {
                foreach($data['data'] as $result) {
                    $results[] = $this->populateUser($result);
                }
            }
            
        }
        
        return $results;
    }
    
    /**
     * Create a User model and populate it with our data.
     * @param Array $data
     * @return User
     */
    protected function populateUser($data) {
        $user = new User();
        foreach($data as $key => $value) {
            //Convert snake_case to camelCase so set function is, e.g. setFirstName not setfirst_name
            $key = 'set' . str_replace('_', '', ucwords($key, '_'));
            $user->{$key}($value);
        }
        return $user;
    }
}