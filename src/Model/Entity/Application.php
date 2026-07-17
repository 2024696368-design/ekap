<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Application Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $club_id
 * @property string|null $reference_no
 * @property string $organiser_type
 * @property string|null $department_head
 * @property string $program_title
 * @property string $program_level
 * @property string $program_category
 * @property string $attendance_type
 * @property string $location_type
 * @property string $venue
 * @property string $target_group
 * @property \Cake\I18n\DateTime $start_datetime
 * @property \Cake\I18n\DateTime $end_datetime
 * @property int|null $male_participants
 * @property int|null $female_participants
 * @property int|null $total_participants
 * @property string $program_description
 * @property string $objectives
 * @property string|null $expected_outcomes
 * @property string|null $estimated_budget
 * @property string|null $requested_allocation
 * @property string|null $funding_source
 * @property bool $has_risk
 * @property string|null $risk_level
 * @property string|null $risk_description
 * @property string|null $safety_action
 * @property string $person_in_charge
 * @property string $pic_phone
 * @property string $pic_email
 * @property string $status
 * @property string|null $admin_comment
 * @property \Cake\I18n\DateTime|null $submitted_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Club $club
 * @property \App\Model\Entity\Document[] $documents
 * @property \App\Model\Entity\Review[] $reviews
 */
class Application extends Entity
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
        'user_id' => true,
        'club_id' => true,
        'reference_no' => true,
        'organiser_type' => true,
        'department_head' => true,
        'program_title' => true,
        'program_level' => true,
        'program_category' => true,
        'attendance_type' => true,
        'location_type' => true,
        'venue' => true,
        'target_group' => true,
        'start_datetime' => true,
        'end_datetime' => true,
        'male_participants' => true,
        'female_participants' => true,
        'total_participants' => true,
        'program_description' => true,
        'objectives' => true,
        'expected_outcomes' => true,
        'estimated_budget' => true,
        'requested_allocation' => true,
        'funding_source' => true,
        'has_risk' => true,
        'risk_level' => true,
        'risk_description' => true,
        'safety_action' => true,
        'person_in_charge' => true,
        'pic_phone' => true,
        'pic_email' => true,
        'status' => true,
        'admin_comment' => true,
        'submitted_at' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'club' => true,
        'documents' => true,
        'reviews' => true,
    ];
}
