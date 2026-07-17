<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Documents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documents view content">
            <h3><?= h($document->document_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Application') ?></th>
                    <td><?= $document->hasValue('application') ? $this->Html->link($document->application->organiser_type, ['controller' => 'Applications', 'action' => 'view', $document->application->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type') ?></th>
                    <td><?= h($document->document_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Name') ?></th>
                    <td><?= h($document->file_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Path') ?></th>
                    <td><?= h($document->file_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Type') ?></th>
                    <td><?= h($document->file_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($document->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Size') ?></th>
                    <td><?= $document->file_size === null ? '' : $this->Number->format($document->file_size) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($document->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($document->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>