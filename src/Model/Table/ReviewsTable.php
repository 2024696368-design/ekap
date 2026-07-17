<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reviews Model
 *
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\BelongsTo $Applications
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Admins
 *
 * @method \App\Model\Entity\Review newEmptyEntity()
 * @method \App\Model\Entity\Review newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Review> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Review get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Review findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Review patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Review> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Review|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Review saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReviewsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reviews');
        $this->setDisplayField('decision');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Applications', [
            'foreignKey' => 'application_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
            'className' => 'Users',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('application_id')
            ->notEmptyString('application_id');

        $validator
            ->nonNegativeInteger('admin_id')
            ->notEmptyString('admin_id');

        $validator
            ->scalar('decision')
            ->requirePresence('decision', 'create')
            ->notEmptyString('decision');

        $validator
            ->scalar('comments')
            ->allowEmptyString('comments');

        $validator
            ->scalar('internal_notes')
            ->allowEmptyString('internal_notes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['application_id'], 'Applications'), ['errorField' => 'application_id']);
        $rules->add($rules->existsIn(['admin_id'], 'Admins'), ['errorField' => 'admin_id']);

        return $rules;
    }
}
