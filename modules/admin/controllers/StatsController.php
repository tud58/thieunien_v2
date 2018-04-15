<?php
namespace app\modules\admin\controllers;

use app\helper\Functions;
use app\models\Category;
use app\models\News;
use app\models\StatsDaily;
use Yii;


class StatsController extends BaseController
{
    public function actionIndex()
    {
        $this->view->title = "Thống kê";

        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
        $searchData = [];
        $searchData['from_date'] = $request->get('from_date', date('d-m-Y', time() - 60 * 60 * 24));
        $searchData['to_date'] = $request->get('to_date', date('d-m-Y', time() - 60 * 60 * 24));
        $searchData['category_id'] = $request->get('category_id', 0);

        $from_time = strtotime($searchData['from_date']);
        $to_time = strtotime($searchData['to_date']) + 60 * 60 * 24;

        $data = StatsDaily::getData($searchData, 'view_count', $from_time, $to_time, ($page - 1) * ADMIN_ROW_PER_PAGE, ADMIN_ROW_PER_PAGE);
        $statsViewCount = $data['data'];
        $count_items = $data['count'];
        $page_count = ceil($count_items / ADMIN_ROW_PER_PAGE);

        $nextpage = false;
        if (count($statsViewCount) > ADMIN_ROW_PER_PAGE) {
            $nextpage = true;
            unset($statsViewCount[ADMIN_ROW_PER_PAGE]);
        }
        $categoryTree = Category::getCategoryTree(false, '');
        return $this->render('index', [
            'categoryTree' => $categoryTree,
            'statsViewCount' => $statsViewCount,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/stats?' . Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,
        ]);
    }

    public function actionNews()
    {
        $news_id = Yii::$app->request->get('id');
        $news = News::findOne($news_id);
        if (!$news) {
            echo 'Bài viết không tồn tại';
            exit;
        }
        $data = StatsDaily::find()->where(['news_id' => $news_id])->all();

        return $this->render('news', [
            'data' => $data,
            'news' => $news,
        ]);
    }

    public function actionExport()
    {
        $request = Yii::$app->request;
        $searchData = [];
        $searchData['from_date'] = $request->get('from_date', date('d-m-Y', time() - 60 * 60 * 24));
        $searchData['to_date'] = $request->get('to_date', date('d-m-Y', time() - 60 * 60 * 24));
        $searchData['category_id'] = $request->get('category_id', 0);

        $from_time = strtotime($searchData['from_date']);
        $to_time = strtotime($searchData['to_date']) + 60 * 60 * 24;

        $data = StatsDaily::getDataExport($searchData, 'view_count', $from_time, $to_time, 0, '');
        $statsViewCount = $data['data'];

        $result = '<table border="1" width="100%">
        <thead>
            <tr>
                <th>STT</th>
                <th>Bài viết</th>
                <th>Lượt xem</th>
                <th>Lượt xem tổng</th>
                <th>Ngày tạo</th>
                <th>Ngày xuất bản</th>
            </tr>
        </thead>';
		//var_dump($result);die;
        foreach ($statsViewCount as $k => $item) {
            $result .= '
                <tr>
                    <td>' . ($k+1) . '</td>
                    <td>' . $item->title . '</td>
                    <td>' . $item->sum_view_count . '</td>
                    <td>' . $item->view_count . '</td>
                    <td>' . date('d-m-Y', $item->create_time) . '</td>
                    <td>' . date('d-m-Y', $item->publish_time) . '</td>
                </tr>
            ';
        }
        $result .= '</table>';
		//var_dump($result);die;
		$filename = 'Thống kê HHT - ' . Date('YmdGis') . '.xls';
        header('Content-type: application/ms-excel; charset=utf-8');
        header("Expires: 0");
        header('Content-Disposition: attachment; filename='.$filename);
        header("Pragma: no-cache");
        echo chr(255) . chr(254) . mb_convert_encoding($result, 'UTF-16LE', 'UTF-8');
    }
}