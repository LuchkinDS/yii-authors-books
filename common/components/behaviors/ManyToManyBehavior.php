<?php
/**
 * Created by PhpStorm.
 * User: luchkinds
 * Date: 02.12.16
 * Time: 15:45
 */

namespace common\components\behaviors;

use yii\base\Behavior;
use yii\base\UnknownPropertyException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

class ManyToManyBehavior extends Behavior
{
    /**
    * Usage
    * ------------
    *
    * ```php
     * class User extends ActiveRecord
     * {
     *      public function behaviors()
     *      {
     *          return [
     *              'crossTable' => [
     *                  'class' => 'common\behaviors\ManyToMany',
     *                  'relationAttribute' => 'groups',
     *              ]
     *          ];
     *      }
     *
     *      public function getGroups()
     *      {
     *          return $this->hasMany(Groups::className(), ['id' => 'group_id'])->viaTable('user_group', ['user_id' => 'id']);
     *      }
     *
     *      public function setGroups($value)
     *      {
     *          $this->populateRelation('groups', $value);
     *      }
     * }
     */
    
    /**
     * Object parent.
     * @var ActiveRecord
     */
    public $owner;
    
    /**
     * Collection of data on junction table
     * @var mixed[]
     */
    private $_related = [];
    
    /**
     * @var string
     */
    private $relationAttribute;
    
    public function setRelationAttribute($value)
    {
        $this->relationAttribute = $value;
    }
    /**
     * Delete all records.
     * @param string $name
     */
    private function deleteAll($name)
    {
        $db = $this->owner->getDb();
        $primaryKeyValue = $this->owner->getPrimaryKey();
        $meta = $this->_related[$name]['meta'];
        $db
            ->createCommand()
            ->delete(
                $meta['tableName'],
                [
                    $meta['foreignKey'] => $primaryKeyValue,
                ]
            )
            ->execute();
    }
    
    /**
     * @param string $name
     * @return array
     */
    private function getIds($name)
    {
        $primaryKeyValue = $this->owner->getPrimaryKey();
        $meta = $this->_related[$name]['meta'];
        $ids = $this->_related[$name]['ids'];
        $query = new Query();
        $res = $query
            ->from($meta['tableName'])
            ->select($meta['remoteKey'])
            ->where([
                $meta['foreignKey'] => $primaryKeyValue,
                $meta['remoteKey'] => $ids
            ])->column($this->owner->getDb());
        return array_diff($ids, $res);
    }
    
    /**
     * Check the existence of relation
     * @param string $name
     * @return bool
     */
    public function issetRelation($name)
    {
        $getter = 'get' . $name;
        return (method_exists($this->owner, $getter) && $this->owner->$getter() instanceof ActiveQuery);
    }
    
    /**
     * Get meta data of the junction table
     *
     * The array consists of three keys:
     *
     * 1. tableName - the name of the junction table
     * 2. foreignKey - name field, make a relation with the current model
     * 3. remoteKey - name field connecting two tables
     *
     * @param string $name
     * @return mixed[]
     */
    private function getRelationMeta($name)
    {
        /**
         * ToDo переделать для возможности использования via, при описании связи
         */
        $query = $this->owner->getRelation($name);
        $remoteKey = array_values($query->link);
        $remoteKey = reset($remoteKey);
        $foreignKey = array_keys($query->via->link);
        $foreignKey = reset($foreignKey);
        return [
            'foreignKey' => $foreignKey,
            'remoteKey' => $remoteKey,
            'tableName' => reset($query->via->from),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updateRelations',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateRelations',
        ];
    }
    
    /**
     * Add new data for the junction table
     *
     * @throws UnknownPropertyException
     */
    public function setRelated()
    {
        $relationAttribute = $this->relationAttribute;
        if (!$this->issetRelation($relationAttribute)) {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this->owner) . '::' . $relationAttribute);
        }
        $this->_related[$this->relationAttribute] = [
            'deleteOld' => true,
            'ids' => $this->owner->relatedRecords[$relationAttribute],
            'meta' => $this->getRelationMeta($relationAttribute),
        ];
    }
    
    /**
     * Junction table update
     */
    public function updateRelations()
    {
        $this->setRelated();
        foreach ($this->_related as $nameRelation => $data) {
            $db = $this->owner->getDb();
            $meta = $data['meta'];
            $primaryKeyValue = $this->owner->getPrimaryKey();
            if ($data['deleteOld']) {
                $this->deleteAll($nameRelation);
                $ids = $data['ids'];
            } else {
                $ids = $this->getIds($nameRelation);
            }
            foreach ($ids as $id) {
                $db->createCommand()->insert(
                    $meta['tableName'],
                    [
                        $meta['foreignKey'] => $primaryKeyValue,
                        $meta['remoteKey'] => $id
                    ]
                )->execute();
            }
        }
    }
}