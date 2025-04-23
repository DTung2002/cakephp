<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PostStatus> $postStatuses
 */
?>
<div class="postStatuses index content">
    <?= $this->Html->link(__('New Post Status'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Post Statuses') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($postStatuses as $postStatus): ?>
                <tr>
                    <td><?= $this->Number->format($postStatus->id) ?></td>
                    <td><?= h($postStatus->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $postStatus->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $postStatus->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $postStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postStatus->id)]) ?>
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
