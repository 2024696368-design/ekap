<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clubs Model
 *
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\HasMany $Applications
 *
 * @method \App\Model\Entity\Club newEmptyEntity()
 * @method \App\Model\Entity\Club newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Club> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Club get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Club findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Club patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Club> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Club|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Club saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClubsTable extends Table
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

        $this->setTable('clubs');
        $this->setDisplayField('club_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Applications', [
            'foreignKey' => 'club_id',
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
            ->scalar('club_name')
            ->maxLength('club_name', 150)
            ->requirePresence('club_name', 'create')
            ->notEmptyString('club_name');

        $validator
            ->scalar('registration_no')
            ->maxLength('registration_no', 50)
            ->requirePresence('registration_no', 'create')
            ->notEmptyString('registration_no')
            ->add('registration_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('faculty')
            ->maxLength('faculty', 150)
            ->allowEmptyString('faculty');

        $validator
            ->scalar('advisor_name')
            ->maxLength('advisor_name', 150)
            ->allowEmptyString('advisor_name');

        $validator
            ->scalar('advisor_email')
            ->maxLength('advisor_email', 150)
            ->allowEmptyString('advisor_email');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

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
        $rules->add($rules->isUnique(['registration_no']), ['errorField' => 'registration_no']);

        return $rules;
    }
}
