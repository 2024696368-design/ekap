<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\HasMany $Applications
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method.
     *
     * @param array<string, mixed> $config Configuration.
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Applications', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('full_name')
            ->maxLength('full_name', 150)
            ->requirePresence('full_name', 'create')
            ->notEmptyString('full_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->minLength(
                'password',
                8,
                'Password must contain at least 8 characters.'
            );

        $validator
            ->scalar('role')
            ->notEmptyString('role')
            ->inList(
                'role',
                ['student', 'admin'],
                'Please select a valid role.'
            );

        $validator
            ->scalar('student_no')
            ->maxLength('student_no', 30)
            ->allowEmptyString('student_no')
            ->add('student_no', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
            ]);

        $validator
            ->scalar('staff_no')
            ->maxLength('staff_no', 30)
            ->allowEmptyString('staff_no')
            ->add('staff_no', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
            ]);

        $validator
            ->scalar('faculty')
            ->maxLength('faculty', 150)
            ->requirePresence('faculty', 'create')
            ->notEmptyString('faculty')
            ->inList(
                'faculty',
                [
                    'Faculty of Information Science',
                    'Faculty of Film, Theater & Animation',
                ],
                'Please select a valid faculty.'
            );

        $validator
            ->scalar('phone')
            ->maxLength('phone', 30)
            ->allowEmptyString('phone');

        $validator
            ->scalar('account_status')
            ->notEmptyString('account_status')
            ->inList(
                'account_status',
                ['active', 'inactive'],
                'Please select a valid account status.'
            );

        return $validator;
    }

    /**
     * Application integrity rules.
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add(
            $rules->isUnique(['email']),
            ['errorField' => 'email']
        );

        $rules->add(
            $rules->isUnique(
                ['student_no'],
                ['allowMultipleNulls' => true]
            ),
            ['errorField' => 'student_no']
        );

        $rules->add(
            $rules->isUnique(
                ['staff_no'],
                ['allowMultipleNulls' => true]
            ),
            ['errorField' => 'staff_no']
        );

        return $rules;
    }
}
