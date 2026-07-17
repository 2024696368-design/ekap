<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Review> $reviews
 */
?>
<div class="reviews index content">
    <?= $this->Html->link(__('New Review'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reviews') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('application_id') ?></th>
                    <th><?= $this->Paginator->sort('admin_id') ?></th>
                    <th><?= $this->Paginator->sort('decision') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= $this->Number->format($review->id) ?></td>
                    <td><?= $review->hasValue('application') ? $this->Html->link($review->application->organiser_type, ['controller' => 'Applications', 'action' => 'view', $review->application->id]) : '' ?></td>
                    <td><?= $review->hasValue('admin') ? $this->Html->link($review->admin->full_name, ['controller' => 'Users', 'action' => 'view', $review->admin->id]) : '' ?></td>
                    <td><?= h($review->decision) ?></td>
                    <td><?= h($review->created) ?></td>
                    <td><?= h($review->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $review->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $review->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $review->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $review->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>