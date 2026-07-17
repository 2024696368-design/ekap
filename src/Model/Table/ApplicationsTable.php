<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Applications Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ClubsTable&\Cake\ORM\Association\BelongsTo $Clubs
 * @property \App\Model\Table\DocumentsTable&\Cake\ORM\Association\HasMany $Documents
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 *
 * @method \App\Model\Entity\Application newEmptyEntity()
 * @method \App\Model\Entity\Application newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Application> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Application get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Application findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Application patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Application> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Application|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Application saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Application>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Application>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Application>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Application> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Application>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Application>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Application>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Application> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ApplicationsTable extends Table
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

        $this->setTable('applications');
        $this->setDisplayField('organiser_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Clubs', [
            'foreignKey' => 'club_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Documents', [
            'foreignKey' => 'application_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'application_id',
        ]);
    }

    /**
     * Supply internal compatibility values for legacy columns that are no
     * longer displayed in the student application form.
     *
     * @param \Cake\Event\EventInterface $event Event instance.
     * @param \ArrayObject<string, mixed> $data Marshalled data.
     * @param \ArrayObject<string, mixed> $options Marshal options.
     */
    public function beforeMarshal(
        EventInterface $event,
        ArrayObject $data,
        ArrayObject $options
    ): void {
        $data['department_head'] = null;
        $data['attendance_type'] = 'physical';
        $data['location_type'] = 'inside_campus';
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
            ->nonNegativeInteger('user_id')
            ->notEmptyString('user_id');

        $validator
            ->nonNegativeInteger('club_id')
            ->notEmptyString('club_id');

        $validator
            ->scalar('reference_no')
            ->maxLength('reference_no', 50)
            ->allowEmptyString('reference_no')
            ->add('reference_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('organiser_type')
            ->maxLength('organiser_type', 100)
            ->requirePresence('organiser_type', 'create')
            ->notEmptyString('organiser_type')
            ->inList('organiser_type', [
                'Club/Society',
                'Faculty/Department',
                'MPP/Student Council',
                'Joint Organization',
                'External Organization',
            ], 'Please select a valid organiser type.');

        $validator
            ->scalar('department_head')
            ->maxLength('department_head', 150)
            ->allowEmptyString('department_head');

        $validator
            ->scalar('program_title')
            ->maxLength('program_title', 255)
            ->requirePresence('program_title', 'create')
            ->notEmptyString('program_title');

        $validator
            ->scalar('program_level')
            ->maxLength('program_level', 100)
            ->requirePresence('program_level', 'create')
            ->notEmptyString('program_level')
            ->inList('program_level', [
                'International',
                'National',
                'State',
                'District',
                'University',
                'Faculty',
                'Club/Student Society',
                'College',
            ], 'Please select a valid programme level.');

        $validator
            ->scalar('program_category')
            ->maxLength('program_category', 100)
            ->requirePresence('program_category', 'create')
            ->notEmptyString('program_category')
            ->inList('program_category', [
                'Academic',
                'Cultural/Heritage',
                'Religious Affairs',
                'Volunteering',
                'Business/Entrepreneurship',
                'Public Speaking',
                'Science & Innovation',
                'Intellectual Forum',
            ], 'Please select a valid programme category.');

        $validator
            ->scalar('attendance_type')
            ->requirePresence('attendance_type', 'create')
            ->notEmptyString('attendance_type');

        $validator
            ->scalar('location_type')
            ->requirePresence('location_type', 'create')
            ->notEmptyString('location_type');

        $validator
            ->scalar('venue')
            ->maxLength('venue', 255)
            ->requirePresence('venue', 'create')
            ->notEmptyString('venue');

        $validator
            ->scalar('target_group')
            ->maxLength('target_group', 255)
            ->requirePresence('target_group', 'create')
            ->notEmptyString('target_group');

        $validator
            ->dateTime('start_datetime')
            ->requirePresence('start_datetime', 'create')
            ->notEmptyDateTime('start_datetime');

        $validator
            ->dateTime('end_datetime')
            ->requirePresence('end_datetime', 'create')
            ->notEmptyDateTime('end_datetime');

        $validator
            ->nonNegativeInteger('male_participants')
            ->allowEmptyString('male_participants');

        $validator
            ->nonNegativeInteger('female_participants')
            ->allowEmptyString('female_participants');

        $validator
            ->nonNegativeInteger('total_participants')
            ->allowEmptyString('total_participants');

        $validator
            ->scalar('program_description')
            ->requirePresence('program_description', 'create')
            ->notEmptyString('program_description');

        $validator
            ->scalar('objectives')
            ->requirePresence('objectives', 'create')
            ->notEmptyString('objectives');

        $validator
            ->scalar('expected_outcomes')
            ->allowEmptyString('expected_outcomes');

        $validator
            ->decimal('estimated_budget')
            ->allowEmptyString('estimated_budget');

        $validator
            ->decimal('requested_allocation')
            ->allowEmptyString('requested_allocation');

        $validator
            ->scalar('funding_source')
            ->maxLength('funding_source', 255)
            ->allowEmptyString('funding_source');

        $validator
            ->boolean('has_risk')
            ->notEmptyString('has_risk');

        $validator
            ->scalar('risk_level')
            ->allowEmptyString('risk_level');

        $validator
            ->scalar('risk_description')
            ->allowEmptyString('risk_description');

        $validator
            ->scalar('safety_action')
            ->allowEmptyString('safety_action');

        $validator
            ->scalar('person_in_charge')
            ->maxLength('person_in_charge', 150)
            ->requirePresence('person_in_charge', 'create')
            ->notEmptyString('person_in_charge');

        $validator
            ->scalar('pic_phone')
            ->maxLength('pic_phone', 30)
            ->requirePresence('pic_phone', 'create')
            ->notEmptyString('pic_phone');

        $validator
            ->scalar('pic_email')
            ->maxLength('pic_email', 150)
            ->requirePresence('pic_email', 'create')
            ->notEmptyString('pic_email');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->scalar('admin_comment')
            ->allowEmptyString('admin_comment');

        $validator
            ->dateTime('submitted_at')
            ->allowEmptyDateTime('submitted_at');

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
        $rules->add($rules->isUnique(['reference_no'], ['allowMultipleNulls' => true]), ['errorField' => 'reference_no']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['club_id'], 'Clubs'), ['errorField' => 'club_id']);

        return $rules;
    }
}
