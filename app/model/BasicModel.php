<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 10/07/17
 * Time: 12:27 AM
 */

namespace app\model;

use app\service\R;

class BasicModel implements \JsonSerializable
{
    static $BEAN_CACHE = array();
    static $META_CONFIGURED = FALSE;
    static $BEAN_TYPE = null;
    protected $bean;
    protected $bean_id = 0;

    public function __construct($bean = null)
    {
        if (!empty($bean)) {
            $this->bean = $bean;
        }
    }

    public function save()
    {
        $this->bean_id = R::store($this->bean);
        $this->bean_id;
        return $this;
    }

    public function bean()
    {
        return $this->bean;
    }

    public function set($model)
    {
        if (!empty($model)) {
            $class = get_class($model);
            $this->bean()->{$class::$BEAN_TYPE} = $model->bean();
        }
        return $this;
    }

    public static function byId($id)
    {
        $bean = null;
        if (!empty(static::$BEAN_TYPE)) {
            $bean = R::load(static::$BEAN_TYPE, $id);
        }
        return new static($bean);
    }

    public static function byBeanTitle($type, $title)
    {
        $title = trim($title);
        if (empty($title)) {
            return null;
        }
        $bean = self::in_cache($type, $title);
        if (empty($bean))
            $bean = R::findOne($type, "title=?", array($title));
        if (empty($bean)) {
            $bean = R::dispense($type);
            $bean->title = $title;
            R::store($bean);
        }
        self::in_cache($type, $title, $bean);
        return new BasicModel($bean);
    }

    /**
     * Accepts BasicModel,Bean OR id
     *
     * @param $object - BasicModel OR \RedBeanPHP\OODBBean OR id
     * @return id
     */

    public static function get_id($object)
    {
        if ($object instanceof BasicModel) {
            return $object->bean()->id;
        } else if ($object instanceof \RedBeanPHP\OODBBean) {
            return $object->id;
        } else if (is_int($object)) {
            return $object;
        }
        return null;
    }


    public static function in_cache($type, $key, $bean)
    {
        if (!isset(self::$BEAN_CACHE[$type])) {
            self::$BEAN_CACHE[$type] = array();
        }
        if (!isset(self::$BEAN_CACHE[$type][$key])) {
            if (!empty($bean)) {
                self::$BEAN_CACHE[$type][$key] = $bean;
            }
            return self::$BEAN_CACHE[$type][$key];
        }
    }

    function jsonSerialize()
    {
        return $this->bean;
    }

    function configureMeta()
    {
        if (empty(self::$META_CONFIGURED) && !empty($this->bean)) {
            return static::configure_meta($this->bean);
        }
    }

    public static function configure_meta($bean)
    {
        //DO ANY THING LIEK YOU WANT:P
    }

    public static function sanitize($title)
    {
        $titlecode = strtoupper(str_replace(array("-", "_", "&", ","), array(" ", " ", "and", ","), $title));
        $titlecode = preg_replace('!\s+!', ' ', $titlecode);
        return $titlecode;
    }
}