<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Review Entity
 *
 * @property int $id
 * @property int $application_id
 * @property int $admin_id
 * @property string $decision
 * @property string|null $comments
 * @property string|null $internal_notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Application $application
 * @property \App\Model\Entity\User $admin
 */
class Review extends Entity
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
        'application_id' => true,
        'admin_id' => true,
        'decision' => true,
        'comments' => true,
        'internal_notes' => true,
        'created' => true,
        'modified' => true,
        'application' => true,
        'admin' => true,
    ];
}
