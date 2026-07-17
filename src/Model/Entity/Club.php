<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Club Entity
 *
 * @property int $id
 * @property string $club_name
 * @property string $registration_no
 * @property string|null $faculty
 * @property string|null $advisor_name
 * @property string|null $advisor_email
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Application[] $applications
 */
class Club extends Entity
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
        'club_name' => true,
        'registration_no' => true,
        'faculty' => true,
        'advisor_name' => true,
        'advisor_email' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'applications' => true,
    ];
}
