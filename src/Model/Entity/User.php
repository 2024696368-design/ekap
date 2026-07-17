<?php
declare(strict_types=1);

namespace App\Model\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $student_no
 * @property string|null $staff_no
 * @property string|null $faculty
 * @property string|null $phone
 * @property string $account_status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Application[] $applications
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'full_name' => true,
        'email' => true,
        'password' => true,
        'role' => true,
        'student_no' => true,
        'staff_no' => true,
        'faculty' => true,
        'phone' => true,
        'account_status' => true,
        'created' => true,
        'modified' => true,
        'applications' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return null;
    }
}
