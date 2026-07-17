<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Review'), ['action' => 'edit', $review->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Review'), ['action' => 'delete', $review->id], ['confirm' => __('Are you sure you want to delete # {0}?', $review->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reviews'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Review'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reviews view content">
            <h3><?= h($review->decision) ?></h3>
            <table>
                <tr>
                    <th><?= __('Application') ?></th>
                    <td><?= $review->hasValue('application') ? $this->Html->link($review->application->organiser_type, ['controller' => 'Applications', 'action' => 'view', $review->application->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Admin') ?></th>
                    <td><?= $review->hasValue('admin') ? $this->Html->link($review->admin->full_name, ['controller' => 'Users', 'action' => 'view', $review->admin->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Decision') ?></th>
                    <td><?= h($review->decision) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($review->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($review->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($review->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comments') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($review->comments)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Internal Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($review->internal_notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>