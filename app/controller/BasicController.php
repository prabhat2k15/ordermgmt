<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 28/07/17
 * Time: 11:07 PM
 */

namespace app\controller;


class BasicController extends AbstractController
{
    static $DOMAIN = null;
    static $TITLE = WEBSITE_TITLE;
    static $DESCRIPTION = "MOVIES";
    static $KEYWORDS = array("MOVIES", "ACTORS", "DIRECTORS");
    static $COVER_IMAGE = null;
    static $SEARCH_URL = null;

    public function _before_controller_($model)
    {
        //self::$DOMAIN = \RudraX\Utils\WebApp::$DOMAIN;
        return true;
    }

    public function _post_controller_($model)
    {
        if (empty($this->output)) {
            return $this->index($model);
        }
        $model->assign("COVER_IMAGE", self::$COVER_IMAGE);
        $model->assign("DOMAIN", "http://" . self::$DOMAIN);
        $model->assign("SEARCH_URL", self::$SEARCH_URL);
        $model->assign("WEBSITE_TITLE", self::$TITLE);
        $model->assign("WEBSITE_DESCRIPTION", self::$DESCRIPTION);
        $model->assign("WEBSITE_KEYWORDS", self::$KEYWORDS);
        $model->assign("REMOTE_HOST", "http://" . self::$DOMAIN);
        $model->assign("__fragment__", $this->output . ".tpl");
        \app\service\Smarty::addPluginsDir("../plugins/");
        return "index";

    }

    /**
     * @RequestMapping(url="",type="template")
     * @RequestParams(true)
     */
    public function welcome($model, $penname = null)
    {
        return "welcome";
    }
}
