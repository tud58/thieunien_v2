<?php

namespace app\models;

use Yii;
use pendalf89\filemanager\behaviors\MediafileBehavior;
use yii\db\Query;
use app\helper\Functions;

class News extends BaseModel
{

    public $category;
    public $tag;

    public $publish_time_temp;
    public $publish_time_temp_hour;

    public $active_time_temp;
    public $active_time_temp_hour;

    public static function tableName()
    {
        return static::getDb()->tablePrefix . "news";
    }

    public function behaviors()
    {
        return [
            'mediafile' => [
                'class' => MediafileBehavior::className(),
                'name' => 'post',
                'attributes' => [
                    'logo',
                ],
            ]
        ];
    }

    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['logo', 'cover'], 'file', 'extensions' => 'gif, jpg', 'maxSize' => 1024 * 1024 * 1],
            [['content', 'source', 'author'], 'string'],
            [['publish_time_temp', 'publish_time_temp_hour', 'active_time_temp', 'active_time_temp_hour'], 'checkTime'],
            [['type', 'show_home', 'event_id', 'daily', 'contest'], 'number'],
            [['title'], 'string'],
            [['description'], 'string'],
            [['title', 'description'], 'checkWordCount'],
            [['logo'], 'checkLogo', 'on' => 'admin'],

        ];
    }

    public function attributeLabels()
    {
        return [

            "title" => "Tiêu đề",
            "logo" => "Ảnh đại diện",
            "cover" => "Ảnh đại diện",
            "description" => "Sapo",
            "content" => "Nội dung",
            "tag" => "Tag/Từ khóa",
            "publish_time_temp" => "Ngày (xuất bản) hiển thị",
            "publish_time_temp_hour" => "Giờ (xuất bản) hiển thị",
            "active_time_temp" => "Ngày lên bài",
            "active_time_temp_hour" => "Giờ lên bài",
            "type" => "Loại bài viết",
            "event_id" => "Sự kiện",
            "source" => "Nguồn",
            "author" => "Tác giả",
            "show_home" => "Hiển thị tại trang chủ",
            "category_id" => "Chuyên mục chính",
        ];
    }

    public function checkLogo()
    {
        if ($this->logo != '') {
            if (strpos($this->logo, '600x450.') === false) {
                $this->addError("logo", "Ảnh đại diện phải chọn size 600x450");
            }
//            list($width, $height, $type, $attr) = getimagesize($this->logo);
//            if ($width < 600 || $height < 450) {
//                $this->addError("logo", "Ảnh đại diện rộng tối thiểu 600px cao tối thiểu 450px, kích thước hiện tại $width x $height");
//            }
        }
    }

    public function checkTime()
    {

        if (!empty($this->publish_time_temp)) {
            if (strtotime($this->publish_time_temp_hour . ' ' . $this->publish_time_temp) !== false) {
                $this->publish_time = strtotime($this->publish_time_temp_hour . ' ' . $this->publish_time_temp);
            } else {
                $this->addError("publish_time_temp", "Ngày hiển thị sai định dạng");
            }
        }
        if (!empty($this->active_time_temp)) {
            if (strtotime($this->active_time_temp_hour . ' ' . $this->active_time_temp) !== false) {
                $this->active_time = strtotime($this->active_time_temp_hour . ' ' . $this->active_time_temp);
            } else {
                $this->addError("active_time_temp", "Ngày hiển thị sai định dạng");
            }
        }
    }

    public function checkWordCount()
    {
        if (count(explode(' ', strip_tags(trim($this->title)))) > 21) {
            $this->addError("title", "Tiêu đề độ dài tối đa 20 từ");
        }
        if (count(explode(' ', strip_tags(trim($this->description)))) > 51) {
            $this->addError("description", "Sapo độ dài tối đa 50 từ");
        }
    }

    public function beforeSave($insert)
    {
        $this->event_id = (int)$this->event_id;
        $this->update_time = time();

        //check slug
        $counter = 0;
        do {
            if ($counter == 0)
                $slug = Functions::toSlug(strip_tags(html_entity_decode($this->title)));
            else {
                $slug = Functions::toSlug(strip_tags(html_entity_decode($this->title))) . '-' . $counter;
            }
            $counter++;
            $check = ($n = News::findOne(['slug' => $slug])) && $n->id != $this->id;
        } while ($check);
        $this->slug = $slug;
        return parent::beforeSave($insert);
    }

    ///

    public static function search($where, $offset = 0, $limit = SEARCH_ROW_PER_PAGE, $order = ['news.publish_time' => SORT_DESC], $elseId = 0)
    {

        $query = new Query;
        $query->select(['news.*'])->from('news');

        if (isset($where['category_id'])) {
            $query->join('INNER JOIN',
                'news_category',
                'news.id = news_category.news_id'
            );
            $query->andWhere(['=', 'news_category.category_id', $where['category_id']]);
            unset($where['category_id']);
        }
        if (isset($where['keyword'])) {
            $query->andFilterWhere(['OR',
                ['LIKE', 'news.title', $where['keyword']],
                ['LIKE', 'news.description', $where['keyword']]
            ]);
            unset($where['keyword']);
        }

        if ($elseId) {
            $query->andWhere(['<>', 'news.id', $elseId]);
        }

        $query->andWhere($where);
        $query->andWhere(['!=', 'status', STATUS_DELETED]);
        $query->andWhere([
            'or',
            ['=', 'news.active_time', 0],
            ['<', 'news.active_time', time()],
        ]);

        $query->limit($limit)->offset($offset)->orderBy($order);

        $command = $query->createCommand();
        $news = $command->queryAll(\PDO::FETCH_OBJ);

        return $news;
    }

    public static function searchIndex($where, $offset = 0, $limit = SEARCH_ROW_PER_PAGE, $order = ['news.publish_time' => SORT_DESC], $elseId = 0)
    {
        $query = new Query;
        $query->select(['news.*'])->from('news');

        if ($elseId) {
            $query->andWhere(['<>', 'news.id', $elseId]);
        }

        $query->andWhere($where);
        $query->andWhere(['!=', 'status', STATUS_DELETED]);
        $query->andWhere([
            'or',
            ['=', 'news.active_time', 0],
            ['<', 'news.active_time', time()],
        ]);

        $query->limit($limit)->offset($offset)->orderBy($order);

        $command = $query->createCommand();
        $news = $command->queryAll(\PDO::FETCH_OBJ);

        return $news;
    }

    public static function search2($where, $offset = 0, $limit = SEARCH_ROW_PER_PAGE, $order = ['news.publish_time' => SORT_DESC])
    {

        $query = new Query;
        $query->select(['news.*'])->from('news');

        if (isset($where['category_id'])) {
            $query->join('INNER JOIN',
                'news_category',
                'news.id = news_category.news_id'
            );
            $query->andWhere(['=', 'news_category.category_id', $where['category_id']]);
            unset($where['category_id']);
        }
        if (isset($where['keyword'])) {
            $query->andFilterWhere(['OR',
                ['LIKE', 'news.title', $where['keyword']],
                ['LIKE', 'news.description', $where['keyword']]
            ]);
            unset($where['keyword']);
        }

        $query->andWhere($where);
        $query->andWhere(['!=', 'status', STATUS_DELETED]);


        $query->limit($limit)->offset($offset)->orderBy($order);
        $count = $query->count();

        $command = $query->createCommand();
        $news = $command->queryAll(\PDO::FETCH_OBJ);

        return ['data' => $news, 'count_items' => $count];
    }

    public static function updateCommentCount($news_id)
    {
        $news = News::findOne($news_id);
        if (!$news) {
            return false;
        }
        $comment_count = Comment::find()->where(['news_id' => $news_id])->count();
        $news->comment_count = $comment_count;
        return $news->save();
    }

    public static function updateViewCount($news_id)
    {
        Yii::$app->db->createCommand()
            ->update('news', ['view_count' => new \yii\db\Expression('view_count + 1')], 'id = ' . $news_id)
            ->execute();
    }

}