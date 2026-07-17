<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property int $application_id
 * @property string $document_type
 * @property string $file_name
 * @property string $file_path
 * @property string|null $file_type
 * @property int|null $file_size
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Application $application
 */
class Document extends Entity
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
        'document_type' => true,
        'file_name' => true,
        'file_path' => true,
        'file_type' => true,
        'file_size' => true,
        'created' => true,
        'modified' => true,
        'application' => true,
    ];
}
