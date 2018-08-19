<?php
class ArticleUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='article/index')
        {
			if ((isset($params['city'])) && (isset($params['category']))) {
                $url = strtolower(str_replace(' ', '-', $params['city'])) . '/' . strtolower(str_replace(' ', '-', $params['category']));
            } else if (isset($params['city'])) {
                $url = strtolower(str_replace(' ', '-', $params['city']));
				// Replace spaces with hyphens
            } else if (isset($params['category'])) {
                $url = strtolower(str_replace(' ', '-', $params['category']));
			}

			if (isset($params['page']))
				$url .= '/page/' . $params['page'];
				
			return $url;
        }
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('%^([\w-]+)(/([\w-/&]+))?$%', $pathInfo, $matches))
        {
            // Check $matches[1] and $matches[3] to see
            // if they match a city and a category in the database
            // If so, set $_GET['city'] and/or $_GET['category']
            // and return 'article/index'
			
			// First check for city name in position one
			$city = $matches[1];
			// Replace hyphens with spaces
			$city = str_replace('-', ' ', $city);
			$criteria = new CDbCriteria();
			$criteria->condition = 'title=:city';
			$criteria->params = array(':city'=>$city);
			$count = City::model()->count($criteria);
			$city = City::model()->find($criteria);

			if ($count == 1) {
				$_GET['city'] = $city->id;
			}
			
			// Then check for category name in position three or one
			$category = (isset($matches[3]) && !empty($matches[3]) ? $matches[3] : $matches[1]);
			// Replace hyphens with spaces
			$category = str_replace('-', ' ', $category);
			$criteria = new CDbCriteria();
			$criteria->condition = 'title=:category';
			$criteria->params = array(':category'=>$category);
			$count = Category::model()->count($criteria);
			$category = Category::model()->find($criteria);
			
			if ($count == 1) {
				$_GET['category'] = $category->id;
			}
			
			// If either city or category are provided, go to article/index
			if (isset($_GET['city']) || isset($_GET['category']))
			{
				return 'article/index';
			}
        }
        return false;  // This rule does not apply
    }
}