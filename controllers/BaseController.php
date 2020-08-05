<?php
/**
 * Created by egquan@163.com
 * Date: 2020/8/4
 * Time: 14:01
 */

namespace app\controllers;

use yii\web\Controller;
class BaseController extends Controller
{
	/**
	 * 防刷查询缓存
	 * @var int
	 */
	public $CacheTime = 5;

	/**
	 * 每页显示数量
	 * @var int
	 */
	public $pageSize = 20;
}