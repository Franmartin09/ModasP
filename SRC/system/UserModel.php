<?php

namespace CodeIgniter;

use CodeIgniter\Model;


/**
 * Model class for User objects
 */
class UserModel extends Model {
  const USER_MODEL_KIND = 'User';
  const USER_EMAIL_PROPERTY_NAME = 'email';
  const USER_ID_PROPERTY_NAME = 'user_id';
  const SUBSCRIBED_FEEDS_PROPERTY_NAME = 'feeds';

  private $user_email;
  private $user_id;
  private $feeds;
  private $key_name;

  public function __construct($user_email, $user_id, $feeds = null) {
    parent::__construct();
    $this->key_name = $user_id;
    $this->user_email = $user_email;
    $this->user_id = $user_id;
    $this->feeds = is_array($feeds) ? $feeds : [];
  }

  public function getUserEmail() {
    return $this->user_email;
  }

  public function getUserId() {
    return $this->user_id;
  }

  public function getFeeds() {
    return $this->feeds;
  }

  public function addFeed($feed) {
    if ($this->feeds == null) {
      $this->feeds = [$feed];
      return true;
    }
    if (!in_array($feed, $this->feeds)) {
      $this->feeds[] = $feed;
      return true;
    }
    return false;
  }

  /**
   * ...
   * @param $feed
   */
  public function removeFeed($feed) {
    $key = array_search($feed, $this->feeds);
    if ($key!==false) {
        unset($this->feeds[$key]);
        return true;
    }
    else {
      return false;
    }
  }

  public function removeAllFeeds() {
    $this->feeds = [];
  }

  protected static function getKindName() {
    return self::USER_MODEL_KIND;
  }

  /**
   * Generate the entity property map from the User object fields.
   */
  protected function getKindProperties() {
    $property_map = [];

    $property_map[self::USER_EMAIL_PROPERTY_NAME] =
        parent::createStringProperty($this->user_email);

    $property_map[self::USER_ID_PROPERTY_NAME] =
        parent::createStringProperty($this->user_id, true);

    if (!empty($this->feeds)) {
      $property_map[self::SUBSCRIBED_FEEDS_PROPERTY_NAME] =
          parent::createStringListProperty($this->feeds);
    }

    return $property_map;
  }

  /**
   * ...
   * @param $user_id
   */
  public static function get($user_id) {
    $query = parent::createQuery(self::USER_MODEL_KIND);
    $user_id_filter = parent::createStringFilter(
        self::USER_ID_PROPERTY_NAME,
        $user_id);
    $filter = parent::createCompositeFilter([$user_id_filter]);
    $query->setFilter($filter);
    $results = self::executeQuery($query);
    return self::extractQueryResults($results);
  }

  /**
   * Extract the results of a Datastore query into FeedModel objects
   * @param $results Datastore query results
   */
  protected static function extractQueryResults($results) {
    // Should only be one result
    if (!empty($results)) {
      $id = @$results[0]['entity']['key']['path'][0]['id'];
      $key_name = @$results[0]['entity']['key']['path'][0]['name'];
      $props = $results[0]['entity']['properties'];
      $email = $props[self::USER_EMAIL_PROPERTY_NAME]->getStringValue();
      $user_id = $props[self::USER_ID_PROPERTY_NAME]->getStringValue();
      $feeds = [];
      if (isset($props[self::SUBSCRIBED_FEEDS_PROPERTY_NAME])) {
        if (!empty($props[self::SUBSCRIBED_FEEDS_PROPERTY_NAME]['listValue'])) {
          $feedslist = $props[self::SUBSCRIBED_FEEDS_PROPERTY_NAME]->getListValue();
          foreach ($feedslist as $f) {
            $feeds[] = $f->getStringValue();
          }
        }
      }
      $user_model = new UserModel($email, $user_id, $feeds);
      $user_model->setKeyId($id);
      $user_model->setKeyName($key_name);
      return $user_model;
    } else {
      return null;
    }
  }

}
