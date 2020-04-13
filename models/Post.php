<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "post".
 *
 * @property float|null $updated_at
 * @property float|null $created_at
 * @property int|null $id
 * @property string|null $title
 * @property resource|null $content
 * @property float|null $author
 * @property string $slug
 *
 * @property User $author0
 */
class Post extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title'
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author',
                'updatedByAttribute' => false
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at', 'created_at', 'author'], 'number'],
            [['title', 'content', 'slug'], 'string'],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'author' => 'Author',
            'slug' => 'Slug',
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'author']);
    }

    public function getPostTags()
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    public function getTags()
    {
        $tags = array();
        if ($this->postTags != null) {
            foreach ($this->postTags as $tag)
            {
                $tags[] = Tag::findOne($tag->tag_id);
            }
        }
        return $tags;
    }

    public function getPostComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }
}

